<?php

class DB
{
	private static $_instance = NULL;
	private $_dbc,
			$_query,
			$_PDOparam,
			$_error = false,
			$_insert,
			$_edit,
			$_delete,
			$_count = 0,
			$_result;
			
	private $_time_key,
			$_time_value;
	public	$time_true = false;
	
	
	private function __construct()
	{
		
		try
		{
			$this->_dbc = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
			$this->_dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_dbc->query("SET names 'utf8'");
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	public static function getInstance()
	{
		if(!isset(self::$_instance))
		{
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	
	/**
	 * Desc : abstract PDO prepare statement
	 * 
	 * @param : sql string
	 * @param : [, array $params - parameters of sql query in array ]
	 *
	 * @return : this object to allow chain other methods or false ($this->_error = true)
	 */
	public function query($sql, $params = array())
	{
		$this->_error = false;
		
		if($this->_query = $this->_dbc->prepare($sql))
		{
			$i = 1;
			
			if(count($params))
			{
				foreach($params as $param)
				{	
					$this->_query->bindValue($i, $param);
					//echo $i.' - '.$param.' || ';
					$i++;
				}
			}
			
			if($this->_query->execute())
			{
				if(!$this->_insert && !$this->_delete && !$this->_edit)
				{
					$this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ); //echo "<pre>",var_dump($this->_result),"</pre>";
				}
				
				$this->_count = $this->_query->rowCount();
			}
			else
			{
				$this->_error = true;
			}
		}
		
		return $this;
	}
	
	/**
	 * Desc : insert into database
	 * @param : string $table
	 * @param : array $fields
	 * @param : [, array $time required if you need save data without prepering query ]
	 * @return : true or false
	 */
	public function insert($table, $fields = array(), $time = array())
	{
		if(count($fields))
		{	
			$this->_insert = false;
			$keys = array_keys($fields); //print_r($keys);
			$countf = count($fields);
			$values = '';
			$i = 1;
			
			foreach($fields as $field)
			{	
				$values .= '?';
				if($i < $countf)
				{
					$values .= ', ';
				}
				
				$i++;
			}
			
			$explodeVal = array();
			if(count($time))
			{
				$this->time_true = true;
				$explodeVal = explode(', ', $values);
				//array_pop($explodeVal);
				$this->_time_key = '';
				$this->_time_value = '';
				
				foreach($time as $kt => $vt)
				{
					if($vt != 'NOW()')
					{
						$vt = 'NOW()';
					}
					$this->_time_value .= $vt;
					$this->_time_key .= $kt;
					
					$keys[] = $this->_time_key;
					$explodeVal[] = $this->_time_value;
					$values = implode(', ', $explodeVal);
				}
				//echo '<pre>',print_r($explodeVal),'</pre>';
			}
			
			$this->_insert = true;
			$sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES(".$values.")";
			//echo '<pre>',print_r($fields),'</pre>';
			//echo $sql; //die();
			if(!$this->query($sql, $fields)->error())
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Desc : edit table
	 * @param : string $table
	 * @param : int $id
	 * @param : array $fields
	 * @return : true or false
	 */
	public function update($table, $id, $fields = array()) {
		$id = (int)$id;

		if(count($fields)) {
			
			$this->_edit = false;
			$keys = array_keys($fields); //print_r($keys);
			$countf = count($fields);
			$i = 1;
			
			$this->_edit = true;
			$sql  = "UPDATE {$table} SET ";

			foreach($keys as $key) {
				// make sure that there is no comma after last question mark
				$value = ($i < $countf) ? '?, ' : '?';
				$sql .= "{$key} = {$value} ";
				$i++;
			}

			$sql .= "WHERE id = {$id} LIMIT 1";
			if(!$this->query($sql, $fields)->error()) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Desc : delete from database
	 * @param : string $table
	 * @param : array $fields
	 * @return : true or false
	 */
	public function delete($table, $fields = array())
	{
		if(count($fields))
		{
			$this->_delete = false;
			$keys = array_keys($fields); //print_r($keys);
			$countf = count($fields);
			$values = '';
			$i = 1;
			
			foreach($fields as $field)
			{	
				$values .= '?';
				if($i < $countf)
				{
					$values .= ', ';
				}
				$i++;
			}
			
			$this->_delete = true;
			$sql = "DELETE FROM {$table} WHERE (`".implode('`, `', $keys)."`) = (".$values.")";
			if(!$this->query($sql, $fields)->error())
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 * @return : attribute $_error status (tue or false)
	 */
	public function error()
	{
		return $this->_error;
	}
	
	/**
	 * @return : attribute $_result status
	 */
	public function getResults()
	{
		return $this->_result;
	}
	
	public function countResults()
	{
		return $this->_count;
	}

}