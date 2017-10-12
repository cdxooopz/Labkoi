<?php
	require TEMPLATES_PATH . DS . 'inc_function.php';
	$_title = 'Backoffice';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><?php require TEMPLATES_PATH . DS . 'inc_header.php'; ?>
</head>
<body class="skin-blue sidebar-mini sidebar-collapse">
	<div class="wrapper">
	<!-- Header-top -->
	<header class="main-header">
        <!-- Logo -->
        <a href="../index/" class="logo top-header top-header-font" >
          <!-- logo for regular state and mobile devices -->
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>L</b>K</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><? echo WEB_PROJECT;?></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top top-header" role="navigation">
          <!-- Navbar Right Menu -->
          <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	        <span class="sr-only">Toggle navigation</span>
	      </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
			  <li class="dropdown messages-menu">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" >
                  <i class="fa  fa-user-secret fa-2x"></i>  <span class="hidden-xs fa-2x"><?php echo ucfirst($_SESSION['LOGIN']['USER']);?></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="javascript:void(0)">
                          <div class="pull-left">
							  <i class="fa fa-laptop fa-3x"></i>
                          </div>
                          <h4>
                            <b>IP : </b><?php echo $_SERVER['REMOTE_ADDR'];?>
                          </h4>
                        </a>
                      </li>
                      <li>
						  <a href="javascript:void(0)">
                          <div class="pull-left">
							  <i class="fa fa-clock-o fa-3x"></i>
                          </div>
                          <h4>
                            <b>Last Login : </b><?php echo date('d-m-Y H:i:s',$_SESSION['LOGIN']['LAST']);?>
                          </h4>
                        </a>
                      </li>
<!--
				 	  <li>
						  <a href="javascript:void(0)">
                          <div class="pull-left">
							  <i class="fa fa-clock-o fa-3x"></i>
                          </div>
                          <h4>
                            <b>Online : </b><span id="online" rel="<?php echo CURRENT_TIME-$_SESSION['LOGIN']['ONLINE'];?>">00:00:00</span>
                          </h4>
                        </a>
                      </li>
-->
                      <li>
                        <a href="../changePassword/">
                          <div class="pull-left">
							  <i class="fa fa-key fa-3x"></i>
                          </div>
                          <h4>
                            <b>Change Password</b>
                          </h4>
                        </a>
                      </li>
                      <li>
                    </ul>
                  </li>
                </ul>
              </li>
              <?php
	              if(IS_SPADMIN){
	              echo '
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears fa-2x"></i></a>
              </li>';
              }
              ?>
				<li>
					<a href="../logout/" title="Log out"><i class="glyphicon glyphicon-off fa-2x"></i></a>
				</li>
            </ul>
          </div>

        </nav>
      </header>
	
	<!-- Header-top -->
	<?php require 'inc_sidebar.php'; ?>
	<div class="content-wrapper">
		<section class="content-header">
          <h1 id="headerPage"></h1>
          <ol class="breadcrumb">
			<li><a href="../index/"><i class="fa fa-dashboard"></i>Home</a></li>
			<li id="nav"></li>
          </ol>
        </section>

		<?php
			if(!empty($_GET['frm']))
				$_file 	= 'view' . DS . 'frm-'.$_GET['frm'] . EXT;
			else
				$_file 	= 'view' . DS . 'frm-index' . EXT;
				
			if(file_exists($_file )) require $_file ;
		?>
	</div>
	
<!--  !dev-control Sidebar  -->
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
          <li><a href="#control-sidebar-model-tab" data-toggle="tab"><i class="fa fa-plus"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class='control-sidebar-menu'>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class='control-sidebar-menu'>
              <li>
                <a href='javascript::;'>
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-waring pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->

          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right" />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="control-sidebar-model-tab">
            <form method="post" action="./createModel" target="@Alert">
              <h3 class="control-sidebar-heading">Create Model</h3>
              <div class="form-group">
                <input type="text" id="model-name" name="model-name" class="form-control ui-corner-all input " data-parsley-required="true" placeholder="Model Name">
                <input type="text" id="model-table" name="model-table" class="form-control ui-corner-all input " data-parsley-required="true" placeholder="Model Table">
                <input type="text" id="model-pk" name="model-pk" class="form-control ui-corner-all input " data-parsley-required="true" placeholder="Model PK">
                <input type="text" id="model-status" name="model-status" class="form-control ui-corner-all input " data-parsley-required="true" placeholder="Model Status">
              </div><!-- /.form-group -->
              <button type="submit" class="btn btn-success col-xs-12">Submit</button>
              <button type="reset" class="btn btn-danger col-xs-12">Cancel</button>
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
      </div>
<?php require 'inc_footer.php'; ?>
	<?php
	$dataCheck = $memu['0'];
	unset($dataCheck[1]);
	$dataCheck = array_values($dataCheck);
	$status = array();
	$urlCheck = explode('/', $_SERVER['REQUEST_URI']);
	if($dataCheck)
	{
		foreach($dataCheck as $k => $v)
		{
			if(!in_array("index", $urlCheck))
			{
				if($_SESSION['permission'])
				{
					if(!in_array($urlCheck[3], $_SESSION['permission']))
					{ 
						if(@in_array($urlCheck[3], $_SESSION['permission'][$k]))
						{ 
							$status[] =true;
						}
						else
						{
							$status[] =false;
						}
					}
					else $status[] =true;
				}
			}
			else
			{
				if($permission[$k] == 'on') $_SESSION['permission'][$k] = (isset($v['active'][0]) ? $v['active'] : $v['link']);
			}
		}
		if(IS_SPADMIN) $status[] =true;
		if(!in_array(true, $status))
		{
			if(!in_array("index", $urlCheck)) redirect('../index');
		}
	}
	?>
	<script>
		$('#headerPage').html($('#SetTitle').text())
	</script>
</body>
<!-- </html> -->