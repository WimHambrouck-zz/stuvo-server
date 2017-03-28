<?php namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "home"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');

use mvdwcms\models\User;

$target = $user;

if (isset($_GET['id'])){
	$uid = $_GET['id'];
	if ($uid == "new" ){
		$target = null;
	}else{
		$target = $userManager -> getUserById($uid);
	}
}

if (isset($_GET['action'])) {
	if ($_GET['action'] == 'edit') {
		if (isset($_GET['firstname']) && isset($_GET['lastname']) && isset($_GET['password2']) && isset($_GET['password1']) && isset($_GET['username'])) {
			$target->setUsername($_GET['username']);
			$password1 = $_GET['password1'];
			$password2 = $_GET['password2'];
			if ($password2 != $password1){
				$status = 2;
			}else{
				if($password1 != ""){
					$target->setPasswordMD5(md5($password1));
				}
				$target->setFirstName($_GET['firstname']);
				$target->setLastName($_GET['lastname']);
				$target->setEmail($_GET['email']);
				$target->setGroup($userGroupManager->getUserGroupById(1));
				$userManager -> editUser($target->getId(),$target);
				$logUtil->addLog($target,4,"Changed his profile");
				$status = 1;
			}
		}
		header('Location: profile.php'.(isset($_GET['id']) ? "?id=".$target->getId() : ""));
	}else if ($_GET['action'] == 'new') {
		if (isset($_GET['firstname']) && isset($_GET['lastname']) && isset($_GET['password2']) && isset($_GET['password1']) && isset($_GET['username'])) {
			$username = $_GET['username'];
			$password1 = $_GET['password1'];
			$password2 =$_GET['password2'];
			if ($password2 != $password1){
				$status = 2;
			}else{
				$password = "";
				if($password1 != ""){
					$password = (md5($password1));
				}
				
				$firstName = ($_GET['firstname']);
				$lastName = ($_GET['lastname']);
				$target = User::fromName($firstName, $lastName);
				$target->setUsername($username);
				$target->setPasswordMD5($password);
				$target->setEmail($_GET['email']);
				$target->setGroup($userGroupManager->getUserGroupById(1));
				$userManager -> addUser($target);
				$logUtil->addLog($target,8,"Added a new user [".$target->getUsername()."]");
				$status = 1;
			}
		}
		header('Location: admin/users.php');
	}
}

if (isset($_GET['action'])) {
	if ($_GET['action'] == 'new') {
		$target = null;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Edit profile";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
	</head>
	<body>
		<?php
		// Menu header
		include_once('../private/header.php');

		// Load user groups
		$groups = $userGroupManager->getUserGroups();
		?>
		<div id="content">
			<h2>Information <small><?php if (isset($target)) { echo $target->getFirstName() . ' ' . $target->getLastName(); }else{ echo "New user"; } ?></small>,</h2>
			
			<form id="form-edituser" class="form-horizontal" role="form" action="profile.php" method="get">
				<input type="hidden" name="action" id="action" value="<?php if (!isset($target)) { echo "new"; }else{ echo "edit";} ?>">
				<input type="hidden" name="id" value="<?php if (!isset($target)) { echo ""; }else{ echo $target->getId();} ?>">
				<div class="form-group">
					<label for="inputFirstname" class="col-sm-2 control-label">First Name</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="firstname" id="inputFirstname" placeholder="First name" value="<?php if (isset($target)) {echo $target->getFirstName();} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputLastname" class="col-sm-2 control-label">Last Name</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="lastname" id="inputLastname" placeholder="Last name" value="<?php if (isset($target)) {echo $target->getLastName();} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputUsername" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" autocomplete="off" name="username" id="inputUsername" placeholder="Username" value="<?php if (isset($target)) {echo $target->getUsername();} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword1" class="col-sm-2 control-label">New Password</label>
					<div class="col-sm-3">
						<input type="password" class="form-control" autocomplete="off" name="password1" id="inputPassword1" placeholder="New password">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword2" class="col-sm-2 control-label">*Repeat Password</label>
					<div class="col-sm-3">
						<input type="password" class="form-control" name="password2" id="inputPassword2" placeholder="Repeat password">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail" class="col-sm-2 control-label">Email address</label>
					<div class="col-sm-3">
						<input type="email" class="form-control" autocomplete="off" name="email" id="inputEmail" placeholder="Email address" value="<?php if (isset($target)) {echo $target->getEmail();} ?>">
					</div>
				</div>
                <!-- NO NEED
				<div class="form-group">
					<label for="group" class="col-sm-2 control-label">User group</label>
					<div class="col-sm-3">
						<select id="group" name="group"class="form-control">
							<option value="">Choose a group</option>
							<?php
							for ($i = 0 ; $i < sizeof($groups) ; $i++){
								$group = $groups[$i];
								if (isset($target)) {
									if($target->getGroup()->getId() == $group->getId()){
										echo "<option value=\"".$group->getId()."\" selected>".$group->getName()."</option>";
										continue;
									}
								}
								echo "<option value=\"".$group->getId()."\">".$group->getName()."</option>";
							}
							?>
						</select>
					</div>
				</div>
                -->
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<button type="submit" class="btn btn-primary">Save Settings</button>
					</div>
				</div>
			</form>
		</div>
		<?php
		// Footer
		include_once('../private/footer.php');
		?>
	</body>
</html>
