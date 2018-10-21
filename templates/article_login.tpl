<h2><?=getWord('titlelogin')?></h2>

<?if(access(1)):?>
	<p class='success'><?=getWord('loginSuccess')?> <strong><?=$user -> login?></strong>!
<?else:?>
	<p class='failure'><?=getWord('loginFailure')?>
<?endif?>