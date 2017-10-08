<?php 
/* 	require_once("../../init.php"); */
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");

	class Admin  Extends Crud {
		
			# Your Table name 
			protected $table = DB_PREFIX.'user_admin';
			
			# Primary Key of the Table
			protected $pk	 = 'admin_id';
			
			public function getTable(){
				return $this->table;
			}
			
			public function getPk(){
				return $this->pk;
			}
	}

?>