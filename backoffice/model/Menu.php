<?php 
/* 	require_once("../../init.php"); */
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");

	class Menu  Extends Crud {
		
			# Your Table name 
			protected $table = DB_PREFIX.'menu';
			
			# Primary Key of the Table
			protected $pk	 = 'menu_id';
	}

?>