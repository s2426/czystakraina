<!--
<?if(@$_GET['logged'] === 'on'):?>
	<p id='logging_message'>Zalogowano!</p>
<?elseif(@$_GET['logged'] === 'off'):?>
	<p id='logging_message'>Wylogowano!</p>
<?endif?>
-->

<?

$names_length = sizeof($names_final);

?>
<?require 'templates/helper_enumeration.tpl'?>
<ul>
<?foreach($names_final as $index => $news):?>
	<li>
	<div class='zajawka'>
	<?Barter_Illustration::illustrate($news -> name)?>
	<?if($news -> link):?>
		<h2><a href='<?=$news -> link?>'><?=$news -> name?></a></h2>
	<?else:?>
		<h2><?=$news -> name?></h2>
	<?endif?>
	
	<?=$news -> text?>
	
	<?if($news -> link):?>
		<p class='read_more'><a href='<?=$news -> link?>'>&rarr; Czytaj więcej</a></p>
	<?endif?>

	</div>
	</li>
<?endforeach?>
</ul>
<?require 'templates/helper_enumeration.tpl'?>