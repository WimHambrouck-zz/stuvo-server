<?php
namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "home"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');
$xmlUrl='api/xml/spons.xml';

$get = file_get_contents($xmlUrl);
$Contarr = simplexml_load_string($get);
if($_REQUEST['node']!='')
  $node = (int) $_REQUEST['node'];
$item = $Contarr->children();
$data = $item[$node];

$naam = $_REQUEST['naam'];
$link = $_REQUEST['link'];
$beschrijving= $_REQUEST['beschrijving'];
$prioriteit = $_REQUEST['prioriteit'];

$imageurlxml = "images/";
$imagedir='images/';
//Code for edit xml

$actiont = $_REQUEST['action'];
if($actiont=="d" && $node!=''){
	$xml = simplexml_load_file($xmlUrl);
 	unset($xml->sponser[$node]) ;
 $xml->saveXML($xmlUrl);
 header('location:spons.php?msg=d');
	
}

if($_FILES['image']['name'])
{
	//if no errors...
	if(!$_FILES['image']['error'])
	{
		
		//now is the time to modify the future file name and validate the file
		$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
		$new_file_name = substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 16 ) .".". $ext; //rename file
		 
			//move it to where we want it to be
		move_uploaded_file($_FILES['image']['tmp_name'], $imagedir.$new_file_name);
			$message = 'Congratulations!  Your file was accepted.';
		
	}
	//if there is an error...
	else
	{
		//set that to be the returned message
		$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
	}
}
if(isset($node) && $node>=0 && ( $naam !='' || $link!='' || $beschrijving!=''))
{



 $xml = simplexml_load_file($xmlUrl);
 $xmldata = $xml->sponser[$node];
 $xml->sponser[$node]->naam=$naam;
 $xml->sponser[$node]->link=$link;
 if(isset($ext))
 $xml->sponser[$node]->image=$imageurlxml.$new_file_name;
 
 $xml->sponser[$node]->beschrijving=$beschrijving;

 $xml->saveXML($xmlUrl);
 header('location:spons.php?msg=u');
	
}else{
	if($naam !='' || $link!='' || $beschrijving!='')
	{
		 $xml = simplexml_load_file($xmlUrl);
		 $cont = $xml->addChild('sponser','');
		  $cont->addChild('naam',$naam);
		 $cont->addChild('link',$link);
		 if(isset($ext))
		 $cont->addChild('image',$imageurlxml.$new_file_name);
		 $cont->addChild('beschrijving',$beschrijving);
         $cont->addChild('prioriteit',$prioriteit);
		 $xml->saveXML($xmlUrl);
		 header('location:spons.php?msg=a');
	}
	
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "Sponsor";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
	</head>
	<body>
	<?php
		// Menu header
		include_once('../private/header.php');
		?>
	<div id="content">
			<h2> <small><?php if (isset($node)) { echo 'Update Sponsors';} else{echo'Create New Sponsors';} ?></small>,</h2>
			
			<form id="form-contact" class="form-horizontal" role="form" action="create_spons.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="node" id="node" value="<?php echo $node;?>">
				<div class="form-group">
					<label for="inputvoornaam" class="col-sm-2 control-label">naam</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="naam" id="naam" placeholder="naam" value="<?php if (isset($data->naam)) {echo $data->naam;} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="group" class="col-sm-2 control-label">Link</label>
					<div class="col-sm-3">
										
				<input type="text" class="form-control" name="link" id="link" placeholder="link" value="<?php if (isset($data->link)) {echo $data->link;} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="group" class="col-sm-2 control-label">Prioriteit</label>
					<div class="col-sm-3">
                        <select id="prioriteit" placeholder="prioriteit" class="form-control" name="prioriteit">
                            <option value="laag">laag</option>
                            <option value="normaal">normaal</option>
                            <option value="hoog">hoog</option>
                        </select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="inputemail" class="col-sm-2 control-label" email>Image</label>
					<div class="col-sm-3">
						<input type="file" name="image" id="image">
					</div>
				</div>
				
					
				
				<div class="form-group">
					<label for="inputEmail" class="col-sm-2 control-label">beschrijving</label>
					<div class="col-sm-3">
					<textarea id="beschrijving" class="form-control" name="beschrijving"><?php if (isset($data->beschrijving)) {echo $data->beschrijving;} ?></textarea>
						
					</div>
				</div>
			
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
		<?php
		// Footer
		include_once('../private/footer.php');
		?>
	</body>