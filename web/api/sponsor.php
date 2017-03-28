<?php
header('Access-Control-Allow-Origin: *');
$get = file_get_contents('xml/spons.xml');
$arr = simplexml_load_string($get);
echo json_encode($arr);
?>