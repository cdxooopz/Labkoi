<?php
	function required($field)
	{
		return ($field == '') ? FALSE : TRUE;
	}
	function matches($str, $field)
	{
	return ($str !== $field) ? FALSE : TRUE;
}
	function minLength($str, $val)
	{
	if(preg_match("/[^0-9]/", $val)) return FALSE;

	return (strlen($str) < $val) ? FALSE : TRUE;
}
	function maxLength($str, $val)
	{
	if (preg_match("/[^0-9]/", $val)) return FALSE;

	return (strlen($str) > $val) ? FALSE : TRUE;
}
	function exactLength($str, $val)
	{
	if (preg_match("/[^0-9]/", $val)) return FALSE;

	return (strlen($str) != $val) ? FALSE : TRUE;
}
	function validEmail($str)
	{
		if(empty($str)) return TRUE;
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}
	function alpha($str)
	{
		return (!preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
	}
	function alphaNumeric($str)
	{
	return (!preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
}
	function alphaDash($str)
	{
	return (!preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
}
	function numeric($str)
	{
	if((bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str))
		return $str;
	else
		return '';
}
	function isNumeric($str)
	{
	return (!is_numeric($str)) ? FALSE : TRUE;
} 
	function integer($str)
	{
	return (bool)preg_match('/^[\-+]?[0-9]+$/', $str);
}
	function setSelected($field = '', $value = '')
	{
	if(is_array($value))
		return (in_array($field,$value)) ? ' selected="selected"' : '';
	else
		return ($field == $value) ? ' selected="selected"' : '';
}
	function setChecked($field = '', $value = '')
	{
	if(is_array($value))
		return (in_array($field,$value)) ? ' checked="checked"' : '';
	else
		return ($field == $value) ? ' checked="checked"' : '';
}
	function redirect($uri = '', $method = 'parent')
	{
	switch($method)
	{
		case 'refresh'	: 
			echo '<script language="javascript">window.parent.location.reload("'. $uri.'");</script>';
			break;
		case 'window'	: 
			echo '<script language="javascript">window.location.replace("'. $uri.'");</script>';
			break;
		default	:		
			echo '<script language="javascript">window.parent.location.replace("'. $uri.'");</script>';
			break;
	}
	exit;
}
	function reload()
	{
		echo '<script language="javascript">window.parent.location.reload();</script>';
	}
	function js($coding)
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo "<script language=\"javascript\">{$coding}</script>";
	}
	function alert($msg, $topic = 'Error!', $type='error')
	{
		if($msg != '')
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			if(is_array($msg))
			{
				$t = ''; 
				foreach($msg as $msg){	$t .= $msg.'\n';	}
				echo "<script language=\"javascript\">
				alert('".$t."');
				swal(
				  '{$topic}',
				  '{$t}',
				  '{$type}'
				)
				</script>";
	
			}else{
				echo "<script language=\"javascript\">
				alert('".$msg."');
				swal(
				  '{$topic}',
				  '{$msg}',
				  '{$type}'
				)</script>";
			}
		}
	}
	function autoAlert($msg, $topic = 'Success!', $type='success')
	{
		
		if($msg != '')
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script language=\"javascript\">
				swal({
				  title: '{$topic}!',
				  text: '{$msg}',
				  timer: 2000
				}).then(
				  function () {},
				  // handling the promise rejection
				  function (dismiss) {
				    if (dismiss === 'timer') {
				      console.log('I was closed by the timer')
				    }
				  }
				)
				</script>";
			
		}
	}
	function prompt($msg, $id)
	{
		if($msg != '')
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script language=\"javascript\">
				swal({
				  title: 'An input!',
				  text: '{$msg}:',
				  type: 'input',
				  showCancelButton: true,
				  closeOnConfirm: false,
				  inputPlaceholder: 'Write something'
				}, function (inputValue) {
				  if (inputValue === false) return false;
				  if (inputValue === '') {
				    swal.showInputError('You need to write something!');
				    return false
				  }
				  document.getElementById('".$id."').value = inputValue;
				});
				
				
				</script>";
			
		}
		
	}
	function console($string)
	{
		if($string != '')
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script language=\"javascript\">
				console.log(".$string.");
				</script>";
			
		}
	}
	function formatChange($string, $format)
	{
		$originalDate = str_replace("/", "-", $string);
		return date($format, strtotime($originalDate));
	}
	function formatChangeTH($string, $format)
	{
		$originalDate = str_replace("/", "-", $string);
		return date($format, strtotime($originalDate.' +543 year'));
	}
	function formatChangeEN($string, $format)
	{
		$originalDate = str_replace("/", "-", $string);
		return date($format, strtotime($originalDate.' -543 year'));
	}
	function changeBuddha($string,$format)
	{
		$data['d'] = array(
			'1' => 'จันทร์',
			'2' => 'อังคาร',
			'3' => 'พุธ',
			'4' => 'พฤหัส',
			'5' => 'ศุกร์',
			'6' => 'เสาร์',
			'7' => 'อาทิตย์'
		);
		$data['m'] = array(
			'1' => 'มกราคม',
			'2' => 'กุมภาพันธ์',
			'3' => 'มีนาคม',
			'4' => 'เมษายน',
			'5' => 'พฤษภาคม',
			'6' => 'มิถุนายน',
			'7' => 'กรกฎาคม',
			'8' => 'สิงหาคม',
			'9' => 'กันยายน',
			'10' => 'ตุลาคม',
			'11' => 'พฤศจิกายน',
			'12' => 'ธันวาคม'
		);
		switch($format) {
			case 'd':
				return 'a';
				break;
			case 'm':
				return $data['m'][intval($string)];
				break;
		}
	}
	function formatChangePlus($string, $format, $plus)
	{
		$newDate = (date('d', $string)+$plus).'-'.date('m', $string).'-'.date('Y', $string);
		return date($format, strtotime($newDate));
/* 		return $newDate.' '.$plus; */
	}
	function getDayNumber($date1, $date2)
	{
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$interval = $datetime1->diff($datetime2);
		return $interval->format('%a');
	}
	function formatChangeSTT($string, $format)
	{
		return date($format, $string);
	}
	function backpage()
	{
		echo "<script language=\"javascript\">";
		echo "	location.href=\"javascript:history.back()\";";
		echo "</script>";
	}
	function delDir($path)
	{	
		$dir = dir($path);
		while($file = $dir->read()){
			if(($file != '.') && ($file != '..')){
				unlink($dir->path . DS . $file);
			}
		}
		$dir->close();	
		rmdir($dir->path);
	}	
	function sql_in($val)
	{
		if(is_array($val))
			if($val)
				return "IN (".implode(',',$val).")";
			else
				return 'false';
		else
			return $val;
	}
	function sql_b2v($val1,$val2)
	{
		return "BETWEEN {$val1} AND {$val2}";
	}
	function sql_like($val1,$type='2')
	{
		if($type == '0')	return "LIKE '{$val1}'";
		if($type == '1')	return "LIKE '{$val1}%%'";
		if($type == '2')	return "LIKE '%{$val1}%'";
		if($type == '3')	return "LIKE '%%{$val1}'";
	}
	function cv_obj($array)
	{
		return $object = (object) $array;
	}
	function user_ip()
	{
		//find user ip
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$output = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$output = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$output = $_SERVER['REMOTE_ADDR'];
		}
		return $output;
	}// user_ip
	function gv_int($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_VALIDATE_INT);
	}
	function gv_float($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_VALIDATE_FLOAT);
	}
	function gv_ip($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_VALIDATE_IP);
	}
	function gv_url($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_VALIDATE_URL);
	}
	function gv_boolean($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_VALIDATE_BOOLEAN);
	}
	function gv_email($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_VALIDATE_EMAIL);
	}
	function pv_int($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_VALIDATE_INT);
	}
	function pv_float($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_VALIDATE_FLOAT);
	}
	function pv_ip($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_VALIDATE_IP);
	}
	function pv_url($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_VALIDATE_URL);
	}
	function pv_boolean($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_VALIDATE_BOOLEAN);
	}
	function pv_email($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_VALIDATE_EMAIL);
	}
	function p_email($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_SANITIZE_EMAIL);
	}
	function p_float($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_SANITIZE_NUMBER_FLOAT);
	}
	function p_int($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_SANITIZE_NUMBER_INT);
	}
	function p_string($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_SANITIZE_STRING);
	}
	function p_url($string)
	{
		return filter_input(INPUT_POST, $string,FILTER_SANITIZE_URL);
	}
	function g_email($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_SANITIZE_EMAIL);
	}
	function g_float($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_SANITIZE_NUMBER_FLOAT);
	}
	function g_int($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_SANITIZE_NUMBER_INT);
	}
	function g_string($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_SANITIZE_STRING);
	}
	function g_url($string)
	{
		return filter_input(INPUT_GET, $string,FILTER_SANITIZE_URL);
	}
	function g_arr($args)
	{
		return filter_input_array(INPUT_GET, $args);
	}
	function p_arr($args)
	{
		return filter_input_array(INPUT_POST, $args);
	}
	function notification($str, $type, $status)
	{
		echo "<script language=\"javascript\">
		$.toaster({ priority : '{$status}', title : '{$type}', message : '{$str}'});
		</script>";
		
	}
	function searching($arr)
	{
		if($arr)
		{
			$i = 1;
			foreach(array_filter($arr) as $k => $v)
			{
				if( $i == 1 )
				{
					$rs = $k.' = "'.$v.'"';
				}
				else
				{
					$rs .= ' and '.$k.' = "'.$v.'"';
				}
				$i++;
			}
		}
		return $rs;
	}
	function v_int($string)
	{
		return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
	}
	function v_string($string)
	{
		return filter_var($string,FILTER_SANITIZE_STRING);
	}
	function v_url($string)
	{
		return filter_var($string,FILTER_SANITIZE_URL);
	}
	function v_email($string)
	{
		return filter_var($string,FILTER_SANITIZE_EMAIL);
	}
	function v_float($string)
	{
		return filter_var($string,FILTER_SANITIZE_NUMBER_FLOAT);
	}
	function uploadFile($file, $filename, $destination,$tag)
	{
		@mkdir(".." . DS . "uploadFiles" . DS . $tag, 0777);
		$foo = new Upload($file); 
		@chmod($file,0755);
		if ($foo->uploaded) {
			$foo->file_new_name_body = $filename;
			$foo->Process($destination);
			if ($foo->processed) {
// 			echo $foo->file_new_name_body;
				$nameDestination = $foo->file_dst_name;
				$foo->Clean();
				return $destination . DS . $nameDestination;
			}
			else return $foo->error;
		}
		return false;
	}
	function uploadImagetopath($file, $filename, $destination, $resize = null, $resizeY = null)
	{
		$foo = new Upload($file); 
		@chmod($file,0755);
		if ($foo->uploaded) {
			$foo->file_new_name_body = $filename;
			if(!empty($resize))
			{
				$foo->image_resize = true;
				if(!empty($resizeY)) 
				{
				    $foo->image_y = $resizeY;
				    $foo->image_x = $resize;
				}
			    else 
			    {
				    $foo->image_x = $resize;
    			    $foo->image_ratio_y = true;
			    }
			}
			$foo->Process($destination);
			if ($foo->processed) {
/* 			echo $foo->file_new_name_body; */
				$nameDestination = $foo->file_dst_name;
				$foo->Clean();
				return $nameDestination;
			}
		}
		return false;
	}
	function logging($db,$type,$detail,$member,$staff)
	{
		$data = array(
			'logging_date'			=> date('Y-m-d'),
			'logging_time'			=> date('H:i:s'),
			'logging_type'			=> $type,
			'logging_description'		=> $detail,
			'logging_ref_member'	=> 0,
			'logging_ref_staff'		=> $staff
		);
		print_r($log);
// 		$db->query("INSERT INTO ".DB_PREFIX."logging VALUES (null, :date, :time, :type, :detail, :ref, :refStaff)", array("date"=>date('Y-m-d'), "time"=>date('H:i:s'), "type"=>$type,"detail"=>$detail, "ref"=>0, "refStaff"=>ADMINID));
		echo 'aaa';
/* 		$db->insert(DB_PREFIX.'logging', $data); */
	}
	function paymentS($payment_, $day, $month)
	{
		if($payment_)
		{
			foreach($payment_ as $k=>$payment)
			{
				$data[formatChangeSTT($payment->dateInsert,'m')][formatChangeSTT($payment->dateInsert,'d')]['Start'][$k] = formatChangeSTT($payment->paymentDateStart,'d').' - '.formatChangeSTT($payment->paymentDateEnd,'d');
				$data[formatChangeSTT($payment->dateInsert,'m')][formatChangeSTT($payment->dateInsert,'d')]['Paid'][$k] = (formatChangeSTT($payment->dateInsert,'m') == $month && formatChangeSTT($payment->dateInsert,'d') == $day?formatChangeSTT($payment->dateInsert,'Y-m-d'):'-');
				$data[formatChangeSTT($payment->dateInsert,'m')][formatChangeSTT($payment->dateInsert,'d')]['amount'][$k] = $payment->paymentFee;
				
				if(!empty($payment->paidDayFreeDate))
				{
					$date = explode(',',$payment->paidDayFreeDate);
					if($date)
					{
						foreach($date as $k => $d)
						{
							$date[$k] = formatChange($d,'d/m');
						}
					}
					$data[formatChangeSTT($payment->dateInsert,'m')][formatChangeSTT($payment->dateInsert,'d')]['free'][$k] = '<span style="color:green">'.implode(',', $date).'</span>';
				}
				
/* 				$data[$payment->paymentID][formatChangeSTT($payment->dateInsert,'m')][formatChangeSTT($payment->paymentDateStart,'d')]['Start'] = formatChangeSTT($payment->paymentDateStart,'d').' - '.formatChangeSTT($payment->paymentDateEnd,'d'); */
/* 				$data[$payment->paymentID][formatChangeSTT($payment->dateInsert,'m')][formatChangeSTT($payment->paymentDateStart,'d')]['Paid'] = (formatChangeSTT($payment->dateInsert,'m') == '07' && formatChangeSTT($payment->dateInsert,'d') == '08'?formatChangeSTT($payment->dateInsert,'Y-m-d'):'-'); */
			}
		}
		return $data;
	}
	function d($v, $t = "") 
	{
		echo '<pre>';
		echo '<h1>' . $t. '</h1>';
		print_r($v);
		echo '</pre>';
	}

?>