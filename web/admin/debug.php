<?php namespace mvdwcms\admin;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "administration"; 
$page['requirelogin'] = true;
$page['root'] = "../";
$page['requireperm'] = "debug";
// Load main
include_once('../../private/main.php');

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
			<h2><?php echo $config['project']; ?> Panel information</h2>
			
		</div>
		<?php
		// Footer
		include_once('../../private/footer.php');
		?>
	</body>
</html>
