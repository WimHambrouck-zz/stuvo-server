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

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "Stuvo App beheer";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
	</head>
	<body>
		<?php
		// Menu header
		include_once('../private/header.php');
		?>
		<div id="content">
			<div class="row">
				<div class="col-md-10">
					<h1>StuvoApp beheer</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<a class="btn btn-default" href="contacts.php" role="button">Contacten beheren</a>
				</div>
				<div class="col-md-6">
					<a class="btn btn-default" href="spons.php" role="button">Sponsors beheren</a>
					<br />
					<br />
				</div>
				
				<div class="col-md-6">
					<a class="btn btn-default" href="resto.php" role="button">Restaurants beheren</a>
				</div>
                
                <!-- DISABLED OMDAT NIET GEIMPLMENTEERD IN APP
				<div class="col-md-6">
					<a class="btn btn-default" href="notifications.php" role="button">Notificaties verzenden</a>
				</div>
                -->
			</div>
		</div>
		<?php
		// Footer
		include_once('../private/footer.php');
		?>
	</body>
</html>