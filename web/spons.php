<?php
namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$page['name'] = "Sponsors"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');
$xmlUrl='api/xml/spons.xml';
$get = file_get_contents($xmlUrl);
$Contarr = simplexml_load_string($get);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Sponsors";
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
        <strong>Nieuw!</strong> Sponsors succesvol toegevoegd.
    </div>
    <?php }?>
    	<?php
	 
	 if(isset($msg) && $msg=="u")
	 {
	?>
	 <div class="alert alert-success" style="width:50%; margin-top:10px;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Aangepast!</strong> Sponsors succesvol aangepast.
    </div>
    <?php }?>
    
    <?php
	 
	 if(isset($msg) && $msg=="d")
	 {
	?>

    <div class="alert alert-success" style="width:50%; margin-top:10px;">

        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <strong>Verwijderd!</strong> Sponsors succesvol verwijderd.

    </div>
 <?php }?>

    
  <h2>Sponsors Lijst</h2>
	<table class="table table-condensed">
   
   <a href="create_spons.php"><i class=" pull-right glyphicon glyphicon-plus"></i></a>
   <thead>
      <tr>
         <th>Naam</th>
         <th>Link</th>
         <th>Prioriteit</th>
        <th class="hidden-xs"></th>
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
         <td><?php echo $cont->naam;?></td>
         <td><?php echo $cont->link;?></td>
         <td><?php echo $cont->prioriteit;?></td>
         <td class="hidden-xs"><div style="background-size: contain; background-repeat: no-repeat; height: 35px;  width: 80px;background-image: url(<?php echo $cont->image;?>);" class="thumbnailContact"></div></td>
         <td>
            <a href="create_spons.php?node=<?php echo $k;?>&action=d" onclick="return confirm('Bent u zeker dat u dit wilt verwijderen?')"> <i class="glyphicon glyphicon-trash"></i></a>
         
         </td>
      </tr>
      <?php $k++;}?>
   </tbody>
</table>
</div>
<?php
		// Footer
		include_once('../private/footer.php');
		?>
	</body>