<fieldset>
<p>
	Nazwa kategorii:<br>
	<input name='name' class='wide' value='<?=htmlspecialchars(@$result -> text['name'])?>'>
<p>
	Kategoria kategorii:<br>
	<select name='category'>
	<option value='<?=VAR_TOP_CATEGORY?>'>(Kategoria główna)
	<?module('categories_select', array('current' => @(object)$result -> text))?>
	</select>
<p>
	Numer porządkowy kategorii (kategorie wewnątrz list będą sortowane najpierw według tego numeru, następnie według nazwy):<br>
	<input name='siblingOrder' value='<?=@$result -> text['siblingOrder']?>'></dt>
</fieldset>