<?php
require BACKOFFICE . DS . 'CoreController' . EXT;
class cCompile Extends CoreController{
	private $menu;
	function __construct($db){
		$this->db = $db;
	}
	public function Del(){
		$object = new Menu();
		$objectSub = new Menu();
		$object->delete(p_int('id'));
		$dataSub = $objectSub->findx(g_int('id'), 'ref_menu_id');
		if($dataSub)
		{
			foreach($dataSub AS $k => $v)
			{
				$object = new Temp();
				$dataSub->menu_id;
				$object->delete($dataSub->menu_id);
			}
		}
		
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Menu List';
		$log->logging_description = 'Delete';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		redirect('./');
	}
	public function Insert(){
	
		$menu = new Menu();
		$err = array();
		if(!required(p_string('menu_name')))				$err[] = 'กรุณาระบุ Menu';
		if(!required(p_string('menu_component')))			$err[] = 'กรุณาระบุ Component';
		if(!required(p_string('menu_sort')))				$err[] = 'กรุณาระบุ Sort';
		if(!required(p_string('menu_link')))				$err[] = 'กรุณาระบุ Link';
		if(count($err) > 0) {  alert($err); return exit; }
		$menu->menu_component = p_string('menu_component');
		$menu->menu_name = p_string('menu_name');
		$menu->ref_menu_id = p_int('ref_menu_id');
		$menu->menu_sort = p_string('menu_sort');
		$menu->menu_link	= p_string('menu_link');
		$menu->menu_icon = (p_string('menu_icon') ? p_string('menu_icon') : 'fa fa-circle-o');
		$menu->menu_admin_update = $_SESSION['LOGIN']['ID'];
		$menu->menu_date_update = CURRENT_TIME;
		if(empty(p_string('menu_id'))){
			$data['menu_admin_create'] 	= $_SESSION['LOGIN']['ID'];
			$data['menu_date_create'] 	= CURRENT_TIME;
			$menu->Create();
			alert('Insert to complete!');
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Menu List';
		$log->logging_description = 'Add';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		$this->menu = p_string('menu_link');
		$this->CreateFile();
		}else{
			$menu->menu_id = p_int('menu_id');
			$menu->Save();
			alert('Update to complete!');
		$log = new Logging();
		$log->logging_date = date('Y-m-d');
		$log->logging_time = date('H:i:s');
		$log->logging_type = 'Menu List';
		$log->logging_description = 'Edit';
		$log->logging_ref_staff = ADMINID;
		$log->Create();
		}
		redirect('./');
	}
	public function GetData(){
		if( !empty(pv_int('id')) ) {
			$refMenu = new Menu;
			$rs = $refMenu->find(pv_int('id'));
		}
		if( empty(g_int('menu')) ) $ref_menu_id = 0; else $ref_menu_id = g_int('menu');
		
		$subMenu = new Menu;
		$menuList = $subMenu->search(array('menu_active' => 'Y', 'ref_menu_id' => '0'));
		$menu[0]    =    'เมนูหลัก';
		if($menuList){
			foreach($menuList as $menuList){
				$menu[$menuList->menu_id] = $menuList->menu_name;
			}
		}
			PushText('Menu', 'menu_name','w300','ml-100',$rs->menu_name);
			PushText('Component', 'menu_component','w300','ml-100',$rs->menu_component);
			PushText('Sort', 'menu_sort','w300','ml-100',$rs->menu_sort);
			PushText('Link', 'menu_link','w300','ml-100',$rs->menu_link);
			PushText('Icon', 'menu_icon','w300','ml-100',$rs->menu_icon);
			PushHidden('ID', 'menu_id','', 'ml-100', $rs->menu_id);
			PushSelect($menu,'เมนูหลัก', 'ref_menu_id','', 'ml-100', $rs->ref_menu_id);
	}
	public function CreateFile(){
		$menu = $this->menu;
// 		$menu = 'import';
		
		$txt = array();
		$myfile = fopen(BASE_PATH . DS . SYSTEM_DIR . DS . 'ck.define' . EXT, "r") or die("Unable to open file!");
		while(!feof($myfile)) {
		  $txt[] = fgets($myfile);
		}
		fclose($myfile);
		$txt[] = '
require(MODEL . DS . "' . ucfirst($menu) . '.php");';
		if( !file_exists(BACKOFFICE . DS . $menu . 'Controller.php') )
		{
			$myfile = fopen(BASE_PATH . DS . SYSTEM_DIR . DS . 'ck.define' . EXT, "w") or die("Unable to open file!");
			fwrite($myfile, implode('', $txt));
			fclose($myfile);
		}
// 		Controller Files
		$create = array();
		$create['CTR']['src'] = BACKOFFICE . DS . 'tempController.php';
		$create['CTR']['destination'] = BACKOFFICE . DS . $menu . 'Controller.php';
// 		CSS Files
		$create['Css']['src'] = SYSTEM_PATH . DS . 'HTML' . DS . 'Entity' . DS . 'CSS' . DS . 'template.css';
		$create['Css']['destination'] = SYSTEM_PATH . DS . 'HTML' . DS . 'Entity' . DS . 'CSS' . DS . $menu . '.css';
// 		JS Files
		$create['JS']['src'] = SYSTEM_PATH . DS . 'HTML' . DS . 'Entity' . DS . 'JS' . DS . 'template.js';
		$create['JS']['destination'] = SYSTEM_PATH . DS . 'HTML' . DS . 'Entity' . DS . 'JS' . DS . $menu . '.js';
// 		Model Files
		$create['Model']['src'] = MODEL . DS . 'Temp.php';
		$create['Model']['destination'] = MODEL . DS . ucfirst($menu) . '.php';
// 		View Files
		$create['View']['src'] = VIEW . DS . 'temp';
		$create['View']['destination'] = VIEW . DS . $menu;
		$fileCTR = $templateView;
		$newfileCTR = $pathView;
		if( $create )
		{
			foreach( $create AS $k => $v )
			{
				if( $k != 'View' )
				{
					if (!copy($v['src'], $v['destination'])) {
					    echo "failed to copy {$v['src']}...\n";
					}
				}
				else
				{
					if (!copyr($v['src'], $v['destination'])) {
					    echo "failed to copy {$v['src']}...\n";
					}
					
				}
			}
		}
		
		$txts = array();
		$myfile = fopen(MODEL . DS . ucfirst($menu) . EXT, "w") or die("Unable to open file!");
		$txts[] = '<?php';
		$txts[] = '	
	require_once(CONFIG_PATH . DS . "easyCRUD.class.php");';
		$txts[] = '
	class ' . ucfirst($menu) . '  Extends Crud {';
		$txts[] = '	
		# Your Table name';
		$txts[] = '
		protected $table = DB_PREFIX . "tableName";';
		$txts[] = '	
		# Primary Key of the Table';
		$txts[] = '	
		protected $pk	 = "id";';
		$txts[] = '
		protected $status	 = "status";';
		$txts[] = '
			public function getTable(){';
		$txts[] = '
				return $this->table;';
		$txts[] = '
			}';
			
		$txts[] = '
			public function getPk(){';
		$txts[] = '
				return $this->pk;';
		$txts[] = '
			}';
		$txts[] = '
	}';
		$txts[] = '	
?>';
		fwrite($myfile, implode('', $txts));
		fclose($myfile);

	}
}
/**
 * Copy a file, or recursively copy a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.1
 * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
 * @param       string   $source    Source path
 * @param       string   $dest      Destination path
 * @return      bool     Returns TRUE on success, FALSE on failure
 */
function copyr($source, $dest)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }
    
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        copyr("$source/$entry", "$dest/$entry");
    }

    // Clean up
    $dir->close();
    return true;
}
?>
