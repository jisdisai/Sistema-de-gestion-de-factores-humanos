<?php
	session_start();
	session_destroy();
	echo("window.location='../Login/login.php'");
?>