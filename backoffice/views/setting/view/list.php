<?php
include('../../../init.php');
	$db->bind("menu_active","Y");
	$row = $db->query("SELECT * FROM ".DB_PREFIX."menu WHERE menu_active = :menu_active ORDER BY ref_menu_id asc,menu_sort asc");
	if($row)
	{
		$memu 		= array();
		$active 	= array();
		foreach($row AS $r){
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
		unset($row);
	}
	$db->bind("menu_active","Y");
	$row = $db->query("SELECT * FROM ".DB_PREFIX."menu ORDER BY menu_sort asc");
?>
<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="menu-table" class="table table-bordered table-hover">
                    <thead>
						<th scope="col" class="w20"><input type="checkbox" id="checkAll"/></th>
						<th scope="col"><b>Main Menu</b></th>
						<th scope="col"><b>Sub Menu</b></th>
						<th scope="col"><b>Component</b></th>
						<th scope="col"><b>Sort</b></th>
						<th scope="col"><b>Link</b></th>
						<th scope="col" class="tc w100"><b>Action</b></th>
                    </thead>
                    <tbody>
<?php
	if( $memu['0'] ){
		foreach($memu['0'] AS $m){
			if($inum++%2==1) $row =  ' class="spec"'; else $row='';
			echo '
			<tr'.$row .'>
				<td><input name="id" type="checkbox" id="id" value="'.$r->menu_id.'" class="checkboxAll" /></td>
				<td>'.$m['name'].'</td>
				<td>-</td>
				<td>'.$m['component'].'</td>
				<td>'.$m['sort'].'</td>
				<td>'.$m['link'].'</td>
				<td>
					<a href="#FormsAddEdit" onclick="addSub('.$m['id'].')"id="add-FormsAddEdit"><i class="fa fa-plus fa-2x"></i></a>&nbsp;
					<a href="#FormsAddEdit" onclick="edit('.$m['id'].')" id="edit-FormsAddEdit"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
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
							<a href="#FormsAddEdit" id="edit-FormsAddEdit" onclick="editSub('.$s['ref'].','.$s['id'].')"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
							<a href="?Mode=Del&id='.$s['id'].'" onclick="return confirm(\'Confirm Delete?\')"><i class="fa fa-remove fa-2x"></i></a>&nbsp;
						</td>
					</tr>';
				}
			}
		}
	}
?>
						
					</tbody>
                    <tfoot>
                      <tr>
                        <th scope="col"><!--<input type="checkbox" id="checkAll"/>--></th>
						<th scope="col"><b>Main Menu</b></th>
						<th scope="col"><b>Sub Menu</b></th>
						<th scope="col"><b>Component</b></th>
						<th scope="col"><b>Sort</b></th>
						<th scope="col"><b>Link</b></th>
						<th scope="col" class="tc w100"><b>Action</b></th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>


			
			