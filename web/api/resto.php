<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
header('Access-Control-Allow-Origin: *');  
 
require_once realpath(dirname(__FILE__) . '/../../private/autoload.php');
require_once realpath(dirname(__FILE__) . '/../../private/config.php');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$campus = 0;
if (isset($_GET['campus']))
	$campus = $_GET['campus'];

$files = scandir("menus/".$campus."/");

sort($files);
$xls = PHPExcel_IOFactory::load("menus/".$campus."/".$files[2]);
for ($i = 2; $i <sizeof($files);$i++){
	$file = $files[$i];
	$dates = explode('_',explode('.',$file)[0]);
	$curDate = date_timestamp_get(date_create());
	$dateBegin = strtotime($dates[0]);
	$dateEnd = strtotime($dates[1]);
	if (($curDate > $dateBegin) && ($curDate < $dateEnd))
    {
    	$xls = PHPExcel_IOFactory::load("menus/".$campus."/".$files[$i]);
    }
}
							
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();

$output['menu'] = array();
$i = 0;

$output['menu'][$sheet->getCell('B1')->getCalculatedValue()] = array(); //Ma
$output['menu'][$sheet->getCell('C1')->getCalculatedValue()] = array(); //Di
$output['menu'][$sheet->getCell('D1')->getCalculatedValue()] = array(); //Wo
$output['menu'][$sheet->getCell('E1')->getCalculatedValue()] = array(); //Do
$output['menu'][$sheet->getCell('F1')->getCalculatedValue()] = array(); //Vr

foreach($sheet->getRowIterator() as $row){
    $rowIndex = $row->getRowIndex();
    
    foreach (array("B","C","D","E","F") as $letter){
	    $day = $sheet->getCell($letter.'1')->getCalculatedValue();
	    
	    $voeding = $sheet->getCell('A'.$rowIndex)->getCalculatedValue();
	    $cell = $sheet->getCell($letter.$rowIndex)->getCalculatedValue();
	    if ($voeding != null && $rowIndex != 1)
	      $output['menu'][$day][$voeding] = $cell;
    }
}

echo json_encode($output);
?>