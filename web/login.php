<?php namespace mvdwcms;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

// Page settings
$page['name'] = "login"; 
$page['requirelogin'] = false;
$page['root'] = "";
$page['requireperm'] = "";
// Load main
include_once(dirname(__FILE__).'/../private/main.php');

$ref = "";
if (isset($_GET['ref'])){
	$ref = $_GET['ref'];
}
if (isset($_POST['ref'])){
	$ref = $_POST['ref'];
}
	
$loginfail = 0;
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'login') {
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$passwordMD5 = md5($password);
			$userId = $sessionManager->logIn($username, $passwordMD5);
			if ($userId != -1) {
				$user = $userManager->getUserById($userId);
				if (!$user->isActive()){
					$loginfail = 2;
					$sessionManager->logOut();
					$logUtil->addLog($user,5,"Login fout - Gedeactiveerd");
				}else{
					$logUtil->addLog($user,0,'Aangemeld');
					if ($ref != ""){
						header('Location: '.urldecode($ref));
					}else{
						header('Location: index.php');
					}
				}
			} else {
				$logUtil->addLog(null,5,"Login fout '".$username."' - ".$_SERVER['REMOTE_ADDR']);
				$loginfail = 1;
			}
		}
	} else if ($_POST['action'] == 'logout') {
		$sessionManager-> logOut();
		$logUtil->addLog($user,1,$user->getUsername().' uitgelogd');
	}
}

if ($sessionManager->isLoggedIn() != -1) {
	if ($ref != ""){
		header('Location: '.urldecode($ref));
	}else{
		header('Location: index.php');
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		// Header
		$header['title'] = "StuvoApp - Admin Login";
		$header['description'] = "";
		$header['keywords'] = "";
		include_once(dirname(__FILE__).'/../private/head.php');
		?>
		<link href="css/login.css" rel="stylesheet">
		<script>
			$(function() {
				$("[data-toggle='popover']").popover();
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div id="logo"></div>
				<?php 
				if ($loginfail == 1){ 
					echo "<div class='alert alert-danger'>Foutieve gebruikersnaam of wachtwoord!</div>";
				}else if ($loginfail == 2){
					echo "<div class='alert alert-danger'>Account gedeactiveerd!</div>";
				} 
				?>
				<div class="row">
					<div class="login-form">
						<form class="form-horizontal" role="form" action="login.php" method="post">
							<input type="hidden" name="action" id="action" value="login">
							<input type="hidden" name="ref" value="<?php echo $ref; ?>">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="username" id="username" placeholder="Gebruikersnaam">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<input type="password" class="form-control" name="password" id="password" placeholder="Wachtwoord">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-10">
									<button type="submit" class="btn btn-primary">
										 <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>    Aanmelden
									</button>
									<button id="help" type="button" class="btn btn-default mobile-hide" data-container="body" data-toggle="popover" data-placement="right" data-content="Voer uw login gegevens in om de StuvoApp instellingen te wijzigen.">
										 <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>    Help
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /container -->
	</body>
</html>
