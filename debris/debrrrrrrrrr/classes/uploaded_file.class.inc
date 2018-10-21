<?php

class uploaded_file {
	function uploaded_file($file) {
		# Is the upload_tmp_dir directive readable 
		# at all? Does it end with a slash?
	
		$this -> temporary_directory = ini_get('upload_tmp_dir');
		$this -> temporary_name = $file['tmp_name'];
		$this -> result_directory = DIR_IMAGES;
		$this -> result_name = $file['name'];

		$this -> error = $file['error']; 
		$this -> size = $file['size'];		
		$this -> type = $file['type']; }
	
	function get_temporary_path() {
		return($this -> temporary_directory . $this -> temporary_name); }

	function get_result_path() {
		return($this -> result_directory . $this -> result_name); }

	function save() {
		return(move_uploaded_file($this -> temporary_name, $this -> get_result_path())); } }

?>
