<?php

class Viny_ForumBrowser extends RecursiveIteratorIterator
{
	function __construct($path = '', $node_types = Viny_Forum::MESSAGES, $recurse = false)
	{
		$iterator = new Viny_Forum($path, $node_types, $recurse);
		$flags = ($node_types & Viny_Forum::SECTIONS) ? self::SELF_FIRST : self::LEAVES_ONLY;

		parent::__construct($iterator, $flags);
	}
	
	function sort_messages(Viny_Element $one, Viny_Element $two)
	{
		return ($one -> getctime() < $two -> getctime()) ? 1 : -1;
	}

	function sort_threads(Viny_Element $one, Viny_Element $two)
	{
		// getctime === data utworzenia, getmtime === data zmienienia
		$one_date = $one -> get_messages() ? $one -> first_message() -> getctime() : 0;
		$two_date = $two -> get_messages() ? $two -> first_message() -> getctime() : 0;
		
		return ($one_date < $two_date) ? 1 : -1;
	}
}

?>