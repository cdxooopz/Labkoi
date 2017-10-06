<?php
include('../../../init.php');
include('../../ck_plugin/templates/inc_function.php');
include('../../ck_plugin/templates/inc_header.php');
$tbl 	= DB_PREFIX.'menu';


/* 	$row = $db->row("SELECT * FROM ".DB_PREFIX."menu WHERE menu_id = :menu_id"); */
if( !empty(g_int('id')) ) {
	$db->bind("menu_id",g_int('id'));
	$rs = $db->row("SELECT * FROM ".DB_PREFIX."menu WHERE menu_id = :menu_id");
}
if( empty(g_int('menu')) ) $ref_menu_id = 0; else $ref_menu_id = g_int('menu');
?>
<form name="frm" id="frm" method="post" action="?Mode=Menu" target="@Alert">
	<fieldset>
		<legend class="ui-state-default ui-corner-all">รายละเอียด</legend>
		<?php
		$db->bind("menu_active","Y");
		$db->bind("ref_menu_id","0");
		$menuList = $db->query("SELECT * FROM ".DB_PREFIX."menu WHERE menu_active = :menu_active AND ref_menu_id = :ref_menu_id");
/* 		$menuList = $db->result(DB_PREFIX.'menu', array('menu_active' => 'Y', 'ref_menu_id' => 0)); */
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
			PushHidden('ID', 'menu_id','', 'ml-100', $rs->menu_id);
			PushSelect($menu,'เมนูหลัก', 'ref_menu_id','', 'ml-100', $ref_menu_id);
/* 			PushHidden('ID', 'ref_menu_id','', 'ml-100', $ref_menu_id); */
		?>
		<div class="button ml-100">  
			<button id="Save" class="btn btn-success ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Save</button>   
			<button id="Reset" class="btn btn-danger ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Reset</button>
		</div> 
	</fieldset>
</form>