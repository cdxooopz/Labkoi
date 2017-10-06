
		<?php
		$activeMenu = explode('/', $_SERVER['REQUEST_URI']);
		
	$object = new AdminPermission();
	$dataGet = $object->find($_SESSION['LOGIN']['LEVEL']);
	$permission = explode(':',$dataGet->level_permission);
	$_SESSION['dataPermissionCheckForEach'] = json_decode($dataGet->level_permission_each);
		if( $memu['0'] )
		{
			$i = -1;
			foreach($memu['0'] AS $k => $m)
			{
// 				echo $i.' '.$m['component'] .' : ';
			  if($_SESSION['LOGIN']['LEVEL']!="2" && $m['component']!="Menu"){
				if($_SESSION['dataPermissionCheckForEach']->$m['component']->see)
				{
					 if( ($_GET['c'] == $m['component']) || ( $active[$m['id']] AND in_array( '?c='.$_GET['c'], $active[$m['id']] ) ) || $m['link'] == $activeMenu[3])
					{
						echo "				<li class=\"active\">\n";
					}
					else
					{
						$activeMain = (in_array($activeMenu[3], $m['active']) ? 'active' : '');
						echo "				<li class=\"treeview {$activeMain}\" ".($m['link'] == $activeMenu ? 'active' : '').">\n";
					}
					echo "					<a class=\"header-menu\" href=\"".BASE_URL."backoffice/{$m['link']}/\"><i class=\"{$m['icon']}\"></i> <span>{$m['name']}</span> <i class=\"{$m['sub']}\"></i></a>\n";
					if( $memu[$m['id']] )
					{
						echo "					<ul  class=\"treeview-menu\">\n";
						foreach($memu[$m['id']] AS $s)
						{
							if($_SESSION['dataPermissionCheckForEach']->$s['component']->see){
								echo "						<li class=\"".(in_array($s['link'], $activeMenu) ? 'active' : '')."\">\n";
								echo "							<a href=\"".BASE_URL."backoffice/{$s['link']}/\"><i class=\"{$s['icon']}\"></i> {$s['name']}</a>\n";
								echo "						</li>\n";
							}
						}
						echo "					</ul>\n";
					}
					echo "				</li>\n";
				  
				}
				$i++;
			  }else if($_SESSION['LOGIN']['LEVEL']=="2"){
					if($_SESSION['dataPermissionCheckForEach']->$m['component']->see){
					  
						if( ($_GET['c'] == $m['component']) || ( $active[$m['id']] AND in_array( '?c='.$_GET['c'], $active[$m['id']] ) ) || $m['link'] == $activeMenu[3])
						{
							echo "				<li class=\"active\">\n";
						}else{
							$activeMain = (in_array($activeMenu[3], $m['active']) ? 'active' : '');
							echo "				<li class=\"treeview {$activeMain}\">\n";
						}
						echo "					<a class=\"header-menu\" href=\"".BASE_URL."backoffice/{$m['link']}/\"><i class=\"{$m['icon']}\"></i> <span>{$m['name']}</span> <i class=\"{$m['sub']}\"></i></a>\n";
						if( $memu[$m['id']] )
						{
							echo "					<ul  class=\"treeview-menu\" style=\"display: block;margin-top: -3px;\">\n";
							foreach($memu[$m['id']] AS $s)
							{
								if($_SESSION['dataPermissionCheckForEach']->$s['component']->see){
									echo "						<li class=\"".(in_array($s['link'], $activeMenu) ? 'active' : '')."\">\n";
									echo "							<a href=\"".BASE_URL."backoffice/{$s['link']}/\"><i class=\"{$s['icon']}\"></i> {$s['name']}</a>\n";
									echo "						</li>\n";
								}
							}
							echo "					</ul>\n";
						}
						echo "				</li>\n";
					}
			  }
			}
		}
		unset($m);
		unset($s);
		?>