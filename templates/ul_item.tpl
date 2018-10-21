<?if($current -> items):?>
<ul>
<?foreach($current -> items as $row):?>
	<li><a href='/<?=$link?>/<?=$row -> id?>/<?=$row -> id?>'><!-- <?=$row -> idCatalogue?>: --><?=$row -> name?></a>
<?endforeach?>
</ul>
<?else:?>
<p>Kategoria jest pusta!
<?endif?>