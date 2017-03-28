<?php namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014-2015
 * ------------------------------------- */

// Page settings
$page['name'] = "notifications"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Notificaties";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
		<script>
		function send(){
			$('#gcm').ajaxSubmit();
			
		}
		</script>
	</head>
	<body>
		<?php
		// Menu header
		include_once('../private/header.php');
		?>
		<div id="content">
			<div class="row">
				<div class="col-md-10">
					<h1>StuvoApp - Notificaties</h1>
				</div>
			</div>
			
			<form id="gcm" action="api/notification_gcm_send.php" method="GET">
				<div class="form-group">
					<label class="col-sm-2 control-label">Notificatie titel</label>
					<div class="col-sm-3">
						<input class="form-group" type="text" name="title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Notificatie tekst</label>
					<div class="col-sm-3">
						<textarea class="form-group" name="message"></textarea>
					</div>
				</div>
				<input type="hidden" name="action" value="send">
				<div class="form-group">
					<button class="btn btn-primary" type="button" onclick="send();">Verzenden</button>
				</div>
			</form>
		</div>
		<?php
		// Footer
		include_once('../private/footer.php');
		?>
	</body>
</html>