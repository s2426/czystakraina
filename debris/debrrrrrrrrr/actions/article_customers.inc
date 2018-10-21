<?php

access(2, true);

if(getOrder(1)) {
	$current = new user;
    $current -> read(getOrder(1)); }

if(getOrder(2) == 'edit') {
	$current -> readHash(getPost());
	$current -> update(); }
elseif(getOrder(2) == 'delete') {
	$current -> delete();
	$current = false; }

$query = mysql_query("SELECT id FROM users ORDER BY surname");
while($row = mysql_fetch_assoc($query)) {
    $db = new user;
    $db -> read($row['id']);
    $customers[] = $db; }

?>
