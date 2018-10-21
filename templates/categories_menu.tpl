<?if($parent -> categories):?>
<ol class='category'>
<?foreach($parent -> categories as $child):?>
	<li class='
		<?if($child -> categories):?>
			is_parent
		<?endif?>
		<?if($first):?>
			is_first <?$first = false?>
		<?endif?>
	'>

	<?if($child -> items):?>
		<a href='/category/<?=$child -> id?>'>
	<?endif?>
	
	<?=$child -> name?><?if($child -> items):?>&nbsp;(<?=$child -> items?>)<?endif?>
	
	<?if($child -> items):?>
		</a>
	<?endif?>

 	<?module('categories_menu', array('start' => $child -> id))?>
<?endforeach?>
</ol>
<?endif?>
