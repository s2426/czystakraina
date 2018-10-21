<?php

class Custom
{
	static function mkdir_r($dirName, $rights=0777){ // http://pl2.php.net/manual/pl/function.mkdir.php#68207
    $dirs = explode('/', $dirName);
    $dir='';
    foreach ($dirs as $part) {
        $dir.=$part.'/';
        if (!is_dir($dir) && strlen($dir)>0)
            mkdir($dir, $rights);
    }
}

	static function windows()
	{
		return (boolean)preg_match('/^win/i', php_uname('s'));
	}
}

?>