<ul>
	<li>Nazwa:<br><input class='wide' name='<?=Barter_Access::PARAMETER_NAME?>' value='<?=htmlspecialchars(@$result -> name)?>'>
		(Używaj jedynie znaków alfanumerycznych; nazwa ta będzie elementem adresu strony)
	</li>
	<li>Treść:<br>
		<textarea class='wide' id='niceditor' name='<?=Barter_AccessArticle::PARAMETER_TEXT?>' rows='15' cols='60'><?=@htmlspecialchars(extract_text_from_article($result -> text))?></textarea>
	</li>
	<li>Kolejność: (wyższa wartość = wyższa pozycja)<br>
		<input style='width: 50px' name='<?=Barter_AccessArticle::PARAMETER_ORDER?>' value='<?=@htmlspecialchars(extract_order_from_article($result -> text))?>'>
	</li>
</ul>