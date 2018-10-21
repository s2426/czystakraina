<?php

$phrase = trim(strtolower(getPost('phrase')));
if(!(boolean)$phrase) {
	setFlag('noPhrase', true); }
else {
	$query = mysql_query("SELECT * FROM items WHERE (idCatalogue LIKE '%" . $phrase . "%' OR name_en LIKE '%" . $phrase . "%' OR name LIKE '%" . $phrase . "%') AND category <> '' AND category <> 124 ORDER BY name");
	while($row = mysql_fetch_assoc($query)) {
		$search_hit = new item;
		$search_hit -> readHash($row);
		$results[] = $search_hit; } }

?>
