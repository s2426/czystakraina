<?php

$item = new item;
$item -> read(getOrder(1));
echo'<!--';var_dump($item);echo'-->';

$itemCategory = new category;
$itemCategory -> read($item -> category);

if($itemCategory) {
	$ascendants = $itemCategory -> getAscendants();
	$ascendants = array_flatten($ascendants);
	$ascendants = array_reverse($ascendants); }

?>
