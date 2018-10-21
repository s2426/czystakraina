<?php

access(2, true);

$current = new category;
$current -> read(getOrder(1));
if($current -> id) {
	$current -> getCategories();
	$current -> getItems(); }

if(!getOrder(1)) {
	setFlag('notChosen', true); }
elseif($current -> categories || $current -> items) {
	setFlag('hasChildren', true); }
elseif(getOrder(2) != 'confirmed') {
	setFlag('noConfirm', true); }
else {
	$current -> delete();
	menuClear(); }

?>
