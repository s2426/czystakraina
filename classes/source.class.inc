<?php // dodano mysql_real_escape_string

class source {
	function getColumns() {
		$query = mysql_query('SHOW COLUMNS FROM ' . $this -> getTable());
		while($row = mysql_fetch_assoc($query)) {
			$result[] = $row; }
		return($result); }

	function getTable() {
		return(get_class($this) . VAR_PLUR); }

	function create() {
		foreach($this -> getColumns() as $column) {
			if($column['Field'] !== VAR_KEY) {
				$names[] = $column['Field'];
				$values[] = VAR_APOS . mysql_real_escape_string($this -> $column['Field']) . VAR_APOS; } }
		if($this -> validate()) {
			return(mysql_query('INSERT INTO ' . $this -> getTable() . ' (' . array_string($names, ', ') . ') VALUES ' . ' (' . array_string($values, ', ') . ')')); } }

	/* stara wersja, sprzed wprowadzenia obiektowej obslugi baz
	function read($id) {
		if($this -> checkExistence($id)) {
			$query = mysql_query('SELECT * FROM ' . $this -> getTable() . ' WHERE id = ' . VAR_APOS . $id . VAR_APOS, getDb());
			$this -> readHash(mysql_fetch_assoc($query)); } }
	*/

	// nowa wersja: przystosowana do powyzszego
	function read($id) {
		if($this -> checkExistence($id)) {
			$query = mysql_query('SELECT * FROM ' . $this -> getTable() . ' WHERE id = ' . VAR_APOS . $id . VAR_APOS, getDb());
			$this -> readHash($array = mysql_fetch_assoc($query)); }
		return @(is_array($array) ? $array : null); }

	function update() {
		foreach($this -> getColumns() as $column) {
			if($column['Field'] !== VAR_KEY) {
				$subqueries[] = $column['Field'] . ' = ' . VAR_APOS . mysql_real_escape_string($this -> $column['Field']) . VAR_APOS; } }
		if($this -> checkExistence($this -> id) && $this -> validate()) {
			return(mysql_query('UPDATE ' . $this -> getTable() . ' SET ' . array_string($subqueries, ', ') . ' WHERE id = ' . VAR_APOS . $this -> id . VAR_APOS)); } }

	function delete() {
		if($this -> validate()) {
			return(mysql_query('DELETE FROM ' . $this -> getTable() . ' WHERE id = ' . VAR_APOS . $this -> id . VAR_APOS)); } }

	function checkExistence($id) {
		return((boolean)mysql_num_rows(mysql_query('SELECT id FROM ' . $this -> getTable() . ' WHERE id = ' . VAR_APOS . $id . VAR_APOS, getDb()))); }

	function readHash($array) {
		if(is_array($array)) {
			foreach($array as $key => $value) {
				$redirect_existence = ($suffix_column = substr($key, -3, 3)) === ($suffix_language = '_' . getSession('language'));
				$redirect_source = substr($key, 0, -3);
				$redirect_target = $key;

				$this -> $key = $value;
				if($redirect_existence) $this -> $redirect_source = &$this -> $redirect_target;
			}
			return true; }
		else {
			return false; } } }

?>
