 <?php
include('../../../init.php');
include('../../ck_plugin/templates/inc_function.php');
?>


	          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">รายการประเภทการเข้าใช้งาน</h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 50px;">
                        <button class="btn btn-sm btn-default" onclick="addTypeAdmin()"><i class="fa fa-user-plus col-xs-12"></i></button>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding" id="showListTypeAdmin">
                  <table class="table table-condensed">
                    <tbody><tr>
                      <th style="width: 10px">#</th>
                      <th>ประเภทการเข้าใช้งาน</th>
                      <th>% ของทั้งหมด</th>
                      <th style="width: 40px">จำนวน</th>
                    </tr>
                    <?php
                    if($_SESSION['LOGIN']['LEVEL'] == 2)
                    {
                    	$row_level = $dbOld->result(DB_PREFIX.'admin_level');
                    }
                    else
                    {
	                    $row_level = $dbOld->result(DB_PREFIX.'admin_level', array('level_status' => 1));
                    }
                    
                    $color = array(
                    1 => 'danger',
                    2 => 'yellow',
                    3 => 'green',
                    4 => 'blue'
                    );
                    if($row_level)
                    {
                    $num = 1;
	                    foreach( $row_level as $row_level )
	                    {
	                    $countUser = $dbOld->countRow(DB_PREFIX.'user_admin', array('admin_level' => $row_level->level_id));
	                    $countUserAll = $dbOld->countRow(DB_PREFIX.'user_admin');
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
		                      <td><button type="button" class="btn btn-block btn-info" onclick="addTypeAdmin('.$row_level->level_id.')">'.$row_level->level_name.'</button></td>
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
          