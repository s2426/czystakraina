<?php

// klasa odpowiada za licznik zarzadzajacy
// wszystkimi odwiedzinami serwisu

class Counter
{
	function Counter()
	{
		$this -> configure('total', true);
	}

	function configure($order, $descend)
	{
		$this -> order = $order;
		$this -> descend = $descend;
	}
	
	function get_all($type, $path)
	{
		return $this -> get($type, $path);
	}

	function get_current($type)
	{
		return $this -> get($type, $type === 'simple' ? get_order_all(true) : null, 1);
	}

	function get($type, $path, $limit = null)
	{
		$query = sprintf('	SELECT *, visits_guest + visits_user + visits_admin AS total
							FROM `visits`
							WHERE
								`path` REGEXP \'^%s(/)?([^/]+)?$\' AND
								`type` = \'%s\'
							ORDER BY \'%s\' %s',
			$type == 'simple' ? implode('/', (array)$path) : null,
			$type,
			$limit ? 'path' : $this -> order,					// jezeli ograniczamy sie do pobierania jednego rekordu,
			!$limit && $this -> descend ? 'DESC' : 'ASC');		// to MUSI on byc pierwszy alfabetycznie oraz nie moze
			if($limit === 1) $query .= ' LIMIT ' . $limit;			// zostac posortowanym malejaco (w przeciwnym razie mozemy
																// zwiekszyc niewlasciwy rekord)
		$results = mysql_query($query);

		// jezeli zapytanie nie powiodlo sie czy z powodu
		// bledow skladni, przerywamy. jezeli nie wykonano
		// go z powodu nie zwrocenia zadnego rekordu, tworzymy
		// jego obiekt na wlasna reke

		if(!$results || !mysql_num_rows($results)) return false;

		while($row = mysql_fetch_assoc($results)) $result[(int)$i++] = new CounterRecord($row);
		if($limit === 1) $result = current($result);

		return $result;
	}

}

// klasa odpowiada za wizyty
// na jednej podstronie serwisu

class CounterRecord
{

	// ta funkcja zazwyczaj wypelnia rekord danymi z mysql_fetch_assoc(),
	// ale czasami (gdy zachodzi potrzeba wygenerowania rekordu do podniesienia
	// jego licznika, a nie jest on jeszcze obecny w bazie) przyjmuje
	// do parametru takze zapisana na sztywno tablice bazowych danych

	function CounterRecord($external_data)
	{
		foreach($external_data as $key => $value) $this -> $key = $value;
	}

	function visit()
	{
		$visitor = access(2) ? 'admin' : (access(1) ? 'user' : 'guest');
		$this -> {'visits_' . $visitor}++;
		$this -> total++;
		
		$query = sprintf('
			REPLACE `visits`
				(`id`,			`type`,			`path`,			`visits_guest`,	`visits_user`,	`visits_admin`)
			VALUES
				(%s,			\'%s\',			\'%s\',			%d,				%d,				%d)',
			$this -> id ? $this -> id : 'NULL',
			$this -> type,
			implode('/', (array)$this -> path),
			$this -> visits_guest,
			$this -> visits_user,
			$this -> visits_admin);

		$results = mysql_query($query);
		return $results ? true : false;
	}

	function get_name() {
		static $names;
		if(!$names)
		{
			foreach(array('categorys', 'items') as $table)
			{
				$result = mysql_query(sprintf('SELECT `id`, `name` FROM `%s`', $table));
				while($row = mysql_fetch_object($result)) $names[$table][$row -> id] = $row -> name;
			}
		}
		
		return count($path = explode('/', $this -> path)) === 2 ? $names[$path[0] . 's'][$path[1]] : null;
	}

}

?>
