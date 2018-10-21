<?if($item -> id):?>
<h2><?=$item -> name?></h2>

<p><?Barter_Illustration::illustrate($item)?></p>

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
	<li><a href='/manager?content_name=<?=$item -> id?>&content_type=item'><?=getWord('item_admin_edit')?></a>
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

<p><?Barter_Illustration::illustrate(null, true)?></p>

<?else:?>
<p><?=getWord('item_missing')?>
<?endif?>