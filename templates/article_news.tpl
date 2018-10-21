<?php

$names_length = sizeof($names_final);

?>
<ul>
<?foreach($names_final as $index => $news):?>
	<?if($news -> link):?>
		<h2><a href='<?=$news -> link?>'><?=$news -> name?></a></h2>
	<?else:?>
		<h2><?=$news -> name?></h2>
	<?endif?>
	
	<?=$news -> text?>
	
	<?if($news -> link):?>
		<p><a href='<?=$news -> link?>'>Czytaj więcej</a></p>
	<?endif?>
	
	<?if($index !== ($names_length - 1)):?>
		<hr>
	<?endif?>
<?endforeach?>
</ul>