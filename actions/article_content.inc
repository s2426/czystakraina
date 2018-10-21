<?php

try
{
	$names = new Barter_AccessArticle(null, null, null, $data);
	$names = $names -> get_siblings($names_final);
}
catch(Exception $error)
{
  $names = array();
}

$resources_last_index = sizeof($names) - 1;
$page_size = (isset($page_size) && is_int($page_size)) ? $page_size : 5;
$page_number_last = floor($resources_last_index / $page_size);
$page_number_of_human = abs(intval(isset($_GET['page']) ? ($_GET['page'] - 1) : 0));
$page_number_of_system = min($page_number_of_human, $page_number_last);

$names_final = array_slice($names_final, $page_number_of_system * $page_size, $page_size);

?>