<?php

interface Viny_OperatesWithExternalData
{
	function execute_with_external_data(&$result);
	function get_external_name();
	function get_external_text_new();
	function get_external_additional_operations();
}

?>