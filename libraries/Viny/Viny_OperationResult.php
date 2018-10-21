<?php

class Viny_OperationResult extends ArrayObject // jak z referencjami?
{
	function __get($name) // cukier
	{
		if(isset($this[$name]))
		{
			return $this[$name];
		}
		else
		{
			throw new BadMethodCallException(sprintf('Zażądano nieistniejącej właściwości wyniku dostępu (%s)', $name));
		}
	}
}

?>