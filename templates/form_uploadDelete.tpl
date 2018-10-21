<form action='/uploadDelete' method='post'>
<fieldset><legend>Lista plików<!-- w katalogu <?=DIR_IMAGES?>--> na serwerze</legend>
<ul id='uploaded_illustrations' class='contains_inputs'>
	<?foreach($files as $file):?>
		<li><input type='submit' name='file_to_remove' value='<?=/*illustration_file_to_pretty*/($file/*, true*/)?>'>
	<?endforeach?>
</ul>
</fieldset>
</form>