<?php

access(1, true);

if(!$user -> cart -> items) {
	$user -> cart = new cart; }

if(getOrder(1) == 'add') {
	$user -> cart -> add(); }
if(getOrder(1) == 'edit') {
	$user -> cart -> edit(); }

setSession('user', $user);

?>
