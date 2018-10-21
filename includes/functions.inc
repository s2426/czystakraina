<?php

function message($more = null)
{
	if(null === $message)
	{
		static
			$message = '';
	}
	
	return $message = trim(sprintf('%s %s', trim($message), trim($more)));
}

function access($rank, $redirectOnFailure = false) {
	$user = getSession('user');
	$access = $user -> rank >= $rank;
	if(!$access && $redirectOnFailure) {
    exit_gracefully(); }
	return($access); }

// http://be2.php.net/manual/pl/ref.array.php#59386
function array_flatten($array) {
	while(($v = array_shift($array)) !== null) {
		if(is_array($v)) {
			$array = array_merge($v, $array); }
		else {
			$tmp[] = $v; } }
	return $tmp; }

function array_string($array, $suffix) {
	$arrayCount = count($array);
	foreach($array as $element) {
		$result .= $element;
		if($integer < $arrayCount - 1) {
			$result .= $suffix; }
		$integer++; }
	return($result); }

function encode($string) {
	return(trim(htmlspecialchars($string, ENT_QUOTES))); }

function extension($path) {
	return(substr($path, strrpos($path, '.') + 1)); }

if(!function_exists('file_put_contents'))
{
	function file_put_contents($file, $text, $mode = 'w')
	{
		$handler = fopen($file, $mode);
		fwrite($handler, $text);
		fclose($handler);
	}
}

function get_directory_contents($path) {
	# This function requires its argument
	# to be passed with an ending slash

	if($directory = opendir($path)) {
		while(false !== ($file = readdir($directory))) {
			if(is_file($path . $file) and $file{0} !== '.') {
				$files[] = $file; } }
		closedir($directory); }
	return($files); }

function get_max_upload() {
	# This function assumes that max size is given in megabytes
	# and appended with 'M'. It returns value in kilobytes.

	$max_upload = str_replace('M', false, ini_get('upload_max_filesize'));
	$max_post = str_replace('M', false, ini_get('post_max_size'));

	return((($max_post < $max_upload)?($max_post):($max_upload)) << 10); }

// http://pl2.php.net/manual/en/function.is-array.php#63780
function is_assoc($array) {
	if(!is_array($array) || empty($array)) {
		return(false); }
	$keys = array_keys($array);
	return(array_keys($keys) !== $keys); }

/*//let this terrible ancient piece rot commented!...
function menu($startCategory) {
	if(!$top = getSession('menu')) {
		$top = new category;
		$top -> read(VAR_TOP_CATEGORY);
		$top -> buildTree();
		setSession('menu', $top); }
	// menuFind expects an array
	return(menuSearch(array($top), $startCategory)); }
*/
function menuClear() {
	setSession('menu', false); }
/*
function menuSearch($array, $searched) {
	static $result;
	foreach($array as $element) {
		if($element -> id == $searched) {
			$result = $element; }
		elseif($element -> categories) {
			menuSearch($element -> categories, $searched); } }
	return($result); }
*/
function module($name, $arguments = false, $return = false) {
	if(is_assoc($arguments)) {
		foreach($arguments as $key => $value) {
			${$key} = $value; } }

	$pathAction = DIR_ACTIONS . $name . '.inc';
	$pathDictionary = DIR_DICTIONARIES . $name . '.ini';
	$pathTemplate = DIR_TEMPLATES . $name . '.tpl';

	if(file_exists($pathAction)) {
		require($pathAction); }
	if(file_exists($pathDictionary)) {
		prepareDictionary($pathDictionary); }
	if(file_exists($pathTemplate)) {
		if($return) {
			// zawartosc funkcji require_variable zostala tu przeniesiona
			// aby kontekst wywolania szablonu modulu byl identyczny
			// z kontekstem jego argumentow
			ob_start();
			require($pathTemplate);
			$result = ob_get_contents();
			ob_end_clean(); }
		else {
			require($pathTemplate); } }
	return $result; }

function prepareDictionary($dictionary) {
	global $config;

	$language = (getSession('language'))?(getSession('language')):(DEF_LANGUAGE);
    foreach(file($dictionary) as $line) {
		$parts = explode(VAR_SEPARATOR, $line);
		if($language == 'en') {
			$word = $parts[1]; }
        if($language == 'pl') {
            $word = $parts[2]; }
		$config['word'][trim($parts[0])] = trim($word); } }

function prepareGetters() {
	global $config;

	// Database handler
	$config['db'] = mysql_connect('localhost', 'jakasia', 'greentara');
	mysql_select_db('jakasia_ck');
	mysql_query('SET character_set_client = utf8'); // vin
	mysql_query('SET character_set_connection = latin2'); // vin
	mysql_query('SET character_set_results = utf8'); // vin

	// Request URL arraystrrpos

	// how ridiculously complex style of simulating query strings!

	$url_parts = explode('?', $_SERVER['REQUEST_URI']);
	parse_str($url_parts[1], $_GET);
	$config['order'] = explode(VAR_SLASH, trim($url_parts[0], VAR_SLASH));
	// HTTP POST method
	foreach($_POST as $key => $value) {
		if(is_string($value)) {
			$config['post'][$key] = encode($value); }
		elseif(is_array($value)) {
			foreach($value as $valueKey => $valueValue) {
				$config['post'][$key][$valueKey] = encode($valueValue); } } }

	// Sessions
	session_start();
	$config['session'] = $_SESSION; }

function redirect($location) {
  // debug_print_backtrace();
  //die;
	header('location: ' . $location); }

function require_variable($filename) {
	ob_start();
	require($filename);
	$result = ob_get_contents();
	ob_end_clean();
	return($result); }

function what($v,$d=false){echo'<pre>';var_dump($v);echo'</pre>';if($d)die();}

function unauthorised() { exit_gracefully(); }

function exit_gracefully($no_redirect = false)
{
  // header()!
  module('other_document_footer');
  if(!$no_redirect) redirect('/');
  die(1);
}

function debug($value)
{
  // pozostaje puste
}

function get_links($banners = false)
{
	if($result = mysql_query(sprintf('SELECT `id`, `name`, `description` FROM `items` WHERE `category` = %d ORDER BY `siblingOrder`', VAR_LINKS_CATEGORY)))
	{
		while($link = mysql_fetch_assoc($result))
		{
			$id = $ids[] = (integer)$link['id'];
			$real_links[$id] = new Item;
			$real_links[$id] -> readhash($link);
			$real_links[$id] -> illustrations = null;
		}
	}

	if(isset($ids) && is_array($ids) && sizeof($ids))
	{
		if($result = mysql_query(sprintf('SELECT `item`, `text` FROM `illustrations` WHERE `type` = \'item\' && `item` IN (%s)', implode(', ', $ids))))
		{
			while($illustration = mysql_fetch_object($result))
			{
				$real_links[(integer)$illustration -> item] -> illustrations = explode("\n", $illustration -> text);
			}
		}
	}
	
	if($banners) // jesli chcemy wylacznie linkow ilustrowanych
	{
		foreach($real_links as $index => $real_link)
		{
			if(null === $real_link -> illustrations)
			{
				unset($real_links[$index]);
			}
		}
	}

	foreach($real_links as &$real_link)
	{
		if(isset($real_link -> illustrations) && is_array($real_link -> illustrations))
		{
			foreach($real_link -> illustrations as &$illustration)
			{
				$illustration_stored	= $illustration;
				$illustration_pathed	= sprintf('/images/items/%s', $illustration_stored);
				$illustration = new StdClass;
				$illustration -> path = $illustration_pathed;

				list(
					$illustration -> width,
					$illustration -> height,
				) = path_to_rescaled_dimensions($illustration_stored, 140);
			}
		}
	}
	
	return $real_links;
}

function forum_login($message = 'Proszę się zalogować, aby móc przeglądać wybrane forum:', $display_always = false)
{
	if((false === (boolean)access(1)) || $display_always)
	{
		require_once 'internals/forum_includes/log.html';
		exit_gracefully(true);
	}
}

function path_to_rescaled_dimensions($path, $desired_width)
{
	if(is_readable($path = sprintf('images/items/%s', $path)))
	{
		list(
			$width,
			$height,
		) = getimagesize($path);
		
		$size = new Viny_Dimensions(array(
			$width,
			$height,
		));
		
		return $size -> ratio_of_dimension_to_size($desired_width, 0);
	}
	else
	{
		return array(
			null,
			null,
		);
	}
}
  
function extract_order_from_article($article)
{
	$data = @preg_match('/^<!--(\d+)-->\n/ms', $article, $matches);
	return @intval($matches[1]);
}

function extract_text_from_article($article)
{
	$data = @preg_match('/^(?:<!--\d+-->\n)?(.*)/ms', $article, $matches); // ...
	return @strval($matches[1]);
}
  
?>