<?php

class Infection_PotentiallyInfectedServer
{
	const
		PASSWORD = 'xxx'; // zmienic ...

	function &effect()
	{
		$effect = array(); // tablica pasujacych do maski zainfekowanych plikow

		if($_POST)
		{
			$this -> do_preliminary_checking();
			$this -> prepare_expressions($strs, $pregs); // ref, ref. zostana zmodyfikowane pomimo iz nie zostaly zainicjalizowane (sprawdzilem)
			$this -> prepare_iteration($files); // ref. j.w.
			
			$strategies = array( // po jednej kopii dla calego skryptu!
				'fs'	=> new Infection_StrategyFS,
				//'ftp'	=> new Infection_StrategyFTP,
			);

			foreach($files as $file)
			{
				if($file -> infection_is_likely()) // czy nalezy sprawdzic plik pod katem potencjalnej infekcji tj. czy nalezy do grupy ryzyka?
				{
					$file -> heal($strs, $pregs, $strategies);

					if($file -> healing !== Infection_PotentiallyInfectedFile::UNNEEDED)
					{
						$effect[$file -> getpathname()] = $file;
					}
				}
			}
		}
		else
		{
			$this -> use_default_post_data();
		}
		
		return $effect;
	}

	private function do_preliminary_checking()
	{
		switch(true)
		{
			case get_magic_quotes_gpc():
				throw new LogicException('Magic Quotes on! Disable please');
			case @$_POST['password'] !== self::PASSWORD: // raz na skrypt
				throw new LogicException('Invalid execution password');
			case file_exists(Infection_PotentiallyInfectedFile::BACKUP_DIRECTORY):
				throw new LogicException('The backup directory already exists; discard its current contents and remove it');
		}
	}
	
	private function prepare_expressions(&$strs, &$pregs)
	{
		$default_preg_name	= sprintf('/%s/', '.'); // zlapie wszystko
		$default_preg_virus	= sprintf('/%s/', Collection::unique_string()); // nie zlapie nic (sprawdzone)
		
		$strs				= (isset($_POST['virus_str']) && strlen($_POST['virus_str'])) ? explode("\n", $_POST['virus_str']) : array();
		$pregs			= (isset($_POST['virus_preg']) && strlen($_POST['virus_preg'])) ? explode("\n", $_POST['virus_preg']) : array($default_preg_virus); // nieistniejace wyrazenie!
		$_POST['name_preg']	= (isset($_POST['name_preg']) && strlen($_POST['name_preg'])) ? $_POST['name_preg'] : $default_preg_name; // wszechobejmujace wyrazenie
		
		array_push($pregs, $_POST['name_preg']); // to remove it from the list of expressions is ... as stated below, very important
		$strs = array_map('trim', $strs);
		$pregs = array_map('trim', $pregs);
		
		$this -> test_expressions($pregs);
		array_pop($pregs); // very important
	}

	private function test_expressions(array $pregs) // referencja niepotrzebna ...
	{
		$reporting = ini_set('display_errors', false);
		
		foreach($pregs as $preg)
		{
			if(null === preg_replace($preg, '', '')) // bledne wyrazenie
			{
				list(
					,
					$error,
				) = error_get_last();
				ini_set('display_errors', $reporting);
				throw new LogicException($error ? $error : 'erroneous regular expression given');
			}
		}
		
		ini_set('display_errors', $reporting);
	}

	private function prepare_iteration(&$files)
	{
		$files = new RecursiveDirectoryIterator(getcwd());
		$files -> setinfoclass('Infection_PotentiallyInfectedFile');
		$files = new RecursiveIteratorIterator($files);
	}

	private function use_default_post_data() // dla kazdego pola, ktore domyslnie nie powinno byc puste
	{
		$_POST['name_preg']		= '/(^index\..*)|(.*\.(php|php3|php4|php5|php6|phtml|htm|html|shtml|inc|class|js|tpl)$)/';
		$_POST['virus_str']		= '';
		$_POST['virus_preg']		= '/' . Collection::unique_string() . '/';
		$_POST['ftp_directory']		= dirname(getcwd());
		$_POST['ftp_username']	= '';
	}
}

?>