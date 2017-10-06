<?php

require BACKOFFICE . DS . 'CoreController' . EXT;
class cCompile Extends CoreController{
	function __construct($dbOld){
		$this->db = $dbOld;
	}
	function Delall(){//ลบALL
		for($i=0;$i<count(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));$i++)	
	  {
		$this->db->delete(DB_PREFIX.'user_admin', array('admin_id'=> filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT)[$i]));
		$row = $this->db->record(DB_PREFIX.'user_admin', array('admin_id' => gv_int('id')[$i]));
		$typeLOG	= 'I';
		$detailLOG	= 'ลบ Staff : '.$row->admin_name;
		$memberLOG	= $row->admin_id;
		$staffLOG	= $_SESSION['LOGIN']['ID'];
		logging($this->db,$typeLOG,$detailLOG,$memberLOG,$staffLOG);
	  }
		redirect('./');
	}
	public function Del(){
		$this->db->delete(DB_PREFIX.'user_admin', array('admin_id'=> gv_int('id')));
		$row = $this->db->record(DB_PREFIX.'user_admin', array('admin_id' => gv_int('id')));
		$typeLOG	= 'I';
		$detailLOG	= 'ลบ Staff : '.$row->admin_name;
		$memberLOG	= $row->admin_id;
		$staffLOG	= $_SESSION['LOGIN']['ID'];
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Admin List';
		$log->logging_description = 'Delete';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		redirect('./');
	}
	public function Admin(){
		$err = array();
		
		$objectCheck = new Admin;
		$object = new Admin;
		$row = $objectCheck->findx(p_string('admin_username'),'admin_username');
		if(!required($_POST['admin_username']))			$err[] = 'Username not empty!';
		if(!required($_POST['admin_name']))				$err[] = 'Name not empty!';
		if(!required($_POST['admin_surname']))			$err[] = 'Surname not empty!';
		if(!validEmail($_POST['admin_email']))			$err[] = 'E-mail invalid';		
		if(count($err) > 0) {  alert($err); return exit; }
		$data = array(
			'admin_username' 		=> filter_input(INPUT_POST, 'admin_username', FILTER_SANITIZE_STRING),
			'admin_name' 			=> filter_input(INPUT_POST, 'admin_name', FILTER_SANITIZE_STRING),
			'admin_surname' 		=> filter_input(INPUT_POST, 'admin_surname', FILTER_SANITIZE_STRING),
			'admin_email' 			=> filter_input(INPUT_POST, 'admin_email', FILTER_VALIDATE_EMAIL),
			'admin_tel' 			=> filter_input(INPUT_POST, 'admin_tel'),
			'admin_admin_update' 	=> $_SESSION['LOGIN']['ID'],
			'admin_date_update' 	=> CURRENT_TIME,
			'admin_level' 	     	=> filter_input(INPUT_POST, 'admin_level', FILTER_VALIDATE_INT)
		);
		$object->admin_username = p_string('admin_username');
		$object->admin_name = p_string('admin_name');
		$object->admin_surname = p_string('admin_surname');
		$object->admin_email = pv_email('admin_email');
		$object->admin_tel = p_string('admin_tel');
		$object->admin_admin_update = $_SESSION['LOGIN']['ID'];
		$object->admin_date_update = CURRENT_TIME;
		$object->admin_level = pv_int('admin_level');
		$object->admin_group = p_string('admin_group');
		
		if( !empty(filter_input(INPUT_POST, 'admin_pass', FILTER_SANITIZE_STRING)) && !empty(filter_input(INPUT_POST, 'admin_username', FILTER_SANITIZE_STRING)) ){
			$data['admin_pass'] = password_hash(filter_input(INPUT_POST, 'admin_pass', FILTER_SANITIZE_STRING).filter_input(INPUT_POST, 'admin_username', FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);
			$object->admin_pass = password_hash(p_string('admin_pass').p_string('admin_username'),PASSWORD_DEFAULT);
		}
		foreach($data as $k => $v)
		{
			$string .= $k.':'.$v.'<br>';
		}
		if(empty(pv_int('admin_id'))){
			$object->Create();
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Admin List';
		$log->logging_description = 'Add';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
			alert('Insert to complete!');
		}else{
			
			$object->Save(pv_int('admin_id'));
			$typeLOG	= 'I';
			$detailLOG	= 'Edit : '.$string;
			$memberLOG	= null;
			$staffLOG	= $_SESSION['LOGIN']['ID'];
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Admin List';
		$log->logging_description = 'Edit';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
			alert('Update to complete!');
		}
		redirect('./', 'refresh');
	}
	public function Permission(){
		
      	$objectMenu = new Menu;
      	$objectLevel = new AdminPermission;
      	$menu = $objectMenu->all();
      	$level = $objectLevel->all();
		$totalLevel = count($level);
		$check = array();
		$sss = array();
		$check_= array();
		$chck = array();
		if(filter_input_array(INPUT_POST))
		{
			$a = filter_input_array(INPUT_POST);
			$ks=0;
			foreach($a as $k => $v)
			{
				echo array_search("on",$v);
				foreach($v as $kk=>$vv)
				{
					$chck[$k] .= array_search("on",$vv).':';
				}
				$ks++;
			}
		}
		foreach($chck as $k => $v)
		{
			str_replace('on', '1', $chck[$k]);
		}
		$status;
		$check = array_values($chck);
		foreach($check as $k => $v)
		{
			
      		$objectLevel_ = new AdminPermission;
          	$levelWhere = array(
	          	'level_status' => array(
		          		'operator' => '=',
		          		'value' => "1",
	          		)
          	);
          	$levelSort = array(
	          	'level_sort' => 'asc'
          	);
          	$level_ = $objectLevel_->searchOther($levelWhere, $levelSort);
			$check_[$level_[$k]->level_id] = $v;
		}
		foreach($check_ as $k => $v)
		{
      		$objectLevelUpdate = new AdminPermission;
			if($k == 2)
			{
				$objectLevelUpdate->level_permission = $v;
				$data = array(
					'level_permission' => $v
				);
			}
			else
			{
				$objectLevelUpdate->level_permission = $v;
				$data = array(
					'level_permission' => $v
				);
			}
			$objectLevelUpdate->Save($k);
		}
  		$objectLevelNew = new AdminPermission;
  		$level = $objectLevelNew->find($_SESSION['LOGIN']['LEVEL']);
		$permission = explode(":",$level->level_permission);
		$_SESSION['LOGIN']['PERMISSION'] = $permission;
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Admin List';
		$log->logging_description = 'Edit Permission';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		redirect('./');
	}
	public function Edit(){
		$object = new Admin();
		$object = $object->find(p_int('id'));
		
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Admin List';
		$log->logging_description = 'View';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		$position = array(
			'0' => '---- Select ----',
			'N' => 'กลางคืน',
			'D' => 'เช้า',
			'E' => 'บ่าย',
		);
		$select = array(
		'N' => 'Deactivate',
		'Y' => 'Activate');
		$obj = new AdminPermission;
		if($_SESSION['LOGIN']['LEVEL'] == 2){
			$level = $obj->all();
		}else $level = $level = $obj->search(array('level_status' => 1));
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
		
	}
	public function TypeAdmin(){
		$object = new AdminPermission;
		$object->level_name = p_string('levelName');
		$object->level_type = p_string('level_type');
		$object->level_status = 1;
		
		if(pv_int('id'))
		{
			$log = new Logging();
			$log->logging_date = date('Y-m-d');
			$log->logging_time = date('H:i:s');
			$log->logging_type = 'Admin List';
			$log->logging_description = 'Edit Level';
			$log->logging_ref_staff = ADMINID;
			$object->Save(pv_int('id'));
			$data = array(
				'status'=>'COMPLETE', 
				'data'=>array(
					'name'=>p_string('levelName'),
					'id'=>pv_int('id')
				)
			);
			$log->Create();
			echo json_encode($data);
			exit;
		}
		else
		{
			$log = new Logging();
			$log->logging_date = date('Y-m-d');
			$log->logging_time = date('H:i:s');
			$log->logging_type = 'Admin List';
			$log->logging_description = 'Add Level';
			$log->logging_ref_staff = ADMINID;
			$id = $object->createGetID();
			$data = array(
				'status'=>'COMPLETE', 
				'data'=>array(
					'name'=>p_string('levelName'),
					'id'=>$id
				)
			);
			$log->Create();
			echo json_encode($data);
			exit;
		}
		$data = array(
			'status'=>'FAIL'
		);
		echo json_encode($data);
	}
	public function GetLevelName(){
		$object = new AdminPermission;
		$getData = $object->find(pv_int('id'));
		echo json_encode($getData);
	}
	public function DeleteLevelName(){
		$object = new AdminPermission;
		$getData = $object->delete(pv_int('id'));
		echo json_encode(array('status' => 'COMPLETE'));
	}
	public function GetDataList(){
// 		Table NAME
		$table = DB_PREFIX . 'user_admin';
// 		Primary Key
		$primaryKey = 'admin_id';
		$columns = array(
			array( 'db' => 'admin_username',   'dt' => 0),
			array( 'db' => 'admin_username',   'dt' => 1),
			array( 'db' => 'admin_name',   'dt' => 2),
			array( 'db' => 'admin_email',   'dt' => 3),
			array( 'db' => 'admin_tel',   'dt' => 4 ),
			array( 'db' => 'admin_date_login',     'dt' => 5 ),
		    array(
		        'db'        => 'admin_id',
		        'dt'        => 6,
		        'formatter' => function( $d, $row ) {
			        	
					$obj = new Permission;
					$edit = $obj->permissionLink('edit', "<a href=\"javascript:void(0)\" data-value=\"{$d}\" class=\"edit-btn\"><i class=\"fa fa-edit fa-2x\"></i></a>");
					$obj = new Permission;
					$del = $obj->permissionLink('delete', "<a href=\"?Mode=Del&id={$d}\" id=\"del-FormsAddEdit\" onclick=\"return confirm('Confirm Delete?')\"><i class=\"fa fa-remove fa-2x\"></i></a>");
		            return $edit."&nbsp;&nbsp;". $del;
// 						. 
		        }
		    ),
			
			
		);
		$DB_SETTING = parse_ini_file(CONFIG_PATH . DS . "settings.ini.php");
		$sql_details['scheme'] = 'mysql';
		$sql_details['host'] = $DB_SETTING['host'];
		$sql_details['user'] = $DB_SETTING['user'];
		$sql_details['pass'] = $DB_SETTING['password'];
		$sql_details['path'] = '/'.$DB_SETTING['dbname'];
		$sql_details['fragment'] = 'utf8';
		$sql_details['db'] = $DB_SETTING['dbname'];
		
		$obj = new AdminPermission;
		$getData = $obj->search(array('level_type' => 'S'));
		$total = array();
		if($getData)
		{
		    foreach($getData as $k => $v)
		    {
		        $total[] = $v->level_id;
		    }
		}
		
		$whereResult = 'admin_level IN ('.implode(',', $total).')';
		echo json_encode(
			SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns, null,$whereResult)
		);
	}
	public function GetConfigurationPermission(){
		
      	$obj = new AdminPermission;
      	$pms = $obj->find(p_int('id'));
      	$pm = json_decode($pms->level_permission_each);
		$obj = new Menu;
      	$menuWhere = array(
          	'menu_component' => array(
	          		'operator' => '!=',
	          		'value' => "menu",
          		)
      	);
      	$menuSort = array(
          	'menu_sort' => 'asc'
      	);
      	$menu = $obj->searchOther($menuWhere, $menuSort);
      	if($menu)
      	{
			echo "
	          <form name=\"frm\" method=\"post\" id=\"PermissionAdd\" target=\"@Alert\">
		          <input id=\"id\" type=\"hidden\" name=\"id\" value=\"" . p_int('id') . "\">
		          <div class=\"row\">
			          <div class=\"b col-xs-3\">Menu</div>
			          <div class=\"b col-xs-1\">See</div>
			          <div class=\"b col-xs-1\">Show</div>
			          <div class=\"b col-xs-1\">Insert</div>
			          <div class=\"b col-xs-1\">Update</div>
			          <div class=\"b col-xs-1\">Delete</div>
		          </div>";
		          foreach($menu as $k => $v)
		          {
			          $componant = $v->menu_component;
			          echo "<div class=\"row\" style=\"height:30px; border:0.5px solid\">
				          <div class=\"col-xs-3 b\">{$v->menu_name}</div>
				          <div class=\"col-xs-1\">
					          <input class=\"updatePermission\" type=\"checkbox\"name=\"{$v->menu_component}[see]\" " . ($pm->$componant->see ? 'checked' : '') . " style=\"top:0px;\">
				          </div>
				          <div class=\"col-xs-1\">
					          <input class=\"updatePermission\" type=\"checkbox\"name=\"{$v->menu_component}[show]\" " . ($pm->$componant->show ? 'checked' : '') . " style=\"top:0px;\">
					      </div>
				          <div class=\"col-xs-1\">
					          <input class=\"updatePermission\" type=\"checkbox\"name=\"{$v->menu_component}[insert]\" " . ($pm->$componant->insert ? 'checked' : '') . " style=\"top:0px;\">
					      </div>
				          <div class=\"col-xs-1\">
					          <input class=\"updatePermission\" type=\"checkbox\"name=\"{$v->menu_component}[edit]\" " . ($pm->$componant->edit ? 'checked' : '') . " style=\"top:0px;\">
					      </div>
				          <div class=\"col-xs-1\">
					          <input class=\"updatePermission\" type=\"checkbox\"name=\"{$v->menu_component}[delete]\" " . ($pm->$componant->delete ? 'checked' : '') . " style=\"top:0px;\">
					      </div>										  
			          </div>";

		          }
		          echo "
	          </form>";
        }
	}
	public function UpdatePermission(){
		$id = p_int('id');
		unset($_POST['id']);
      	$obj = new AdminPermission;
      	$obj->level_permission_each = json_encode($_POST);
      	$obj->Save($id);
	}
}

function setPermission($key, $checkKey, $val)
{
	if($key == $checkKey)
	{
		foreach($val as $k => $v)
		{
			if(empty($v))
			{
				$check[$key][substr($k,0,1)] .= '0:';
			}
			else
			{
				$check[$key][substr($k,0,1)] .= '1:';
			}
			return $check;
		}
	}
}
?>
