<?php
// Page settings
$page['requirelogin']=true;
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
	}else if ($action == "send"){
		if (isset($_GET['message']) && isset($_GET['title'])){
			$data = array( 'message' => $_GET['message'] ,'title' => $_GET['title']);
			

			$androidIDS = array();
			$registrations = $registrationManager->getRegistrations();
			for ($i = 0 ; $i < sizeof($registrations); $i++){
                if (!in_array($device,$androidIDS)){ // Only add if not added yet
                    array_push($androidIDS,$registrations[$i]->getRegistrationId());
                }
			}

			sendGoogleCloudMessage(  $data, $androidIDS );
		}
	}
}


//------------------------------
// Define custom GCM function
//------------------------------

function sendGoogleCloudMessage( $data, $ids )
{
    //------------------------------
    // Replace with real GCM API 
    // key from Google APIs Console
    // 
    // https://code.google.com/apis/console/
    //------------------------------

    $apiKey = 'AIzaSyB59RtSdA_sjI7J3WTDzlV0Gv3UlZJVYwM';

    //------------------------------
    // Define URL to GCM endpoint
    //------------------------------

    $url = 'https://android.googleapis.com/gcm/send';

    //------------------------------
    // Set GCM post variables
    // (Device IDs and push payload)
    //------------------------------

    $post = array(
                    'registration_ids'  => $ids,
                    'data'              => $data,
                    );

    //------------------------------
    // Set CURL request headers
    // (Authentication and type)
    //------------------------------

    $headers = array( 
                        'Authorization: key=' . $apiKey,
                        'Content-Type: application/json'
                    );

    //------------------------------
    // Initialize curl handle
    //------------------------------

    $ch = curl_init();

    //------------------------------
    // Set URL to GCM endpoint
    //------------------------------

    curl_setopt( $ch, CURLOPT_URL, $url );

    //------------------------------
    // Set request method to POST
    //------------------------------

    curl_setopt( $ch, CURLOPT_POST, true );

    //------------------------------
    // Set our custom headers
    //------------------------------

    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

    //------------------------------
    // Get the response back as 
    // string instead of printing it
    //------------------------------

    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    //------------------------------
    // Set post data as JSON
    //------------------------------

    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

    //------------------------------
    // Actually send the push!
    //------------------------------

    $result = curl_exec( $ch );

    //------------------------------
    // Error? Display it!
    //------------------------------

    if ( curl_errno( $ch ) )
    {
        echo 'GCM error: ' . curl_error( $ch );
    }

    //------------------------------
    // Close curl handle
    //------------------------------

    curl_close( $ch );

    //------------------------------
    // Debug GCM response
    //------------------------------

    echo $result;
}
?>