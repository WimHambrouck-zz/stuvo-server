<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
header('Access-Control-Allow-Origin: *');  

$limit = 25;
$since = 0;
$query = "";

if (isset($_GET['q'])){
    $query = $_GET['q'];
}
if (isset($_GET['limit'])){
	$limit = $_GET['limit'];
}
if (isset($_GET['since'])){
	$since = $_GET['since'];
}
 
require_once realpath(dirname(__FILE__) . '/../../private/autoload.php');
require_once realpath(dirname(__FILE__) . '/../../private/config.php');

$facebook = new Facebook(array(
  'appId'  => $config['facebookapi']['appid'],
  'secret' => $config['facebookapi']['secret'],
));

function newsSearch($posts,$query){
    $resultPosts = array('data'=>array()); 
    foreach ($posts['data'] as $post){
        if (contains($post['message'],$query))
            array_push($resultPosts['data'],$post);
    }
    return $resultPosts;
}

function contains($haystack,$needle){
    if (strpos(strtolower($haystack),strtolower($needle)) !== false){
        return true;
    }
    return false;
}

$pagePosts = $facebook->api($config['facebookapi']['stuvopage']. '/feed?limit='.$limit.($since != 0 ? ('&since='.$since) : ''));

if ($query != ""){
    echo json_encode(newsSearch($pagePosts,$query));
}else{
    echo json_encode($pagePosts);
}
?>