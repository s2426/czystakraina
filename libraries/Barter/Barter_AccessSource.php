<?php

/*
	*pobieranie* identyfikatora z Source do Barter_AccessSource jest bezcelowe!
	to wylacznie $this -> index -> index sluzy (czasami) jako identyfikator
	dla Source! od niego samego niczego nie chcemy.
*/

class Barter_AccessSource extends Barter_Access implements Viny_InterfaceSiblingsProvider
{
	private
		$source;

	function prepare_name($name)
	{
		if(@is_subclass_of($name -> table, 'Source'))
		{
			$this -> source = new $name -> table; // dla get_siblings()
		}
		switch(false)
		{
			case @is_subclass_of($name -> table, 'Source'):
			case @is_object($name -> index) || @is_integer($name -> index):
			case @is_object($name -> index) ? @($name -> index instanceof Viny_LetDatabaseDecide) : true:
				return;
			default:
				return $this -> name = $name;
		}
	}
	
	function prepare_text_new($text_new)
	{
		if(is_array($text_new) && sizeof($text_new))
		{
			return $this -> text_new = $text_new;
		}
	}
	
	/*
		do metod CRUD zrodel zawsze przekazujemy identyfikator (jest potrzebny do odczytu), ale to niczemu nie szkodzi
		mysql_query zwraca false, stad wykrywanie false
	*/
	
	private function do_source_operation($operation, $code)
	{
		if($code === Viny_Operation::CREATE || $code === Viny_Operation::UPDATE)
		{
			$this -> source -> readhash($this -> get_prepared_text_new());
		}

		if(false === $operation = $this -> source -> $operation($this -> name -> index))
		{
			throw new Viny_ExceptionFailedOperation('Nie powiodło się dodawanie, zmienianie lub usuwanie zasobu przechowywanego w bazie danych', $code);
		}
		else
		{
			return $operation;
			
			/*
				moze to byc:
				- resource (z poprawnego CUD),
				- tablica z danymi (z poprawnego read), lub
				- null (z read, ktore nic nie zaoferowalo)
			*/
		}
	}

	function read()
	{
		if(is_null($this -> text_old = $this -> do_source_operation(__FUNCTION__, Viny_Operation::READ))) // takze przypisanie
		{
			throw new Viny_ExceptionFailedOperation('Nie powiodło się odczytywanie zasobu przechowywanego w bazie danych', Viny_Operation::READ); // do_source_operation jest uczulone na zwrocenie false, nie null, wiec wyrzucenie wyjatku powtarzamy tutaj (a musimy?)
		}
		
		parent::read();
	}

	function create()
	{
		$this -> do_source_operation(__FUNCTION__, Viny_Operation::CREATE);
		$this -> name -> index = mysql_insert_id(); // nie zrobimy tego, jesli dodawanie zawiedzie, poniewaz powyzsza linijka wyrzuci wyjatek
		parent::create();
	}

	function update()
	{
		$this -> do_source_operation(__FUNCTION__, Viny_Operation::UPDATE);
		parent::update();
	}

	function delete()
	{
		$this -> do_source_operation(__FUNCTION__, Viny_Operation::DELETE);
		$this -> name -> index = null; // ?
		parent::delete();
	}
	
	function exists()
	{
		return isset($this -> name -> index) && is_integer($this -> name -> index) && $this -> source -> checkexistence($this -> name -> index);
	}
	
	function get_siblings() // returns something iterable
	{
		$result = array();

		if($this -> source)
		{
			if($query = mysql_query(sprintf('SELECT `id`, `name` FROM `%s` ORDER BY `name`', $this -> source -> gettable())))
			{
				while($object = mysql_fetch_object($query))
				{
					$result[] = array(
						strval($object -> name),
						intval($object -> id),
					);
				}
			}
		}

		return $result;
	}

	function get_external_name() // pozniej rozbudujemy te metode o mozliwosc zmuszenia skryptu do utworzenia nowego zasobu wysylajac dane dotyczace zasobu istniejacego
	{
		$result = new StdClass;
		$result -> table	= @strval($_GET[Barter_Access::PARAMETER_TYPE]);
		$result -> index	= @intval($_GET[Barter_Access::PARAMETER_NAME]);

		if(@is_null($_GET[Barter_Access::PARAMETER_NAME])) // jesli identyfikator nieokreslony ...
		{
			if(@is_null($this -> prepare_text_new($this -> get_external_text_new()))) // jesli zwyczajnie odwiedzilismy strone, niweczymy mozliwosc poprawnej identyfikacji (umieszczajac null w nazwie, ktora pozniej poddamy walidacji)
			{
				$result -> index = null;
			}
			else // w przeciwnym razie: wyslalismy tresc! wiec jezeli identyfikatora brakuje, oznacza to, ze chcemy, aby baza danych sama jakis przedlozyla
			{
				$result -> index = new Viny_LetDatabaseDecide;
			}
		}

		if($result -> table === 'link')
		{
			$result -> table = 'item';
		}

		return $result;
	}
	
	function get_external_text_new()
	{
		$result = $_POST;
		
		unset($result[Barter_Access::PARAMETER_NAME], $result[Barter_Access::PARAMETER_TYPE]);
		
		return $result;
	}
}

?>