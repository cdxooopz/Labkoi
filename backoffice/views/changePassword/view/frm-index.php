	<div class="content-header hide hide" id="SetTitle">Change Password</div>
	<div id="SetPageHeader" class="hide">Change Password<small></small></div>
<div class="content">
	<div class="row">
		<div class="col-xs-12">
		
		  <div class="box">
		    <div class="box-header text-right"></div><!-- /.box-header -->
		    <div class="box-body">
	            <div class="col-xs-6">
		            <form id="insert" action="?Mode=insert" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
	            <?php
		            	$admin = new Admin();
		            	$list = $admin->find($_SESSION['LOGIN']['ID']);
		      		ShowTexts("Username", "username", null, $ml='ml-150', $list->admin_username);
		      		PushUsername("Name", "name", null, $ml='ml-150', $list->admin_name, true);
		      		PushUsername("Surname", "surname", null, $ml='ml-150', $list->admin_surname, true);
		      		PushUsername("Email", "email", null, $ml='ml-150', $list->admin_email, true,'fa-envelope');
		      		PushUsername("Telephone", "telephone", null, $ml='ml-150', $list->admin_tel, true,'fa-phone');
		      		PushPassword("Old Password", "oldPassword", null, $ml='ml-150', null, true);
		      		PushPassword("New Password", "newPassword", null, $ml='ml-150', null);
		      		PushPassword("Check Password", "recheckPassowrd", null, $ml='ml-150', null);

	            ?>
		      		<button type="submit" class="btn btn-success" id="save-btn">SAVE</button>
		      		<button type="reset" class="btn btn-danger">CANCEL</button>
		            </form>
	            </div>
		    </div><!-- /.box-body -->
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
	<script>
		$(document).on('keyup', '#oldPassword', function(){
			var password = $(this).val();
			$.ajax({
				url: '?Mode=checkOldPassword',
				data: {'password' : password},
				type: 'POST',
				dataType: 'JSON'
			})
			.done(function(result){
/*
				if(result.X == 'null')
				{
					$('#oldPassword').css({'border-color': '#d2d6de','box-shadow': 'none'})
					$('#oldPassword').parent('div').find('div.input-group-addon').css({'border-color': '#d2d6de','box-shadow': 'none'})
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-check')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-close')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). addClass('fa-key')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i').css('color','#555')
				}
				else if(result.X)
				{
					$('#oldPassword').css({'border-color': '#00a65a','box-shadow': 'none'})
					$('#oldPassword').parent('div').find('div.input-group-addon').css({'border-color': '#00a65a','box-shadow': 'none'})
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-key')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-close')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). addClass('fa-check')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i').css('color','#00a65a')
				}
				else{
					$('#oldPassword').css({'border-color': '#dd4b39','box-shadow': 'none'})
					$('#oldPassword').parent('div').find('div.input-group-addon').css({'border-color': '#dd4b39','box-shadow': 'none'})
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-key')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i'). addClass('fa-close')
					$('#oldPassword').parent('div').find('div.input-group-addon').find('i').css('color','#dd4b39')
				}
*/
			})
		})
		
		$(document).on('keyup', '#recheckPassowrd', function(){
			var recheck =$(this).val();
			var newPassword =$('#newPassword').val();
			console.log()
			console.log($('').val())
			if(recheck == newPassword)
			{ 
				$('#insert').prop('action', '?Mode=insert');
				console.log('aaaa');
				$('#recheckPassowrd').css({'border-color': '#00a65a','box-shadow': 'none'})
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').css({'border-color': '#00a65a','box-shadow': 'none'})
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-key')
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-close')
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i'). addClass('fa-check')
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i').css('color','#00a65a')
				
				$('#newPassword').css({'border-color': '#00a65a','box-shadow': 'none'})
				$('#newPassword').parent('div').find('div.input-group-addon').css({'border-color': '#00a65a','box-shadow': 'none'})
				$('#newPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-key')
				$('#newPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-close')
				$('#newPassword').parent('div').find('div.input-group-addon').find('i'). addClass('fa-check')
				$('#newPassword').parent('div').find('div.input-group-addon').find('i').css('color','#00a65a')
			}
			else
			{
				$('#insert').prop('action', '');
				$('#recheckPassowrd').css({'border-color': '#dd4b39','box-shadow': 'none'})
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').css({'border-color': '#dd4b39','box-shadow': 'none'})
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-key')
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i'). addClass('fa-close')
				$('#recheckPassowrd').parent('div').find('div.input-group-addon').find('i').css('color','#dd4b39')
				
				$('#newPassword').css({'border-color': '#d2d6de','box-shadow': 'none'})
				$('#newPassword').parent('div').find('div.input-group-addon').css({'border-color': '#d2d6de','box-shadow': 'none'})
				$('#newPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-check')
				$('#newPassword').parent('div').find('div.input-group-addon').find('i'). removeClass('fa-close')
				$('#newPassword').parent('div').find('div.input-group-addon').find('i'). addClass('fa-key')
				$('#newPassword').parent('div').find('div.input-group-addon').find('i').css('color','#555')
			}
		})
	</script>
</div><!-- /.content -->
