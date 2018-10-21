<?php

// nie wykorzystywane do niczego?

try
{
	new Barter_ArticleAccess(null, null, null, $data);
}
catch(Exception $error)
{

}

if(isset($data))
{
	$names = &$data['list'];
	$names = $names ? $names : array();
}

$names_final = array();

foreach($names as $index => $name)
{
	$document = new DOMDocument;

	try
	{
		$names_final[] = new Barter_News($name, $document);
	}
	catch(Exception $error)
	{
		//echo $name, $error -> getmessage(), "<br>";
	}
}

class Barter_News
{
	private
		$showcase,
		$illustration,
		$additional_paragraphs;
	public
		$link,
		$name,
		$text;

	function __construct($name, DOMDocument $document)
	{
		$this -> name = $name;
		$text = @file_get_contents(sprintf('internals/articles/%s.html', $name));
		$text = @sprintf('<meta http-equiv=\'Content-Type\' content=\'text/html; charset=UTF-8\'>%s', $text); // tego wymaga biblioteka, afair ... wykrywa kodowanie wg elementu <meta>
		
		if(false === $text = @$document -> loadhtml($text))
		{
			throw new Exception('nieudane ładowanie drzewa');
		}
		
		$paragraphs = new DOMXPath($document);
		$paragraphs = $paragraphs -> query('//p');
		$this -> classify_paragraphs($paragraphs);

		if(null === $this -> showcase)
		{
			throw new Exception('brak treści');
		}
		else
		{
			$this -> text = $this -> illustration ? $document -> savexml($this -> illustration) : '';
			$this -> text .= $document -> savexml($this -> showcase);
		}

		if(null !== $this -> additional_paragraphs) // jezeli bedziemy linkowali, bo gdzies jest jeszcze tresc
		{
			$this -> link = sprintf('article?%s', rawurlencode($name));
		}
	}
	
	private function classify_paragraphs(DOMNodeList $paragraphs)
	{
		for($index = 0; $paragraph = $paragraphs -> item($index++); )
		{
			if($paragraph -> getattribute('class') === 'illustration_container')
			{
				if(false === isset($this -> illustration))
				{
					$this -> illustration = $paragraph;
				}
			}
			else
			{
				if(false === isset($this -> showcase))
				{
					$this -> showcase = $paragraph;
				}
				else
				{
					$this -> additional_paragraphs[] = $paragraph;
				}
			}
		}
	}
}

?>