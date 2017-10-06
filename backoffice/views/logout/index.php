<?php require 'init.php'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $_title = 'Login Form'; ?>
	<?php require TEMPLATES_PATH . DS . 'inc_header.php';  ?>
</head>
<body>
	<div id="wrapper">
		<div id="wrappertop"></div>
		<div id="wrappermiddle">
			<h2>Logout Complete</h2>
			<div id="time">5</div>
		</div>
		<div id="wrapperbottom"></div>
	</div>
	<script>
		/*=============================================================================================
  :: _LoadReady_ ::
=============================================================================================*/
vl.time = 5;
$(document).ready(function(){
	vl.Time();
});
/*=============================================================================================
  :: _ADDEDIT_ ::
=============================================================================================*/
vl.Time=function(){
	vl.time--;
	$('#time').html(vl.time);
	if( vl.time < 1 ) 
		window.location.replace('../login/');
	else{
		setTimeout( function(){
			vl.Time();
		},1000);
	}
}
	</script>
</body>
</html>
<?php
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Logout';
		$log->logging_description = 'Logout';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
	session_destroy();
// 	logging($db,'Logout','Logout',null,$adminobject->admin_id);
	unset($_SESSION['LOGOUT']);
?>