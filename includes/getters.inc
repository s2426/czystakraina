<?php

function getDb() {
	global $config;
	return($config['db']); }
function getFlag($name) {
	global $config;
	return($config['flag'][$name]); }
function getOrder($name) {
	global $config;
	return($config['order'][$name]); }
function getPost($name = false) {
	global $config;
	return(($name)?($config['post'][$name]):($config['post'])); }
function getSession($name) {
	global $config;
	return($config['session'][$name]); }
function getWord($name) {
	global $config;
	return($config['word'][$name]); }

function setFlag($name, $value) {
	global $config;
	$config['flag'][$name] = $value; }
function setOrder($name, $value) {
	global $config;
	$config['order'][$name] = $value; }
function setSession($name, $value) {
	global $config;
	$config['session'][$name] = $value;
	$_SESSION[$name] = $value; }
function setWord($name, $value) {
	global $config;
	$config['word'][$name] = $value; }

function get_order_all($deal_with_start = false)
{
	// prawdziwosc argumentu powoduje, ze nigdzie (np. w liczniku)
	// nie zostanie zapisana informacja o wartosci 'start'

	global $config;
	$result = $config['order'];
	if($deal_with_start && ($key = array_search('start', $result)) === 0) unset($result[$key]);
	return $result;
}

?>
