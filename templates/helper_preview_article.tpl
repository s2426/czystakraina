<?if($news -> link):?>
	<h2><a href='<?=$news -> link?>'><?=$news -> name?></a></h2>
<?else:?>
	<h2><?=$news -> name?></h2>
<?endif?>

<?=$news -> text?>

<?if($news -> link):?>
	<p><a href='<?=$news -> link?>'>Czytaj więcej</a></p>
<?endif?>