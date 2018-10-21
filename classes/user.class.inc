<?php

class user extends source {
	function checkLogin() {
		$query = mysql_query('SELECT id FROM users WHERE login = ' . VAR_APOS . $this -> login . VAR_APOS . ' AND pass = ' . VAR_APOS . md5($this -> pass) . VAR_APOS);
		if(mysql_num_rows($query)) {
			while($row = mysql_fetch_assoc($query)) {
				return($row['id']); } } }

	function validate($action = false) {
		$query = mysql_query('SELECT id FROM users WHERE login = ' . VAR_APOS . $this -> login . VAR_APOS);

		$result = true;
		if($action == 'register' && !preg_match('/[a-zA-Z0-9¹æê³ñóœ¿Ÿ¥ÆÊ£ÑÓŒ¯]+/', $this -> login)) {
			$result = false; }
		if($action == 'register' && !preg_match(REG_STRING_EN, $this -> pass)) {
			$result = false; }
		if($action == 'register' && $this -> pass !== $this -> passRepeated) {
			$result = false; }
		if($action == 'register' && mysql_num_rows($query)) {
			$result = false; }
		/* if(!preg_match(REG_EMAIL, $this -> mail)) {
			$result = false; } */
		if(!$this -> mail || !$this -> name || !$this -> surname || !$this -> city || !$this -> address || !$this -> postCode) {
			$result = false; }
		return($result); }

	function remember_state()
	{
		setcookie('barter_login', $this -> pass, time() + 2592000);
	}
}

?>
