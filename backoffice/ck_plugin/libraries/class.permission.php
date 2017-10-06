<?php
class Permission
{
	
	public function permissionButton($type, $text, $class, $kind)
	{
		$getMenu = explode('/',$_SERVER['REDIRECT_URL']);
		array_pop($getMenu);
		$menuCheck = end($getMenu);
		if($_SESSION['dataPermissionCheckForEach']->$menuCheck->$type)
		echo "<button class=\"{$class}\" data-toggle=\"modal\">{$text}</button>";
	}
	public function permissionLink($type, $text)
	{
		$getMenu = explode('/',$_SERVER['REDIRECT_URL']);
		array_pop($getMenu);
		$menuCheck = end($getMenu);
		if($_SESSION['dataPermissionCheckForEach']->$menuCheck->$type)
		return $text;
	}

}