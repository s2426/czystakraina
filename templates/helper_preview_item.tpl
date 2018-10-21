<?if($item -> id):?>
<h2><?=$item -> name?></h2>

<?if($item -> photo):?>
	<p id='item_photo'><img src='/<?=DIR_IMAGES . $item -> photo?>' alt='<?=getWord('item_image')?>'>
<?endif?>

<?if($item -> description):?>
	<p><?=html_entity_decode($item -> description, ENT_QUOTES)?>
<?endif?>

<ul id='item_details'>
<?if($ascendants):?>
	<li id='item_categories'>
	<?=getWord('item_category')?>
	<ol>
	<?foreach($ascendants as $ascendant):?>
		<li><a href='/category/<?=$ascendant -> id?>'><?=$ascendant -> name?></a>
	<?endforeach?>
	</ol>
<?endif?>
<?if(true):?>
	<li>
	<?=getWord('item_price')?> <?=number_format($item -> price, 2, ',', ' ')?> zł
<?endif?>
</ul>

<?if(access(2)):?>
<ul>
	<li><?=getWord('item_category')?> <?=$itemCategory -> name?>
	<li><a href='/itemEdit/<?=$item -> category?>/<?=$item -> id?>'><?=getWord('item_admin_edit')?></a>
	<li><a href='/itemRemove/<?=$item -> category?>/<?=$item -> id?>'><?=getWord('item_admin_remove')?></a>
</ul>
<?endif?>


<h2><?=getWord('item_order')?></h2>

<?if(access(1)):?>
	<form action='/cart/add' method='post'>
	<p><?=getWord('item_order_add')?>
		<input class='number' name='<?=$item -> id?>'> <?=getWord('item_order_items')?>
		<input type='submit' value='<?=getWord('item_order_to_the_cart')?>'>!
	</form>
<?else:?>
	<p>Musisz być zarejestrowany aby dokonać zakupu!
<?endif?>

<?else:?>
<p><?=getWord('item_missing')?>
<?endif?>