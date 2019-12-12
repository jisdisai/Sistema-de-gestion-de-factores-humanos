<?php
	session_start();

	if(empty($_SESSION)){
		header('Location:login.php');
	}
	else{
		echo "Bienvenido Admin";
		echo "Tu numero de empleado es: ".$_SESSION['no_empleado'];
		session_destroy();
	}
    

?>
