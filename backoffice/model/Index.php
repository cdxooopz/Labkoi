<?php 
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");

	class Index  Extends Crud {
			# Your Table name 
			protected $table = DB_PREFIX.'tableName';
			# Primary Key of the Table
			protected $pk	 = 'id';
	}

?>