Zamówienie z dnia <?=VAR_DATE?>

<?foreach($cart -> items as $item):?>
- <?=$item -> name?> (<?=$item -> quantity?> * <?=$item -> price?> zł = <?=$item -> price * $item -> quantity?> zł)
<?endforeach?>

Suma: <?=$cart -> returnTotal()?> zł

<?if($cart -> owner -> company):?><?=$cart -> owner -> company?><?endif?>
<?=$cart -> owner -> name?> <?=$cart -> owner -> surname?>
<?=$cart -> owner -> street?> <?=$cart -> owner -> nr1?> <?=$cart -> owner -> nr2?>
<?=$cart -> owner -> postCode?> <?=$cart -> owner -> city?>
<?=$cart -> owner -> mail?>
<?=$cart -> owner -> tel1?>

<?if($cart -> comment):?><?=$cart -> comment?><?endif?>