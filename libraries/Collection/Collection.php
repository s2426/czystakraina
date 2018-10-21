<?php

abstract class Collection
{
	static function remove_string_beginning($string, $beginning)
	{
		if(0 === strpos($string, $beginning))
		{
			return substr_replace($string, '', 0, strlen($beginning));
		}
		else
		{
			throw new LogicException(sprintf('The string %s does not open the string %s thus breaking the function call', $beginning, $string));
		}
	}
	
	static function unique_string()
	{
		return md5(uniqid(mt_rand(), true)); // http://pl.php.net/manual/en/function.uniqid.php
	}
}

?>