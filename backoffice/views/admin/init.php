<?php
define('DS', DIRECTORY_SEPARATOR);
require '..' . DS . '..' . DS . '..' . DS . 'init.php';
if(empty($_SESSION['LOGIN']['ID'])) header('Location:../login/');
$mode = $_REQUEST["Mode"];
if( !empty($mode) ){
	require BACKOFFICE . DS . 'adminController' . EXT;
	$obj = new cCompile($dbOld);
	if( method_exists($obj,$mode) ){
		$obj->$mode();
	}else{
		alert('ไม่พบ Method!');
	}
	exit;
}

?>
