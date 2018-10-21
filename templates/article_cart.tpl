<h2><?=getWord('titlecart')?></h2>

<?if($user -> cart -> items):?>
<form action='/cart/edit' method='post'>
<table summary='<?=getWord('cartTableSummary')?>'>
<thead>
<tr>
	<th>№
	<th><?=getWord('cartHeaderName')?>
	<th><?=getWord('price')?>
	<th><?=getWord('cartHeaderQuantity')?>
	<th><?=getWord('cartHeaderPayment')?>
<tfoot>
	<tr>
	<th>
	<th>
	<th>
	<th>
	<th><?=$user -> cart -> returnTotal()?>&nbsp;<?=getWord('priceUnits')?>
<tbody>
<?$counter = 1?>
<?foreach($user -> cart -> items as $item):?>
<tr>
	<td><?=$counter?>.
	<td><a href='/item/<?=$item -> id?>'><?=$item -> name?></a>
	<td><?=$item -> price?>&nbsp;<?=getWord('priceUnits')?>
	<td><input name='<?=$item -> id?>' value='<?=$item -> quantity?>'>&nbsp;<?=getWord('packageUnits')?>
	<td><?=($item -> price * $item -> quantity)?>&nbsp;<?=getWord('priceUnits')?>
	<?$counter++?>
<?endforeach?>
</table>

<p><?=getWord('orderComment')?>
<p><textarea name='comment' onblur='this.form.submit()'><?=$user -> cart -> comment?></textarea>
<p><?=getWord('cartRemoval')?>
<p><input type='submit' value='<?=getWord('cartUpdate')?>'>&nbsp;<?=getWord('or')?>&nbsp;<a href='/finalise'><?=getWord('cartFinalise')?></a>!
</form>
<?else:?>
<p><?=getWord('cartEmpty')?>
<?endif?>