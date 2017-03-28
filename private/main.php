<?php namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Start time
$time['start'] = microtime();
 
include_once (dirname(__FILE__).'/include.php');

use mvdwcms\managers\SessionManager;
use mvdwcms\managers\UserManager;
use mvdwcms\managers\UserGroupManager;
use mvdwcms\managers\PermissionManager;
use mvdwcms\utils\LogUtil;

$sessionManager = new SessionManager($config);
$userManager = new UserManager($config);
$permissionManager = new PermissionManager($config);
$userGroupManager = new userGroupManager($config);
$logUtil = new LogUtil($config);

$request_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$request_url_noargs = explode('?',$request_url)[0];

$user;
$userId = $sessionManager->isLoggedIn();
if ($userId == -1 && $page['requirelogin']) {
	loginRedirect();
} else {
	$user = $userManager -> getUserById($userId);
}

function loginRedirect() {
	global $request_url, $page;
	header('Location: '.$page['root'].'login.php?ref='.urlencode($request_url));
	die();
}

// Live flush
ob_end_flush();
ob_start();
?>