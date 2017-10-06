/*=============================================================================================
  :: _LoadReady_ ::
=============================================================================================*/

$(document).ready(function(){
	ae.FormLogin();
	$('#BtnLogin').click(function(){ae.Login();});
});
/*=============================================================================================
  :: _FUNCTION_ ::
=============================================================================================*/
function checkAll(){
	$('.checkboxAllSelect').attr("checked",true);
}
function unCheckAll(){
	$('.checkboxAllSelect').attr("checked",false);
}
function checkychecky(val)
{
	console.log(val.name);
	var str = val.name.replace("on", "off");
	if($('input[name="'+val.name+'"]').prop("checked"))
	{
		console.log('ssss');
		$('input[name="'+str+'"]').prop("checked", false)
	}
	else
	{
		$('input[name="'+str+'"]').prop("checked", true)
	}
	
}
function typeShowlist(){
	$.ajax(
	{
		url: 'view/list-type.php',
		type: 'POST',
		success: function(html)
		{
			$('#FormsType').html(html);
		}
	});
}


/*=============================================================================================
  :: _ADDEDIT_ ::
=============================================================================================*/
ae.Login=function(){
	if( $("#username").val() == 'User Name' ){ frm.MsgBox('กรุณาป้อน Username!!', 'red', 1000); return false; }
	if( $("#password2").val() == 'Password' ){ frm.MsgBox('กรุณาป้อนPassword!!', 'red', 1000); return false; }
	$.ajax({
		url:'ck.json.php?Mode=Login&'+new Date().getTime(),
		type:'POST',
		dataType:'json',
		data:{'username':$('#username').val(),'password':$('#password').val()},
		success:function(data){
			switch(data.status){
				case 'COMPLETE' :
					frm.MsgBox('Login Success!!', 'green', 2000);
					setTimeout(function(){
						window.location.replace('../index');
					},1000);
					break;
				default :
					frm.MsgBox('Login Fail!!', 'red', 2000);
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
		if( $(this).val() == 'User Name' ) $(this).val('');
	});
	$("#username").blur(function() { 
		if( $(this).val() == '' ) $(this).val('User Name');
	});
 	$("#password2").focus(function() { 
		if( $(this).val() == 'Password' ){
			$(this).val('');  
			$(this).css('display','none');  
			$("#password").css('display','');  
			$("#password").focus();
		} 
	});
	$("#password").blur(function() { 
		if( $(this).val() == '' )
		{
			$(this).css('display','none');  
			$("#password2").css('display','');  
			$("#password2").val('Password');
		}
	});
}


