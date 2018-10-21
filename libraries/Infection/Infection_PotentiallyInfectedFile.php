<?php

class Infection_PotentiallyInfectedFile extends SplFileInfo
{
	const
		DONE			= 1,
		UNDONE		= 2,
		UNNEEDED		= 4;
	const
		BACKUP_DIRECTORY	= 'virus_removal_backup', // nazwa powinna byc dosyc nietypowa
		BACKUP_PERMISSIONS	= 0707; // user, world = all, group = none // zezwolenia kopii zapasowych
	private
		$text;
	public // dla wygody
		$error;

	function __construct($name)
	{
		parent::__construct($name);
		
		// z jakiegos powodu ponizsze nie moga byc umieszczone w deklaracji klasy. moze dlatego, ze dziedziczy po klasie wbudowanej?
		$this -> copying	= self::UNNEEDED;
		$this -> healing	= self::UNNEEDED;
	}

	function text()
	{
		return $this -> text;
	}

	function infection_is_likely()
	{
		return
			$this -> isfile() && // plik
			($this -> getsize() < 0x100000) && // plik jest mniejszy niz 1 MB
			(false === strpos($this -> getpathname(), self::BACKUP_DIRECTORY)) && // nie sprawdzamy katalogu z kopiami ...
			preg_match($_POST['name_preg'], $this -> getpathname()) // nazwa pliku pasuje do maski
		;
	}

	function heal(array $strs, array $pregs, array $strategies)
	{
		if(is_string($this -> text = file_get_contents($this -> getpathname())))
		{
			$this -> text = preg_replace($pregs, '', str_replace($strs, '', $this -> text, $count_str), -1 /* maksimum zastapien - nie dotyczy */, $count_preg); // ograniczamy liczbe odczytan/zapisan zmiennych. i: najpierw str, nastepnie preg

			if($count_str || $count_preg)
			{
				$this -> copying = $this -> healing = self::UNDONE;
				
				try
				{
					$this -> backup(); // wyrzuca wyjatek w razie bledu
					$this -> copying	= self::DONE;
					$this -> save($strategies); // j.w.
					$this -> healing	= self::DONE;
				}
				catch(Exception $error)
				{
					$this -> error = $error;
				}
			}
		}
		
		unset($this -> text); // pomaga pamieci?
	}

	private function backup()
	{
		$backup_file		= sprintf('%s%s%s', self::BACKUP_DIRECTORY, DIRECTORY_SEPARATOR, Collection::remove_string_beginning($this -> getpathname(), getcwd()));
		$backup_directory	= dirname($backup_file);
		
		$this -> make_backup_directory($backup_directory);
		$this -> make_backup_file($backup_file);
	}

	private function make_backup_directory($target)
	{
		if(false === file_exists($target))
		{
			if(false === mkdir($target, self::BACKUP_PERMISSIONS, true)) // true == recursive
			{
				throw new LogicException('Creating a backup subdirectory for a given file failed');
			}
		}
	}

	private function make_backup_file($target)
	{
		if(false === copy($this -> getpathname(), $target))
		{
			throw new LogicException('Backing a file up failed');
		}
	}
	
	private function save(array $strategies)
	{
		foreach($strategies as $strategy)
		{
			try
			{
				$strategy -> adopt_infectee($this);
				$strategy -> save();

				return; // jesli nie wyrzucono wyjatku sprawdzajac dana strategie ...
			}
			catch(Exception $error)
			{
				
			}
		}

		throw new LogicException('Saving failed under every strategy attempted');
	}
}

?>