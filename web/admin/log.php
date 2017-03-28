<?php namespace mvdwcms\admin;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "administration"; 
$page['requirelogin'] = true;
$page['root'] = "../";
$page['requireperm'] = "log";
// Load main
include_once('../../private/main.php');
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
			$pageNr = 1;
			$query = "";
			if (isset($_GET['page'])){
				$pageNr = mysql_real_escape_string($_GET['page']);
			}
			$logCount = $logUtil->getCount();
			$maxPages = floor(($logCount / 50)) + 1;
			$logs = $logUtil->getLogs(50,$pageNr);
		?>
		<div id="content">
			<h2>Activity Log</h2>
			<table class="table">
				<tr>
					<th>
						
					</th>
					<th>
						Timestamp
					</th>
					<th>
						User
					</th>
					<th>
						Log
					</th>
				</tr>
				<?php
				for($i= 0 ; $i < sizeof($logs);$i++){
					$log= $logs[$i]['log'];
					$type = $log['type'];
					$icon = "";
					if ($type == 0){
						$icon = "glyphicon glyphicon-ok";
					}else if ($type == 1){
						$icon = "glyphicon glyphicon-arrow-up";
					}else if ($type == 2){
						$icon = "glyphicon glyphicon-trash";
					}else if ($type == 3){
						$icon = "glyphicon glyphicon-search";
					}else if ($type == 4){
						$icon = "glyphicon glyphicon-pencil";
					}else if ($type == 5){
						$icon = "glyphicon glyphicon-remove";
					}else if($type == 6){
						$icon = "glyphicon glyphicon-download-alt";
					}else if($type == 7){
						$icon = "glyphicon glyphicon-saved";
					}else if($type == 8){
						$icon = "glyphicon glyphicon-plus";
					}
					echo "<tr".($type == 5 ? " class=\"danger\"" : "").">";
					
					echo "<td>";
					// Image type
					echo "<span class=\"$icon\"></span>";
					echo "</td>";
					
					echo "<td>";
					// Timestamp
					$dt = new \DateTime("@".$log['time']); // convert UNIX timestamp to PHP DateTime
					echo $dt->format('Y-m-d H:i:s'); 
					echo "</td>";
					
					echo "<td>";
					// User
					$uid = $log['uid'];
					if ($uid != 0){
						$logUser = $userManager->getUserById($log['uid']);
						echo $logUser->getUsername();
					}else{
						echo "";
					}
					echo "</td>";
					
					echo "<td>";
					// Message
					echo $log['message'];
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
