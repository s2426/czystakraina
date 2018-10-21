<?php

class category extends source {
	function buildTree() {
		$this -> getCategories();
		$this -> getItems();
		if(is_array($this -> categories)) {
			for($i = 0; $i < count($this -> categories); $i++) {
				if(method_exists($this -> categories[$i], 'buildTree')) {
					$this -> categories[$i] -> buildTree(); } } } }

   	function getCategories() {
		$query = sprintf(
		   'SELECT id FROM categorys WHERE category REGEXP %s %s ORDER BY siblingOrder, name',
		   VAR_APOS . '^([0-9]+[|])*' . (integer)$this -> id . '([|][0-9]+)*$' . VAR_APOS,
		   !access(2) ? 'AND id <> 124' : ''
		);
   		$query = mysql_query($query);

   		if(mysql_num_rows($query)) {
			while($row = mysql_fetch_assoc($query)) {
				$category = new category;
				$category -> read($row['id']);
				$this -> categories[] = $category; } } }

   	function getItems() {
   		$query = mysql_query('SELECT id FROM items WHERE category REGEXP ' . VAR_APOS . '^([0-9]+[|])*' . (integer)$this -> id . '([|][0-9]+)*$' . VAR_APOS . ' ORDER BY siblingOrder, name');

   		if(mysql_num_rows($query)) {
			while($row = mysql_fetch_assoc($query)) {
				$item = new item;
				$item -> read($row['id']);
				$this -> items[] = $item; } } }

	function getAscendants($ascendants = false) {
		$query = mysql_query('SELECT id FROM categorys WHERE id = ' . $this -> category);

		if(mysql_num_rows($query)) {
 			while($row = mysql_fetch_assoc($query)) {
				$parent = new category;
				$parent -> read($row['id']);
				$ascendants = array($this, $parent -> getAscendants($ascendants)); }

		return($ascendants); } }

	function validate() {
		return(true); } }

?>
