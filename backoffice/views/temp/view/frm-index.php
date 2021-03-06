
<div class="content">
	<div class="content-header hide" id="SetTitle">จัดการสินค้า</div>
		<div id="FormsViewList" class="frm-viewlist"> 
		<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
				    	
					    <?=@$permissionCheck->permissionButton('insert', 'สร้างสินค้าใหม่', "btn btn-info modalInsert pull-right", 'button');?>
                </div><!-- /.box-header -->
                <div class="box-body " style="overflow-x: scroll">
                  <table id="menu-table" class="table table-bordered table-hover">
                    <thead>
						<th scope="col" class="w20"><input type="checkbox" id="checkAll"/></th>
						<th scope="col"><b>เมนู</b></th>
						<th scope="col"><b>เมนูย่อย</b></th>
						<th scope="col"><b>Component</b></th>
						<th scope="col"><b>ลำดับ</b></th>
						<th scope="col"><b>Link</b></th>
						<th scope="col" class="tc w100"><b>จัดการ</b></th>
                    </thead>
                    <tbody></tbody>
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
  		<form id="insert" action="./Menu/" method="post" target="@Alert" enctype="multipart/form-data" data-parsley-validate="true">
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
	$(document).on('click', '.modalInsert', function(){
		var id = $(this).attr("data-val");
		if($.isNumeric(id)) $('#ref_menu_id').val(id) 
		else $('#ref_menu_id').val(0)
		$('#modalInsert').modal('show');
	})
</script>