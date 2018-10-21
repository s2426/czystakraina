
<?if($name):?>
<?Barter_Illustration::illustrate($name)?>
<h2><?=htmlspecialchars($name)?></h2>

<?require $path?>
<?Barter_Illustration::illustrate(null, true)?>
<?endif?>