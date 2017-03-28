<?php
// Page settings
$page['name'] = "info"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');

phpinfo();
?>