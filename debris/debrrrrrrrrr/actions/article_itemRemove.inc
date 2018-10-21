<?php

access(2, true);

$current = new item;
$current -> read(getOrder(2));

if(getOrder(3) == 'confirmed') {
	$current -> delete();
	menuClear(); }

?>
