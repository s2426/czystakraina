<?php 

//access(1, true);

$user = new user;
$user -> readHash(getPost());
$login = $user -> checkLogin();

if($login) {
	$user -> read($login);
	menuClear();
	setSession('user', $user); }

?>
