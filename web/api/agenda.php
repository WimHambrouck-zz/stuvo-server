<?php
header('Access-Control-Allow-Origin: *');  
 
require_once realpath(dirname(__FILE__) . '/../../private/autoload.php');
require_once realpath(dirname(__FILE__) . '/../../private/config.php');

$client = new Google_Client();
$client->setApplicationName($config['googleapi']['name']);
$client->setDeveloperKey($config['googleapi']['key']);

$cal = new Google_Service_Calendar($client);
$params = array(
	'singleEvents' => true,
	'orderBy' => 'startTime',
	'timeMin' => date(DateTime::ATOM),
	
);

$events = $cal->events->listEvents($config['googleapi']['calendarid'], $params);

$query = "";

if (isset($_GET['q'])){
    $query = $_GET['q'];
}

// Output array
$output = array();

$maanden[1] = 'Januari';
$maanden[2] = 'Februari';
$maanden[3] = 'Maart';
$maanden[4] = 'April';
$maanden[5] = 'Mei';
$maanden[6] = 'Juni';
$maanden[7] = 'Juli';
$maanden[8] = 'Augustus';
$maanden[9] = 'September';
$maanden[10] = 'October';
$maanden[11] = 'November';
$maanden[12] = 'December';

$currentMonth = date('n');
$currentYear = date('Y');

$i = 0;
$monthStr = $maanden[$currentMonth];
foreach ($events->getItems() as $event) {
	// Laad event data
	$eventName = $event->summary;
	$eventTime = $event->start->dateTime != null ? strtotime($event->start->dateTime) : strtotime($event->start->date);
	$eventEndTime = $event->end->dateTime != null ? strtotime($event->end->dateTime) : strtotime($event->end->date);
	$eventDateStr = date('d/m',$eventTime);
	$eventLocation = $event->location;
	
	$eventMonth = date('n',$eventTime);
	$eventYear = date('Y',$eventTime);
	$eventDay = date('d' , $eventTime);
	$eventHour = date('G' , $eventTime);
	$eventMinute = date('i' , $eventTime);
	
	$eventEndMonth = date('n',$eventEndTime);
	$eventEndYear = date('Y',$eventEndTime);
	$eventEndDay = date('d' , $eventEndTime);
	$eventEndHour = date('G' , $eventEndTime);
	$eventEndMinute = date('i' , $eventEndTime);
	
	$eventId = $event->id;
	$eventDescription = $event->description == null ? "" : $event->description;
	
	if ($eventMonth == $currentMonth){
		$monthStr = $maanden[$currentMonth];
	}else{
		if ($eventYear == $currentYear)
			$monthStr = $maanden[$eventMonth];
		else
			$monthStr = $maanden[$eventMonth].' '.$eventYear;
	}
	
	// Zet event data in array voor JSON output
	$eventItem = array();
	$eventItem['name'] = $eventName;
	$eventItem['date']['short'] = $eventDateStr;
	$eventItem['date']['startyear'] = $eventYear;
	$eventItem['date']['startmonth'] = $eventMonth;
	$eventItem['date']['startday'] = $eventDay;
	$eventItem['date']['starthour'] = $eventHour;
	$eventItem['date']['startminute'] = $eventMinute;
	$eventItem['date']['endyear'] = $eventEndYear;
	$eventItem['date']['endmonth'] = $eventEndMonth;
	$eventItem['date']['endday'] = $eventEndDay;
	$eventItem['date']['endhour'] = $eventEndHour;
	$eventItem['date']['endminute'] = $eventEndMinute;
	$eventItem['description'] = $eventDescription;	
	$eventItem['id'] = $eventId;	
	$eventItem['location'] = $eventLocation;
	if (!isset($output['events'][$monthStr])){
		$output['events'][$monthStr] = array();
	}
	array_push($output['events'][$monthStr],$eventItem);
	$i++;
}

echo json_encode($output);
?>