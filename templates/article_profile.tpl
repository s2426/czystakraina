<h2><?=getWord('titleprofile')?> – <?=getWord('title' . getOrder(1))?></h2>

<?if(getFlag('registerUntouched')):?>
	<p><?=getWord('registerUntouched')?>
<?elseif(getFlag('registerInvalid')):?>
	<p><?=getWord('registerInvalid')?>
<?elseif(getFlag('registerCreated')):?>
	<p><?=getWord('registerCreated')?>
<?elseif(getFlag('registerUpdated')):?>
	<p><?=getWord('registerUpdated')?>
<?endif?>

<?if(!getFlag('registerCreated')):?>
<form action='/profile/<?=getOrder(1)?>' method='post'>
<?module('form_user', array('current' => $current, 'action' => getOrder(1)))?>
<p>
	<input type='hidden' name='sent' value='yes'>
	<input type='submit' value='<?=getWord('sendForm')?>' id='accept_profile_change'>

</form>
<?endif?>