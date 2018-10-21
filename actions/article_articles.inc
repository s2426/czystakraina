<h2>Materiały, artykuły</h2>

<?php

$page_size = 100000;
require_once 'actions/article_content.inc';

?>

<?if(isset($names_final)):?>
<ul>
<?foreach($names_final as $name_final):?>
	<li><a href='<?=$name_final -> link?>'><?=$name_final -> name?></a>
<?endforeach?>
</ul>
<?endif?>