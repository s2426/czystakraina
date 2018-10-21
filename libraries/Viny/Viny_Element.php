<?php

class Viny_Element extends SplFileInfo
{
	private
		$access, // crud+e przypisany elementowi
		$messages;

	function __construct($data) // z wnetrza iteracji, nie wiem, co przychodzi, zakladam, ze tylko jeden argument!
	{
		$this -> access = new Viny_ElementAccess;
		parent::__construct($data);
	}

	function read_immediately() // powodujemy odczytanie siebie (tj. modulu siebie, ktory dyryguje pobieraniem i wysylaniem danych).
	{
		return $this -> access -> read_immediately($this);
	}

	function __tostring() // nazwa watku *do wyswietlenia*, nie do operacji na plikach! byc moze, ze musi zostac zmieniona przed przeniesieniem skryptu do internetu.
	{
		return Viny_Forum::disk_to_page(basename($this));
	}
	
	function get_messages()
	{
		if(false === isset($this -> messages))
		{
			$browser = new Viny_ForumBrowser(parent::__tostring(), Viny_Forum::MESSAGES, false);
			$this -> messages = array();

			foreach($browser as $message)
			{
				$this -> messages[] = $message;
			}
			
			usort($this -> messages, array(
				$browser,
				'sort_messages',
			));
		}
		
		return $this -> messages;
	}
	
	function read()
	{
		try
		{
			$this -> access -> __construct($this);
		}
		catch(Viny_ExceptionAbsentTextNew $error)
		{
			// niewazne; chcemy tylko, aby Viny_ElementAccess odczytal autora & tekst
		}
	}
	
	function has_one_message()
	{
		return sizeof($this -> messages) === 1;
	}
	
	function first_message()
	{
		return @$this -> messages[sizeof($this -> messages) - 1];		
	}
	
	function last_message()
	{
		return @$this -> messages[0];
	}

	function get_author()
	{
		return $this -> access -> get_message_author();
	}

	function get_text()
	{
		return $this -> access -> get_message_text();
	}
}

?>