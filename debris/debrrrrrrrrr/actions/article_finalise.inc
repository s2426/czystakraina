<?php 

access(1, true);
if(!$user -> cart) {
	redirect('/'); }

if(getOrder(1) == 'confirmed') {
	$user -> cart -> send();
	$user -> cart = false;
	setSession('user', $user); }

?>
