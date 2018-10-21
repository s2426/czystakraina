<?php

abstract class Barter_Access extends Viny_OperationWithExternalData // prawdopodobnie tutaj umieszcze kod zwiazany z ilustracjami
{
	private
		$illustrations,
		$message;
	const
		PARAMETER_NAME	= 'content_name', // name jest zajete, albo przynajmniej bezpiecznie jest z niego zrezygnowac: taka bywa kolumna w tabeli danych
		PARAMETER_TYPE	= 'content_type'; // dla konsekwencji z powyzszym

	function __construct()
	{
		$this -> illustrations_access = new Barter_Illustration;
	}

	function message($more = null)
	{
		return $this -> message = trim(sprintf('%s %s', trim($this -> message), trim($more)));
	}
	
	function manager_url($path, $type = null, array $array = null)
	{
		if(is_array($array))
		{
			$parameters = $array;
		}
		elseif($this -> get_prepared_name())
		{
			$parameters = array(
				self::PARAMETER_NAME => ($this -> operation instanceof Barter_AccessArticle) ? $this -> get_prepared_name() : $this -> get_prepared_name() -> index // w przypadku zrodel: sam identyfikator, klase przekazemy typem
			);
		}
		
		if(false === isset($parameters[self::PARAMETER_TYPE]))
		{
			$parameters[self::PARAMETER_TYPE] = $type; // jezeli $type === null, to klucza odpowiadajacemu typowi w wynikowym ciagu zapytania ... nie bedzie!
		}
	
		return trim(sprintf('%s?%s', $path, http_build_query($parameters)), '?'); // funkcja stosuje urlencode, nie rawurlencode ... to zaszkodzi?
	}

	function get_external_additional_operations()
	{
		return @(intval($_POST[Viny_Operation::DELETE]) | intval($_POST[Viny_Operation::PREVIEW]));
	}

	private function get_external_illustrations_array()
	{
		switch(false)
		{
			case isset($_POST['illustrations']):
			case strlen($_POST['illustrations']):
				$array = array();
				break;
			default:
				$array = explode("\n", $_POST['illustrations']);
		}

		foreach($array as &$element)
		{
			$element = trim($element);
		}
		
		return $array;
	}

	function create()
	{
		try
		{
			$this -> illustrations_access -> execute($this, $this -> get_external_illustrations_array(), null, $foo);
			$this -> illustrations = $foo -> text;
		}
		catch(Viny_ExceptionAbsentTextNew $error)
		{
			// ignorujemy
		}
	}

	function update()
	{
		try
		{
			$this -> illustrations_access -> execute($this, $this -> get_external_illustrations_array(), null, $foo);
			$this -> illustrations = $foo -> text;
		}
		catch(Viny_ExceptionAbsentTextNew $error)
		{
			// ignorujemy
		}
	}
	
	function read()
	{
		try
		{
			$this -> illustrations_access -> execute($this, null, null, $effect);
		}
		catch(Viny_ExceptionAbsentTextNew $error)
		{
			// ignorujemy
		}
		
		$this -> illustrations = $effect -> text;
	}
	
	function delete()
	{
		try
		{
			$this -> illustrations_access -> execute($this, null, Viny_Operation::DELETE, $foo);
		}
		catch(Viny_ExceptionAbsentTextNew $error)
		{
			// ignorujemy
		}
	}
	
	function get_illustrations()
	{
		return is_array($this -> illustrations) ? $this -> illustrations : array();
	}
}

?>