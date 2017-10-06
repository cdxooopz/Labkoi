
<?php
define('DS', DIRECTORY_SEPARATOR);
require '..' . DS . 'init.php';

if( !empty($_REQUEST["Mode"]) ){
	require SYSTEM_PATH . DS . 'installationController' . EXT;
	$obj = new cCompile($db);
	if( method_exists($obj,$_REQUEST["Mode"]) ){
		$obj->$_REQUEST["Mode"]();
	}else{
		alert('ไม่พบ Method!');
	}
	exit;
}

?>
