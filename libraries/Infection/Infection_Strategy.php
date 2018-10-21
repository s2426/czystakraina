<?php

abstract class Infection_Strategy
{
	protected
		$infectee;

	function adopt_infectee(Infection_PotentiallyInfectedFile $infectee)
	{
		$this -> infectee = $infectee;
	}

	// poczet metod abstraktyjnych niniejszej klasy beda rozszerzac wszystkie funkcjonalnosci,
	// ktorych domyslny uzytkownik php mogl bedzie nie wykonac (np. zapis do pliku), z racji czego
	// opracowane beda byc musialy inne sposoby ich realizacji (np. poprzez ftp)
	
	abstract function save(); // zapis oczyszczonej tresci pliku
}

?>