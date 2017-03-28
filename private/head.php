<title><?php echo $header['title']; ?></title>
		<meta name="description" content="<?php echo $header['description']; ?>">
		<meta name="keywords" content="<?php echo $header['keywords']; ?>">
		<meta name="author" content="Maxim Van de Wynckel">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/ico" href="<?php echo $page['root']; ?>favicon.ico">
		<meta charset="UTF-8">
		<link href="<?php echo $page['root']; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $page['root']; ?>bootstrap/css/glyphicons.css" rel="stylesheet">
		<link href="<?php echo $page['root']; ?>bootstrap/css/wizard.css" rel="stylesheet">
		<link href="<?php echo $page['root']; ?>css/content.css" rel="stylesheet">
		<link href="<?php echo $page['root']; ?>css/header.css" rel="stylesheet">
		<link href="<?php echo $page['root']; ?>css/fonts.css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="<?php echo $page['root']; ?>js/jQuery.js"></script>
		<script src="<?php echo $page['root']; ?>js/jquery.form.min.js"></script>
		<script src="<?php echo $page['root']; ?>js/jquery.wheelzoom.js"></script>
		<script src="<?php echo $page['root']; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo $page['root']; ?>bootstrap/js/bootstrap-filestyle.min.js"></script>
		<script src="<?php echo $page['root']; ?>bootstrap/js/bootstrap-datepicker.js"></script>
		<script>
		function logOut() {
			var actionData = {
				action : "logout"
			};
			$.ajax({
				type : "POST",
				url : "<?php echo $page['root']; ?>login.php",
				data : actionData,
				async : false,
				success : function(text) {
					window.location = "<?php echo $page['root']; ?>login.php";
				}
			});
			window.location = "<?php echo $page['root']; ?><?php echo $page['root']; ?>login.php";
		}
		</script>
