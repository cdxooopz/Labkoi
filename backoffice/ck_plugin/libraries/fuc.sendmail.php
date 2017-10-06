<?php
function SendMail($strTo, $Subject, $Message, $Files = false, $From = array('Contact Orange-Thailand','contact@orange-thailand.com'))
{
	$Uniqid  	= md5(uniqid(time()));
	$Subject 	= "=?utf-8?B?".base64_encode($Subject)."?=";

	$Header 	= "";
	$Header 	.= "From: ".$From[0]."<".$From[1].">\nReply-To: ".$From[0]."<".$From[1].">\n";
	//$Header 	.= "Cc: Mr.Surachai Sirisart<surachai@thaicreate.com>";
	//$Header 	.= "Bcc: chinakron@msn.com";
	$Header 	.= "X-Priority: 1 (Higuest)\nX-MSMail-Priority: High\nImportance: High\n"; 
	$Header 	.= "X-Mailer: CuEiHzO/chinakron@msn.com";

	$Header 	.= "MIME-Version: 1.0\n";
	$Header 	.= "Content-Type: multipart/mixed; boundary=\"".$Uniqid."\"\n\n";
	$Header 	.= "This is a multi-part message in MIME format.\n";

	$Header 	.= "--".$Uniqid."\n";
	$Header 	.= "Content-type: text/html; charset=UTF-8\n";
	$Header 	.= "Content-Transfer-Encoding: 7bit\n\n";
	$Header 	.= $Message."\n\n";
	
	if( $Files ){
		foreach( (array)$Files as $i => $File ){
			$Content = chunk_split(base64_encode(file_get_contents($File))); 
			$Header .= "--".$Uniqid."\n";
			$Header .= "Content-Type: application/octet-stream; name=\"".$File."\"\n"; 
			$Header .= "Content-Transfer-Encoding: base64\n";
			$Header .= "Content-Disposition: attachment; filename=\"".$File."\"\n\n";
			$Header .= $Content."\n\n";
		}
	}
	if( $strTo ){
		$rs = false;
		foreach( (array)$strTo as $i => $To ){
			$rs = mail($To, $Subject, null, $Header);
		}
		return $rs;
	}
}