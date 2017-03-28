<?php namespace mvdwcms\utils;
// Load main
include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

class LoadingScreen{
	public static function showLoading(){
		echo "<div id=\"loading\" class=\"alert alert-info\" role=\"alert\"></div>";
		ob_flush();
		flush();
	}

	public static function hideLoading(){
		echo '<script language="javascript">document.getElementById("loading").style.display = \'none\'</script>';
		ob_flush();
		flush();
	}

	public static function setText($text){
		echo '<script language="javascript">document.getElementById("loading").innerHTML="<center><h3>'.$text.'</h3></center>"</script>';
		ob_flush();
		flush();
	}
}
?>