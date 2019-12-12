<?php
	include('conexion.php');
	include('AES.php');
	//$password=encrypt_decrypt("encrypt", "gtaiv");
	$sentenciaSql="SELECT correo FROM  `usuarios` WHERE no_empleado='emp3'";
	$con=new conexion();
	$resultado=$con->ejecutarSql($sentenciaSql);
	$registro=$con->obtenerFila($resultado);
	$password=$registro['correo'];
	$password=encrypt_decrypt("decrypt",$password);
	echo("Contraseña desencriptada: ".$password);

?>