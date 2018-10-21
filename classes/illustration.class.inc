<?php

// client: miejscowy, tj. na komputerze uzytkownika
// server: zdalny, tj. na serwerze barter-poland

class Barter_Illustration
{
	const
		CONTAINING_DIRECTORY	= 'images/items/',
		REGULAR_EXPRESSION	= '/^(\d+)\.(.+)$/';
	private
		$number,
		$filename_client,
		$user;

	function __construct()
	{
		global
			$user;

		if(null === $this -> user = $user)
		{
			$this -> err();
		}
	}

	function construct_from_filename_server($filename_server)
	{
		if(preg_match(self::REGULAR_EXPRESSION, basename($filename_server), $matches))
		{
			list(
				,
				$this -> number,
				$this -> filename_client,
			) = $matches;
		}

		$this -> number = intval($this -> number);
		$this -> check_integrity();
	}

	function construct_from_pseudonym($pseudonym)
	{
		if(access(2))
		{
			$this -> construct_from_filename_server($pseudonym);
		}
		else
		{
			$this -> number			= $this -> user -> id; // operacji dokonuje uzytkownik, nie administrator
			$this -> filename_client	= $pseudonym;
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
			? sprintf('%d.%s', $this -> number, $this -> filename_client)
			: sprintf('%s', $this -> filename_client);
	}
	
	function to_locator() // ... nie!
	{
		return sprintf('/%s%d%s', self::CONTAINING_DIRECTORY, $this -> number, $this -> filename_client);
	}
	
	function to_filename_client()
	{
		return $this -> filename_client;
	}
	
	function to_filename_server()
	{
		return sprintf('%d.%s', $this -> number, $this -> filename_client);
	}
	
	private function check_integrity()
	{
		if(!$this -> number || !$this -> filename_client)
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
			$user;
		
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
					$file_all -> construct_from_filename_server($file_all);
					
					if($file_all -> can_be_edited())
					{
						$files[] = $file_all -> to_filename_server();
					}
				}
			}
		}
		//var_dump($files);
		natcasesort($files);
		return $files;
	}
}

?>