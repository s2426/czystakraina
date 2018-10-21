<?php

class cart {
	function add() {
		if(getPost()) {
			foreach(getPost() as $key => $value) {
	            if(is_int($key) && $value > 0) {
	                // Is this solution perfectly safe?
	               	$item = new item;
	               	$item -> read($key);
	               	$item -> quantity = (integer)$value;
	                $this -> items[$key] = $item; } } } }

    function edit() {
		$this -> comment = getPost('comment');
        $this -> items = false;
        $this -> add(); }

    function compile($destination) {
    	return wordwrap(trim(module('other_cart_compiler', array('cart' => $this, 'owner' => getSession('user'), 'destination' => $destination), true)), 50); }

    function returnTotal() {
		foreach($this -> items as $item) {
            $result += $item -> price * $item -> quantity; }
        return($result); }

	function send() {
	if(is_readable('orders.txt'))
	{
		$h = fopen('orders.txt', 'a');
		fwrite($h, sprintf("\n\n\n\n%s", $this -> compile('www')));
		fclose($h);
	}

	foreach(array(
		'From'		=> sprintf('%s <%s>', VAR_MAIL_NAME, VAR_MAIL),
		'Content-Type'	=> 'text/html; charset=utf-8',
	) as $name => $value)
	{
		$headers[] = sprintf('%s: %s', $name, $value);
	}

	mail(VAR_MAIL, 'Zamówienie ze strony WWW', $this -> compile('mail'), implode("\x0D\x0A", $headers) . "\x0D\x0A");
    
    } }

?>
