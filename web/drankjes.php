<?php namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "drankregistratie"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');

$code = "";
if (isset($_GET['code'])){
	$code = $_GET['code'];
}

use mvdwcms\managers\StudentRegistratieManager;
use mvdwcms\models\StudentRegistratie;
$registrationManager=new StudentRegistratieManager($config);
$reg = $registrationManager->isValid($code);
if ($reg != false){
	
	$reg->setReceived(1);
	$registrationManager->editRegistration($reg->getId(),$reg);
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Gratis drankjes";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
	</head>
	<body style="text-align: center; font-size: 72px; background-color: @brand-success">
		<span class="glyphicon glyphicon-<?php echo $reg == false ? "remove" : "ok"; ?>"></span>
	</body>
</html>