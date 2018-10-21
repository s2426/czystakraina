<fieldset>
<p>
	Nazwa odsyłacza:<br>
	<input name='name' class='wide' maxlength='100' value='<?=htmlspecialchars(@$result -> text['name'])?>'>

<p>
	Adres <abbr>URL</abbr> odsyłacza:<br>
	<input name='description' class='wide' maxlength='300' value='<?=htmlspecialchars(@$result -> text['description'])?>'>

<p>
	Numer porządkowy:<br>
	<input name='siblingOrder' value='<?=@$result -> text['siblingOrder']?>'>

<input type='hidden' name='category' value='<?=VAR_LINKS_CATEGORY?>'>
<input type='hidden' name='price' value='0'>
<input type='hidden' name='featured' value='on'>
</fieldset>