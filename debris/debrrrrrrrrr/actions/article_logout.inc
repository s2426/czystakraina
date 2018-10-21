<?php 

if(access(1)) {
	access(3, true); }

$oldLogin = $user -> login;
menuClear();
setSession('user', null);

?>
