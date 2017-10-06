<?php 
/**
* Easy Crud  -  This class kinda works like ORM. Just created for fun :) 
*
* @author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
* @version      0.1a
*/
require_once(LIBRARIES_PATH . DS . 'class.db' . EXT);
class Crud {

	private $db;

	public $variables;

	public function __construct($data = array()) {
		$this->db =  new DB();	
		$this->variables  = $data;
	}

	public function __set($name,$value){
		if(strtolower($name) === $this->pk) {
			$this->variables[$this->pk] = $value;
		}
		else {
			$this->variables[$name] = $value;
		}
	}

	public function __get($name)
	{	
		if(is_array($this->variables)) {
			if(array_key_exists($name,$this->variables)) {
				return $this->variables[$name];
			}
		}

		return null;
	}
	
	public function save($id = "0") {
		$this->variables[$this->pk] = (empty($this->variables[$this->pk])) ? $id : $this->variables[$this->pk];

		$fieldsvals = '';
		$columns = array_keys($this->variables);

		foreach($columns as $column)
		{
			if($column !== $this->pk)
			$fieldsvals .= $column . " = :". $column . ",";
		}

		$fieldsvals = substr_replace($fieldsvals , '', -1);

		if(count($columns) > 1 ) {

			$sql = "UPDATE " . $this->table .  " SET " . $fieldsvals . " WHERE " . $this->pk . "= :" . $this->pk;
			if($id === "0" && $this->variables[$this->pk] === "0") { 
				unset($this->variables[$this->pk]);
				$sql = "UPDATE " . $this->table .  " SET " . $fieldsvals;
			}

			return $this->exec($sql);
		}

		return null;
	}

	public function createGetID() { 
		$bindings   	= $this->variables;

		if(!empty($bindings)) {
			$fields     =  array_keys($bindings);
			$fieldsvals =  array(implode(",",$fields),":" . implode(",:",$fields));
			$sql 		= "INSERT INTO ".$this->table." (".$fieldsvals[0].") VALUES (".$fieldsvals[1].")";
		}
		else {
			$sql 		= "INSERT INTO ".$this->table." () VALUES ()";
		}

		return $this->execGetID($sql);
	}

	public function create() { 
		$bindings   	= $this->variables;

		if(!empty($bindings)) {
			$fields     =  array_keys($bindings);
			$fieldsvals =  array(implode(",",$fields),":" . implode(",:",$fields));
			$sql 		= "INSERT INTO ".$this->table." (".$fieldsvals[0].") VALUES (".$fieldsvals[1].")";
		}
		else {
			$sql 		= "INSERT INTO ".$this->table." () VALUES ()";
		}

		return $this->exec($sql);
	}

	public function delete($id = "") {
		$id = (empty($this->variables[$this->pk])) ? $id : $this->variables[$this->pk];

		if(!empty($id)) {
			$sql = "DELETE FROM " . $this->table . " WHERE " . $this->pk . "= :" . $this->pk. " LIMIT 1" ;
		}

		return $this->exec($sql, array($this->pk=>$id));
	}
	public function deleteBind($data = array()) {
		$id = (empty($this->variables[$this->pk])) ? $id : $this->variables[$this->pk];

		if($data) {
			foreach($data as $k => $v)
			{
				$sql = "DELETE FROM " . $this->table . " WHERE " . $k . "=" . $v ;
			}
		}

		return $this->exec($sql, array($this->pk=>$id));
	}

	public function find($id = "") {
		$id = (empty($this->variables[$this->pk])) ? $id : $this->variables[$this->pk];

		if(!empty($id)) {
			$sql = "SELECT * FROM " . $this->table ." WHERE " . $this->pk . "= :" . $this->pk . " LIMIT 1";	
			
			$result = $this->db->row($sql, array($this->pk=>$id));
			$this->variables = ($result != false) ? $result : null;
		}
			return $this->variables;
	}
	public function findRevised($id, $refID, $where) {
		if(!empty($id)) {
			$sql = "SELECT * FROM " . $this->table ." WHERE " . $this->pk . "= :" . $this->pk . " UNION SELECT * FROM " . $this->table ." WHERE " . $refID . "= :" . $refID;
			
			$result = $this->db->query($sql, array($this->pk=>$id,$refID=>$id));
			$this->variables = ($result != false) ? $result : null;
		}
			return $this->variables;
	}
	public function findx($id = "", $field) {
		
		$id = (empty($this->variables[$this->pk])) ? $id : $this->variables[$this->pk];
		
		if(!empty($id)) {
			$sql = "SELECT * FROM " . $this->table ." WHERE ".$field."= :" . $this->pk . " LIMIT 1";	
			
			$result = $this->db->row($sql, array($this->pk=>$id));
			$this->variables = ($result != false) ? $result : null;
		}
			return $this->variables;
	}
	/**
	* @param array $fields.
	* @param array $sort.
	* @return array of Collection.
	* Example: $user = new User;
	* $found_user_array = $user->search(array('sex' => 'Male', 'age' => '18'), array('dob' => 'DESC'));
	* // Will produce: SELECT * FROM {$this->table_name} WHERE sex = :sex AND age = :age ORDER BY dob DESC;
	* // And rest is binding those params with the Query. Which will return an array.
	* // Now we can use for each on $found_user_array.
	* Other functionalities ex: Support for LIKE, >, <, >=, <= ... Are not yet supported.
	*/
	
	public function searchSpecify($field = array(), $fields = array(), $sort = array()) {
		$bindings = empty($fields) ? $this->variables : $fields;

		$dataSelect = implode(',', $field);
		$sql = "SELECT {$dataSelect} FROM " . $this->table;

		if (!empty($bindings)) {
			$fieldsvals = array();
			$columns = array_keys($bindings);
			foreach($bindings as $k => $column) {
				$fieldsvals [] = $k . " = '". $column."'";
			}
			$sql .= " WHERE " . implode(" AND ", $fieldsvals);
		}
		
		if (!empty($sort)) {
			$sortvals = array();
			foreach ($sort as $key => $value) {
				$sortvals[] = $key . " " . $value;
			}
			$sql .= " ORDER BY " . implode(", ", $sortvals);
		}
		return $this->exec($sql);
	}
	public function searchContent($fields = array(), $sort = array()) {
		$bindings = empty($fields) ? $this->variables : $fields;

		$sql = "SELECT * FROM " . $this->table;
		
		if (!empty($bindings)) {
			$fieldsvals = array();
			$columns = array_keys($bindings);
			foreach($bindings as $k => $column) {
				if(is_array($column))
				{
					foreach($column as $ks => $columns){
						$fieldsvals [] = $k . " LIKE '%". $columns."%'";
					}
				}
				else
				{
					$fieldsvals [] = $k . " LIKE '%". $column."%'";
				}
			}
			$sql .= " WHERE " . implode(" AND ", $fieldsvals);
		}
		
		if (!empty($sort)) {
			$sortvals = array();
			foreach ($sort as $key => $value) {
				$sortvals[] = $key . " " . $value;
			}
			$sql .= " ORDER BY " . implode(", ", $sortvals);
		}
		return $this->exec($sql);
	}
	public function searchOther($fields = array(), $sort = array()) {
		$bindings = empty($fields) ? $this->variables : $fields;

		$sql = "SELECT * FROM " . $this->table;
		
		if (!empty($bindings)) {
			$fieldsvals = array();
			$columns = array_keys($bindings);
			foreach($bindings as $k => $column) {
				$fieldsvals [] = $k . " ". $column['operator'] ." '". $column['value'] ."'";
			}
			$sql .= " WHERE " . implode(" " . ($column['oa'] ? $column['oa'] : 'AND') . " ", $fieldsvals);
		}
		
		if (!empty($sort)) {
			$sortvals = array();
			foreach ($sort as $key => $value) {
				$sortvals[] = $key . " " . $value;
			}
			$sql .= " ORDER BY " . implode(", ", $sortvals);
		}
		return $this->exec($sql);
	}
	public function search($fields = array(), $sort = array(),$operation = array('='), $limit = null) {
		$bindings = empty($fields) ? $this->variables : $fields;

		$sql = "SELECT * FROM " . $this->table;
		
		if (!empty($bindings)) {
			$fieldsvals = array();
			$columns = array_keys($bindings);
			foreach($bindings as $k => $column) {
				$fieldsvals [] = $k . " = '". $column."'";
			}
			$sql .= " WHERE " . implode(" AND ", $fieldsvals);
		}
		
		if (!empty($sort)) {
			$sortvals = array();
			foreach ($sort as $key => $value) {
				$sortvals[] = $key . " " . $value;
			}
			$sql .= " ORDER BY " . implode(", ", $sortvals);
		}
		if (!empty($limit)) {
			$sql .= " LIMIT " . $limit;
		}
		return $this->exec($sql);
	}

	public function all(){
		return $this->db->query("SELECT * FROM " . $this->table);
	}
	
	public function min($field)  {
		if($field)
		return $this->db->single("SELECT min(" . $field . ")" . " FROM " . $this->table);
	}

	public function max($field)  {
		if($field)
		return $this->db->single("SELECT max(" . $field . ")" . " FROM " . $this->table);
	}

	public function avg($field)  {
		if($field)
		return $this->db->single("SELECT avg(" . $field . ")" . " FROM " . $this->table);
	}

	public function sum($field)  {
		if($field)
		return $this->db->single("SELECT sum(" . $field . ")" . " FROM " . $this->table);
	}

	public function count($field)  {
		if($field)
		return $this->db->single("SELECT count(" . $field . ")" . " FROM " . $this->table);
	}	
		
	public function minBind($field, $bindings=array())  {
		if (!empty($bindings)) {
			$fieldsvals = array();
			foreach($bindings as $k => $v) {
				$fieldsvals [] = $k . " = '". $v."'";
			}
			$sql = " WHERE " . implode(" AND ", $fieldsvals);
		}
		if($field)
		return $this->db->single("SELECT min(" . $field . ")" . " FROM " . $this->table . $sql);
	}

	public function maxBind($field, $bindings=array())  {
		if (!empty($bindings)) {
			$fieldsvals = array();
			foreach($bindings as $k => $v) {
				$fieldsvals [] = $k . " = '". $v."'";
			}
			$sql = " WHERE " . implode(" AND ", $fieldsvals);
		}
		if($field)
		return $this->db->single("SELECT max(" . $field . ")" . " FROM " . $this->table . $sql);
	}

	public function avgBind($field, $bindings=array())  {
		if (!empty($bindings)) {
			$fieldsvals = array();
			foreach($bindings as $k => $v) {
				$fieldsvals [] = $k . " = '". $v."'";
			}
			$sql = " WHERE " . implode(" AND ", $fieldsvals);
		}
		if($field)
		return $this->db->single("SELECT avg(" . $field . ")" . " FROM " . $this->table . $sql);
	}

	public function sumBind($field, $bindings=array())  {
		if (!empty($bindings)) {
			$fieldsvals = array();
			foreach($bindings as $k => $v) {
				$fieldsvals [] = $k . " = '". $v."'";
			}
			$sql = " WHERE " . implode(" AND ", $fieldsvals);
		}
		if($field)
		return $this->db->single("SELECT sum(" . $field . ")" . " FROM " . $this->table . $sql);
	}

	public function countBind($field, $bindings)  {
		if (!empty($bindings)) {
			if (is_array($bindings)) {
				$fieldsvals = array();
				foreach($bindings as $k => $v) {
					$fieldsvals [] = $k . " = '". $v."'";
				}
				$sql = " WHERE " . implode(" AND ", $fieldsvals);
			}
			else{
				$sql = " WHERE " . $bindings;
			}
		}
		if($field)
		return $this->db->single("SELECT count(" . $field . ")" . " FROM " . $this->table . $sql);
	}	

	public function complex($field, $bindings, $group)  {
		if (!empty($bindings)) {
			if (is_array($bindings)) {
				$fieldsvals = array();
				foreach($bindings as $k => $v) {
					$fieldsvals [] = $k . " = '". $v."'";
				}
				$sql = " WHERE " . implode(" AND ", $fieldsvals);
			}
			else{
				$sql = " WHERE " . $bindings;
			}
		}
		$fld = array();
		if (!empty($field)) {
			if(is_array($field) )
			{
				foreach($field as $k => $f)
				{
					$fld[] = "{$f} AS {$k}";
				}
			}
			else $fld[] = "{$field}";
		}
		if (!empty($group)) {
			if(is_array($group))
			{
				$grp = " GROUP BY ". implode(',', $group);
			}
			else $grp = " GROUP BY {$group}";
		}
		$query = "SELECT ".implode(',', $fld)." FROM " . $this->table . $sql . $grp;
		return $this->exec($query);
	}	

	private function execGetID($sql, $array = null) {
		$this->db->beginTransaction();
		if($array !== null) {
			// Get result with the DB object
			$result =  $this->db->query($sql, $array);	
			$getID = $this->db->lastInsertId();
		}
		else {
			// Get result with the DB object
			$result =  $this->db->query($sql, $this->variables);	
			$getID = $this->db->lastInsertId();
		}
		
		// Empty bindings
		$this->variables = array();

		return $getID;
	}

	private function exec($sql, $array = null) {
		$this->db->beginTransaction();
		if($array !== null) {
			// Get result with the DB object
			$result =  $this->db->query($sql, $array);	
			if($result) $this->db->executeTransaction();
			else $this->db->rollBack();
		}
		else {
			// Get result with the DB object
			$result =  $this->db->query($sql, $this->variables);	
			if($result) $this->db->executeTransaction();
			else $this->db->rollBack();
		}
		
		// Empty bindings
		$this->variables = array();

		return $result;
	}

}
?>
