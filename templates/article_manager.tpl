<!--
<h2><a href='<?=$access -> manager_url($path, null, array())?>'><?=$header_text?></a></h2>
-->

<?if($access -> message()):?>
	<p><strong><?=htmlspecialchars($access -> message())?></strong>
<?endif?>

<form method='post' action='<?=$access -> manager_url($path, $type)?>'>
<p>Wybierz typ zasobu, który chcesz edytować:
<ul>
	<?foreach(array(
		'Artykuły (newsy)'	=> 'article',
		'Produkty'			=> 'item',
		'Kategorie'			=> 'category',
		'Bannery / Linki'			=> 'link',
	) as $possible_name => $possible_type):?>
		<li><a href='<?=$access -> manager_url($path, $possible_type, array())?>'><?=$possible_name?></a>
	<?endforeach?>
</ul>

<?if($type):?>
	<?if(false && $preview && is_readable($helper_preview = sprintf('templates/helper_preview_%s.tpl', $type))):?>
		<!--<hr>--><p>Podgląd treści:</p>
		<blockquote><?require_once $helper_preview?></blockquote>
	<?endif?>

	<?if(is_readable($helper_form = sprintf('templates/helper_form_%s.tpl', $type))):?>
		<!--<hr>--><p>Wprowadź dane:</p>
		<?require_once $helper_form?>
	<?else:?>
		<!--<hr>--><p>Formularz nie mógł zostać otworzony!</p>
	<?endif?>

	<?if($type !== 'category'):?>
	<!--<hr>-->
	<ul>
		<li>Lista zdjęć ilustrujących niniejszy zasób:<br>
		<textarea rows='5' cols='40' name='illustrations' class='illustrations_management_list'><?=htmlspecialchars(implode("\n", $result -> operation -> get_illustrations()))?></textarea>
		<li>…wybieranych z poniższej listy:<br>
		<textarea rows='5' cols='40' readonly='readonly' class='illustrations_management_list'><?=htmlspecialchars($illustrations)?></textarea>
	</ul>
	<?endif?>
	
	<!--<hr>-->
	<p>Co dalej?
	<ul>
		<?foreach(array(
			Viny_Operation::DELETE	=> 'usunąć',
			Viny_Operation::PREVIEW	=> 'podejrzeć efekt bez wprowadzania zmian',
		) as $operation => $command):?>
		<li><label for='<?=$operation?>'>
			<input
				style='width: auto'
				type='checkbox'
				id='<?=$operation?>'
				name='<?=$operation?>'
				value='<?=$operation?>'
				<?=($result -> additional_operations & $operation) ? 'checked' : ''?>
			>
			wybierz, aby <?=$command?>
		</label></li>
		<?endforeach?>
	</ul>
<?endif?>

<!--<hr>--><p><label for='manager_action'><input class='wymupdate' id='manager_action' type='submit' value=
<?if($type):?>
	'Akceptuj'>
<?else:?>
	'Odśwież'> widok
<?endif?>
</label></p>

<?if($siblings):?>
<!--<hr>-->
<p>Utworzone zasoby:

<ol>
	<?foreach($siblings as $sibling):?>
	<li>Zasób
		<?if($type === 'article'):?>
			<a href='<?=$access -> manager_url($path, $type, array(
				Barter_Access::PARAMETER_NAME => $sibling,
			))?>'><?=htmlspecialchars($sibling /* zawsze ma nazwe */)?></a>
		<?else:?>
			<a href='<?=$access -> manager_url($path, $type, array(
				Barter_Access::PARAMETER_NAME => $sibling[1],
			))?>'><?=strlen($sibling[0]) ? htmlspecialchars($sibling[0]): '<small>nieznany</small>'?></a>
		<?endif?>
	</li>
	<?endforeach?>
</ol>
<?endif?>

</form>