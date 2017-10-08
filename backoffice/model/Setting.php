<?php 
/* 	require_once("../../init.php"); */
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");

	class Setting  Extends Crud {
		
			# Your Table name 
			protected $table = DB_PREFIX.'setting';
			
			# Primary Key of the Table
			protected $pk	 = 'setting_id';
			
			public function getTable(){
				return $this->table;
			}
			
			public function getPk(){
				return $this->pk;
			}
	}

?>
