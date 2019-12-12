<?php
	session_start();
	if(empty($_SESSION)){
		//header('location:../../Login/login.php');
		echo"Sesion cerrada";
	}
	else{
		echo"sesion aún abierta";
	}
?>