<?php
require TEMPLATES_PATH . DS . 'inc_function' . EXT;
class CoreController{
	public function Del(){
		$this->obj->delete(p_int('test4'));
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = '';
		$log->logging_description = 'Delete';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		redirect('./');
	}
	public function Insert(){
		$variable = $_POST;
		$obj = $this->obj;
		if($variable)
		{
			foreach($variable as $key => $value)
			{
				$this->obj->$key = (is_array($value) ? json_encode($value) : v_string($value));
			}
			$this->obj->Create();
		}
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = json_encode($this->obj);
		$log->logging_description = 'Insert';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		redirect('./');
	}
	public function Edit(){
		
		$variable = $_POST;
		$obj = $this->obj;
		if($variable)
		{
			foreach($variable as $key => $value)
			{
				$this->obj->$key = (is_array($value) ? json_encode($value) : v_string($value));
			}
			$this->obj->Save();
		}
		
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = json_encode($this->obj);
		$log->logging_description = 'Edit';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		redirect('./');
	}
	public function createModel()
	{
		echo '<pre>';
		print_r($_POST);
		$menu = p_string('model-name');
		$txt = array();
		$myfile = fopen(BASE_PATH . DS . SYSTEM_DIR . DS . 'ck.define' . EXT, "r") or die("Unable to open file!");
		while(!feof($myfile)) {
		  $txt[] = fgets($myfile);
		}
		fclose($myfile);
		$txt[] = '
require(MODEL . DS . "' . ucfirst($menu) . '" . EXT);';
		if( !file_exists(BACKOFFICE . DS . $menu . 'Controller.php') )
		{
			$myfile = fopen(BASE_PATH . DS . SYSTEM_DIR . DS . 'ck.define' . EXT, "w") or die("Unable to open file!");
			fwrite($myfile, implode('', $txt));
			fclose($myfile);
		}
// 		Model Files
		$create['Model']['src'] = MODEL . DS . 'Temp.php';
		$create['Model']['destination'] = MODEL . DS . ucfirst($menu) . '.php';
		
		$txts = array();
		$myfile = fopen(MODEL . DS . ucfirst($menu) . EXT, "w") or die("Unable to open file!");
		$txts[] = '<?php';
		$txts[] = '	
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");';
		$txts[] = '
	class ' . ucfirst($menu) . '  Extends Crud {';
		$txts[] = '	
		# Your Table name';
		$txts[] = '
		protected $table = "'. p_string('model-table') .'";';
		$txts[] = '	
		# Primary Key of the Table';
		$txts[] = '	
		protected $pk	 = "'. p_string('model-pk') .'";';
		$txts[] = '
		protected $status	 = "'. p_string('model-status') .'";';
		$txts[] = '
			public function getTable(){';
		$txts[] = '
				return $this->table;';
		$txts[] = '
			}';
			
		$txts[] = '
			public function getPk(){';
		$txts[] = '
				return $this->pk;';
		$txts[] = '
			}';
		$txts[] = '
	}';
		$txts[] = '	
?>';
		fwrite($myfile, implode('', $txts));
		fclose($myfile);
	}
}

?>
