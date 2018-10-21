<?php

class Viny_ElementAccess extends Viny_OperationFile implements Viny_OperatesWithExternalData // musimy nadpisac to_path()
{
	private
		$forum_path;

	function __construct($forum_path = null) // nadpisujemy konstruktor rodzica. nadpisywanie nastapi tez przy paru innych metodach
	{
		$this -> forum_path = $forum_path;
	}

	function read_immediately(Viny_Element $owner)
	{
		$this -> name = $owner;
		$this -> read();
	}

	final function execute_with_external_data(&$result) // skopiowane z Viny_OperationWithExternalData, abysmy mogli dziedziczyc CRUD z Viny_OperationFile
	{
		return $this -> execute(
			$this -> get_external_name(),
			$this -> get_external_text_new(),
			$this -> get_external_additional_operations(),
			$result
		);
	}

	function get_external_name()
	{
		$thread = @$_REQUEST['thread'];
		$message = @$_REQUEST['message'];
		
		switch(0)
		{
			case strlen($thread):
				throw new LogicException('Nie podano nazwy wątku!');
			case strlen($message):
				$message = uniqid(true); // uniqid zwraca wylacznie znaki alfanumeryczne
		}
		
		if(preg_match('/^\w+$/', $message))
		{
			$element = new Viny_Element(sprintf('%s%s%s%s', $this -> forum_path, $thread, DIRECTORY_SEPARATOR, $message)); // konstruujemy Viny_Element recznie
			$element -> name_of_thread = $thread;
			$element -> name_of_message = $message;
			return $this -> name = $element;
		}
	}

	function get_external_text_new()
	{
		global
			$user;

		// $text['message_author']	= trim($_POST['name']);
		$text['message_author']	= access(1) ? trim($user -> login) : $_POST['name'];
		$text['message_text']		= trim($_POST['text']);

		return $text;
	}

	function get_external_additional_operations()
	{
		if(isset($_POST['delete']))
		{
			if(access(2)) // tylko administratorzy
			{
				return Viny_Operation::DELETE;
			}
		}
	}
	
	protected function create_and_update($error_action)
	{
		Custom::mkdir_r(dirname($this -> to_path())); // o kasowanie podczas usuwania zadbamy pozniej
		return parent::create_and_update($error_action);
	}

	function create()
	{
		$name = 'niedawno_wyslana_wiadomosc';
		$time = 10;

		if(isset($_COOKIE[$name]))
		{
			throw new LogicException(sprintf('Nie można wysłać dwóch wiadomości w czasie krótszym niż %d sekund!', $time));
		}
		else
		{
			parent::create();
			setcookie($name, 'przykladowa_wartosc', time() + $time);
		}
	}

	function read()
	{
		if(false === isset($this -> text_old['message_author'], $this -> text_old['message_text']))
		{
			if($this -> name -> isfile())
			{
				$file = fopen($this -> name, 'r'); // $this -> name -> openfile() z jakichs przyczyn nie dziala (kodowanie?)
				$this -> text_old['message_author'] = trim(fgets($file));
				$this -> text_old['message_text'] = '';

				while($line = fgets($file))
				{
					$this -> text_old['message_text'] .= $line;	
				}

				$this -> text_old['message_text'] = trim($this -> text_old['message_text']);
			}
		}
	}

	function delete()
	{
		parent::delete();

		if(0 === sizeof(glob(sprintf('%s%s*', dirname($this -> to_path()), DIRECTORY_SEPARATOR))))
		{
			if(false === rmdir(dirname($this -> to_path())))
			{
				throw new Viny_ExceptionFailedOperation('Usuwanie w�tku zako�czone niepowodzeniem!', parent::DELETE);
			}
		}
	}

	function to_path() // nadpisujemy z Viny_OperationFile
	{
		return Viny_Forum::page_to_disk($this -> name -> getpathname());
	}
	
	protected function get_raw_created_or_updated_text()
	{
		return @sprintf('%s%s%s', $this -> text_new['message_author'], Custom::windows() ? "\r\n" : "\n", $this -> text_new['message_text']); // ...
	}

	function exists()
	{
		return $this -> name -> isfile();
	}

	function prepare_name($name)
	{
		if($name instanceof Viny_Element)
		{
			return $this -> name = $name;
		}
	}

	function prepare_text_new($text_new)
	{
		if(@strlen($text_new['message_author']) && @strlen($text_new['message_text']))
		{
			return $this -> text_new = $text_new;	
		}
	}

	function get_message_author()
	{
		return @$this -> text_old['message_author'];
	}

	function get_message_text()
	{
		return @$this -> text_old['message_text'];
	}
}

?>