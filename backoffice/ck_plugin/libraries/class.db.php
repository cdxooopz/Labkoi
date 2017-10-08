<?php
/**
 *  DB - A simple database class 
 *
 * @author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
 * @git 		https://github.com/indieteq/PHP-MySQL-PDO-Database-Class
 * @version      0.2ab
 *
 */
require(CONFIG_PATH . DS . "Log.class.php");
class DB
{
    # @object, The PDO object
    private $pdo;
    
    # @object, PDO statement object
    private $sQuery;
    
    # @array,  The database settings
    private $settings;
    
    # @bool ,  Connected to the database
    private $bConnected = false;
    
    # @object, Object for logging exceptions	
    protected $log;
    
    # @array, The parameters of the SQL query
    protected $parameters;
    
    protected $_tableName;
    protected $_wh;
    protected $_where;
    protected $_andWhere = array();
    protected $_orWhere = array();
    protected $_whereBetween = array();
    protected $_orWhereBetween = array();
    protected $_whereIn = array();
    protected $_whereNotIn = array();
    protected $_groupBy;
    protected $_orderBy = array();
    protected $_join = array();
    protected $_limit = array();
    
    /**
     *   Default Constructor 
     *
     *	1. Instantiate Log class.
     *	2. Connect to database.
     *	3. Creates the parameter array.
     */
    public function __construct()
    {
        $this->log = new Log();
        $this->Connect();
        $this->parameters = array();
    }
    
    /**
     *	This method makes connection to the database.
     *	
     *	1. Reads the database settings from a ini file. 
     *	2. Puts  the ini content into the settings array.
     *	3. Tries to connect to the database.
     *	4. If connection failed, exception is displayed and a log file gets created.
     */
    private function Connect()
    {
        $this->settings = parse_ini_file(CONFIG_PATH . DS . "settings.ini.php");
        $dsn            = 'mysql:dbname=' . $this->settings["dbname"] . ';host=' . $this->settings["host"] . '';
        try {
            # Read settings from INI file, set UTF8
            $this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            
            # We can now log any exceptions on Fatal error. 
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            # Connection succeeded, set the boolean to true.
            $this->bConnected = true;
        }
        catch (PDOException $e) {
            # Write into log
            echo $this->ExceptionLog($e->getMessage());
            die();
        }
    }
    /*
     *   You can use this little method if you want to close the PDO connection
     *
     */
    public function CloseConnection()
    {
        # Set the PDO object to null to close the connection
        # http://www.php.net/manual/en/pdo.connections.php
        $this->pdo = null;
    }
    
    /**
     *	Every method which needs to execute a SQL query uses this method.
     *	
     *	1. If not connected, connect to the database.
     *	2. Prepare Query.
     *	3. Parameterize Query.
     *	4. Execute Query.	
     *	5. On exception : Write Exception into the log + SQL query.
     *	6. Reset the Parameters.
     */
    private function Init($query, $parameters = "")
    {
        # Connect to database
        if (!$this->bConnected) {
            $this->Connect();
        }
        try {
            # Prepare query
            $this->sQuery = $this->pdo->prepare($query);
            
            # Add parameters to the parameter array	
            $this->bindMore($parameters);
            
            # Bind parameters
            if (!empty($this->parameters)) {
                foreach ($this->parameters as $param => $value) {
                    
                    $type = PDO::PARAM_STR;
                    switch ($value[1]) {
                        case is_int($value[1]):
                            $type = PDO::PARAM_INT;
                            break;
                        case is_bool($value[1]):
                            $type = PDO::PARAM_BOOL;
                            break;
                        case is_null($value[1]):
                            $type = PDO::PARAM_NULL;
                            break;
                    }
                    // Add type when binding the values to the column
                    $this->sQuery->bindValue($value[0], $value[1], $type);
                }
            }
            
            # Execute SQL 
            $this->sQuery->execute();
        }
        catch (PDOException $e) {
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query);
            die();
        }
        
        # Reset the parameters
        $this->parameters = array();
    }
    
    /**
     *	@void 
     *
     *	Add the parameter to the parameter array
     *	@param string $para  
     *	@param string $value 
     */
    public function bind($para, $value)
    {
        $this->parameters[sizeof($this->parameters)] = [":" . $para , $value];
    }
    /**
     *	@void
     *	
     *	Add more parameters to the parameter array
     *	@param array $parray
     */
    public function bindMore($parray)
    {
        if (empty($this->parameters) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach ($columns as $i => &$column) {
                $this->bind($column, $parray[$column]);
            }
        }
    }
    /**
     *  If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
     *	If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
     *
     *   	@param  string $query
     *	@param  array  $params
     *	@param  int    $fetchmode
     *	@return mixed
     */
    public function query($query, $params = null, $fetchmode = PDO::FETCH_OBJ)
    {
        $query = trim(str_replace("\r", " ", $query));
        
        $this->Init($query, $params);
        
        $rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
        
        # Which SQL statement is used 
        $statement = strtolower($rawStatement[0]);
        
        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } else {
            return NULL;
        }
    }
    
    /**
     *  Returns the last inserted id.
     *  @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Starts the transaction
     * @return boolean, true on success or false on failure
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }
    
    /**
     *  Execute Transaction
     *  @return boolean, true on success or false on failure
     */
    public function executeTransaction()
    {
        return $this->pdo->commit();
    }
    
    /**
     *  Rollback of Transaction
     *  @return boolean, true on success or false on failure
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
    /**
     *	Returns an array which represents a column from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return array
     */
    public function column($query, $params = null)
    {
        $this->Init($query, $params);
        $Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);
        
        $column = null;
        
        foreach ($Columns as $cells) {
            $column[] = $cells[0];
        }
        
        return $column;
        
    }
    /**
     *	Returns an array which represents a row from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *   	@param  int    $fetchmode
     *	@return array
     */
    public function row($query, $params = null, $fetchmode = PDO::FETCH_OBJ)
    {
        $this->Init($query, $params);
        $result = $this->sQuery->fetch($fetchmode);
        $this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
        return $result;
    }
    /**
     *	Returns the value of one single field/column
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return string
     */
    public function single($query, $params = null)
    {
        $this->Init($query, $params);
        $result = $this->sQuery->fetchColumn();
        $this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued
        return $result;
    }
    /**	
     * Writes the log and returns the exception
     *
     * @param  string $message
     * @param  string $sql
     * @return string
     */
    private function ExceptionLog($message, $sql = "")
    {
        $exception = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";
        
        if (!empty($sql)) {
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : " . $sql;
        }
        # Write into log
        echo $message;
//         $this->log->write($message);
        
        return $exception;
    }
    
    protected function excute($query, $params = null, $fetchmode = PDO::FETCH_OBJ)
    {
	    
    }
//     DB::table('name')->join('table', 'name.id', '=', 'table.id')->select('name.id', 'table.email');
    public function join($table = null, $colFirst = null, $colSecond = null, $operater = '=', $type = "INNER JOIN")
    {
	    $this->_join[] = " {$type} {$table} ON {$this->_tableName}.{$colFirst} {$operater} {$table}.{$colSecond}";
	    return $this;
    }
    public function get($columns = array(), $params = null, $fetchmode = PDO::FETCH_OBJ)
    {
	    $t = $this->_tableName;
	    $c = (is_array($column) ? implode(',', $columns) : '*');
	    $w = $this->_wh;
	    $o = ($this->_orderBy ? ' ORDER BY ' . implode(', ', $this->_orderBy) : '');
	    $g = (!empty($this->_groupBy) ? $this->_groupBy : '');
	    $j = implode('', $this->_join);
	    $l = $this->_limit;
	    
	    $sql = "SELECT {$c} FROM {$t} {$j} {$w} {$g} {$o} {$l}";
	    $sql = $this->prepareSql($sql);
	    $this->Init($sql);
	    $result = $this->sQuery->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function first()
    {
	    $t = $this->_tableName;
	    $c = (is_array($column) ? implode(',', $columns) : '*');
	    $w = $this->_wh;
	    $o = ($this->_orderBy ? ' ORDER BY ' . implode(', ', $this->_orderBy) : '');
	    $g = (!empty($this->_groupBy) ? $this->_groupBy : '');
	    $l = 'LIMIT 1';
	    
	    $sql = "SELECT {$c} FROM {$t} {$w} {$g} {$o} {$l}";
	    $sql = $this->prepareSql($sql);

	    $this->Init($sql);
	    $result = $this->sQuery->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function pluck($index, $val = null)
    {
	    $t = $this->_tableName;
	    $c = (is_null($val) ? $index : $index . ',' . $val);
	    $w = $this->_wh;
	    $o = ($this->_orderBy ? ' ORDER BY ' . implode(', ', $this->_orderBy) : '');
	    $g = (!empty($this->_groupBy) ? $this->_groupBy : '');
	    
	    $sql = "SELECT {$c} FROM {$t} {$w} {$g} {$o} {$l}";
	    $sql = $this->prepareSql($sql);
	    $this->Init($sql);
	    $result = $this->sQuery->fetchAll(PDO::FETCH_OBJ);
	    $rs = array();
	    if(is_null($val))
	    {
		    foreach($result as $k => $v)
		    {
			    $rs[] = $v->$index;
		    }
	    }
	    else
	    {
		    foreach($result as $k => $v)
		    {
			    $rs[$v->$index] = $v->$val;
		    }
	    }
        return $rs;
    }
    protected function prepareSql($sql)
    {    
	    $sql = str_replace('1 AND ', '', $sql);
	    $sql = str_replace('1 OR ', '', $sql);
	    $sql = str_replace(' WHERE 1', '', $sql);
	    $sql = str_replace(' ORDER BY 1', '', $sql);
	    return $sql;
    }
    protected function wh()
    {
	    	$w = null;
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_where ? $this->_where : 1) : ($this->_where ? $this->_where : 1));
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_andWhere ? implode(' AND ', $this->_andWhere) : 1) : ' AND ' . ($this->_andWhere ? implode(' AND ', $this->_andWhere) : 1));
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_orWhere ? implode(' OR ', $this->_orWhere) : 1) : ' OR ' .($this->_orWhere ? implode(' OR ', $this->_orWhere) : 1));
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_whereBetween ? implode(' AND ', $this->_whereBetween) : 1) : ' AND ' .($this->_whereBetween ? implode(' AND ', $this->_whereBetween) : 1));
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_orWhereBetween ? implode(' OR ', $this->_orWhereBetween) : 1) : ' OR ' .($this->_orWhereBetween ? implode(' OR ', $this->_orWhereBetween) : 1));
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_whereIn ? implode(' AND ', $this->_whereIn) : 1) : ' AND ' .($this->_whereIn ? implode(' AND ', $this->_whereIn) : 1));
	    $w .= (is_null($w) ? ' WHERE ' . ($this->_whereNotIn ? implode(' AND ', $this->_whereNotIn) : 1) : ' AND ' .($this->_whereNotIn ? implode(' AND ', $this->_whereNotIn) : 1));
	    $this->_wh = $w;
    }
    public function table($name)
    {
	    $this->_tableName = ($name ? $name : '');
	    return $this;
    }
    public function where($col, $operator, $val)
    {
	    $this->_where = "$col $operator '$val'";
	    return $this;
    }
    public function andWhere($col, $operator, $val)
    {
	    $this->_andWhere[] = "$col $operator '$val'";
	    return $this;
    }
    public function orWhere($col, $operator, $val)
    {
	    $this->_orWhere[] = "$col $operator '$val'";
	    return $this;
    }
    public function whereBetween($col, $val = array())
    {
	    $this->_whereBetween[] = "$col BETWEEN $val[0] AND $val[1]";
	    return $this;
    }
    public function orWhereBetween($col, $val = array())
    {
	    $this->_orWhereBetween[] = "$col BETWEEN $val[0] AND $val[1]";
	    return $this;
    }
    public function whereIn($col, $val = array())
    {
	    $this->_whereIn[] = "$col IN (" . (is_array($val) ? implode(',', $val) : $val) . ")";
	    return $this;
    }
    public function whereNotIn($col, $val = array())
    {
	    $this->_whereNotIn[] = "$col NOT IN (" . (is_array($val) ? implode(',', $val) : $val) . ")";
	    return $this;
    }
    public function groupBy($col = array())
    {
	    $this->_groupBy = " GROUP BY " . (is_array($col) ? implode(', ', $col) : $col);
	    return $this;
    }
    public function orderBy($col, $sort = 'ASC')
    {
	    $this->_orderBy[] = "$col $sort";
	    return $this;
    }
    public function limit($limit = 0, $offset = null )
    {
	    $this->_limit = 'LIMIT ' . (!is_null($offset) ? $offset . ',' : '') . $limit;
	    return $this;
    }
}
?>
