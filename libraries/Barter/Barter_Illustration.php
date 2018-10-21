<?php

// client: miejscowy, tj. na komputerze uzytkownika
// server: zdalny, tj. na serwerze barter-poland

class Barter_Illustration extends Viny_Operation // text_old i text_new: tablice nazw plikow
{
	const
		CONTAINING_DIRECTORY	= 'images/items/',
		REGULAR_EXPRESSION	= '/^(\d+)\.(.+)$/',
		YOUTUBE_EXPRESSION	= '/^http:\/\/www\.youtube\.com\/watch\?v=[\w-]{11}$/';
	private
		$number,
		$filename_on_client,
		$user;

	function __construct()
	{
		global
			$user;

		if(null === $this -> user = $user)
		{
			// $this -> err(); // ... ?
		}
	}
	
	private function sql()
	{
		$name = $this -> get_prepared_name(); // tablica min. dwuelementowa
		$type = @$name[0];
		$item = @$name[1];
		$text = $this -> get_prepared_text_new();
		
		return @array(
			is_null($type) ? 'NULL' : sprintf('\'%s\'', addslashes(trim($type))), // $type moze byc null ... i tylko on
			sprintf('\'%s\'', addslashes(trim($item))),
			sprintf('\'%s\'', addslashes(trim(implode("\n", $text)))),
		);
	}
	
	function create()
	{
		list(
			$type,
			$item,
			$text,
		) = $this -> sql();

		if(false === @mysql_query(sprintf('REPLACE INTO `illustrations` VALUES(%s, %s, %s)', $type, $item, $text))) // $type i $item musza byc, w bazie, kolumnami unikalnymi
		{
			throw new Viny_ExceptionFailedOperation(mysql_error());
		}
	}

	function read()
	{
		list(
			$type,
			$item,
		) = $this -> sql();

		switch(false)
		{
			case $query = @mysql_query(sprintf('SELECT `text` FROM `illustrations` WHERE `type` = %s AND `item` = %s', $type, $item)):
			case $query = @mysql_fetch_object($query):
			case @sizeof($query -> text):
				return;
				// throw new Viny_ExceptionFailedOperation(null, Viny_Operation::READ);
			default:
				return $this -> text_old = explode("\n", $query -> text);
		}
	}

	function update()
	{
		$this -> create(); // uzywamy replace()
	}

	function delete()
	{
		list(
			$type,
			$item,
			,
		) = $this -> sql();
		
		if(false === @mysql_query(sprintf('DELETE FROM `illustrations` WHERE `type` = %s AND `item` = %s', $type, $item)))
		{
			throw new Viny_ExceptionFailedOperation(mysql_error(), Viny_Operation::DELETE);
		}
	}

	function exists()
	{
		return true; // uzywamy REPLACE ...
	}
	
	function prepare_name($name)
	{
		switch(true)
		{
			case $name instanceof Barter_AccessArticle:
				return @$this -> name = array(strtolower(get_class($name)), strval($name -> get_prepared_name()),);
			case $name instanceof Barter_AccessSource:
				return @$this -> name = array(strtolower($name -> get_prepared_name() -> table), strval($name -> get_prepared_name() -> index),);
			case $name instanceof Source:
				return @$this -> name = array(strtolower(get_class($name)), strval($name -> {VAR_KEY}),);
			case is_array($name) && sizeof($name):
				return @$this -> name = $name;
			case is_string($name) && strlen($name):
				return @$this -> name = array(strtolower('Barter_AccessArticle'), strval($name),);
		}
	}

	function prepare_text_new($text_new) // tablica sciezek do ilustracji. przefiltrujemy ja tutaj
	{
		if(is_array($text_new)) // youtube
		{
			$text_possible = self::get_editable();
			$text_accepted = $text_youtube = array();

			foreach($text_new as $item_new)
			{
				switch(true)
				{
					case in_array($item_new, $text_possible):
					case preg_match(self::YOUTUBE_EXPRESSION, $item_new):
						$text_accepted[] = $item_new;
						break;
					default:
						throw new LogicException('Podałeś nazwę (nazwy) ilustracji, która nie istnieje.');
				}
			}

			if(sizeof($text_accepted))
			{
				return $this -> text_new = $text_accepted;
			}
		}
	}

	function construct_from_filename_on_server($filename_on_server)
	{
		if(preg_match(self::REGULAR_EXPRESSION, basename($filename_on_server), $matches))
		{
			list(
				,
				$this -> number,
				$this -> filename_on_client,
			) = $matches;
		}

		$this -> number = intval($this -> number);
		$this -> check_integrity();
	}

	function construct_from_pseudonym($pseudonym)
	{
		if(access(2))
		{
			$this -> construct_from_filename_on_server($pseudonym);
		}
		else
		{
			$this -> number			= $this -> user -> id; // operacji dokonuje uzytkownik, nie administrator
			$this -> filename_on_client	= $pseudonym;
		}
		
		$this -> check_integrity();
	}
	
	function can_be_edited() // zakladamy, ze -> id istnieje
	{
		return access(2) || intval($this -> user -> id) === intval($this -> number);
	}
	
	function to_pseudonym()
	{
		return access(2)
			? sprintf('%d.%s', $this -> number, $this -> filename_on_client)
			: sprintf('%s', $this -> filename_on_client);
	}
	
	function to_locator() // ... nie!
	{
		return sprintf('/%s%d%s', self::CONTAINING_DIRECTORY, $this -> number, $this -> filename_on_client);
	}
	
	function to_filename_on_client()
	{
		return $this -> filename_on_client;
	}
	
	function to_filename_on_server()
	{
		return sprintf('%d.%s', $this -> number, $this -> filename_on_client);
	}
	
	private function check_integrity()
	{
		if(!$this -> number || !$this -> filename_on_client)
		{
			$this -> err();
		}
	}
	
	private function err()
	{
		throw new LogicException;
	}

	static function get_editable() // zakladamy, ze przychodzi uzytkownik
	{
		global
			$user; // wykorzystujemy zmienna globalna, poniewaz uruchamiajac metode statyczna nie dysponujemny wlasciwosciami!
		
		$files = @get_directory_contents(DIR_IMAGES);
		
		if($user && $files)
		{
			if(false === access(2))
			{
				$files_all	= $files;
				$files		= array();

				foreach($files_all as $file_all)
				{
					$file_all = new Barter_Illustration;
					$file_all -> construct_from_filename_on_server($file_all);
					
					if($file_all -> can_be_edited())
					{
						$files[] = $file_all -> to_filename_on_server();
					}
				}
			}
		}
		
		if($files)
		{
			natcasesort($files);
		}

		return (array)$files;
	}
	
	static function illustrate($object = null, $continue = false)
	{
		static
			$array, // tablica
			$integer;

		if(false === is_null($object))
		{
			try
			{
				$array = new self;
				$array -> execute($object, null, null, $effect);
			}
			catch(Viny_ExceptionAbsent $error)
			{
			
			}
				
			$array	= $effect -> text_old;
			$integer	= 0;
		}

		if(isset($array[$integer]))
		{
			if(false === preg_match(self::YOUTUBE_EXPRESSION, $array[$integer]))
			{
				if(false === is_readable(sprintf('images/items/%s', $array[$integer])))
				{
					return;
				}
			}

			list(
				$base_width,
				$base_height,
			) = @getimagesize(sprintf('images/items/%s', $array[$integer]));
			
			$html = '<a onclick=\'return event.returnValue = !open(this.href, Math.random(), "dependent=yes,toolbar=no,resizable=yes,width=%d,height=%d")\' href=\'/images/items/%s\'><img src=\'/images/items/%s\' alt=\'%s\' style=\'width: %dpx; height: %dpx; float: %s; margin: %s\'></a>';
			$r = 'rawurlencode';
			
			$resize = new Viny_Dimensions(array(
				$base_width,
				$base_height,
			), 'floor');

			if($integer)
			{
				list(
					$thumbnail_width,
					$thumbnail_height,
				) = $resize -> ratio_of_dimension_to_size(50, 1);
				
				printf($html, $base_width, $base_height, $r($array[$integer]), $r($array[$integer]), '', $thumbnail_width, $thumbnail_height, 'left', '0');
			}
			else
			{
				$optimal_width = 140;

				$ytid = 'youtube_illustration_' . md5(uniqid(rand(), true));

				if(preg_match(self::YOUTUBE_EXPRESSION, $array[$integer]))
				{echo '<div class=illustration_left>';
					printf('
						<div class=\'youtube_illustration\' id=\'' . $ytid . '\'>
						<script type=\'text/javascript\'>
							swfobject.embedSWF(\'http://www.youtube.com/v/%1$s&amp;hl=pl&amp;fs=1\', \'' . $ytid . '\', \'%2$d\', \'%3$d\', \'6\')
						</script>
						</div>
					', preg_replace('/.*(.{11})/', '\1', $array[$integer]), $optimal_width, $optimal_width); // z youtube.com
					echo '</div>';
				}
				else
				{				echo '<div class=illustration_left>';
					list(
						$thumbnail_width,
						$thumbnail_height,
					) = $resize -> ratio_of_dimension_to_size($optimal_width, 0);
				
					printf($html, $base_width, $base_height, $r($array[$integer]), $r($array[$integer]), '', $thumbnail_width, $thumbnail_height, 'left', '0');
					echo '</div>';
				}
			}
			
			$integer++;

			if($continue) // mozna skrocic ponizsze?
			{
				$function = __FUNCTION__;
				self::$function(null, $continue);
			}
		}
	}
}

?>