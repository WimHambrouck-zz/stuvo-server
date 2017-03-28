<?php namespace mvdwcms\admin;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "administration"; 
$page['requirelogin'] = true;
$page['root'] = "../";
$page['requireperm'] = "users";
// Load main
include_once('../../private/main.php');

if (isset($_GET['action'])){
	$action = $_GET['action'];
	if ($action == "remove"){
		$uid = $_GET['id'];
		
		$userManager->removeUserById($uid);
	}
	header('Location: users.php');
}

$pageNr = 1;
if (isset($_GET['page'])){
	$pageNr = $_GET['page'];
}

$users = $userManager->getUsers(50,$pageNr);
$userCount = $userManager->getCount();
$query= "";

$maxPages = floor(($userCount / 50)) + 1;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - ADMIN";
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
			<h2><?php echo $config['project']; ?> Users</h2>
			<div class="row no-print">
				<div class="col-md-2">
					<a href="../profile.php?id=new" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>  Create new user</a>
				</div>
				<br></br>
			</div>
			
			<table class="table">
				<tr>
					<th class="mobile-hide">
						#
					</th>
					<th>
						Username
					</th>
					<th class="mobile-hide">
						First name
					</th>
					<th class="mobile-hide">
						Last name
					</th>
					<th>
						Group
					</th>
					<th>
					
					</th>
				</tr>
				<?php
				for($i = 0 ; $i < sizeof($users) ; $i++){
					$u = $users[$i];
					
					echo "<tr>";
					
					echo "<td class=\"mobile-hide\">";
					echo $u->getId();
					echo "</td>";
					
					echo "<td>";
					echo $u->getUsername();
					echo "</td>";
					
					echo "<td class=\"mobile-hide\">";
					echo $u->getFirstname();
					echo "</td>";
					
					echo "<td class=\"mobile-hide\">";
					echo $u->getLastname();
					echo "</td>";
					
					echo "<td>";
					echo $u->getGroup()->getName();
					echo "</td>";
					
					echo "<td>";
					// Buttons
					echo "<div class=\"btn-group\">";
					echo "<a href=\"../profile.php?id=".$u->getId()."\" class=\"btn btn-primary no-print\"><span class=\"glyphicon glyphicon-pencil\"></span></a> ";
					echo "<a href=\"users.php?action=remove&id=".$u->getId()."\" class=\"btn btn-danger no-print\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
					echo "</div>";
					echo "</td>";
					
					echo "</tr>";
				
				}
				?>
			</table>
			
			<center>
				<ul class="pagination no-print">
				<?php
				if( $pageNr == 1){
					echo "<li class=\"disabled\"><a href=\"".$_SERVER['PHP_SELF']."?page=".$pageNr.($query != "" ? ("&q=".$query) : "")."\">&laquo;</a></li>";
				}else{
					echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($pageNr-1).($query != "" ? ("&q=".$query) : "")."\">&laquo;</a></li>";
				}
				for($i = 1; $i <= $maxPages ; $i++){
					if( $pageNr == $i){
						echo "<li class=\"active\"><a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a></li>";
					}else{
						echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".$i.($query != "" ? ("&q=".$query) : "")."\">".$i."</a></li>";
					}
				}
				if( $pageNr >= $maxPages){
					echo "<li class=\"disabled\"><a href=\"".$_SERVER['PHP_SELF']."?page=".$pageNr.($query != "" ? ("&q=".$query) : "")."\">&raquo;</a></li>";
				}else{
					echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($pageNr+1).($query != "" ? ("&q=".$query) : "")."\">&raquo;</a></li>";
				}
				?>
				</ul>
			</center>
		</div>
		<?php
		// Footer
		include_once('../../private/footer.php');
		?>
	</body>
</html>
