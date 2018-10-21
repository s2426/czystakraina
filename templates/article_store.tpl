<?php

if(isset($objects))
{
	$path = array('content/' . getOrder(1) . '.html', 'content/introduction.html');
	require $path[+!file_exists($path[0])];
}
?>
