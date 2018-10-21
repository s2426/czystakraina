<?php 

//access(1, true);

$user = new user;
$user -> readHash(getPost());
$login = $user -> checkLogin();

if(access(1))
{
  @header(sprintf('Location: %s', $_POST['redirect'] ? $_POST['redirect'] : '/?logged=on'));
}
else
  {

if($login) {
	$user -> read($login);
  $user -> remember_state();
	menuClear();
	setSession('user', $user);
  @header(sprintf('Location: %s', $_POST['redirect'] ? $_POST['redirect'] : '/?logged=on')); }
}

?>