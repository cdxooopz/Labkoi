	<div class="content-header hide hide" id="SetTitle">การตั้งค่า</div>
	<div id="SetPageHeader" class="hide">การตั้งค่า<small>ระบบ</small></div>
<div class="content">
	<div class="row">
		<div class="col-xs-12">
		
		  <div class="box">
		    <div class="box-header text-right"></div><!-- /.box-header -->
		    <div class="box-body">
	            <div class="col-xs-6">
		            <form id="insert" action="?Mode=insert" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
	            <?php
	            	$setting = new Setting();
	            	
					$dateGet = $setting->find($setting->max('setting_id'));
					$Auth = array(
						'true' => 'True',
						'false' => 'False'
					);
					$Debug = array(
						2 => 'Yes',
						0 => 'No'
					);
		      		PushText("SMTP Host", "host", null, $ml='ml-150', $dateGet->setting_host, true);
		      		PushText("SMTP port", "port", null, $ml='ml-150', $dateGet->setting_port, true);
		      		PushText("Username", "username", null, $ml='ml-150', $dateGet->setting_username, true);
		      		PushText("Password", "password", null, $ml='ml-150',$dateGet->setting_password,true);
		      		PushRadio($Auth,"SMTP Auth", "auth", null, $ml='ml-150',null,$dateGet->setting_smtp_auth,false);
		      		PushRadio($Debug,"Debug", "debug", null, $ml='ml-150',null,$dateGet->setting_debug,false);
	            ?>
		      		<button type="submit" class="btn btn-success" id="save-btn">SAVE</button>
		      		<button type="reset" class="btn btn-danger">CANCEL</button>
		            </form>
	            </div>
		    </div><!-- /.box-body -->
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
    <script src="../ck_plugin/templates/plugins/tagsinput/bootstrap-tagsinput.js" type="text/javascript"></script>
<script>
	$('#list_order').tagsinput({
	  confirmKeys: [32]
	});
</script>
</div><!-- /.content -->
