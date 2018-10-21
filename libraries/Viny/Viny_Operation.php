<?php

abstract class Viny_Operation // CRUD+E (exists), +funkcje sluzace pobraniu 
{
	const
		CREATE	= 1,
		READ	= 2,
		UPDATE	= 4,
		DELETE	= 8,
		PREVIEW	= 16;

	protected // poniewaz jest wymagane przez podklasy (np. do dodawania w okreslone miejsce, do zmieniania tresci, ... )
		$name,
		$text_old,
		$text_new;
	
	/*
		nazwa sluzy do identyfikowana zasobu *w ramach klasy*! name *nie sluzy* do okreslania klasy,
		ktora zamierzamy utworzyc! ... moze przyjac tylko 2 stany: 1) stan calkowicie identyfikujacy
		dany zasob, albo 2) null. (gdy wystapi jakikolwiek blad lub niemoznosc pelnej identyfikacji).
	*/

	function __construct($name = null, $text_new = null, $additional_operations = null, &$result = null)
	{
		if(func_num_args())
		{
			return $this -> execute($name, $text_new, $additional_operations, $result);
		}
	}

	final function execute($name, $text_new, $additional_operations, &$result)
	{
		$error = null; // wazne: unikamy bledow albo isset

		try
		{
			try
			{
				$this -> prepare($name, $text_new, $additional_operations);
			}
			catch(Viny_ExceptionAbsent $error)
			{
				// powstrzymujemy propagacje wyjatku
			}
			
			$this -> read_if_possible();
			
			if($error)
			{
				throw $error; // ktory wyrzucamy pozniej
			}
			elseif(false === (boolean)($this -> get_prepared_additional_operations() & self::PREVIEW)) // jezeli nie podgladamy
			{
				$this -> perform_main_operation();
				$this -> perform_additional_operations();
			}
		}
		catch(Exception $error)
		{
			// j.w.
		}

		$this -> prepare_result($result, $error); // *po* udostepnieniu niniejszej metodzie bledu, ktory jest zobowiazana przechowywac!
		
		if($error)
		{
			throw $error; // j.w.
		}
	}

	/*
		prepare_name wyrzuci wyjatek, jezeli zostanie null (wartoscia szczegolna,
		oznaczajaca *niemoznosc* zidentyfikowania tresci!).
		
		prepare_text_new wyrzuci wyjatek, jezeli zostanie null (wartoscia, ktora oznacza *niemoznosc* pobrania tresci
		(a nie tylko pusta tresc!) (tutaj nalezy uwazac, aby nie badac, czy obiekt posiada tresc,
		ktora chce dodac, poprzez przyrownanie tresci do wartosci logicznej (poprzez if($this -> text_new)).
		jezeli tresc bedzie pustym ciagiem znakow, '', nadal moze to oznaczac, ze chcemy ja wyzerowac.
		a jednak skrypt procedur zmieniajacych zasob (tj. tu: zerujacych tresc) nie uruchomi, poniewaz ''
		jest rownoznaczne falszowi. sprawdzenie musi badac typ zmiennej, i nie uruchamiac metod zmieniajacych
		tresc tylko wtedy, if(null === $this -> text_new).
	*/

	private function prepare($name, $text_new, $additional_operations) // przebiegamy po *wszystkich* metodach, zwracamy *pierwszy* wyjatek
	{
		foreach(array(
			'Viny_ExceptionAbsentName'	=> array(
				'prepare_name',
				$name,
			),
			'Viny_ExceptionAbsentTextNew'	=> array(
				'prepare_text_new',
				$text_new,
			),
			'LogicException'		=> array(
				'prepare_additional_operations',
				$additional_operations,
			),
		) as $class => $call)
		{
			list(
				$method,
				$argument,
			) = $call;
			
			if(is_null($this -> $method($argument)))
			{
				if(false === isset($error))
				{
					$error = new $class;
				}
			}
		}

		if(isset($error))
		{
			throw $error;
		}
	}

	private function read_if_possible()
	{
		if($this -> exists())
		{
			$this -> read();
		}
	}

	private function perform_main_operation()
	{
		if($this -> exists())
		{
			$this -> update();
		}
		else
		{
			$this -> create();
		}
	}
	
	private function perform_additional_operations() // tymczasem prosta ...
	{
		if($this -> get_prepared_additional_operations() & self::DELETE)
		{
			$this -> delete();
		}
	}

	private function prepare_result(&$result, Exception $error = null)
	{
		$result = new Viny_OperationResult(array(
			'operation'		=> $this,
			'name'			=> $this -> get_prepared_name(),
			'text_old'		=> $this -> get_prepared_text_old(),
			'text_new'		=> $this -> get_prepared_text_new(),
			'text'			=> is_null($this -> get_prepared_text_new()) ? $this -> get_prepared_text_old() : $this -> get_prepared_text_new(), // najnowsza wersja tekstu, ktora zapamietal skrypt
			'additional_operations'	=> $this -> get_prepared_additional_operations(),
			'error'			=> $error,
		));
	}

	// ponizsze metody ... wartosci zwracac nie musza (i tak niczemu by nie posluzyly)

	abstract protected function create();
	abstract protected function read();
	abstract protected function update();
	abstract protected function delete();
	abstract function exists(); // wywolanie jej niczego nie zmieni, wiec moze pozostac publiczna

	abstract function prepare_name($name);
	abstract function prepare_text_new($text_new);

	function prepare_additional_operations($additional_operations) // zdefiniowana tutaj, poniewaz jej tresc jest raczej oczywista
	{
		return $this -> additional_operations = intval($additional_operations);
	}
	
	// *bardzo* wazne jest ... zwrocenie w powyzszych metodach wartosci!

	function get_prepared_name() // identyfikator, niezbedny tej klasie, aby zdefiniowac zasob. zablokowana, jak ponizsze, aby pomoc mi utrzymac dyscypline ... to *nazwa* ma ulegac zmianom w podklasach (tj. procedura jej walidacji, kiedy przychodzi ona od uzytkownika albo od zewnetrznego swiata), a nie *sposob jej pobierania* (akcesor)!
	{
		return $this -> name;
	}

	function get_prepared_text_old() // tekst, j.w. btw, nie ma get_external_test_old !! ...
	{
		return $this -> text_old;
	}

	function get_prepared_text_new() // tekst, j.w.
	{
		return $this -> text_new;
	}

	function get_prepared_additional_operations() // operacje usuniecia, podgladu, ...
	{
		return $this -> additional_operations;
	}
}

?>