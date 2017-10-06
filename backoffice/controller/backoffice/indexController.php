<?php
require_once(CONFIG_PATH . DS . "easyCRUD.class.php");

require BACKOFFICE . DS . 'CoreController' . EXT;
class cCompile Extends CoreController{
	function __construct($db){
		$this->db = $db;
		$this->obj = new Index;
	}
	public function GetDataList(){
/*
		 
// 		Table NAME
		$table = DB_PREFIX . 'product';
// 		Primary Key
		$primaryKey = 'product_id';
		$columns = array(
		    array(
		        'db'        => 'COLUMNS',
		        'dt'        => 0,
		        'formatter' => function( $d, $row ) {
		            return "<img src=\"{$d}\" style=\"width:200px\">";
		        }
		    ),
		    array(
		        'db'        => 'COLUMNS',
		        'dt'        => 1,
		        'formatter' => function( $d, $row ) {
		            return "<img src=\"http://api-bwipjs.rhcloud.com/?bcid=qrcode&text={$d}\"> <br>{$d}";
		// 			return $bc->getBarcode('111111', $bc::TYPE_CODE_128);
		//             return "<img src=\"http://api-bwipjs.rhcloud.com/?bcid=qrcode&text={$d}&height=10\">";
		        }
		    ),
			array( 'db' => 'COLUMNS',   'dt' => 2 ),
			array( 'db' => 'COLUMNS',     'dt' => 3 ),
			array( 'db' => 'COLUMNS',     'dt' => 4 ),
		    array(
		        'db'        => 'COLUMNS',
		        'dt'        => 5,
		        'formatter' => function( $d, $row ) {
		            return "<!-- <a href=\"#\"><i class=\"fa fa-info-circle fa-2x\"></i></a> -->
		<a href=\"#\" data-toggle=\"modal\" data-value=\"{$d}\" class=\"edit-btn\"><i class=\"fa fa-edit fa-2x\"></i></a>
		<a href=\"#\" data-toggle=\"modal\" data-value=\"{$d}\" class=\"delete-btn\"><i class=\"fa fa-close fa-2x\"></i></a>";
		        }
		    ),
		);
		$DB_SETTING = parse_ini_file(CONFIG_PATH . DS . "settings.ini.php");
		$sql_details['scheme'] = 'mysql';
		$sql_details['host'] = $DB_SETTING['host'];
		$sql_details['user'] = $DB_SETTING['user'];
		$sql_details['pass'] = $DB_SETTING['password'];
		$sql_details['path'] = '/'.$DB_SETTING['dbname'];
		$sql_details['fragment'] = 'utf8';
		$sql_details['db'] = $DB_SETTING['dbname'];
		
		echo json_encode(
			SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
		);
*/
	}
}
?>

