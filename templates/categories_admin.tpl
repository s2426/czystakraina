<?if($parent -> categories):?>
<ol>
<?foreach($parent -> categories as $child):?>
	<li>
		<a href='/<?=$link?>/<?=$child -> id?>'><?=$child -> name?>&nbsp;(<?=$child -> items?>)</a>
		<?module('categories_admin', array('start' => $child -> id, 'link' => $link))?>
	
<?endforeach?>
</ol>
<?endif?>