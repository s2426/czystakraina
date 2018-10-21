<?php

abstract class Viny_ExceptionAbsent extends LogicException
{
	private
		$access;

	function __construct($message = null, $code = null)
	{
		parent::__construct($message, $code);

		foreach(debug_backtrace() as $step)
		{
			if(isset($step['object']))
			{
				if($step['object'] instanceof Viny_Operation)
				{
					return $this -> access = $step['object'];
				}
			}
		}
	}
	
	function get_access()
	{
		return $this -> access;
	}
}

?>