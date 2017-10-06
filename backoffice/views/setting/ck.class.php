<?php

class cCompile Extends CoreController{
	function __construct($db){
		$this->db = $db;
	}
	public function insert(){
		$cust = new Setting();
		$cust->setting_host = p_string('host');
		$cust->setting_port = p_string('port');
		$cust->setting_username = p_string('username');
		$cust->setting_password = p_string('password');
		$cust->setting_smtp_auth = p_string('auth');
		$cust->setting_debug = p_string('debug');
		$cust->setting_datetime = CURRENT_DATETIME;
		$cust->Create();
		alert('Update to complete!');
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Setting List';
		$log->logging_description = 'New Setting';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
	}
}
?>
