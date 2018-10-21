<?php

$features = array();
$illustration = new Barter_Illustration;
$dimension = new Viny_Dimensions;

if($query = @mysql_query('SELECT `id`, `name`, `description` FROM `items` WHERE `featured` = \'on\' ORDER BY RAND() LIMIT 0, 10'))
{
	while($feature = @mysql_fetch_object($query))
	{
		try
		{
			$illustration -> execute(array(
				'item',
				$feature -> id,
			), null, null, $result);
		}
		catch(Exception $error)
		{
			
		}

		@($feature -> illustration = /*isset*/($result -> text_old) ? $result -> text_old[0] : null);
		
		list(
			$feature -> width,
			$feature -> height,
		) = path_to_rescaled_dimensions($feature -> illustration, 140);
		
		if($feature -> illustration)
		{
			$features[] = $feature;
		}
	}
}

global $records;

// var_dump($features);
  
?>