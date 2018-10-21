<h2>
<?if(true):?>
	<?=getWord('titlesearch')?>
<?endif?>
<?if(!getFlag('noPhrase')):?>
	: <q><?=$phrase?></q>
<?endif?>
</h2>

<?if(getFlag('noPhrase')):?>
<p><?=getWord('search_no_phrase')?>
<?elseif($results):?>
<ol>
<?foreach($results as $result):?>
	<li><a href='/item/<?=$result -> id?>'><?=$result -> name?></a>
<?endforeach?>
</ol>
<?else:?>
<p><?=getWord('searchNoResults')?>
<?endif?>