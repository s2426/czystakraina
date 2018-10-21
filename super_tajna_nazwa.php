<?php

function __start($directory = 'libraries') 
{
	foreach(glob(sprintf('%s%s*', $directory, DIRECTORY_SEPARATOR)) as $library)
	{	
		set_include_path(sprintf('%s%s%s', get_include_path(), PATH_SEPARATOR, $library));
	}

	if(function_exists('spl_autoload_register'))
	{
		//spl_autoload_register();
		
		function __autoload($class)
		{
			require $class . '.php';
		}
	}
	else
	{
		header('Status: 500 Internal Server Error');
		header('Content-Type: text/plain');
		echo 'PHP requirements not satisfied';
		die(1);
	}
}

__start();

try
{
	$effect = new Infection_PotentiallyInfectedServer;
	$effect = &$effect -> effect(); // referencja, poniewaz mozliwe, ze ponizej bedziemy te tablice zmieniac
	$target = $_SERVER['PHP_SELF'];
}
catch(Exception $error)
{
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: text/plain');
	
	if($error -> getmessage())
	{
		printf('Błąd: %s!', $error -> getmessage());
	}
	else
	{
		var_dump($error);
	}
	
	die(1); // wywola __destruct
}

?>
<!DOCTYPE html> 
<meta charset='UTF-8'>
<title>Skaner</title>
<?if($effect):?>
<p>Lista zainfekowanych plików
<ol>
<?foreach($effect as $file):?>
	<li><?=$file?>
	<ul>
		<li><?=($file -> copying === Infection_PotentiallyInfectedFile::UNDONE) ? 'nie ' : ''?>skopiowano
		<li><?=($file -> healing === Infection_PotentiallyInfectedFile::UNDONE) ? 'nie ' : ''?>uleczono
		<li>Ostatnia modyfikacja: <?=date('Y-m-d, H:i:s', $file -> getmtime())?>
	</ul>
<?endforeach?>
</ol>
<?endif?>

<form action='<?=htmlspecialchars($target)?>' method='post'> <!-- $_POST beda zawsze, ew. uzupelniane automatycznie -->
<ul>
	<li>Hasło skryptu:<br>
	<input name='password' type='password'>
	<li>Wyrażenie regularne dokumentów:<br>
	<input name='name_preg' size='80' value='<?=htmlspecialchars($_POST['name_preg'])?>'> (uzupełnij wg wzoru i potrzeby)
	<li>Wyrażenia bezpośrednie wirusów:<br>
	<textarea name='virus_str' rows='5' cols='80'><?=htmlspecialchars($_POST['virus_str'])?></textarea>
	<li>Wyrażenia regularne wirusów (pamiętaj o ogranicznikach, np. ukośnikach):<br>
	<textarea name='virus_preg' rows='5' cols='80'><?=htmlspecialchars($_POST['virus_preg'])?></textarea>
	<li>Katalog FTP (pełna ścieżka z separatorem wiodącym i bez separatora wieńczącego, np. <samp>/home/user</samp>):<br>
	<input name='ftp_directory' size='100' value='<?=htmlspecialchars($_POST['ftp_directory'])?>'><br>
	<li>Użytkownik FTP:<br>
	<input name='ftp_username' value='<?=htmlspecialchars($_POST['ftp_username'])?>'>
	<li>Hasło FTP:<br>
	<input name='ftp_password' type='password'>
</ul>
<p><label>Rozpocznij <input type='submit' value='oczyszczanie'>!</label>
</form>