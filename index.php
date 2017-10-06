<?php
	require 'init.php';
	
	if(!file_exists('backoffice/installation.php'))
	{
		if(empty($_SESSION['LOGIN']['ID'])) 
			header('Location:./backoffice/login/');
		else
			header('Location:./backoffice/index/');
	}
	else header('Location:./backoffice/installation.php');
?>