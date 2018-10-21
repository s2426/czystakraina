<?php

if(getOrder(1) == 'register' && !access(1)) {
    $current = new user; }
elseif(getOrder(1) == 'edit' && access(1)) {
	$current = getSession('user'); }
else {
	redirect('/'); }

$current -> readHash(getPost());

if(!getPost('sent')) {
	setFlag('registerUntouched', true); }
elseif(!$current -> validate(getOrder(1))) {
	setFlag('registerInvalid', true); }
elseif(getOrder(1) == 'register') {
	$current -> comment = 'brak komentarza';
	$current -> pass = md5($current -> pass);
	$current -> rank = 1;
	$current -> create();
	setFlag('registerCreated', true); }
elseif(getOrder(1) == 'edit') {
	$current -> update();
	setSession('user', $current);
	setFlag('registerUpdated', true); }

?>
