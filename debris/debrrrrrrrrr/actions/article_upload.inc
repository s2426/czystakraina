<?php

access(2, true);

$file = new uploaded_file($_FILES['sent_file']);

if($file -> error === null) {
	setFlag('upload_no_file', true); }
elseif($file -> error === UPLOAD_ERR_OK) {
	setFlag(($file -> save())?('upload_save_succeeded'):('upload_save_failed'), true); }
else {
	setFlag('upload_error', true); }

?>
