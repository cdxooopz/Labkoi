<?php
define('DS', DIRECTORY_SEPARATOR);
require '..' . DS . '..' . DS . '..' . DS . 'init.php';
$mode = $_REQUEST["Mode"];

if( !empty($mode) ){
	require 'ck.class.php';
	$obj = new cCompile($db);
	if( method_exists($obj,$mode) ){
		$obj->$mode();
	}else{
		alert('ไม่พบ Method!');
		backpage();
	}
	exit;
}

?>
