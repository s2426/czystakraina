<?php

$category = new category;
$category -> read(getOrder(1));
$category -> getItems();

if($category -> is_hidden())
{
  access(2, true);
}

?>
