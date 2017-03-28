<?php namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014-2015
 * ------------------------------------- */

// Page settings
$page['name'] = "home"; 
$page['requirelogin'] = true;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once('../private/main.php');

if (isset($_GET['action'])){
	$action = $_GET['action'];
	if ($action == "delete"){
		$campus = $_GET['campus'];
		$file = $_GET['file'];
		$files = scandir("api/menus/0/");
						
		sort($files);
		unlink('api/menus/'.$campus.'/'.$files[$file]);
	
		header('Location: resto.php');		
	}
}
if (isset($_POST['action'])){
	$action = $_POST['action'];
	 if($action == "upload"){
    	$startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $allowedExts = array("doc", "docx", "txt","xls","xlsx");
        $campus = $_POST['campus'];
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if (in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
            		var_dump($_FILES);
			} else {
				if (file_exists("api/menus/".$campus.'/'.$startDate.'_'.$endDate.'.'.$extension)) {
					unlink("api/menus/".$campus.'/'.$startDate.'_'.$endDate.'.'.$extension);
				}
				
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"api/menus/".$campus.'/'.$startDate.'_'.$endDate.'.'.$extension);
			}
		}else{
			
			var_dump($_FILES['file']['type']);
		}   
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Studenten restaurants";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once('../private/head.php');
		?>
		<script>
		$(document).ready(function() {
			$('#datepicker1 .input-group.date').datepicker({
				todayBtn: "linked",
				calendarWeeks: true,
				todayHighlight: true,
				format: "dd-mm-yyyy"
			});
			$('#datepicker2 .input-group.date').datepicker({
				todayBtn: "linked",
				calendarWeeks: true,
				todayHighlight: true,
				format: "dd-mm-yyyy"
			});
		});
		</script>
		<style>
		.datepicker{z-index:1151 !important;}
		</style>
	</head>
	<body>
		<?php
		// Menu header
		include_once('../private/header.php');
		?>
		<div id="content">
			<div class="row">
				<div class="col-md-10">
					<h1>StuvoApp - Studenten restaurants</h1>
				</div>
			</div>
			<div class="row no-print">
				<div class="col-md-3">
					<button data-toggle="modal" data-target="#new" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>  Menu toevoegen</button>
				</div>
			</div>

			<br></br>
			
			
			<div role="tabpanel">

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li onclick="$('#selectedCampus').val('0');" role="presentation" class="active"><a href="#campus_kaai" aria-controls="campus_kaai" role="tab" data-toggle="tab">Campus Kaai</a></li>
			    <li onclick="$('#selectedCampus').val('1');" role="presentation"><a href="#campus_jette" aria-controls="campus_jette" role="tab" data-toggle="tab">Campus Jette</a></li>
			    <li onclick="$('#selectedCampus').val('2');" role="presentation"><a href="#campus_bloemenhof" aria-controls="campus_bloemenhof" role="tab" data-toggle="tab">Campus Bloemenhof (Brussel)</a></li>
			  </ul>
			
			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="campus_kaai">
					<!-- Resto table -->
					<table class="table">
						<tr>
							<th>
								Start datum
							</th>
							<th>
								Eind datum
							</th>
							<th>
								File
							</th>
							<th>
							
							</th>
						</tr>
						<?php
						// Oplijsten van campus
						$files = scandir("api/menus/0/");
						
						sort($files);
						for ($i = 2; $i <sizeof($files);$i++){
							$file = $files[$i];
							$dates = explode('_',explode('.',$file)[0]);
							
							echo "<tr>";
							echo "<td>";
							echo $dates[0];
							echo "</td>";
							
							echo "<td>";
							echo $dates[1];
							echo "</td>"; 
							
							
							echo "<td>";
							echo "<a class='btn btn-success' href='api/menus/0/".$file."'>Download Excel file</a>";
							echo "</td>";
							
							echo "<td>";
							echo "<a class=\"btn btn-danger\" href=\"resto.php?action=delete&campus=0&file=".$i."\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
							echo "</td>";
							echo "</tr>";
							
						}
						?>
					</table>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="campus_jette">
					<!-- Resto table -->
					<table class="table">
						<tr>
							<th>
								Start datum
							</th>
							<th>
								Eind datum
							</th>
							<th>
								File
							</th>
							<th>
							
							</th>
						</tr>
						<?php
						// Oplijsten van campus
						$files = scandir("api/menus/1/");
						
						sort($files);
						for ($i = 2; $i <sizeof($files);$i++){
							$file = $files[$i];
							$dates = explode('_',explode('.',$file)[0]);
							
							echo "<tr>";
							echo "<td>";
							echo $dates[0];
							echo "</td>";
							
							echo "<td>";
							echo $dates[1];
							echo "</td>"; 
							
							
							echo "<td>";
							echo "<a class='btn btn-success' href='api/menus/1/".$file."'>Download Excel file</a>";
							echo "</td>";
							
							echo "<td>";
							echo "<a class=\"btn btn-danger\" href=\"resto.php?action=delete&campus=1&file=".$i."\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
							echo "</td>";
							echo "</tr>";
                            
							echo "</tr>";
							
						}
						?>
					</table>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="campus_bloemenhof">
			    	<!-- Resto table -->
					<table class="table">
						<tr>
							<th>
								Start datum
							</th>
							<th>
								Eind datum
							</th>
							<th>
								File
							</th>
							<th>
							
							</th>
						</tr>
						<?php
						// Oplijsten van campus
						$files = scandir("api/menus/2/");
						
						sort($files);
						for ($i = 2; $i <sizeof($files);$i++){
							$file = $files[$i];
							$dates = explode('_',explode('.',$file)[0]);
							
							echo "<tr>";
							echo "<td>";
							echo $dates[0];
							echo "</td>";
							
							echo "<td>";
							echo $dates[1];
							echo "</td>"; 
							
							
							echo "<td>";
							echo "<a class='btn btn-success' href='api/menus/2/".$file."'>Download Excel file</a>";
							echo "</td>";
							
							echo "<td>";
							echo "<a class=\"btn btn-danger\" href=\"resto.php?action=delete&campus=2&file=".$i."\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
							echo "</td>";
							echo "</tr>";
                            
							echo "</tr>";
							
						}
						?>
					</table>
			    </div>
			  </div>
			
			</div>
			
			
			<div id="new" class="modal fade">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Voeg een menu toe</h4>
			      </div>
			      <div class="modal-body">
			      	<form action="resto.php" method="post"
                            enctype="multipart/form-data">
                        <input id="selectedCampus" type="hidden" name="campus" value="0">
                        <div class="form-group">
							<label for="datepicker1" class="col-sm-4 control-label">Start datum</label>
							<div class="col-sm-7" id="datepicker1">
								<div class="input-group date">
									<input type="text" name="startDate" class="form-control" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
								</div>
							</div>
						</div>
						<br>
						<div class="form-group">
							<label for="datepicker2" class="col-sm-4 control-label">Eind datum</label>
							<div class="col-sm-7" id="datepicker2">
								<div class="input-group date">
									<input type="text" name="endDate" class="form-control" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
								</div>
							</div>
						</div>
                       
                        <label for="file">Filename:</label>
                        <input type="hidden" name="action" value="upload">
                        <input class="form-control" type="file" name="file" id="file"><br>
                        <button type="submit" class="btn btn-warning">Upload menu</button>
                    </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary">Opslaan</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
		<?php
		// Footer
		include_once('../private/footer.php');
		?>
	</body>
</html>