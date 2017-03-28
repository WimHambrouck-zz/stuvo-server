<?php
// Page settings
$page['requirelogin']=false;
$page['root']="../";
$page['requireperm']="";
// Load main
include_once('../../private/main.php');

use mvdwcms\models\GCMRegistration;
use mvdwcms\managers\GCMRegistrationManager;

$registrationManager = new GCMRegistrationManager($config);

if (isset($_GET['action'])){
	$action = $_GET['action'];
	if ($action == "register"){
		if (isset($_GET['id'])){
			$id = $_GET['id'];
			$registration = new GCMRegistration();
			$registration->setRegistrationId($id);
			$registrationManager->addRegistration($registration);
			die();
		}
	}
}

?>