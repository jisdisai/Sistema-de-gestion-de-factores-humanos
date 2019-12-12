<?php
	session_start();
	session_destroy();
	echo("window.location='../../index.php'");
?>