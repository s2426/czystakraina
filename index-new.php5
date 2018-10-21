<?php

function __start($directory = 'libraries') 
{
	foreach(glob(sprintf('%s%s*', $directory, DIRECTORY_SEPARATOR)) as $library)
	{	
		set_include_path(sprintf('%s%s.%s%s', get_include_path(), PATH_SEPARATOR, DIRECTORY_SEPARATOR, $library));
	}

	function __autoload($class)
	{
		require_once $class . '.php'; // ponizsze nie dziala, z jakiejs przyczyny
	}

	if(function_exists('spl_autoload_register'))
	{
		// spl_autoload_register();
	}
	else
	{
		header('Status: 500 Internal Server Error');
		header('Content-Type: text/plain');
		echo 'PHP requirements not satisfied!';
		die(1);
	}
}

__start();

ob_start(); // wazne
ini_set('error_reporting', null);
header('Content-Type: text/html; charset=utf-8');
session_save_path('tmp');

/*
$config						global configuration
$name						name of invoked module
$arguments					its arguments
$pathAction					data of invoked module
$pathDictionary				-//-
$pathTemplate				-//-
$user						current guest of the site
*/
ini_set('display_errors', true);

require_once('includes/constants.inc');
require_once(DIR_CLASSES . 'source.class.inc');
require_once(DIR_CLASSES . 'cart.class.inc');
require_once(DIR_CLASSES . 'category.class.inc');
require_once(DIR_CLASSES . 'counter.class.inc');
require_once(DIR_CLASSES . 'item.class.inc');
require_once(DIR_CLASSES . 'news.class.inc');
require_once(DIR_CLASSES . 'user.class.inc');
require_once(DIR_CLASSES . 'uploaded_file.class.inc');

require_once('includes/functions.inc');
require_once('includes/getters.inc');

prepareGetters();
if(!getOrder(0)) {
	setOrder(0, DEF_ACTION); }

session_start(); 
if(!getSession('language')) setSession('language', 'pl');

// przygotowujemy menu

$query = '	SELECT
				categorys.*,
				COUNT(items.id) AS items
			FROM
				categorys LEFT JOIN items
			ON
				categorys.id = items.category';
$query .= ' GROUP BY categorys.id ORDER BY siblingOrder, name' . (getSession('language') === 'en' ? '_en' : null);
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result))
{
	$menu[$row['id']] = new category;
	$menu[$row['id']] -> readHash($row);
	
	if(false === access(2))
	{
		if($menu[$row['id']] -> is_hidden())
		{
			unset($menu[$row['id']]);
		}
	}
}
//$menu = array(); // do czasu postawienia bazy danych
for($current = &current($menu); $current = &next($menu); ) $menu[$current -> category] -> categories[$current -> id] = $current;
global $menu;

// przygotowujemy licznik

$counter = new Counter;
global $counter;			// niestety siatka obiektow nie pozwala na inne rozwiazanie
foreach(array('simple', 'unique') as $type) {
	if(!$records[$type] = $counter -> get_current($type)) $records[$type] = new CounterRecord(array(
		'type' => $type,
		'path' => $type === 'simple' ? get_order_all(true) : null,
		'visits_guest' => 0,
		'visits_user' => 0,
		'visits_admin' => 0));
}

$records['simple'] -> visit();
if(!getSession('unique'))
{
	$records['unique'] -> visit();
	setSession('unique', true);
}

{
	$user = getSession('user'); // bardzo wazne! musi istniec zmienna globalna $user
	access(2);
	module('other_document_header', array('user' => getSession('user')));
}

?>