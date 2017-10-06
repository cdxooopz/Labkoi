<?php
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Menu List';
		$log->logging_description = 'View List';
		$log->logging_ref_staff = ADMINID;
		$log->Create();

?>
<div class="content">
	<div class="content-header hide" id="SetTitle">Menu</div>
		<div id="FormsViewList" class="frm-viewlist"> 
		<?php
			$object = new Menu;
			$getDataSub = $object->search(array('menu_active' => 'Y'), array('ref_menu_id' => 'ASC', 'menu_sort' => 'ASC'));
			$object = new Menu;
			$getData = $object->search(array('menu_active' => 'Y'), array( 'menu_sort' => 'ASC'));
// 			print_r($getData);
			if($getDataSub)
			{
				$memu 		= array();
				$active 	= array();
				foreach($getDataSub AS $r){
					$active[$r->ref_menu_id][$r->menu_link] = $r->menu_link;
					$menu_sort = $r->menu_sort;
					if($memu[$r->ref_menu_id][$r->menu_sort]){ $menu_sort++; }
					
					$memu[$r->ref_menu_id][$menu_sort] = array(
										'id' 		=>	$r->menu_id ,
										'ref' 		=>	$r->ref_menu_id ,
										'name' 		=>	$r->menu_name,
										'component'	=>	$r->menu_component,
										'link' 		=>	$r->menu_link,
										'sort' 		=>	$r->menu_sort,
									);
					if( $r->menu_link  == '?'.$_SERVER['QUERY_STRING'])	$_menu = $r->menu_name;
				}
				unset($getDataSub);
			}
		?>
		<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header text-right">
				    	
					    <?=@$permissionCheck->permissionButton('insert', 'สร้างเมนูใหม่', "btn btn-info modalInsert pull-right", 'button');?>
					    <button type="button" id="insert" class="btn btn-info modalInsert pull-right">สร้างเมนูใหม่</button>
                </div><!-- /.box-header -->
                <div class="box-body " style="overflow-x: scroll">
                  <table id="menu-table" class="table table-bordered table-hover">
                    <thead>
						<th scope="col" class="w20">#</th>
						<th scope="col"><b>เมนู</b></th>
						<th scope="col"><b>เมนูย่อย</b></th>
						<th scope="col"><b>Component</b></th>
						<th scope="col"><b>ลำดับ</b></th>
						<th scope="col"><b>Link</b></th>
						<th scope="col" class="tc w100"><b>จัดการ</b></th>
                    </thead>
                    <tbody>
<?php
	if( $memu['0'] ){
		foreach($memu['0'] AS $k => $m){
			if($inum++%2==1) $row =  ' class="spec"'; else $row='';
			echo '
			<tr'.$row .'>
				<td>'. ($k+1).'</td>
				<td>'.$m['name'].'</td>
				<td>-</td>
				<td>'.$m['component'].'</td>
				<td>'.$m['sort'].'</td>
				<td>'.$m['link'].'</td>
				<td>
					<a href="javascript:void(0)" data-val="' . $m['id'] . '" class="modalInsert"><i class="fa fa-plus fa-2x"></i></a>&nbsp;
					<a href="javascript:void(0)" class="edit-btn" data-val="' . $m['id'] . '" id="edit-FormsAddEdit"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
					<a href="?Mode=Del&id='.$m['id'].'" id="del-FormsAddEdit"><i class="fa fa-remove fa-2x"></i></a>&nbsp;
				</td>
			</tr>';
			if( $memu[$m['id']] ){
				foreach($memu[$m['id']] AS $s){
					if($inum++%2==1) $row =  ' class="spec"'; else $row='';
					echo '
					<tr'.$row .'>
						<td><input name="id" type="checkbox" id="id" value="'.$s['id'].'" class="checkboxAll" /></td>
						<td>-</td>
						<td>'.$s['name'].'</td>
						<td>'.$s['component'].'</td>
						<td>'.$s['sort'].'</td>
						<td>'.$s['link'].'</td>
						<td>
							<a href="javascript:void(0)" id="edit-FormsAddEdit"  data-val="' . $s['id'] . '" class="edit-btn"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
							<a href="?Mode=Del&id='.$s['id'].'" onclick="return confirm(\'Confirm Delete?\')"><i class="fa fa-remove fa-2x"></i></a>&nbsp;
						</td>
					</tr>';
				}
			}
		}
	}
?>
						
					</tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
		</div>
	<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">สร้างเมนูใหม่</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
  		<form id="insert" action="./Insert" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-sm-12">
						<?php
						$subMenu = new Menu;
						$menuList = $subMenu->search(array('menu_active' => 'Y', 'ref_menu_id' => '0'));
						$menu[0]    =    'เมนูหลัก';
						if($menuList){
							foreach($menuList as $menuList){
								$menu[$menuList->menu_id] = $menuList->menu_name;
							}
						}
							PushText('Menu', 'menu_name','w300','ml-100');
							PushText('Component', 'menu_component','w300','ml-100');
							PushText('Sort', 'menu_sort','w300','ml-100');
							PushText('Link', 'menu_link','w300','ml-100');
							PushText('Icon', 'menu_icon','w300','ml-100');
							PushHidden('ID', 'menu_id','', 'ml-100');
							PushSelect($menu,'เมนูหลัก', 'ref_menu_id','', 'ml-100');
						?>
		      	</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
	        <button type="submit" class="btn btn-primary">บันทึก</button>
	      </div>
  		</form>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">แก้ไขเมนู</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
  		<form id="insert" action="./Insert" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-sm-12" id="content-edit"><!-- CONTENT FROM CONTROLLER --></div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
	        <button type="submit" class="btn btn-primary">บันทึก</button>
	      </div>
  		</form>
	    </div>
	  </div>
	</div>
</div>
<script>
	$(document).on('click', '.createfiles', function(){
		$.ajax({
			url: "./CreateFile",
		})
		.done(function(rs){
			console.log(rs)
		})
	})
	$(document).on('click', '.edit-btn', function(){
		var id = $(this).attr("data-val");
		$.ajax({
			url: "./GetData",
			type: "POST",
			data: {"id" : id}
		})
		.done(function(rs){
			$('#content-edit').html(rs);
			$('#modalEdit').modal('show');
		})
	})
	$(function(){
		$('#menu-table').dataTable();
	})
	$(document).on('click', '.modalInsert', function(){
		var id = $(this).attr("data-val");
		if($.isNumeric(id)) $('#ref_menu_id').val(id) 
		else $('#ref_menu_id').val(0)
		$('#modalInsert').modal('show');
	})
</script>