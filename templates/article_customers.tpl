<h2>Administracja użytkowników</h2>

<ol>
<?foreach($customers as $customer):?>
	<li><a href='/customers/<?=$customer -> id?>'><?=$customer -> login?> (<?=$customer -> name?> <?=$customer -> surname?>)</a>
<?endforeach?>
</ol>

<?if($current):?>
<h3><?=$current -> login?> (<?=$current -> name?> <?=$current -> surname?>)</h3>

<ul>
<li>E-mail: <?=$current -> mail?>
<li>Firma: <?=$current -> company?>
<?if($current -> nip || $current -> pesel || $current -> regon):?>

		<?if($current -> nip):?><li><acronym title='Numer Identyfikacji Podatkowej'>NIP</acronym>: <?=$current -> nip?><?endif?>
		<?if($current -> pesel):?><li><acronym title='Powszechny Elektroniczny System Ewidencji LudnoPci'>PESEL</acronym>: <?=$current -> pesel?><?endif?>
		<?if($current -> regon):?><li><acronym title='Rejestr Gospodarki Narodowej'>REGON</acronym>: <?=$current -> regon?><?endif?>

<?endif?>
<li>Miejscowość: <?=$current -> city?>, kod pocztowy: <?=$current -> postCode?>
<li>Adres: <?=$current -> address?>
<li>Tel.: <?=$current -> tel_home ? $current -> tel_home : 'brak'?> (praca), <?=$current -> tel_work ? $current -> tel_work : 'brak'?> (dom), <?=$current -> tel_cell ? $current -> tel_cell : 'brak'?> (tel. komórkowy)
</ul>



<form action='/customers/<?=$current -> id?>/edit' method='post'>
<p>Dodatkowe dane o użytkowniku. Koordynaty w formacie  <samp>52.266477,21.225929 (współrzędne z kropką dziesiętną oddzielone przecinkiem)</samp>.
<p><textarea rows='5 cols='40' name='comment'><?=$current -> comment?></textarea>
<ul>
	<li><input type='radio' name='rank' value='1'<?if($current -> rank == 1):?> checked<?endif?>> użytkownik
	<li><input type='radio' name='rank' value='2'<?if($current -> rank == 2):?> checked<?endif?>> administrator
</ul>
<p><input type='submit' value='Zmień uprawnienia'>
</form>

<form action='/customers/<?=$current -> id?>/delete' method='post'>
<p><input type='submit' value='Usuń konto'>
</form>
<?endif?>