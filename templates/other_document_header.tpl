<!DOCTYPE html>
<head>
<link rel="image_src" href="http://czystakraina.eu/images/logo_CK.gif">
<meta charset='utf-8'>
<meta name="google-site-verification" content="ecghPojvV4ekuabVsk0K7QoXjMN3-5ZSLk_AKjoWvBY" />
<title>Czysta Kraina</title>
<!--[if IE]>
<style type='text/css'>
body { width: 720px; }
</style>
<![endif]-->

<link rel='stylesheet' href='/index.css' type='text/css'>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js'></script>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js'></script>
<script type='text/javascript' src='/externals/nicEdit/nicEdit.js'></script>
<script type='text/javascript'>
try
{
	jQuery(function()
	{
		//@cc_on jQuery('#content address').css('margin-top', '-10px')
		//jQuery(function() { jQuery('.wymeditor').wymeditor( { lang : 'pl' } ) } )
		jQuery('textarea[readonly=readonly]').css( { backgroundColor : '#FEFAEF' } )
		jQuery('#profile_form input:not([type]), #profile_form [type=password], #profile_form [type=text]').css('width', '200px')
		jQuery('#content input:[type=submit]').css({ border : '1px solid #6E5635', margin: '0 2px', background : '#FEFAEF', color : '#6E5635' })

	myNicEditor = new nicEditor() //	Creates a new nicedit object.  A single instance of nicEditor contains:
	myNicEditor.panelInstance('niceditor')
	})

	swfobject.embedSWF('/images/barter.swf', 'flash', '720', '100', '6').write('flash')
}
catch(error)
{

}
</script>
</head>
<body class='<?=getOrder(0)?>'>
<div id='all'><div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) {return;}  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
<h1>
	<!--<span id='flash'></span>-->
	<!--<img src='/header.jpg' alt=''>-->
</h1>

<ul class='menu' id='left'>
	<li class='barter'><h2>Cyclos</h2><ul><li><a href='http://91.121.72.227:8080/cyclos/do/login'>Logowanie</a><li><a href='/terms_barter'>Regulamin</a></ul>
	<li class='sklep'><h2><a href='/store'>Sklep</a></h2>
	<ul><!-- ... -->
		<?if(access(1)):?>
		<li><a href='/logout'>Wyloguj</a>
		<?else:?>
		<li><a>Logowanie</a>
			<ul>
			<li><a>Logowanie</a>
			<form action='/login' method='post'>
			<ul>
			<li class='submit_container'><input class='pole' name='login'>
			<li class='submit_container'><input class='pole' name='pass' type='password'>
			<li class='submit_container'>
			<input type='submit' value='OK' class='little_submit'>
			<!--<label for='remember'>
			<input type='checkbox' id='remember' name='remember' class='little_submit'>
			pamiętaj
			</label>-->
			</ul>
			</form>
			<li><a href='/profile/register'>Rejestracja</a>
			</ul>
		<?endif?>
		<li><a>Produkty</a>
			<ul>
			<li><select id='categories_switcher'><?module('categories_select')?></select>
			<li>Znajdź produkt:
			<form action='/search' method='post'><ul>
			<li class='submit_container'><input class='pole' name='phrase' style='width: 72px'> <input type='submit' value='OK' class='little_submit'>
			</ul></form>
			<?if(access(1)):?>
			<!--<li><a href='/suggestItem'>Zgłoś produkt</a>-->
			<li><a href='/upload'>Dodaj</a> lub <a href='/uploadDelete'>usuń</a> zdjęcie
			<?endif?>
			</ul>
		<?if(access(1)):?>
		<li><a href='/cart'>Koszyk</a>
		<li><a href='/profile/edit'>Profil</a>
		<?endif?>
		<li><a href='/terms_store'>Regulamin</a>
		<?if(access(2)):?>
		<li><a>Administrator</a>
			<ul>
			<li><a href='/customers'>Użytkownicy</a>
			<li><a href='/orders'>Zamówienia</a>
			<li><a href='/manager'>Edycja</a>
			</ul>
		<?endif?>
	</ul><!-- ... -->
	<script type='text/javascript' src='/externals/activate_menu_category_switcher.js'></script>
	<script type='text/javascript'>
	$('.menu .sklep a').each(function()
	{
		$(this).css('cursor', 'pointer').next().toggle()

		if(this.href)
		{
		
		}
		else
		{
			$(this).click(function(event)
			{
				$(this).next().toggle().is(':visible')
				return event.returnValue = false
			})
		}
	})
	</script>
	<li class='virma'><h2>PARTNERSTWO</h2><ul><li><a href='index-new.php5'>Logowanie</a><li><a href='/terms_virma'>Regulamin</a></ul> 

</ul>
<div class='menu' id='right'>
	<!--
	<a href="http://www.earthhandsandhouses.org"><img src="http://barterpoland.pl/images/items/465.earthhandsandhouses.jpg"></a>
	<a href="http://www.gmo.icppc.pl/index.php?id=470"><img src="http://barterpoland.pl/images/items/465.baner_s-w-od-GMO.gif"></a>
	

	<?if(isset($list)):?>
	<ul>
	<?foreach($list as $list_item):?>
		<li><a href='/article?<?=rawurlencode($list_item)?>'><?=$list_item?></a>
	<?endforeach?>
	</ul>
	<?endif?>
	-->

	<?if(@is_array($features)):?>
	<?foreach($features as $feature):?>
		<a href='<?=$feature -> description?>'><img src='/images/items/<?=$feature -> illustration?>' style='float: left; margin: 0 5px 5px 0; display: block; width: <?=$feature -> width?>px; height: <?=$feature -> height?>px' alt='<?=htmlspecialchars($feature -> name)?>'></a><br>
	<?endforeach?>
	<?endif?>
</div>

<div id='content'>
<?module('article_' . getOrder(0), array('user' => $user))?>
<?module('other_document_footer')?>