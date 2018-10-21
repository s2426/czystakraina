<?php

class item extends source {
	function validate() {
		return(true); }

	function readhash($array)
	{
	if(false === isset($array['featured']))
  {
	$array['featured'] = '';
}
	
		parent::readhash($array);

  

		return;
		if(false == access(2)) // jezeli jestesmy administratorem, to sciezki ilustracji, ktore przyjmujemy z przegladarki, posiadaja prefiksy uzytkownika. musimy to uwzglednic, i dodac je, jezeli ich brakuje (tj. jezeli wysylamy je jako zwyczajny uzytkownik)!
		{
			foreach($this -> illustrations as &$illustration)
			{
				$illustration = illustration_pretty_to_file($illustration);
			}
		}
	}
}

?>

