<fieldset>
<p>
	Nazwa kategorii:<br>
	<input name='name' class='wide' value='<?=$current -> name?>'>
<p>
	Kategoria kategorii:<br>
	<select name='category[]'>
	<option value='1'>(Kategoria główna)
	<?module('categories_select', array('current' => $current))?>
	</select>
<p>
	Numer porządkowy kategorii (kategorie wewnątrz list będą sortowane najpierw według tego numeru, następnie według nazwy):<br>
	<input name='siblingOrder' value='<?=$current -> siblingOrder?>'></dt>
</fieldset>