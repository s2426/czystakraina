<?php

access(2, true);

$current = new item;
$current -> readHash(getPost());

$current -> category = (strstr($current -> category, '|'))?(explode('|', $current -> category)):($current -> category);

if(getPost('sent') == 'yes') {
	$current -> price = str_replace(',', '.', $current -> price);
	$current -> category = (is_array($current -> category))?(implode('|', $current -> category)):($current -> category);
	$current -> create();
	echo mysql_error();
	menuClear(); }

?>
