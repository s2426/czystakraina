<?php

access(2, true);

$file = $_POST['file_to_remove'];
$files = get_directory_contents(DIR_IMAGES);

if(empty($files)) {
	setFlag('remove_no_files', true); }
elseif(!isset($file)) {
	setFlag('remove_no_choice', true); }
else {
	setFlag((is_file($file = DIR_IMAGES . $file) and unlink($file))?('remove_succeeded'):('remove_failed'), true); }

?>
