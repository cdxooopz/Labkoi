	<title><?php echo $_title;?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta name="keywords" content="<?php echo $_title;?>" />
	<meta name="description" content="<?php echo $_title;?>" />
	<meta name="robot" content="noindex, nofollow" />
	<meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
	<script type="text/javascript" language="javascript" src="<?=BASE_URL;?>backoffice/entity/html/script/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?=BASE_URL;?>backoffice/entity/html/script/inc_main.js"></script>
	<link type="text/css" media="screen,projection" rel="stylesheet" href="<?=BASE_URL;?>backoffice/entity/html/css/inc_reset.css" />
	<link type="text/css" media="screen,projection" rel="stylesheet" href="<?=BASE_URL;?>backoffice/entity/html/css/inc_main.css" />
	<link type="text/css" media="screen,projection" rel="stylesheet" href="<?=BASE_URL;?>backoffice/HTML/Entity/CSS/<?=$jsCSSPath;?>.css" />
	<!-- Font CSS (Via CDN) -->
<!-- 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="<?=BASE_URL;?>backoffice/entity/html/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>backoffice/entity/html/plugins/sweetalert/dist/sweetalert.css">

    <!-- Bootstrap 3.3.2 JS -->
<!-- 	<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" /> -->
    <script src="<?=BASE_URL;?>backoffice/entity/html/script/bootstrap.min.js" type="text/javascript"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
	<link href="<?=BASE_URL;?>backoffice/entity/html/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?=BASE_URL;?>backoffice/entity/html/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <!-- iCheck -->
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
	<script src="<?=BASE_URL;?>backoffice/entity/html/script/jquery.toaster.js"></script>
	<!-- Bootstrap CSS -->
    <link href="<?=BASE_URL;?>backoffice/entity/html/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
	
    <!-- Theme style -->
    <link href="<?=BASE_URL;?>backoffice/entity/html/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE_URL;?>backoffice/entity/html/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/select2-4.0.3/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
	<!-- Favicon -->
<!--     <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!--     <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?=BASE_URL;?>backoffice/entity/html/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="assets/img/favicon.ico">
    <script>
	    $(window).load(function(){
		    $.ajax({
			    url: '<?=BASE_URL;?>backoffice/ck_plugin/config/db_view.php'
		    })
	    })
    </script>
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/select2-4.0.3/dist/js/select2.min.js" type="text/javascript"></script>
<?php
	$db->bind("active","Y");
	$row   =  $db->query("SELECT * FROM ".DB_PREFIX."menu WHERE menu_active = :active ORDER BY ref_menu_id asc,menu_sort asc");
/* 	$where 	= array('menu_active'=>'Y'); */
/* 	$row 	= $db->result(DB_PREFIX.'menu',$where,'ref_menu_id asc,menu_sort asc'); */
	if($row)
	{
		$memu 		= array();
		$active 	= array();
		foreach($row AS $k => $r){
/*
			echo '<pre style="margin-left:250px;">';
				print_r($r);
			echo '</pre>';
*/
			$active[$r->ref_menu_id][$r->menu_link] = $r->menu_link;
			$menu_sort = $r->menu_sort;
			if($memu[$r->ref_menu_id][$r->menu_sort]){ $menu_sort++; }
			
			$db->bind("id",$r->menu_id);
			$db->bind("active","Y");
			$activeSubCheck[$r->menu_id]   =  $db->query("SELECT menu_link FROM ".DB_PREFIX."menu WHERE ref_menu_id = :id AND menu_active = :active ORDER BY ref_menu_id asc,menu_sort asc",null, PDO::FETCH_COLUMN);
			
			$memu[$r->ref_menu_id][$menu_sort] = array(
								'id' 		=>	$r->menu_id ,
								'name' 		=>	$r->menu_name,
								'component'	=>	$r->menu_component,
								'link' 		=>	$r->menu_link,
								'sort' 		=>	$r->menu_sort,
								'icon' 		=>	$r->menu_icon,
								'sub' 		=>	($activeSubCheck[$r->menu_id] ? 'fa fa-angle-left pull-right' : ''),
								'active'	=>	$activeSubCheck[$r->menu_id]
							);
			if( $r->menu_link  == '?'.$_SERVER['QUERY_STRING'])	$_menu = $r->menu_name;
		}
		unset($row);
	}
/*
	echo '<pre style="margin-left:250px;">';
	
	print_r($dataGet);
	print_r($memu);
	echo '</pre>';
*/
?>
<?php
	
?>
<!--=========================Jquery====================================================-->
  <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/pdf.object/pdfobject.js"></script>
<!--[[[[[[[ Check all ลบทั้งหมด ]]]]]]]]----->

<script>
	jQuery(function() 
	{  
		jQuery('#check_all').click(function()
		{  
			jQuery('input:checkbox').each(function(index) 
			{  
				jQuery(this).attr('checked', true); 
			});  
 		});  
 		jQuery('#uncheck_all').click(function() 
		{  
			jQuery('input:checkbox').each(function(index)
			{  
 				jQuery(this).attr('checked', false);  
			});  
		});  
	}); 
</script>
<!--=================================================================================-->
<style type="text/css" media="screen">
	.header-menu {
	    background-color: rgb(0,27,48) !important;
	    color: rgb(255,191,25) !important;
	}
	.top-header {
		background-color: rgb(0,52,117) !important;
	}
	.top-header-font {
	    color: rgb(255,191,25) !important;
	}
	.top-header-table, table > thead > tr > th, table > thead > th {
		background-color: lightgray !important;
		color: black !important;
		white-space: nowrap;
	}
</style>