<?php

if(getOrder(1) === '124')
{
	access(2, true);
}

$category = new category;
$category -> read(getOrder(1));
$category -> getItems();

?>
