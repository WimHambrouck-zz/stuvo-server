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
$xmlUrl='api/xml/contact-dev.xml';

$get = file_get_contents($xmlUrl);
$Contarr = simplexml_load_string($get);
if($_REQUEST['node']!='')
  $node = (int) $_REQUEST['node'];
$item = $Contarr->children();
$data = $item[$node];

$voornaam = $_REQUEST['voornaam'];
$departement = $_REQUEST['departement'];
$email= $_REQUEST['email'];
$telefoonnummer = $_REQUEST['telefoonnummer'];
$achternaam1 = $_REQUEST['achternaam'];
$omschrijving=$_REQUEST['omschrijving'];
//Code for edit xml

$actiont = $_REQUEST['action'];
if($actiont=="d" && $node!=''){
	$xml = simplexml_load_file($xmlUrl);
 	unset($xml->contact[$node]) ;
 $xml->saveXML($xmlUrl);
 header('location:contacts.php?msg=d');
	
}

if(isset($node) && $node>=0 && ( $voornaam !='' || $departement!='' || $email!='' || $telefoonnummer!='' || $achternaam1!='' || $omschrijving!=''))
{

 $xml = simplexml_load_file($xmlUrl);
 $xmldata = $xml->contact[$node];
 $xml->contact[$node]->voornaam=$voornaam;
 $xml->contact[$node]->departement=$departement;
 $xml->contact[$node]->email=$email;
 $xml->contact[$node]->telefoonnummer=$telefoonnummer;
 $xml->contact[$node]->achternaam=$achternaam1;
 $xml->contact[$node]->omschrijving=$omschrijving;
 $xml->saveXML($xmlUrl);
 header('location:contacts.php?msg=u');
	
}else{
	if($voornaam !='' || $departement!='' || $email!='' || $telefoonnummer!='' || $achternaam1!='' || $omschrijving!='')
	{
		 $xml = simplexml_load_file($xmlUrl);
		 $cont = $xml->addChild('contact','');
		  $cont->addChild('voornaam',$voornaam);
		 $cont->addChild('departement',$departement);
		 $cont->addChild('email',$email);
		 $cont->addChild('telefoonnummer',$telefoonnummer);
		 $cont->addChild('achternaam',$achternaam1);
		 $cont->addChild('omschrijving',$omschrijving);
		 $xml->saveXML($xmlUrl);
		 header('location:contacts.php?msg=a');
	}
	
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "Contact";
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
			<h2> <small><?php if (isset($node)) { echo 'Update Contact';} else{echo'Create New Contact';} ?></small>,</h2>
			
			<form id="form-contact" class="form-horizontal" role="form" action="create.php" method="post">
				<input type="hidden" name="node" id="node" value="<?php echo $node;?>">
				<div class="form-group">
					<label for="inputvoornaam" class="col-sm-2 control-label">Voornaam</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="voornaam" id="voornaam" placeholder="Voornaam" value="<?php if (isset($data->voornaam)) {echo $data->voornaam;} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="group" class="col-sm-2 control-label">Achternaam</label>
					<div class="col-sm-3">
										
				<input type="text" class="form-control" name="achternaam" id="achternaam" placeholder="Achternaam" value="<?php if (isset($data->achternaam)) {echo $data->achternaam;} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputdepartement" class="col-sm-2 control-label">Departement</label>
					<div class="col-sm-3">
					
					<?php 
					$department_options = array('Sociaaljuridisch advies','Centen voor studenten','Diversiteit','Kot en vervoer','Sport en cultuur',"Studentenresto's");
					?>
					<select name="departement" id="departement" class="form-control">
						<option value="">Choose a departement</option>
						<?php foreach($department_options as $dept){?>
							<option value="<?php echo $dept;?>"  <?php echo ($data->departement==$dept ? "selected" : ""); ?>><?php echo $dept;?></option>
						<?php }?>
						
					</select>
						
					</div>
				</div>
				<div class="form-group">
					<label for="inputemail" class="col-sm-2 control-label" email>Email</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  name="email" id="email" placeholder="Email" value="<?php if (isset($data->email)) {echo $data->email;} ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputtelefoonnummer" class="col-sm-2 control-label">Telefoonnummer</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  name="telefoonnummer" id="telefoonnummer" placeholder="Telefoonnummer" value="<?php if (isset($data->telefoonnummer)) {echo $data->telefoonnummer;} ?>">
					</div>
				</div>
				
				<div class="form-group">
					<label for="inputEmail" class="col-sm-2 control-label">Omschrijving</label>
					<div class="col-sm-3">
					<textarea id="omschrijving" class="form-control" name="omschrijving"><?php if (isset($data->omschrijving)) {echo $data->omschrijving;} ?></textarea>
						
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