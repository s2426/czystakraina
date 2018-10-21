<ul>
	<li>Nazwa:
		<input class='wide' name='name' value='<?=htmlspecialchars($outcome['name'])?>'>
		(Używaj jedynie znaków alfanumerycznych; nazwa ta będzie elementem adresu strony)
	</li>
	<li>Treść:<br>
		<textarea class='wide' name='text' rows='15' cols='60'><?=htmlspecialchars($outcome['text'])?></textarea>
		(Nie stosuj wcale, lub – jeśli już – używaj bardzo uważnie znaczników <abbr>HTML</abbr>, aby nie zniekształcić kodu źródłowego)
	</li>
</ul>