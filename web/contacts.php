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

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "Stuvo Contacten";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
	</head>
	<body>
	<?php
		// Menu header
		include_once('../private/header.php');
		$msg= $_REQUEST['msg'];
		?>
		<div class="container">
	<?php
	 
	 if(isset($msg) && $msg=="a")
	 {
	?>
	 <div class="alert alert-success" style="width:50%; margin-top:10px;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Nieuw!</strong> contact succesvol toegevoegd.
    </div>
    <?php }?>
    	<?php
	 
	 if(isset($msg) && $msg=="u")
	 {
	?>
	 <div class="alert alert-success" style="width:50%; margin-top:10px;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Aangepast!</strong> contact succesvol aangepast.
    </div>
    <?php }?>
    
    <?php
	 
	 if(isset($msg) && $msg=="d")
	 {
	?>

    <div class="alert alert-success" style="width:50%; margin-top:10px;">

        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <strong>Verwijderd!</strong> Contact verwijderd.

    </div>
 <?php }?>

    
  <h2>Contact Lijst</h2>
	<table class="table table-condensed">
   
   <a href="create.php"><i class=" pull-right glyphicon glyphicon-plus"></i></a>
   <thead>
      <tr>
         <th>Voornaam</th>
         <th>Departement</th>
         <th class="hidden-xs">Email</th>
         <th>Actie</th>
      </tr>
   </thead>
   <tbody>
     <?php 
    
   
    $conts = $Contarr[0];
   $k=0;
     foreach($conts as  $cont){
     
     
     ?>
      <tr>
         <td><?php echo $cont->voornaam;?></td>
         <td><?php echo $cont->departement;?></td>
         <td class="hidden-xs"><?php echo $cont->email;?></td>
         <td><a href="create.php?node=<?php echo $k;?>"><i class="glyphicon glyphicon-edit"></i></a>
        <a href="create.php?node=<?php echo $k;?>&action=d" onclick="return confirm('Bent u zeker dat u dit wilt verwijderen?')"> <i class="glyphicon glyphicon-trash"></i></a>
         
         </td>
      </tr>
      <?php $k++;}?>
   </tbody>
</table>
</div>
<?php
		// Footer
		include_once('../footer.php');
		?>
	</body>