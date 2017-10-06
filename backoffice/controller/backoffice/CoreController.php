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
}

?>
