<?php 
/* 	require_once("../../init.php"); */
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");

	class AdminPermission  Extends Crud {
		
			# Your Table name 
			protected $table = DB_PREFIX.'admin_level';
			
			# Primary Key of the Table
			protected $pk	 = 'level_id';
	}

?>