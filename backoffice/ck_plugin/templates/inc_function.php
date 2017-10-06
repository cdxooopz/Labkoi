<?php
function Find($search, $str){
	if(substr_count($str, $search)>0){
		$result = true;
	}else{
		$result = false;
	}
	return $result;
}
function ShowTexts($text, $id, $class='', $ml='ml-150', $value='', $frm='frm clear'){
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.' form-group col-xs-12" >
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.' input-group">
                <span id="'.$id.'" name="'.$id.'" class="ui-corner-all '.$class.'"> '.$value.' </span>
			</div>
		</div><br><br>';
}
function ShowText($text, $id, $class='', $ml='ml-150', $value='', $frm='frm clear'){
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.'">
				<span id="'.$id.'" name="'.$id.'" class="ui-corner-all '.$class.'"> '.$value.' </span>
			</div>
		</div>';
}
function ShowTextList($text, $id, $class='', $ml='col-xs-3', $value='', $frm='frm clear'){
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	$data = '';
	if($value)
	{
		foreach($value as $v)
		{
			$data .= '
			<div class="frm-field '.$ml.'">
				<span id="'.$id.'" name="'.$id.'" class="ui-corner-all '.$class.'"> '.($v->name ? $v->name : $v['name']).' </span>
			</div>';
		}
	}
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			' . $data .'
		</div>';
}
function PushTel($text, $id, $class='', $ml='ml-150', $value='', $symbol="fa-phone",$frm='frm clear'){
if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="'.$frm.' form-group col-xs-12" >
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.' input-group">
					<div class="input-group-addon">
	                	<i class="fa '.$symbol.'"></i>
	                </div>
	                <input type="text" id="'.$id.'" name="'.$id.'" class="form-control " data-inputmask=\'\"mask\": \"(999) 999-9999\"\' data-mask  value="'.$value.'"/>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div><br><br>';
					
}
function PushText($text, $id, $class='', $ml='ml-150', $value='', $validate=false, $frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="'.$frm.'">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">
					<input type="text" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all input '.$class.'" value="'.$value.'" '.$dataValidate.'/>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div>';
}
function PushTextInline($text, $id, $elm, $ml='ml-150', $frm='frm clear'){
	
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="'.$frm.'" id="'.$id.'">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">';
				if($elm)
				{
					foreach($elm as $k => $v)
					{
						echo ($v['main'] ? '<div class="' . $v['main'] . '">' : null );
						$dataValidate = ($v['validate']? 'data-parsley-required="true"': '');
						echo '<input type="text" id="'.$v['id'].'" name="'.$v['id'].'" class="form-control ui-corner-all input '.$v['class'].'" value="'.$v['value'].'" '.$dataValidate.'/>'.$errscr.'
					<div id="e'.$v['id'].'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>';
						echo ($v['main'] ? '</div>' : null );
					}
				}
				echo '
				</div>
			</div>';
}
function PushTextReadOnly($text, $id, $class='', $ml='ml-150', $value='', $validate=false, $frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="'.$frm.'">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">
					<input type="text" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all input '.$class.'" value="'.$value.'" '.$dataValidate.' readonly />'.$errscr.'
				</div>
			</div>';
}
function PushUsername($text, $id, $class='', $ml='ml-150', $value='', $validate=false, $symbol="fa-user", $frm='frm clear'){
if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="'.$frm.' form-group col-xs-12" >
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.' input-group">
					<div class="input-group-addon">
	                	<i class="fa '.$symbol.'"></i>
	                </div>
	                <input type="text" id="'.$id.'" name="'.$id.'" class="form-control" value="'.$value.'"/>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div><br><br>';
					
}
function PushEmail($text, $id, $class='', $ml='ml-150', $value='', $validate=false, $symBol = 'fa-envelope', $frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
	
			<div class="'.$frm.' form-group col-xs-12" >
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.' input-group">
					<div class="input-group-addon">
	                	<i class="fa '.$symBol.'"></i>
	                </div>
	                <input type="text" id="'.$id.'" name="'.$id.'" class="form-control" value="'.$value.'"/>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div><br><br>
			';
}
function PushTextWarning($text, $id, $class='', $ml='ml-150', $value='', $frm='frm clear'){
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="'.$frm.' has-warning">
				<label class="frm-label" for="'.$id.'"><i class="fa fa-bell-o"></i> '.$text.': </label>
				<div class="frm-field '.$ml.'">
					<input type="text" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all form-control '.$class.'" value="'.$value.'"/>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div>';
}
function PushDate($text, $id, $class='', $ml='ml-150', $value='',$validate=false, $frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.'">
				<input type="text" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all '.$class.'" value="'.$value.'" '.$dataValidate.'/>'.$errscr.'
				<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
			</div>
		</div>';
}
function PushFile($text, $id, $class='', $ml='ml-150', $value='', $validate=false,$frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.'">
				<input type="file" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all '.$class.'" '.$dataValidate.'/>
			</div>
		</div>';
}
function PushImage($text, $id, $class='', $ml='ml-150', $value='', $validate=false,$frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.'">
				<input type="file" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all '.$class.'" '.$dataValidate.'/><br>
				<img id="preview" src="../images/upload/'.$value.'" alt="preview" width="40%"/>'.$errscr.'
				<input type="hidden" id="previousPhotos" name="previousPhotos" value="'.$value.'"/>
				<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
			</div>
		</div>';
}

function PushImageold($text, $id, $class='', $ml='ml-150', $value='', $validate=false,$frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.'">
				<input type="file" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all '.$class.'" onchange="readURL(this);" '.$dataValidate.'/><br>
				<img id="preview" src="'.(empty($value)?"../images/default_image.jpg":$value).'" alt="preview" width="40%" '.(empty($value)?"data-check=1":'') . ' />'.$errscr.'
				<input type="hidden" id="previousPhotos" name="previousPhotos" value="'.$value.'"/>
				<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
			</div>
		</div>';
}

function PushImageMultiples($text, $id, $class='', $ml='ml-150', $value='', $validate=false,$frm='frm clear'){
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
		<div class="'.$frm.'">
			<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
			<div class="frm-field '.$ml.'">
				<div id="'.$id.'" name="'.$id.'">Upload</div>
				<input type="file" id="'.$id.'" name="'.$id.'" class="form-control ui-corner-all '.$class.'" value="'.$value.'" onchange="readURL(this);" '.$dataValidate.'/><br>
				<img id="preview" src="'.$value.'" alt="preview" width="40%"/>'.$errscr.'
				<input type="hidden" id="previousPhotos" name="previousPhotos" value="'.$value.'"/>
				<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
			</div>
		</div>';
}
function PushTextArea($text, $id, $class='', $ml='ml-150', $value='',$validate=false)
{
	$dataValidate = ($validate? $validate: '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			<div class="frm clear">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">
					<textarea type="textarea" id="'.$id.'" name="'.$id.'" class="form-control input ui-corner-all '.$class.'" '.$dataValidate.'>'.$value.'</textarea>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div>';
}
function PushPassword($text, $id, $class='', $ml='ml-150', $value='',$validate=false, $symBol = 'fa-key')
{
	$dataValidate = ($validate? $validate: '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	echo '
			
			<div class="'.$frm.' form-group col-xs-12" >
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.' input-group">
					<div class="input-group-addon">
	                	<i class="fa '.$symBol.'"></i>
	                </div>
	                <input type="password" id="'.$id.'" name="'.$id.'" class="form-control" value="'.$value.'"/>'.$errscr.'
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div><br><br>
			';
}

function PushHidden($text, $id, $class='', $ml='ml-150', $val='',$validate=false)
{
	$dataValidate = ($validate? $validate: '');
	echo '
		<input type="hidden" id="'.$id.'" name="'.$id.'" class="'.$class.'" value="'.$val.'" '.$dataValidate.'/>
		<div id="e'.$id.'" class="'.$ml.' errtxt" rel="ไม่พบรหัสอ้างอิง|'.$text.'"></div>
	';
}

function PushRadio($data, $text, $id, $class='', $ml='ml-150', $class2='w100',$value,$validate=false){
	$radio = '';
	$dataValidate = ($validate? $validate: '');
	foreach((array)$data as $key => $val)
	{
		$radio 	.= '
					<label for="'.$id.''.$key.'" class="fl '.$class2.'"><input type="radio" id="'.$id.''.$key.'" name="'.$id.'" value="'.$key.'" class=" '.$class.' mr-5" '.$dataValidate.' '.($key == $value ? 'checked' : '').'/>&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;</label>';
	}
	echo '
			<div class="frm clear">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">'.$radio.'
				</div>
			</div>';
}
function PushCheckbox($data, $text, $id, $class='', $ml='ml-150', $class2='w100',$value, $validate=false){
	$checkbox 	= "";
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	foreach((array)$data as $key => $val)
	{
		$checkbox 	.= '
					<label for="'.$id.''.$key.'" class="fl '.$class2.'"><input type="checkbox" id="'.$id.''.$key.'" name="'.$id.'" value="'.$key.'" class=" '.$class.' mr-5" '.$dataValidate.' '.(@in_array($key, $value) ? 'checked' : '').'/> '.$val.'</label>';
	}
	echo '
			<div class="frm clear">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">'.$checkbox.'
				</div>
			</div>';
}

function PushSelectList($data, 	$text, $id, $class='', $ml='ml-150', $value='', $validate=false, $symBol = 'fa-th-list', $frm='frm clear')
{
	$option		= "";
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	if( $data ){
		foreach((array)$data as $key => $txt){
			$selected = ($key == $value) ? ' selected="selected"' : '';
			$option .= '
						<option value="'.$key.'"'.$selected.'>'.$txt.'</option>';
		}
	}else{
		$option .= '
						<option value="">ไม่มีข้อมูล</option>';
	}
	echo '
			
			<div class="'.$frm.' form-group col-xs-12" >
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.' input-group">
					<div class="input-group-addon">
	                	<i class="fa '.$symBol.'"></i>
	                </div>
					<select id="'.$id.'" name="'.$id.'" class="form-control input ui-corner-all '.$class.'" '.$dataValidate.'>
						'.$option.'
					</select>
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div><br><br>
			';
}
function PushSelectDisabled($data, 	$text, $id, $class='', $ml='ml-150', $value='', $validate=false, $frm='frm clear')
{
	$option		= "";
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	if( $data ){
		foreach((array)$data as $key => $txt){
			$selected = ($key == $value) ? ' selected="selected"' : '';
			$option .= '
						<option value="'.$key.'"'.$selected.'>'.$txt.'</option>';
		}
	}else{
		$option .= '
						<option value="">ไม่มีข้อมูล</option>';
	}
	echo '
			<div class="'.$frm.'">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">
					<select id="'.$id.'" name="'.$id.'" class="form-control input ui-corner-all '.$class.'" '.$dataValidate.' disabled>
						'.$option.'
					</select>
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div>';
}
function PushSelect($data, 	$text, $id, $class='', $ml='ml-150', $value='', $validate=false, $frm='frm clear')
{
	$option		= "";
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	if( $data ){
		foreach((array)$data as $key => $txt){
			$selected = ($key == $value) ? ' selected="selected"' : '';
			$option .= '
						<option value="'.$key.'"'.$selected.'>'.$txt.'</option>';
		}
	}else{
		$option .= '
						<option value="">ไม่มีข้อมูล</option>';
	}
	echo '
			<div class="'.$frm.'">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">
					<select id="'.$id.'" name="'.$id.'" class="form-control input ui-corner-all '.$class.'" '.$dataValidate.'>
						'.$option.'
					</select>
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div>';
}
function PushSelect2($data, 	$text, $id, $class='', $ml='ml-150', $value='', $validate=false, $frm='frm clear')
{
	$option		= "";
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	if( $data ){
		foreach((array)$data as $key => $txt){
			$selected = ($key == $value) ? ' selected="selected"' : '';
			$option .= '
						<option value="'.$key.'"'.$selected.'>'.$txt.'</option>';
		}
	}else{
		$option .= '
						<option value="">ไม่มีข้อมูล</option>';
	}
	echo '
			<div class="'.$frm.'">
				<label class="frm-label b" for="'.$id.'">'.$text.' : </label>
				<div class="frm-field '.$ml.'">
					<select id="'.$id.'" name="'.$id.'" class="form-control input ui-corner-all '.$class.'" '.$dataValidate.' style="width:100%">
						'.$option.'
					</select>
					<div id="e'.$id.'" class="errtxt" rel="กรุณาป้อน|'.$text.'"></div>
				</div>
			</div>';
}
function PushSelectNoLabel($data, 	$text, $id, $class='', $ml='ml-150', $value='', $validate=false, $frm='frm clear')
{
	$option		= "";
	$dataValidate = ($validate? 'data-parsley-required="true"': '');
	if( Find(' err', $class) )	$errscr	= "\n\t\t\t\t\t<span class=\"errscr\">&nbsp;</span>";
	if( $data ){
		foreach((array)$data as $key => $txt){
			$selected = ($key == $value) ? ' selected="selected"' : '';
			$option .= '
						<option value="'.$key.'"'.$selected.'>'.$txt.'</option>';
		}
	}else{
		$option .= '
						<option value="">ไม่มีข้อมูล</option>';
	}
	echo '
					<select id="'.$id.'" name="'.$id.'" class="form-control input ui-corner-all '.$class.'" '.$dataValidate.'>
						'.$option.'
					</select>';
}

?>
