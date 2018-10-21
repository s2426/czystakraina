<?php

access(2, true);

$current = new category;
$current -> read(getOrder(1));
$current -> readHash(getPost());

$current -> category = (strstr($current -> category, '|'))?(explode('|', $current -> category)):($current -> category);

if(getPost('sent') == 'yes') {
	$current -> category = (is_array($current -> category))?(implode('|', $current -> category)):($current -> category);
	$current -> recommended = (int)$current -> recommended;
	$current -> update();
	menuClear(); }

?>
