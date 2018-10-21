<?php

// YES, one of the loops is being used in three places
// of the code separatedly while I couldn't do anything
// with it ... not going to try and hide it. php engine
// considered the reason

class counter_record
{
	function counter_record($name, $parent = null)
	{
		$this -> name = $name;
		$this -> parent = $parent;
		$this -> guest = $this -> user = $this -> admin = 0;
	}

	function populate($guest, $user, $admin)
	{
		$this -> guest = $guest;
		$this -> user = $user;
		$this -> admin = $admin;
		
		return $this;
	}

	function get_name() {
		return count($path = $this -> get_path(false)) === 2 ? counter::get_record_name($path[0] . 's', $path[1]) : null;
	}

	function get_path($as_string = true)
	{
		$parent = &$this;
		while($parent -> name)
		{
			$result[] = $parent -> name;
			$parent = &$parent -> parent;
		}
		$result = array_reverse((array)$result);
		return $as_string ? implode('/', $result) : $result;
	}

	function get_text()
	{
		$result = implode('|', array($this -> guest, $this -> user, $this -> admin, $this -> get_path())) . "\n";
		if(is_array($this -> subpaths))
		{
			foreach($this -> subpaths as $subrecord)
			{
				$result .= $subrecord -> get_text();
			}
		}
		return $result;
	}

	function get_total() {
		$result = array($this -> guest, $this -> user, $this -> admin);

		// do przegladajacego kod: zdaje sobie sprawe z niewygody recznego
		// deklarowania trzech wartosci tablic (tu i ponizej). rozwiazanie
		// wynika z pospiechu i w przyszlosci zostanie zamienione na inne

		$children = (array)$this -> subpaths;
		while($child = current($children))
		{
			$child_result = $child -> get_total();
			$result[0] += $child_result[0];
			$result[1] += $child_result[1];
			$result[2] += $child_result[2];
			next($children);
		}

		return $result;
	}

	function _html($hide_children = false)
	{
		$h = (((bool)current($path = $this -> get_path(false))) && (($value = count($path) + 2) < 7)) ? $value : false;
		$total = $this -> get_total();
		$total_g = $total[0];
		$total_u = $total[1];
		$total_a = $total[2];
		$total = $total_g + $total_u + $total_a;
		
		?>
		
		<li>
			<div class='counter_record_title'>
			<?if($h):?><h<?=$h?>><?endif;?>
				<a class='outer' href='<?=sprintf('http://%s/%s', $_SERVER['HTTP_HOST'], $path = $this -> get_path())?>'><code>/<?=$path?></code></a>
				= <strong class='countable'><?=(int)$total?></strong>
				(<a href='/counter/<?=$path?>'>rozwiñ</a>)
			<?if($h):?></h<?=$h?>><?endif;?>
			</div>

			<?if($name = $this -> get_name()):?><p>Nazwa: <q><?=$name?></q></p><?endif;?>
			
			<div class='counter_record_totals'>
			<ol>
				<li>Suma odwiedzin:		<strong class='countable'><?=($g = $this -> guest) + ($u = $this -> user) + ($a = $this -> admin)?></strong>	</li>
				<li>					(Go¶cie: <strong class='countable'><?=(int)$g?></strong>)														</li>
				<li>					(U¿ytkownicy: +<strong class='countable'><?=(int)$u?></strong>)													</li>
				<li>					(Administratorzy: +<strong class='countable'><?=(int)$a?></strong>)												</li>
			</ol>
			<ol>
				<li>Suma odwiedzin ga³êzi:		<strong class='countable'><?=(int)$total?></strong>							</li>
				<li>							(Go¶cie: <strong class='countable'><?=(int)$total_g?></strong>)				</li>
				<li>							(U¿ytkownicy: +<strong class='countable'><?=(int)$total_u?></strong>)		</li>
				<li>							(Administratorzy: +<strong class='countable'><?=(int)$total_a?></strong>)	</li>
			</ol>
			</div>
			
			<?if($this -> subpaths && !$hide_children): // wyswietlamy dzieci tylko, gdy mamy do czynienia z wezlem glownym ... ?>
			<ul>
			<?foreach($this -> subpaths as $subpath):?>
				<?=$subpath -> _html(true)?>
			<?endforeach;?>
			</ul>
			<?endif;?>

		</li>
		<?php
	}
}

class counter
{
	function counter()
	{
		foreach(array('hits', 'visits') as $type)
		{
			$this -> $type = new counter_record(null);

			$text = mysql_result(mysql_query(sprintf('SELECT `value` FROM `config` WHERE `name` = \'counter_%s\'', $type)), 0);
			preg_match_all('/.+/', $text, $matches);
			while($line_string = $matches[0][(int)$j++])
			{
				list($guest, $user, $admin, $path) = explode('|', trim($line_string));
				$path = (array)explode('/', $path);
				
				$record = &$this -> $type;
				for($name = current($path); $name; $name = next($path))
				{
					$record -> subpaths[$name] = ($record -> subpaths[$name] ? $record -> subpaths[$name] : new counter_record($name, &$record));
					$record = &$record -> subpaths[$name];
				}
				$record -> populate($guest, $user, $admin);
			}

			if(filemtime($file = constant('FILE_COUNTER_' . strtoupper($type))) + 86400 < time())
			{
	
				// jezeli data ostatniej modyfikacji pliku
				// jest o dzien mniejsza niz aktualna data
				// - czas na backup!

				file_put_contents($file, $text);
			}
		}
	}

	function _write()
	{
		foreach(array('hits', 'visits') as $type)
		{
			$record = &$this -> $type;
			$result = $record -> get_text();

			mysql_query(sprintf('UPDATE `config` SET `value` = \'%s\' WHERE `name` = \'counter_%s\'', $result, $type));
		}
	}

	function add($what, $guest, $user, $admin)
	{
		$path = get_order_all();
		$path = (current($path) === 'start' && !next($path)) || ($what === 'visit') ? array() : $path;
		$record = &$this -> {$what . 's'};
		
		for($name = current($path); $name; $name = next($path))
		{
				$record -> subpaths[$name] = ($record -> subpaths[$name] ? $record -> subpaths[$name] : new counter_record($name, &$record));
				$record = &$record -> subpaths[$name];
		}

		switch(true)
		{
			case $guest:
				$new_value = ++$record -> guest;
				break;
			case $user:
				$new_value = ++$record -> user;
				break;
			case $admin:
				$new_value = ++$record -> admin;
				break;
		}

		$this -> _write();
		return $new_value;
	}

	function add_hit($guest, $user, $admin)
	{
		return $this -> add('hit', $guest, $user, $admin);
	}

	function add_visit($guest, $user, $admin)
	{
		return $this -> add('visit', $guest, $user, $admin);
	}

	function _html_total($path = null)
	{
		$hits = &$this -> hits;		
		for($name = @current($path); $name; $name = next($path))
		{
				$hits -> subpaths[$name] = ($hits -> subpaths[$name] ? $hits -> subpaths[$name] : new counter_record($name, &$hits));
				$hits = &$hits -> subpaths[$name];
		}
		
		?>
		<div id='counter'>
			<h2>Licznik odwiedzin podstron</h2>
			<ul><?=$hits -> _html()?></ul>
			<!--
			<h2>Licznik unikalnych wizyt serwisu</h2>
			<ul><?=$this -> visits -> _html()?></ul>
			-->
		</div>
		<?php
	}

	function _html_summary()
	{
		$record = &$this -> hits;
		$path = get_order_all();
		if(current($path) && current($path) != 'start')
		{
			foreach(get_order_all() as $order)
			{
				$record = &$record -> subpaths[$order];
			}
		}

		?>
		<div id='counter_summary'>
		<p>Liczba odwiedzin tej podstrony:</p>
		<ol>
			<li><abbr title='Go¶ci'>G</abbr>:			<strong><?=(int)$g = $record -> guest?></strong>	</li>
			<li><abbr title='U¿ytkowników'>U</abbr>:	<strong><?=(int)$u = $record -> user?></strong>	</li>
			<li><abbr title='Administratorów'>A</abbr>:	<strong><?=(int)$a = $record -> admin?></strong>	</li>
		</ol>
		<p>Suma: <strong><?=$g + $u + $a?></strong></p>
		</div>
		<?php
	}
	
	function get_record_name($type, $id)
	{
		static $names;
		if(!$names)
		{
			foreach(array('categorys', 'items') as $table)
			{
				$result = mysql_query('SELECT id, name FROM ' . $table);
				while($row = mysql_fetch_object($result))
				{
					$names[$table][$row -> id] = $row -> name;
				}
			}
		}
		
		return $names[$type][$id];
	}
}

?>
