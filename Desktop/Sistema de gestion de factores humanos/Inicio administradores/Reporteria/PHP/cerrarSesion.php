<?php
	session_start();
	session_destroy();
	//echo("location.reload()");
	echo("window.location='../../index.php'");
?>