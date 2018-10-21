<?php

class Viny_Forum extends RecursiveFilterIterator
{
	private
		$node_types,
		$recurse;
	const
		MESSAGES	= 1,
		SECTIONS	= 2;

	function __construct($path = '', $node_types = Viny_Forum::MESSAGES, $recurse = false) // konstruktor bedzie wywolywany takze podczas samej iteracji, automatycznie!
	{
		$this -> node_types = $node_types;
		$this -> recurse = $recurse;
		
		$path = $path instanceof RecursiveDirectoryIterator ? $path : new RecursiveDirectoryIterator(strlen($path) ? $path : getcwd());
		$path -> setinfoclass('Viny_Element');
		parent::__construct($path);
	}

	function accept()
	{
		if($this -> current() -> isfile())
		{
			if(0 === ($this -> node_types & Viny_Forum::MESSAGES))
			{
				return false;
			}
		}

		return true;
	}
	
	function current()
	{
		$current = parent::current();
		$current -> read_immediately(); // dokonujemy jakby "kontynuacji konstruktura"
		return $current;
	}

	function getchildren()
	{
		if($this -> recurse) // jesli mamy dokonywac zaglebienia, pobieramy pliki
		{
			return new self($this -> getinneriterator() -> getchildren(), $this -> node_types, $this -> recurse);
		}
		else // a jesli nie, to - tez pobieramy, ale tak, aby nie odzwierciedlone to zostalo w wyniku iteracji (hack ... )
		{
			return new RecursiveArrayIterator; // taki EmptyFilterIterator ...
		}
	}
	
	static /* ech */ function disk_to_page($text)
	{
		return Custom::windows() ? iconv('windows-1250', 'UTF-8', $text) : $text;
	}

	static /* ... */ function page_to_disk($text)
	{
		return Custom::windows() ? iconv('UTF-8', 'windows-1250', $text) : $text;
	}
	
	static /* ... */ function date($date)
	{
		return date('j F Y, h:i:s', $date);
	}

	static /* ... */ function root()
	{
		return sprintf('internals%1$sforum_data%1$s', DIRECTORY_SEPARATOR);
	}
}

?>