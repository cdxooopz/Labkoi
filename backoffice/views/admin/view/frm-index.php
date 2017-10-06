<?php

	$log = new Logging();
	$log->logging_date = date('Y-m-d');
	$log->logging_time = date('H:i:s');
	$log->logging_type = 'Admin List';
	$log->logging_description = 'View List';
	$log->logging_ref_staff = ADMINID;
	$log->Create();

?>

<div class="content">
	<div class="content-header  hide" id="SetTitle">Manage Staff</div>
		<ul class="nav nav-tabs">
          <li class="active"><a href="#listing" data-toggle="tab" >List</a></li>
          <li><a href="#FormsTypes" data-toggle="tab" id="FormsType-link">User Type</a></li>
<!--           <li><a href="#FormsPermission" data-toggle="tab" >Permission</a></li> -->
          <li><a href="#FormsNewPermission" data-toggle="tab" >Permission</a></li>
<!--           <li class="pull-right"><a href="javascript:void(0)" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="listing">
			
			<script>
			</script>
		  <section class="content">
	          <div class="row">
	            <div class="col-xs-12">
	              <div class="box">
				    <div class="box-header text-right">
					    <?=@$permissionCheck->permissionButton('insert', 'Create New Staff', "btn btn-info modalInsert", 'button');?>
	                </div><!-- /.box-header -->
	                <div class="box-body " style="overflow-x: scroll">
	                  <table id="admin-table" class="table table-bordered table-hover">
	                    <thead>
	                      	<th scope="col" class="w20">#</th>
							<th scope="col" class=""><b>Username</b></th>
							<th scope="col" class=""><b>Name - surname</b></th>
							<th scope="col" class=""><b>Email</b></th>
							<th scope="col" class=""><b>Telephone </b></th>
							<th scope="col" class=""><b>Last Login</b></th>
							<th scope="col" class=" w100"><b>Manage</b></th>
	                    </thead>
	                    <tbody></tbody>
	                  </table>
	                </div><!-- /.box-body -->
	              </div><!-- /.box -->
	            </div><!-- /.col -->
	          </div><!-- /.row -->
	        </section>
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="FormsTypes">
	          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">User Type</h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 50px;">
                        <button class="btn btn-sm btn-default" onclick="$('#showing').modal('show');"><i class="fa fa-user-plus col-xs-12"></i></button>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding" id="showListTypeAdmin">
                  <table class="table table-condensed" id="level-name">
                    <tbody><tr>
                      <th style="width: 10px">#</th>
                      <th>User Type</th>
                      <th>% of all</th>
                      <th style="width: 40px">Q'ty</th>
                    </tr>
                    <?php
                    if($_SESSION['LOGIN']['LEVEL'] == 1)
                    {
						$objectLevel = new AdminPermission;
	                    	$row_level = $objectLevel->searchOther(array('level_status'=>array('operator' => '=', 'value'=>1),'level_type'=>array('operator' => '=', 'value'=>'S')),array('level_sort'=>'ASC'));
                    }
                    else
                    {
						$objectLevel = new AdminPermission;
	                    	$row_level = $objectLevel->searchOther(array('level_status'=>array('operator' => '=', 'value'=>1),'level_type'=>array('operator' => '=', 'value'=>'S')),array('level_sort'=>'ASC'));
                    }
                    
                    $color = array(
                    1 => 'danger',
                    2 => 'yellow',
                    3 => 'green',
                    4 => 'blue',
                    5 => 'primary'
                    );
                    if($row_level)
                    {
                    $num = 1;
	                    foreach( $row_level as $row_level )
	                    {
		                    $obj = new Admin;
		                    $countUser = $obj->countBind('admin_level', array('admin_level'=>$row_level->level_id));
		                    $obj = new Admin;
		                    $countUserAll = $obj->count('admin_level');
	                    if($color[$num] == 'danger')
	                    {
		                    $bg = 'red';
	                    }
	                    else
	                    {
		                    $bg = $color[$num];
	                    }
		                    echo '
		                    <tr>
		                      <td>'.$num.'.</td>
		                      <td><button type="button" class="btn btn-block btn-' . ($row_level->level_type == 'S' ? 'info' : 'warning') . '" onclick="addTypeAdmin('.$row_level->level_id.')">'.$row_level->level_name.'</button></td>
		                      <td>
		                        <div class="progress progress-xs">
		                          <div class="progress-bar progress-bar-'.$color[$num].'" style="width: '.($countUser * 100) / $countUserAll.'%"></div>
		                        </div>
		                      </td>
		                      <td><span class="badge bg-'.$bg.'">'.$countUser.'</span></td>
		                    </tr>
		                    ';
		                    $num++;
	                    }
                    }
                    ?>
                  </tbody></table>
                </div><!-- /.box-body -->
              </div>
          </div>
          <div class="tab-pane " id="FormsNewPermission">
          <section class="content">
	          <div class="box box-warning">
	            <div class="box-header">
                  <h3 class="box-title">Manage Permission</h3>
                </div>
		          <div class="box-body no-padding" style="padding-bottom:100px !important;">
				  <legend style="width:100%"></legend>
		          
		          <?php
		          	$objectMenu = new Menu;
		          	$obj = new AdminPermission;
		          	$menuWhere = array(
			          	'menu_component' => array(
				          		'operator' => '!=',
				          		'value' => "menu",
			          		),
			          	'ref_menu_id' => array(
				          		'operator' => '=',
				          		'value' => "0",
			          		),
		          	);
		          	$menuSort = array(
			          	'menu_sort' => 'asc'
		          	);
		          	$levelWhere = array(
			          	'level_status' => array(
				          		'operator' => '=',
				          		'value' => "1",
			          		)
			          	,'level_type' => array(
			          			'operator' => '=', 
			          			'value'=>'S'
			          		)
		          	);
		          	$levelSort = array(
			          	'level_sort' => 'asc'
		          	);
		          	$menu = $objectMenu->searchOther($menuWhere, $menuSort);
		          	$level = $obj->searchOther($levelWhere, $levelSort);
				  	$max = count($level);
		          ?>
		          <div class="row">
			          <div class="col-xs-12">
				          <div class="col-xs-3">
					          <?php
								if($level){
									foreach($level as $k => $v){
										echo "<button type=\"button\" data-ref=\"{$v->level_id}\" class=\"col-xs-12 btn btn-" . ($v->level_type == 'S' ? 'info' : 'warning') . " selected-permission\">{$v->level_name}</button>";
									}
								}
							  ?>
							  
				          </div>
				          <div class="col-xs-9" id="show-list-permission">
				          </div>
			          </div>
		          </div>
		          <form name="frm" id="frm" method="post" action="./Permission" target="@Alert" class="hide">
			          <table class="table table-bordered">
				          <tbody>
				          <tr>
				          	<th>
				          		Menu 
				          	</th>
				          	<?php
				          	$permissionLevel;
				          	if($level)
				          	{
					          	foreach($level as $level)
					          	{
						          	$string = explode(':',$level->level_permission);
						          	$permissionLevel[$level->level_id] = $string;
							        echo '<td>'.$level->level_name.'</td>';
					          	}
				          	}
				          	?>
				          </tr>
				          <?php
				          if($menu)
				          {	
					          if($_SESSION['LOGIN']['LEVEL'] == 2)
					          {
					              $counting = 0;
					          }else
					          {
						          $counting = 0;
					          }
				          	$permission = explode(':',$level->level_permission);
					          foreach($menu as $menu)
					          {
						          echo '<tr><th class="" >'.$menu->menu_name.'</th>';
		          	$objectLevel = new AdminPermission;
		          	$levelWhere = array(
			          	'level_status' => array(
				          		'operator' => '=',
				          		'value' => "1",
			          		)
		          	);
		          	$levelSort = array(
			          	'level_sort' => 'asc'
		          	);
		          	$level = $objectLevel->searchOther($levelWhere, $levelSort);
		          				  $ii = 0;
								  foreach($level as $level)
						          	{
						          	
						          		if($permissionLevel[$level->level_id][$counting] == 'on')
						          		{
							          		echo '<td>
							          		<input class="checky" type="checkbox"name="'.$level->level_id.'['.$menu->menu_id.'][on]" checked onclick="checkychecky(this)">
							          		<input class="checky hide" type="checkbox"name="'.$level->level_id.'['.$menu->menu_id.'][off]"></td>'; 
							          		
						          		}
						          		else
						          		{
							          		echo '<td>
							          		<input class="checky" type="checkbox" name="'.$level->level_id.'['.$menu->menu_id.'][on]" onclick="checkychecky(this)">
							          		<input class="checky hide" type="checkbox"name="'.$level->level_id.'['.$menu->menu_id.'][off]" checked></td>';
						          		}
						          		$ii++;
						          	}
						          	echo '</tr>';
						          	$counting++;
					          }
				          }
				          ?>
				          </tbody>
				          <tfoot>
				              <tr>
				                  <td colspan="2" class="tc">
				                      <button type="submit" class="btn btn-success btn-sm">บันทึกข้อมูล</button>
				                      <button type="reset" class="btn btn-warning btn-sm">ยกเลิก</button>
				                  </td>
				              </tr>
				          </tfoot>
			          </table>
			          
			          
		          </form>
		          </div>
	          </div>
          </section>
          </div><!-- /.tab-pane -->
        </div>
        
	<div class="modal fade" id="editting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
		      <h5 class="modal-title" id="exampleModalLabel">แก้ไขระดับการเข้าใช้งาน</h5>
	      </div>
		      <div class="modal-body">
			   <div class="row">
					<div class="col-xs-12" id="editContent"></div>
			
			    </div><!--End Row-->
		      </div>
		      <div class="modal-footer">
				  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
				  <button type="button" id="add-type-btn" data-ref="" class="btn btn-success btn-sm" onclick="saveTypeAdmin()">บันทึก</button>
<!-- 				  <button type="button"  id="delete-type-btn" data-ref="" class="btn btn-danger btn-sm" >ลบ</button> -->
				  
		      </div>
		    </div>
		  </div>
	</div>
	<div class="modal fade" id="showing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
		      <h5 class="modal-title" id="exampleModalLabel">เพิ่มระดับการเข้าใช้งาน</h5>
	      </div>
		      <div class="modal-body">
			   <div class="row">
					<div class="col-xs-12">
					<?php
						$type = array(
							'S' => 'Staff',
							'C' => 'Member'
						);
						PushUsername('ชื่อระดับการเข้าใช้งาน', 'level_name','w300','ml-150');
						PushSelectList($type, 'ประเภท User', 'level_type', null, 'ml-150', $object->level_type);
					?>
					</div>
			
			    </div><!--End Row-->
		      </div>
		      <div class="modal-footer">
				  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
				  <button type="button" id="add-type-btn" data-ref="" class="btn btn-success btn-sm" onclick="saveTypeAdmin()">บันทึก</button>
				  
		      </div>
		    </div>
		  </div>
	</div>
	<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Create New Staff</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
  		<form id="insert" action="./Admin" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-sm-12">
		      		<?php
					$select = array(
					'N' => 'Deactivate',
					'Y' => 'Activate');
					$position = array(
						'0' => '---- Select ----',
						'N' => 'กลางคืน',
						'D' => 'เช้า',
						'E' => 'บ่าย',
					);
	          	
					$objectLevel = new AdminPermission;
					if($rs->admin_active == 'Y'){
						$adminStatus = 'Y';
					}else $adminStatus = 'N';
					if($_SESSION['LOGIN']['LEVEL'] == 2){
						$level = $objectLevel->all();
					}else $level = $objectLevel->search(array('level_status' => 1));
					if($level)
					{
						foreach($level as $level)
						{
							$selectLevel[$level->level_id] = $level->level_name;
						}
					}
						PushUsername('Username', 'admin_username',null,'ml-100',$object->admin_username, true);
						PushPassword('Password', 'admin_pass',null,'ml-100');
						PushUsername('Name', 'admin_name',null,'ml-100',$object->admin_name);
						PushUsername('Surname', 'admin_surname',null,'ml-100',$object->admin_surname);
						PushEmail('Email', 'admin_email',null,'ml-100',$object->admin_email, true);
						PushTel('Telephone', 'admin_tel',null,'ml-100',$object->admin_tel);
						PushSelectList($select, 'Status', 'admin_active', null, 'ml-100', $object->admin_active);
						PushSelectList($position, 'Shift', 'admin_group', null, 'ml-100', $object->admin_group);
						PushHidden('ID', 'admin_id',null, 'ml-100', $object->admin_id);
						PushSelectList($selectLevel,'Level', 'admin_level',null, 'ml-100', $object->admin_level, true);
					?>
		      	</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>
  		</form>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Staff</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
  		<form id="insert" action="./Admin" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-sm-12" id="content-edit"><!-- CONTENT FROM CONTROLLER --></div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>
  		</form>
	    </div>
	  </div>
	</div>
		<script>
			$(document).on('click', '.updatePermission', function(){
				console.log($(this))
				$.ajax({
					url: './UpdatePermission',
					data: $('#PermissionAdd').serialize(),
					type: 'POST'
				})
				.done(function(rs){
					console.log(rs)
				})
			})
			$(document).on('click', '.selected-permission', function(){
				var id = $(this).attr('data-ref')
				$.ajax({
					url: './GetConfigurationPermission',
					data: {'id' : id},
					dataType: 'text',
					type: 'POST'
				})
				.done(function(rs){
					$('#show-list-permission').html(rs)
				})
			})
	$(function () {
		var table = $("#admin-table").DataTable({
			'searching': true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
	            "url": "./GetDataList",
	            "type": "POST"
	        },
            "aaSorting": [1,'asc'],
            "columnDefs": [
            		{ className: "text-center", "targets": [ 0,1 ] },
            		{
		            "searchable": false,
		            "orderable": false,
		            "targets": [0,6]
		        } 
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
		table.on('order.dt search.dt', function () {
             table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                 cell.innerHTML = i + 1;
             });
         }).draw();
	});
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
	
	function addTypeAdmin(id){
		var datastring = 'id='+id;
		$.ajax({
			url: "./GetLevelName",
			type: "POST",
			data: {"id" : id},
			dataType: 'JSON'
		})
		.done(function(rs){
			var elementValue = '<div class="frm clear form-group col-xs-12">'
			+ '<label class="frm-label b" for="level_name">ชื่อระดับการเข้าใช้งาน : </label>'
			+ '<div class="frm-field ml-150 input-group">'
			+ '	<div class="input-group-addon">'
            + '    	<i class="fa fa-user"></i>'
            + '    </div>'
            + '    <input type="text" id="level_name" name="level_name" class="form-control" value="'+rs.level_name+'">'
			+ '	<div id="elevel_name" class="errtxt" rel="กรุณาป้อน|ชื่อระดับการเข้าใช้งาน"></div>'
			+ '</div>'
			+ '</div>'
			+ '<div class="frm clear form-group col-xs-12" >'
			+ '	<label class="frm-label b" for="level_type">ประเภท User : </label>'
			+ '	<div class="frm-field ml-150 input-group">'
			+ '		<div class="input-group-addon">'
	        + '        	<i class="fa fa-th-list"></i>'
	        + '        </div>'
			+ '		<select id="level_type" name="level_type" class="form-control input ui-corner-all " >'
			+ '			<option value="S" ' + (rs.level_type == 'S' ? 'selected' : '') + '>Staff</option>'
			+ '			<option value="C" ' + (rs.level_type == 'C' ? 'selected' : '') + '>Member</option>'
			+ '		</select>'
			+ '		<div id="elevel_type" class="errtxt" rel="กรุณาป้อน|ประเภท User"></div>'
			+ '	</div>'
			+ '</div>'
			$('#editContent').append(elementValue)
			$('#add-type-btn').attr('data-ref', rs.level_id)
// 			$('#delete-type-btn').attr('data-ref', rs.level_id)
			$('#preview').hide();
			$('#editting').modal('show');
			
		})
	}
	function saveTypeAdmin(){
		var id = $('#add-type-btn').attr('data-ref')
		if(id == '' || id == undefined)
		{
			var datastring = 'addValue='+$('#level_name').val();
		}else
		{
			var datastring = 'addValue='+$('#level_name').val()+'&idType='+id;
		}
		 console.log(datastring)

		 $.ajax({
			 url: './TypeAdmin',
			 type: 'POST',
			 data: { 'levelName' : $('#level_name').val(), 'level_type' : $('#level_type').val(), 'id' : id},
			 dataType: 'JSON'
		 })
		 .done(function(result){
			 console.log(result)
			 var number = $('#level-name').find('tbody').find('tr').length
			 var data = '<tr>'
		                      + '<td>' + number + '.</td>'
		                      + '<td><button type="button" class="btn btn-block btn-info" onclick="addTypeAdmin(' + result.data.id + ')">' + result.data.name + '</button></td>'
		                      + '<td>'
		                      + '<div class="progress progress-xs">'
		                      + '<div class="progress-bar progress-bar-primary" style="width: 0%"></div>'
		                      + '</div>'
		                      + '</td>'
		                      + '<td><span class="badge bg-primary">0</span></td>'
		                      + '</tr>'
			 $('#level-name').find('tbody').append(data)
// 			 $('.modal').modal('toggle');
			 location.reload()
		 })

	}
	$(document).on('click', '#delete-type-btn',function(){
		console.log(this)
		if(confirm('คุณต้องการที่จะลบระดับการเข้าใช้งานนี้หรือไม่?'))
		{
			var id = $('#delete-type-btn').attr('data-ref')
			var datastring = 'idType='+id;
			$.ajax({
				url: './DeleteLevelName',
				data: {
					'id' : id
				},
				type: 'POST',
				dataType: 'JSON'
			})
			.done(function(html)
			{
				if(html.status == 'COMPLETE')
				location.reload()
			})
		}
	})
		</script>
</div>