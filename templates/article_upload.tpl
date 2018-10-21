<?php

$list = Barter_Illustration::get_editable();

?>
<h2>Dodawanie własnych grafik</h2>

<?if(getFlag('upload_no_file')):?>
	<h3>Wybierz plik do wysłania!</h3>
	<p>Wybierz plik za pomocą poniższego formularza. Uwaga: jeżeli plik o wybranej nazwie znajduje się już na serwerze<!-- w katalogu <?=DIR_IMAGES?>-->, zostanie on nadpisany. Maksymalny dozwolony rozmiar pliku to <?=get_max_upload()?> kilobajtów.
	<?module('form_upload')?>
<?elseif(getFlag('upload_error')):?>
	<h3>Przesyłanie pliku <?=$file -> friendly_name?> nie powiodło się.</h3>
	<p>Spróbuj ponownie. Być może plik jest zbyt duży?
	<hr>
	<?module('form_upload')?>
<?elseif(getFlag('upload_save_failed')):?>
	<h3>Przesyłanie powiodło się, ale plik <?=$file -> friendly_name?> nie mógł zostać zapisany na serwerze.</h3>
	<p>Spróbuj ponownie.
	<hr>
	<?module('form_upload')?>
<?elseif(getFlag('upload_save_succeeded')):?>
	<h3>Przesyłanie pliku <?=$file -> friendly_name?> zakończone powodzeniem!</h3>
	<!--<p><img src='<?=DOMAIN . $file -> get_result_path()?>' alt='Podgląd nowo dodanego pliku'>-->
	<p>Grafika znajduje się już<!-- w katalogu <?=DIR_IMAGES?>--> na serwerze.
<?endif?>
<hr>
<p>Przejdź do <a href='uploadDelete'>panelu usuwania plików</a>!
<hr>
<p>Dodane przez ciebie zdjęcia:
<?if($list):?>
</p><ul>
<?foreach($list as $item):?>
<li><?=$item?>
<?endforeach?>
</ul>
<?else:?>
brak.</p>
<?endif?>