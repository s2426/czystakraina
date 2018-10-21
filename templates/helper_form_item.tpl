<?php

if(false === function_exists('adder_hint'))
{
	function adder_hint()
	{
		return access(2) ? '' : ' (zasugeruj)';
	}
}

?>
<fieldset>
<p>
	Nazwa produktu<?=adder_hint()?>:<br>
	<input name='name' class='wide' maxlength='100' value='<?=htmlspecialchars(@$result -> text['name'])?>'>

<p>
	Opis produktu<?=adder_hint()?>:<br>
	<textarea name='description' cols='40' rows='5' id='niceditor'><?=htmlspecialchars(@$result -> text['description'])?></textarea>

<?if(access(2)):?>
	<p>Kategoria:<br>
	<select name='category'>
	<?module('categories_select', array('current' => @(object)$result -> text))?>
	</select>
<?endif?>

<p>
	Cena<?=adder_hint()?> <br>
	<input name='price' value='<?=@$result -> text['price']?>'> zł


<?if(access(2)):?>
<p>
	Numer porządkowy produktu:<br>
	<input name='siblingOrder' value='<?=@$result -> text['siblingOrder']?>'>
<p>
	<label for='featured'>
	<?if('on' === @$result -> text['featured']):?>
	<input style='width: auto' type='checkbox' id='featured' name='featured' checked='checked'>
	<?else:?>
	<input style='width: auto' type='checkbox' id='featured' name='featured'>
	<?endif?>
	Czy produkt będzie promowany na stronie głównej?
	</label>
<?endif?>
</fieldset>