<?php

class Viny_OperationFile extends Viny_Operation implements Viny_InterfaceSiblingsProvider
{
	protected
		$prefix,
		$suffix;

	function __construct($prefix, $suffix)
	{
		$this -> prefix = $prefix;
		$this -> suffix = $suffix;
	}

	protected function create_and_update($error_action)
	{
		switch(false)
		{
			case @file_put_contents($this -> to_path(), $this -> get_raw_created_or_updated_text(), LOCK_EX):
			case @chmod($this -> to_path(), 0777):
				//@unlink($this -> to_path());
				throw new Viny_ExceptionFailedOperation(null, $error_action);
			}
	}

	protected function get_raw_created_or_updated_text()
	{
		return $this -> get_prepared_text_new();
	}

	function create()
	{
		$this -> create_and_update(parent::CREATE);
	}

	function read()
	{
		if(false === $this -> text_old = @file_get_contents($this -> to_path()))
		{
			$this -> text_old = null; // bardzo istotne, $this -> text_new nie moze pozostac false!
			throw new Viny_ExceptionFailedOperation(null, parent::READ);
		}
	}

	function update()
	{
		$this -> create_and_update(parent::UPDATE);
	}

	function delete()
	{
		if(false === unlink($this -> to_path()))
		{
			throw new Viny_ExceptionFailedOperation(null, parent::DELETE);
		}
		
		// usuwamy cos?
	}
	
	function exists()
	{
		return is_readable($this -> to_path());
	}

	function prepare_name($name)
	{
		$name = trim($name);

		if(is_string($name) && strlen($name)) // w przeciwnym wypadku, np. braku sciezki, null i komunikat o bledzie!
		{
			return $this -> name = $name;
		}
	}
	
	function prepare_text_new($text_new)
	{
		if(is_string($text_new)) // nie potrzeba strlen
		{
			return $this -> text_new = $text_new;
		}
	}
	
	function get_siblings() // returns something iterable
	{
		return is_array($result = @array_map(array(
			$this,
			'to_name',
		), glob($this -> glob_argument()))) ? $result : array();
	}

	protected function to_name($path) // z argumentu
	{
		return basename($path, $this -> suffix);
	}

	protected function to_path() // z $this
	{
		return sprintf('%s%s%s', $this -> prefix, $this -> get_prepared_name(), $this -> suffix);
	}
	
	protected function glob_argument()
	{
		return sprintf('%s*%s', $this -> prefix, $this -> suffix);
	}
}

?>