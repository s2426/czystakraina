<?php

if(!access(2)) {
	unauthorised(); }

$current = new item;
$current -> read(getOrder(2));
$current -> readHash(getPost());

$current -> category = (strstr($current -> category, '|'))?(explode('|', $current -> category)):($current -> category);

if(getPost('sent') == 'yes') {
	$current -> category = (is_array($current -> category))?(implode('|', $current -> category)):($current -> category);
	$current -> update();
	menuClear(); }

?>
