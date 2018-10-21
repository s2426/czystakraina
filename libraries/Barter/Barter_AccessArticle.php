<?php

class Barter_AccessArticle extends Barter_Access implements Viny_InterfaceSiblingsProvider
{
	const
		PARAMETER_TEXT = 'text',
		PARAMETER_ORDER = 'text_order',
		PARAMETER_INTRODUCTION = 'introduction';
	
	function __construct()
	{
		$this -> file = new Viny_OperationFile(sprintf('internals%1$sarticles%1$s', DIRECTORY_SEPARATOR), '.html');
		parent::__construct();
	}
	
	// z 11 metod? ... ...

	function read()
	{
		$this -> file -> {__FUNCTION__}();
		parent::read();
	}

	function create()
	{
		$this -> file -> {__FUNCTION__}();
		parent::create();
	}

	function update()
	{
		$this -> file -> {__FUNCTION__}();
		parent::update();
	}

	function delete()
	{
		$this -> file -> {__FUNCTION__}();
		parent::delete();
	}
	
	function exists()
	{
		return $this -> file -> {__FUNCTION__}();
	}
	
	function get_siblings(&$names_final = null)
	{
		$effect = $this -> file -> {__FUNCTION__}();

		$names_final = array();

		foreach($effect as $index => $name)
		{
			$document = new DOMDocument;

			try
			{
				$names_final[] = new Barter_News($name, $document);
			}
			catch(Exception $error)
			{
				//echo $name, $error -> getmessage(), "<br>";
			}
		}
		
		@usort($names_final, 'Barter_News::sort');
		
		$effect = array();
		foreach($names_final as $name_final)
		{
			$effect[] = $name_final -> name;
		}

		return $effect;
	}

	function prepare_name($name)
	{
		return $this -> file -> {__FUNCTION__}($name);
	}
	
	function prepare_text_new($text_new)
	{
		return $this -> file -> {__FUNCTION__}($text_new);
	}

	function get_prepared_name()
	{
		return $this -> file -> {__FUNCTION__}();
	}

	function get_prepared_text_old()
	{
		return $this -> file -> {__FUNCTION__}();
	}

	function get_prepared_text_new()
	{
		return $this -> file -> {__FUNCTION__}();
	}

	function get_external_name()
	{
		return @$_REQUEST[Barter_Access::PARAMETER_NAME]; // czy kolejnosc to GP czy PG chyba nie jest zbyt istotne
	}
	
	function get_external_text_new()
	{
		return isset($_POST[self::PARAMETER_TEXT]) ? @sprintf("<!--%d-->\n%s", $_POST[self::PARAMETER_ORDER], $_POST[self::PARAMETER_TEXT]) : null;
	}
}

?>