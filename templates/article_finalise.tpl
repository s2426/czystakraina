<h2><?=getWord('titlecart')?></h2>
<?if($user -> cart):?>
<?=$user -> cart -> compile('www')?>
	<h2>Formy płatności</h2>
	<?include 'content/shipping.html'?>
	<h2>Wyślij zamówienie</h2>
	<p><?=getWord('finaliseIfValid')?> <a href='/finalise/confirmed'><?=getWord('finaliseSend')?></a>.
<?else:?>
	<p class='success'><?=getWord('finaliseSent')?>
	<p class='success'><?=getWord('finalise_information')?>
<?endif?>