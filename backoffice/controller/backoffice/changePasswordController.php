<?php

require BACKOFFICE . DS . 'CoreController' . EXT;
class cCompile Extends CoreController{
	function __construct($db){
		$this->db = $db;
	}
	public function insert(){
		$object = new Admin();
		$list = $object->find(ADMINID);
		$pGenerate = new PasswordGenerate();
		$pGenerate->user = $list->admin_username;
		$pGenerate->pass = p_string('oldPassword');
		$pGenerate->hash = $list->admin_pass;
		$verify = $pGenerate->verify();
			$pGenerate = new PasswordGenerate();
			$pGenerate->user = $list->admin_username;
			$pGenerate->pass = p_string('newPassword');
		if($verify)
		{
			$object = new Admin();
			$object->admin_username = $list->admin_username;
			if(!empty(p_string('newPassword')) || !empty(p_string('recheckPassowrd')))
			{
				if(p_string('newPassword') == p_string('recheckPassowrd')) $object->admin_pass = $pGenerate->pwHash();
			}
			$object->admin_name = p_string('name');
			$object->admin_surname = p_string('surname');
			$object->admin_email = p_email('email');
			$object->admin_tel = p_string('telephone');
			$object->admin_id = ADMINID;
			$object->Save();
			alert('Update to complete!');
			$log = new Logging();
			$log->logging_date = date('Y-m-d');
			$log->logging_time = date('H:i:s');
			$log->logging_type = 'Update to complete';
			$log->logging_description = 'เปลี่ยนรหัสผ่าน';
			$log->logging_ref_staff = ADMINID;
			$log->Create();
		}
		else
		{
			alert('Wrong Password!');
			$log = new Logging();
			$log->logging_date = date('Y-m-d');
			$log->logging_time = date('H:i:s');
			$log->logging_type = 'Wrong Password';
			$log->logging_description = 'เปลี่ยนรหัสผ่าน';
			$log->logging_ref_staff = ADMINID;
			$log->Create();
			exit;
		}
		redirect('./');
	}
	public function checkOldPassword(){
		$object = new Admin();
		$pGenerate = new PasswordGenerate();
		$list = $object->find($_SESSION['LOGIN']['ID']);
		$status = array();
		$pGenerate->user = $list->admin_username;
		$pGenerate->pass = p_string('password');
		$pGenerate->hash = $list->admin_pass;
		$status['user'] = $list->admin_username;
		$status['pass'] = p_string('password');
		$status['hash'] = $list->admin_pass;
		$status['X'] = $pGenerate->verify();
		if(empty(p_string('password'))) $status['X'] = 'null';
		echo json_encode($status);
	}
}
?>
