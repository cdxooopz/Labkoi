/*=============================================================================================
  :: _LoadReady_ ::
=============================================================================================*/
$(document).ready(function(){
	ae.FormLogin();
	$('#BtnLogin').click(function(){ae.Login();});
});
$(document).on('keyup', '#username', function(e){
	console.log(e.keyCode);
	if(e.keyCode === 13) $('#password').focus();
})
$(document).on('keyup', '#password', function(e){
	if(e.keyCode === 13) $('#BtnLogin').trigger( "click" );
})

/*=============================================================================================
  :: _ADDEDIT_ ::
=============================================================================================*/
ae.Login=function(){
	if( $("#username").val() == '' ){ $.toaster({ priority : 'danger', title : 'Failed', message : 'กรุณาป้อน Username!!'}); }
	if( $("#password").val() == '' ){ $.toaster({ priority : 'danger', title : 'Failed', message : 'กรุณาป้อน Password!!'}); }
	if( $("#username").val() == '' || $("#password").val() == '' ){
		return false;
	}
// 		url:'./Login&'+new Date().getTime(),
	$.ajax({
		url:'./Login',
		type:'POST',
		dataType:'json',
		data:{'username':$('#username').val(),'password':$('#password').val()},
		success:function(data){
			switch(data.status){
				case 'COMPLETE' :
					$.toaster({ priority : 'success', title : 'Success', message : 'Login complete!!'});
					setTimeout(function(){
						var pathname = window.location.pathname
						var rediectTo = pathname.replace('login', 'index')
						window.location.replace(rediectTo);
					},1000);
					break;
				default :
					$.toaster({ priority : 'danger', title : 'Failed', message : 'Login Fail!!'});
					$("#BtnLogin").attr('disabled', false); 
					break;
			}
		},
		error:function(request, status, error){
			if( status == 'timeout' ){
					alert('Warning!\nLoad time out!\nStatus code : ' + status + '\nError code: ' + error);
			}else{
				alert('Error!\nResponse : ' + request.responseText + '\nStatus code : ' + status + '\nError code: ' + error);
			}
		}
	});
}
ae.FormLogin = function(){
 	$("#username").click(function() { 
		if( $(this).val() == '' ) $(this).val('');
	});
	$("#username").blur(function() { 
		if( $(this).val() == '' ) $(this).val('');
	});
 	$("#password2").focus(function() { 
		if( $(this).val() == '' ){
			$(this).css('display','none');  
			$("#password").css('display','');  
			$("#password").focus();
		} 
	});
	$("#password").blur(function() { 
		if( $(this).val() == '' )
		{
			// $(this).css('display','none');  
			$("#password2").css('display','');  
			$("#password2").val('');
		}
	});
}
