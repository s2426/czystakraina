<?php

abstract class Viny_OperationWithExternalData extends Viny_Operation implements Viny_OperatesWithExternalData // get_external_* umozliwiaja pobieranie danych z _GET, _POST, ... a takze z innych zmiennych programu. nie umiescilismy tych metod powyzej, poniewaz uwazamy, ze chociaz warto jest skupic metody wyciagajace dane z zewnetrznych zrodel w klasie, ktora dokonuje zmian, to jednak powinny one zostac oddzielone od abstrakcji manipulowania trescia ... ...
{
	final function execute_with_external_data(&$result)
	{
		return $this -> execute(
			$this -> get_external_name(),
			$this -> get_external_text_new(),
			$this -> get_external_additional_operations(),
			$result
		);
	}
}

?>