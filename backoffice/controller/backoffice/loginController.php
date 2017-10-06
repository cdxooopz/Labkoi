<?php
require BACKOFFICE . DS . 'CoreController' . EXT;
class cCompile Extends CoreController{
	function __construct($db){
		$this->db = $db;
	}
	public function Login(){
		$object = new Admin();
		$adminobject = $object->findx(p_string('username'), 'admin_username');
		$refID = $adminobject->admin_id;
		$pGenerate = new PasswordGenerate();
		$result = array('status'=>'FAIL');
// 		$result['user'] = p_string('username');
// 		$result['password'] = p_string('password');
		$this->db->bind("user",p_string('username'));
// 		$result['hash'] = $adminobject->admin_pass;
		$pGenerate->user = p_string('username');
		$pGenerate->pass = p_string('password');
		$pGenerate->hash = $adminobject->admin_pass;
		if(!$pGenerate->verify()){
			$result['status'] = 'FAIL';
		}else{
			$result['status'] = 'COMPLETE';
			$objectUpdate = new Admin();
			$objectUpdate->admin_date_login = CURRENT_TIME;
			$objectUpdate->admin_ip_login = user_ip();
			$objectUpdate->admin_id = $refID;
			$objectUpdate->save();
			$_SESSION['LOGIN']['ID']		= $adminobject->admin_id;
			$_SESSION['LOGIN']['NAME']		= $adminobject->admin_name;
			$_SESSION['LOGIN']['LAST']		= $adminobject->admin_date_login;
			$_SESSION['LOGIN']['USER']		= $adminobject->admin_username;
			$_SESSION['LOGIN']['ONLINE']	= CURRENT_TIME;
			$_SESSION['LOGIN']['LEVEL'] 	  	= $adminobject->admin_level;
			$_SESSION['LOGIN']['SHIFT'] 	  	= $adminobject->admin_group;
			
			$log = new Logging();
			$log->logging_date = date('Y-m-d');
			$log->logging_time = date('H:i:s');
			$log->logging_type = 'Login';
			$log->logging_description = 'Login';
			$log->logging_ref_staff = $adminobject->admin_id;
			$log->Create();
		}
		echo json_encode($result); 
	}
}
?>
