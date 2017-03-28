<?php
global $config;

// Report all PHP errors
error_reporting(1);
ini_set('display_errors', '1');
ini_set('upload_max_size', '80M');
ini_set('post_max_size', '80M');

/* General settings */
$config['project'] = "StuvoApp";
$config['sessiontime'] = 12;
$config['sessioncount'] = 2;

/* Advanced settings */
$config['permissionprefix'] = "stuvo";

/* MySQL User database Configuration */
// Hostname - MySQL Hostname:port
$config['database']['hostname'] = "localhost";
// Database - MySQL Database
$config['database']['database'] = "c5stuvo";
// Username - MySQL Database username
$config['database']['username'] = "c5stuvo";
// Password - MySQL Database password
$config['database']['password'] = "qsigEI@88D";
// Prefix - MySQL Table prefix
$config['database']['prefix'] = "";
// Database debugging
$config['database']['debug'] = false;

$config['exceldir'] = "/";

date_default_timezone_set('Europe/Berlin');

$config['googleapi']['name'] = 'Stuvo';
$config['googleapi']['key'] = 'AIzaSyAraloDcAYcwYba8JALzJ3YIXzWzGq2824';
$config['googleapi']['calendarid'] = 'stuvoapp@gmail.com';
$config['facebookapi']['appid'] = '1534214693510762';
$config['facebookapi']['secret'] = '1b1d3303ccf8472324a91bc936ffc415';
$config['facebookapi']['stuvopage'] = '149428375138173';

$config['email']['from'] = "Stuvo App <stuvoapp@gmail.com>";
$config['email']['subject'] = "Bedankt voor je registratie!!";
$config['email']['body']['text'] = "Hey! Bedankt voor de Stuvo app te installeren, geef deze code aan de kassa: $code   Groetjes, Het Stuvo Team";
$config['email']['body']['html'] = "<html>Hey!<br><br>Bedankt om de Stuvo app te installeren, gebruik deze code voor je gratis drankje!<br>$code<img src=\"http://app.stuvo.ehb.be/api/drankregistratie.php?code=$code\"></img><br><br>Tot binnenkort, Het Stuvo Team</html>";

$config['student']['email'] = ["student.ehb.be","ehb.be"];
?>