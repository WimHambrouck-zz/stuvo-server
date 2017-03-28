<?php namespace mvdwcms\admin;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "administration"; 
$page['requirelogin'] = true;
$page['root'] = "../";
$page['requireperm'] = "groups";
// Load main
include_once('../../private/main.php');
	
$userGroup = null;
$gid = 1;
if (isset($_GET['id'])){
	$gid = $_GET['id'];
}
$userGroup = $userGroupManager->getUserGroupById($gid);

if (isset($_GET['action'])){
	$action = $_GET['action'];
	if ($action == "ungrant" && isset($userGroup)){
		$pid = $_GET['permission'];
		$permissionManager->ungrantPermission($userGroup,$permissionManager->getPermissionById($pid));
		header('Location: groups.php?id='.$userGroup->getId());
	}else if ($action == "grant" && isset($userGroup)){
		$pid = $_GET['permission'];
		$permissionManager->grantPermission($userGroup,$permissionManager->getPermissionById($pid));
		header('Location: groups.php?id='.$userGroup->getId());
	}
}

$permissions = array(); // Array of permissions
$permissionsGranted = array(); // Array of granted permissions
$permissions = $permissionManager->getPermissions();
$permissionsGranted = $permissionManager->getPermissionsByGroup($userGroup);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Admin";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../../private/head.php');
		?>
	</head>
	<body>
		<?php
			include ('../../private/header.php');
		?>
		<div id="content">
			<h2>Group  <small><?php echo $userGroup->getName(); ?></small>,</h2>
			<div class="row">
            <!--
				<div class="col-md-2">
					<a href="#newgroup" data-toggle="modal" data-target="#modalNewGroup" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>  Create a group</a>
				</div>-->
				<div class="col-md-3">
					<select class="form-control" onchange="var url = 'groups.php'; location = url.concat('?id=',this.options[this.selectedIndex].value);">
					<?php
					$userGroups = $userGroupManager->getUserGroups();
					for ($i = 0 ; $i < sizeof($userGroups) ; $i++){
						$ug= $userGroups[$i];
						echo "<option value=\"".($ug->getId())."\"".($ug->getId() == $gid ? " selected" : "").">".$ug->getName()."</option>";
					}
					?>
					</select>
				</div>
				<div class="modal fade" id="modalNewGroup">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Create a new group</h4>
					  </div>
					  <div class="modal-body">
						<p>One fine body&hellip;</p>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					  </div>
					</div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
			<br></br>
			
			<table class="table">
				<tr>
					<th>
						Granted
					</th>
					<th class="mobile-hide">
						Permission
					</th>
					<th>
						Description
					</th>
				</tr>
				<?php
				for($i = 0 ; $i < sizeof($permissions) ; $i++){
					$permission = $permissions[$i];
					
					echo "<tr>";
					
					echo "<td>";
					if( $permissionManager->hasPermission($userGroup,$permission)){
						echo "<a href=\"groups.php?id=".$userGroup->getId()."&action=ungrant&permission=".$permission->getId()."\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-ok\"></span></a>";
					}else{
						echo "<a href=\"groups.php?id=".$userGroup->getId()."&action=grant&permission=".$permission->getId()."\" class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
					}
					echo "</td>";
					
					echo "<td class=\"mobile-hide\">";
					echo $permission->getName();
					echo "</td>";
					
					echo "<td>";
					echo $permission->getDescription();
					echo "</td>";
					
					echo "</tr>";
				
				}
				?>
			</table>
		</div>
		<?php
		// Footer
		include_once('../../private/footer.php');
		?>
	</body>
</html>
