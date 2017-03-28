<?php
	// Page settings
	$page['name']="drankregistatieapi";
	$page['requirelogin']=false;
	$page['root']="../";
	$page['requireperm']="";
	// Load main
	include_once('../../private/main.php');
	require_once "Mail.php";
	require_once "Mail/mime.php";
	
	use mvdwcms\managers\StudentRegistratieManager;
	use mvdwcms\models\StudentRegistratie;
	
	header('Access-Control-Allow-Origin: *');
		
	if (isset($_GET['code']))
	{
		$code = $_GET['code'];
		QRCode::png("http://srv6.mvdw-software.com/workspace/StuvoBackend/public_html/drankjes.php?code=".$code);
		return;
	}
	
	function getDomainFromEmail($email)
	{
	    // Get the data after the @ sign
	    $domain = substr(strrchr($email, "@"), 1);
	 
	    return $domain;
	}
	
	$registrationManager=new StudentRegistratieManager($config);
	
	$output=array();
	$email="";
	if(isset($_GET['email'])){
		$email=$_GET['email'];
	}
	else{
		$output['status']=1;
		die(json_encode($output));
	}
	$valid = false;
	$domain = getDomainFromEmail($email);
	for ($i = 0 ; $i < sizeof($config['student']['email']) ; $i++){
		$dom = $config['student']['email'][$i];
		if ($domain == $dom){
			$valid = true;
			break;
		}
	}
	if (!$valid){
		$output['status']=1;
		die(json_encode($output));
	}
	if($registrationManager->hasRegistrated($email)){
		$output['status']=2;
		die(json_encode($output));
	}
	$registration=new StudentRegistratie();
	$registration->setEmail($email);
	$code = generateRandomString(10);
	$registration->setPrivateKey($code);	
	$registrationManager->addRegistration($registration);

	
	$output['status']=0;
	$from=$config['email']['from'];
	$to=$email;
	$subject=$config['email']['subject'];
       // Creating the Mime message
    $mime = new Mail_mime("\n");
    
    $headers=array('From'=>$from,'To'=>$to,'Subject'=>$subject);


	$text = $config['email']['body']['text'];
	$html = $config['email']['body']['html'];

    // Setting the body of the email
    $mime->setTXTBody($text);
    $mime->setHTMLBody($html);

    $body = $mime->get();
    $headers = $mime->headers($headers);
	$body=$mime->get();
	
	$smtp=Mail::factory('smtp',array('host'=>'smtp.gmail.com','port'=>'587','auth'=>true,'username'=>'stuvoapp@gmail.com','password'=>'Stuvo2015'));
	$mail=$smtp->send($to,$headers,$body);
	if(PEAR::isError($mail)){
		$output['status']=1;
	}
	die(json_encode($output));
	
	
	// Generate key
	function generateRandomString($length=10){
		$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength=strlen($characters);
		$randomString='';
		for($i=0;
		$i<$length;
		$i++){
			$randomString.=$characters[rand(0,$charactersLength-1)];
		}
		return $randomString;
	}
?>