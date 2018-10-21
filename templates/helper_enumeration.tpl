<span style='display: block; margin-bottom: 5px'>
<?if($page_number_last):?>
<?for($page_index = 0; $page_index <= $page_number_last; $page_index++):?>
	[<?if($page_number_of_system === $page_index):?><strong><?=$page_index + 1?></strong><?else:?><a href='?page=<?=$page_index + 1?>'><?=$page_index + 1?></a><?endif?>]
<?endfor?>
<?endif?>
</span>