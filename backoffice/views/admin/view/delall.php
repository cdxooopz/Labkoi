<?php
	for($i=0;$i<count(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));$i++)	
	{
		$del_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT)[$i];
		//$sql_del_all = mysql_query("delete from fw_group where group_id = '$del_id'");
		//echo $del_id."<br />";
	}
?>