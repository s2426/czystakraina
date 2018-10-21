<?php

class Viny_Dimensions
{
	private
		$dimensions,
		$callback,
		$prevent_increasing;

	function __construct(array $dimensions = null, $callback = null, $prevent_increasing = false)
	{
		$this -> dimensions		= is_array($dimensions) ? array_values($dimensions) : array();
		$this -> callback			= strlen($callback) ? strval($callback) : array($this, 'do_nothing',);
		$this -> prevent_increasing	= (boolean)$prevent_increasing;
	}
	
	function ratio($ratio)
	{
		if($ratio > 1 && $this -> prevent_increasing)
		{
			return $this -> dimensions;
		}
		else
		{
			foreach($this -> dimensions as $dimensions)
			{
				$effect[] = $this -> apply_callback($dimensions * $ratio);
			}
			
			return $effect;
		}
	}
	
	function ratio_of_dimension_to_size($size, $dimension_index)
	{
		return $this -> ratio($size / $this -> dimensions[$dimension_index]);
	}

	function ratio_of_largest_dimension_to_size($size)
	{
		return $this -> ratio_of_dimension_to_size($size, array_search(max($this -> dimensions), $this -> dimensions, true));
	}
	
	protected function apply_callback($argument)
	{
		return call_user_func($this -> callback, $argument);
	}
	
	protected function do_nothing($argument)
	{
		return $argument;
	}
}

?>