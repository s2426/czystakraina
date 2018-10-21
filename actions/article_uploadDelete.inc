<?php

access(1, true);

$files = Barter_Illustration::get_editable();

if(isset($_POST['file_to_remove']))
{
  $file = new Barter_Illustration;
  $file -> construct_from_pseudonym($_POST['file_to_remove']);
  $file = $file -> to_filename_on_server();
}

if(empty($files)) {
	setFlag('remove_no_files', true); }
elseif(!isset($file)) {
	setFlag('remove_no_choice', true); }
elseif(!in_array($file, $files)) {
	setFlag('remove_no_choice', true); } // flaga niezbyt odpowiada rzeczywistemu bledowi, ale wazne jest, aby w ogole powyzszy scenariusz przewidziec
else {
	setFlag((is_file($file = DIR_IMAGES . $file) and unlink($file))?('remove_succeeded'):('remove_failed'), true); }

?>
