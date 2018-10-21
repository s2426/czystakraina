<?php

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
		$length_text	= 300;
		$this -> name	= $name;
		$this -> path	= sprintf('internals/articles/%s.html', $name);
		$this -> text_all	= @file_get_contents($this -> path);
		$this -> text	= sprintf(
			'<p>%s%s</p>',
			preg_replace(sprintf('/^(.{0,%d}).*$/ms', $length_text), '\1', strip_tags($this -> text_all)),
			(strlen($this -> text_all) > $length_text) ? '…' : ''
		);
		$this -> text = preg_replace('/\d\d?\.\d\d?\.\d\d\d\d/', ' \0 ', $this -> text);

		if(strlen($this -> text_all) > $length_text) // jezeli bedziemy linkowali, bo gdzies jest jeszcze tresc
		{
			$this -> link = sprintf('/article?%s', rawurlencode($name));
		}

		return;
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
	
	static function sort(self $one, self $two)
	{
		return @(extract_order_from_article($one -> text_all) < extract_order_from_article($two -> text_all)) ? 1 : -1;
	
		return;
		$one_stat = stat($one -> path);
		$two_stat = stat($one -> path);
		
		return ($one_stat['mtime'] > $two_stat['mtime']) ? 1 : -1;
	}
}

?>