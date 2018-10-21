<h2>Linki</h2>

<?if($links = get_links()):?>
<ul>
<?foreach($links as $link):?>
<li><a href='<?=htmlspecialchars($link -> description)?>'><?=htmlspecialchars($link -> name)?></a>
<?endforeach?>
</ul>
<?endif?>