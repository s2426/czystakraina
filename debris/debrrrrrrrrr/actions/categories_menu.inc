<?php

// deklarujemy kilka zmiennych przydatnych przy
// wyswietlaniu listy

$first	= true;
$start	= $start ? $start : VAR_TOP_CATEGORY;

// deklarujemy sama liste

global $menu;
$parent = &$menu[$start];

?>
