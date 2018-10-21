<?php

/*
	- $siblings nie porownujemy z null, ale z false, poniewaz funkcja moze zwracac pusta tablice! (afair)
	- TYMCZASEM sibling moze byc *czymkolwiek*. pozniej NALEZALO bedzie go ustrukturyzowac!
*/

//error_reporting(E_ALL | E_STRICT);
access(2, true);

$header_text	= 'Witaj w panelu';
$path		= sprintf('/%s', getorder(0));
$preview		= null;
$result		= new Viny_Dummy; // zostanie zastapiony przez Viny_OperationResult
$siblings		= array(); // ewaluuje do falszu, przy wyswietlaniu rodzenstwa ... czy powinny byc *zawsze* reprezentowane przez Iterator lub RecursiveIterator?
$type		= &/* referencja jest istotna */$_GET[Barter_Access::PARAMETER_TYPE];

/*
	odnosnie typu ... ot tak ... w innych podstronach serwisu rozroznienia na zasobow moze zupelnie zniknac,
	w innych byc oparte na innym parametrze, etc ... wazne jest, aby abstrakcja manipulowania zasobami byla
	calkowicie pozbawiona wzmianek o implementacji badz o sposobie pobierania zewnetrznych danych.
*/

if($type === 'item' || $type === 'category' || $type === 'link')
{
	$access = new Barter_AccessSource;
}
else
{
	$access = new Barter_AccessArticle;
	$type = 'article';
}

/*
	parametr typu pozwala nam na okreslenie klasy, ktora umozliwi dostep do zasobu.
	nalezy tutaj pamietac, ze pozniejsze wykorzystywanie jej w klasie zasobu zrodla,
	i sprawdzanie, czy przechowuje ona nazwe podklasy klasy Source, jest calkowicie
	niezalezne od sprawdzenia dokonywanego tutaj. tamto sprawdzenie jest konieczne,
	podczas gdy niniejsze sluzy jedynie wstepnemu wyodrebnieniu klas, i gdyby
	panel nie przewidywal mozliwosci edytowania artykulow, nie zostaloby zamieszczone
	w ogole.
*/

try
{
	$access -> execute_with_external_data($result);
}
catch(Viny_ExceptionFailedOperation $error)
{
	$access -> message(sprintf(
		'Akcja, którą wykonałeś (kod akcji: %d), zawiodła! (powód: %s!)',
		$error -> getcode() ? $error -> getcode() : 'brak kodu',
		$error -> getmessage() ? $error -> getmessage() : 'brak komunikatu'
	));
}
catch(Viny_ExceptionAbsent $error)
{
	if(false === is_null($result -> text_new)) // tylko jezeli wyslano nowy tekst, informujemy ...
	{
		$access -> message(sprintf('Podaj %s!', $error instanceof Viny_ExceptionAbsentName ? 'nazwę' : 'treść'));
	}
}
catch(Exception $error)
{
	$access -> message('Wystąpił błąd!');
	
	if($error -> getmessage())
	{
		$access -> message($error -> getmessage());
	}
}

$siblings = $access -> get_siblings(); // tutaj! po kodzie, ktory spowoduje potencjalne utworzenie nowego zasobu lub zmiane nazwy starego!

if(is_null($result -> error) === true)
{
	if(is_null($result -> text_new) === false)
	{
		$access -> message('Akcję zakończono powodzeniem!');
		
		if($result -> additional_operations & Viny_Operation::PREVIEW)
		{
			$access -> message('Uwaga: nastąpił tylko podgląd, zmiany nie zostały wprowadzone!');
		}
	}
}

switch(true) // mozna by wykrywac tutaj nazwy takze produktow i kategorii
{
	case true === is_string($result -> name):
		$header_text = sprintf('Zasób %s', $result -> name);
		break;
	case false === is_null($result -> text_new):
		$header_text = 'Trwa praca nad zasobem';
		break;
}

$illustrations = Barter_Illustration::get_editable();
$illustrations = implode("\n", $illustrations);

if(false === is_null($result -> text))
{
	if($access instanceof Barter_AccessSource)
	{
		$preview = new Viny_Dummy;
	}
	elseif($access instanceof Barter_AccessArticle)
	{
		$preview -> name = $result -> name;
		$preview -> text = $result -> text;
		$preview -> link = null;
	}
}

?>