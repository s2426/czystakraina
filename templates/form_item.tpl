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
	<textarea name='name' cols='40' rows='5'><?=$current -> name?></textarea>

<p>
	Opis produktu<?=adder_hint()?>:<br>
	<textarea name='description' cols='40' rows='5'><?=$current -> description?></textarea>

<?if(access(2)):?>
	<input type='hidden' name='photo' value=''>
	<?if(empty($files)):?>
		<p>
			Tutaj możesz wybrać ilustrację produktu spośród zdjęć wewnątrz katalogu <?=DIR_IMAGES?>. Aktualnie katalog ten jest pusty. Przejdź do <a href='/upload'>formularza dodawania grafik</a> aby dodać grafiki.
	<?else:/*?>
		<p>
			Grafika wewnątrz katalogu <?=DIR_IMAGES?>:<br>
			<select name='photo'>
			<?foreach($files as $file):?>
				<option<?if($file === $current -> photo):?> selected<?endif?>><?=basename($file)?>
			<?endforeach?>
			</select>
	<?*/endif?>

	<p>
		Kategoria:<br>
	<select name='category[]'>
	<!--<option value='1'>(Kategoria główna)-->
	<?module('categories_select', array('current' => $current))?>
	</select>
<?endif?>

<p>
	Cena<?=adder_hint()?>:<br>
	<input name='price' value='<?=$current -> price?>'> zł


<?if(access(2)):?>
<p>
	Numer porządkowy produktu:<br>
	<input name='siblingOrder' value='<?=$current -> siblingOrder?>'>
<?endif?>
</fieldset>