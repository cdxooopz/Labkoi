<?php
/* 
ขาดส่วน Sum, Count
*/
class database
{
    public $dsn, $conn;
    function database()
    {
        global $conn;
        $this->_initialize();
        $db = parse_url($this->dsn);
        try 
        {
            $conn = new PDO("mysql:host=".$db['host'].";dbname=".substr($db['path'], 1).";charset=utf8", $db['user'], $db['pass']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public function _initialize()
    {
        if(file_exists(SYSTEM_PATH . DS . 'ck.config' . EXT))
        {
            require SYSTEM_PATH . DS . 'ck.config' . EXT;
        }
        $this->dsn = $dsn;
    }

    public function CreateID($tbl=false, $field=false)
    {
        $sql	= 'SELECT MAX('.$field.') AS Code FROM '.$tbl.' ORDER BY '.$field.' DESC';
        $query	= $this->query($sql);
        if($row	= $this->fetch($query)){
            $num 	= (int)$row->Code;
            $num++;
            $id	= $num;
        }else{
            $id	= '1';
        }
        return $id;
    }

    function result($tbl, $where = NULL, $order = NULL, $limit = NULL, $field = '*', $group = NULL)
    {
        $f = $this->_field($field);
        $w = (!is_null($where)) ? $this->_where($where) : '';
        $o = (!is_null($order)) ? $this->_order($order) : '';
        $g = (!is_null($group)) ? $this->_group($group) : '';
        $l = (!is_null($limit)) ? $this->_limit($limit) : '';

        $sql = "SELECT {$f} FROM {$tbl} {$w} {$g} {$o} {$l}";
        $res = $this->query($sql);
        $num = $this->num($res);
        if($num == 0)
        {
            return FALSE;
        }
        else
        {
           while($row = $res->fetch(PDO::FETCH_OBJ))
                $tmp[] = $row;
            return $tmp;
        }
    }	

    function record($tbl, $where = NULL, $field = '*')
    {
        global $conn;
        $f = $this->_field($field);
        $w = (!is_null($where)) ? $this->_where($where) : '';

        $sql = "SELECT {$f} FROM {$tbl} {$w}";
        $res = $this->query($sql);
        $num = $this->num($res);
        if($num == 0)
        {
            return FALSE;
        }
        else
        {
	        return $res->fetch(PDO::FETCH_OBJ);
        }
    }	

    function begin()
    {
        $this->query("BEGIN");
    }

    function commit()
    {
        $this->query("COMMIT");
    }

    function rollback()
    {
        $this->query("ROLLBACK");
    }

    function query($sql)
    {
        global $conn;
        return $conn->prepare($sql);
    }

    function sum($tbl, $where = NULL, $field=NULL)
    {

        $w = (!is_null($where)) ? $this->_where($where) : '';
        $sql = "SELECT SUM($field) AS cnt FROM {$tbl} {$w} ";
        $res = $this->query($sql);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC); 
        return $row['cnt']?$row['cnt']:0;		
    }

    function countRow($tbl, $where = NULL, $group = NULL)
    {
        $w = (!is_null($where)) ? $this->_where($where) : '';
        $g = (!is_null($group)) ? $this->_group($group) : '';

        $sql = "SELECT * FROM {$tbl} {$w} {$g}";
        $res = $this->query($sql);
        $num = $this->num($res);
        return $num;
    }

    function error()
    {
        return mysql_error();
    }

    function error_sql_log($s_data)
    {
        $data 			= explode("<br />", $s_data);
        $s_error_text 	= "ERROR : MySql query failed\tIP : " . $_SERVER['REMOTE_ADDR'] . " \tDATE/TIME : " . date ( "d/m/Y H:I:s" ) . " h\r\n";
        $s_error_text  .= "SQL ERROR : " . $data['0'] . "\r\n";
        $s_error_text  .= "MSG ERROR : " . $data['1'] . "\r\n\r\n";
        $s_error = fopen(LOG_PATH.DS."log_sql_".date('dMY').".txt",'a+');
        fwrite($s_error,$s_error_text);
        fclose($s_error);
        return $s_data;
    }

    function id()
    {
        return mysql_insert_id();
    }

    function num($res)
    {
        $res->execute();
		return $res->rowCount();
    }

    function fetch($res)
    {
        return $res->execute();
    }
    function insert($tbl, $data)
    {
        global $conn;
        if(is_array($data))
        {
            foreach($data as $k => $v)
            {
                $field[] = $k;
                $value[] = $this->_escape($v); 
            }

            $insert = "(".implode(', ', $field).") VALUES (".implode(', ', $value).")";
        }
        else
        {
            $insert = " VALUES {$data}";
        }
        $process = $conn->prepare("INSERT INTO {$tbl} {$insert}");
        return $process->execute();
    }

    function update($tbl, $data, $where = NULL)
    {
        global $conn;
        $w = (!is_null($where)) ? $this->_where($where) : '';
        if(is_array($data))
        {
            foreach($data as $k => $v)
            {
                $set[] = $k . ' = ' . $this->_escape($v); 
            }

            $update = implode(', ', $set);
        }
        else
        {
            $update = $data;
        }
        $process = $conn->prepare("UPDATE {$tbl} SET {$update} {$w}");
        return $process->execute();
    }

    function delete($tbl, $where = NULL)
    {	
        global $conn;
        $w = (!is_null($where)) ? $this->_where($where) : '';
        
        $process = $conn->prepare("DELETE FROM {$tbl} {$w}");
        return $process->execute();
    }

    function _field($field)
    {
        if(is_array($field))
        {
            $f = implode(', ', $field);
        }
        else
        {
            $f = $field;
        }

        return $f;
    }
    function _sql_option($where)
    {
        if('IN' == substr($where, 0,2) || 'BETWEEN' == substr($where, 0,7)  || 'LIKE' == substr($where, 0,4)  || '>' == substr($where, 0,1)  || '<' == substr($where, 0,1) )
            return true;
        else 
            return false;
    }
    function _sql_option2($where)
    {
        if('KRON2KRON' == substr($where, 2,9) )
            return true;
        else 
            return false;
    }

    function _where($where)
    {
        $w = ' WHERE ';
        if(is_array($where))
        {
            foreach ($where as $k => $v)
            {
                if(!$this->_operator($k) && is_null($where[$k]))
                    $k .= ' IS NULL';

                if(!is_null($v) && !$this->_sql_option($v))
                {	
                    if(!$this->_operator($k))
                        $k .= ' =';

                    $v = ' '.$this->_escape($v);
                }

                if(!$this->_operator($k) && $this->_sql_option($v))
                    $tmp[] = $k .' '. $v;
                else
                    if($this->_sql_option2($v)){$tmp[] = $k; }else{ $tmp[] = $k . $v;}
            }
            if($tmp)
                $w .= implode(' AND ', $tmp);
            else
                $w = ' ';
        }
        else
        {
            $w .= $where;
        }

        return $w;
    }

    function _order($order)
    {
        $o = ' ORDER BY ';

        if(is_array($order))
        {
            foreach($order as $k => $v)
                $tmp[] = $k.' '.$v;

            $o .= implode(', ', $tmp);
        }
        else
        {
            $o .= $order;
        }

        return $o;
    }

    function _group($group)
    {
        $o = ' GROUP BY ';
        $o .= $group;
        return $o;
    }

    function _limit($limit)
    {
        $l = ' LIMIT ';

        if(is_array($limit))
        {
            foreach($limit as $k => $v)
                $tmp[] = $k.', '.$v;

            $l .= implode(', ', $tmp);
        }
        else
        {
            $l .= $limit;
        }

        return $l;
    }

    function _operator($str)
    {
        $str = trim($str);
        if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str))
        {
            return FALSE;
        }

        return TRUE;
    }

    function _escape($str)
    {	
        global $conn;
        switch(gettype($str))
        {
            case 'string'  : $str = $conn->quote($str);
                break;
            case 'boolean' : $str = ($str === FALSE) ? 0 : 1;
                break;
            default        : $str = ($str === NULL) ? 'NULL' : $str;
                break;
        }		
        //		print_r($conn);

        return $str;
    }

}
?>