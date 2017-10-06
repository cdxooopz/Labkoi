/*=============================================================================================
  :: _LoadReady_ ::
=============================================================================================*/
$(document).ready(function(){
	ae.FormLogin();
	$('#BtnLogin').click(function(){ae.Login();});
});

	$(document).on('click', '.delete-btn', function(){
		var Element = $(this);
		var id = $(this).attr("data-value");
		$.ajax({
			url: "?Mode=cancel",
			type: "GET",
			data: {"id" : id},
			success: function(rs){
				console.log(rs);
				Element.closest("tr").remove();
			},
			beforeSend: function(){
				 return confirm("คุณแน่ใจที่จะยกเลิกลูกค้าคนนี้ใช่หรือไม่?");
			}
		});
	})
	$(document).on('click', '.edit-btn', function(){
		var id = $(this).attr("data-value");
		$.ajax({
			url: "./edit",
			type: "POST",
			data: {"id" : id}
		})
		.done(function(rs){
			$('#content-edit').html(rs);
			$('#modalEdit').modal('show');
		})
	})
	$(document).on('click', '.modalInsert', function(){
		$('#modalInsert').modal('show');
	})
	$(function () {
		$("#example1").dataTable({
			'searching': true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": "?Mode=listCust",
            "aaSorting": [1,'asc'],
             
            "columns": [
             
                { "width": "30%","bSortable": false, },
                { "width": "30%" },
                { "width": "10%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%","bSortable": false, },
            ],
            "language": {
                "lengthMenu": "แสดง  _MENU_ ข้อมูลต่อหน้า",
                "zeroRecords": "ไม่พบข้อมูล",
                "info": "แสดงหน้า  _PAGE_ ต่อหน้า _PAGES_ ทั้งหมด",
                "infoEmpty": "ไม่พบข้อมูล",
                "infoFiltered": "(จาก _MAX_ ข้อมูลทั้งหมด)",
                "search":         "ค้นหา:",
                "paginate": {
                    "first":      "หน้าแรก",
                    "last":       "หน้าสุดท้าย",
                    "next":       "หน้าถัดไป",
                    "previous":   "หน้าก่อนหน้านี้"
                },
            }
		});
	});

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
