<?php require 'init.php'; 
	if(file_exists(SYSTEM_PATH . DS . 'installation' . EXT))
		unlink(SYSTEM_PATH . DS . 'installation' . EXT);
	if(file_exists(SYSTEM_PATH . DS . 'installationController' . EXT))
		unlink(SYSTEM_PATH . DS . 'installationController' . EXT);
	if(file_exists(SYSTEM_PATH . DS . 'installationInit' . EXT))
		unlink(SYSTEM_PATH . DS . 'installationInit' . EXT);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $_title = 'Login Form'; ?>
	<?php require TEMPLATES_PATH . DS . 'inc_header.php';  ?>
</head>
<body>
      <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
		  <b>Admin</b>LOGIN
      </div><!-- /.login-logo -->
      <div class="login-box-body">
          <div class="form-group has-feedback">
            <input type="#" class="form-control" placeholder="Username" id="username"/>
            <span class="glyphicon glyphicon glyphicon-user  form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" id="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" id="BtnLogin">Sign In</button>
            </div><!-- /.col -->
          </div>

		  <script type="text/javascript" language="javascript" src="../HTML/Entity/JS/<?=$jsCSSPath;?>.js"></script>
      </div><!-- /.login-box-body -->
    </div>
</body>
</html>
