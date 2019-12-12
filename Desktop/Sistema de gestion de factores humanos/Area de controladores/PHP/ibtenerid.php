<?php
	include('conexion.php');
	include('fecha.php');
	$con = new Conexion();
	$sql="SELECT MAX(user.id) AS 'id_usuario' FROM user";
	$nuevaid=1;
	$resultado=$con->ejecutarSql($sql);
	$registro=$con->obtenerFila($resultado);
	if(strcmp($registro['id_usuario'],"")==0){
		echo "No hay id de usuario, se asumira que es :".$nuevaid;
	}
	else{
		echo"La id maxima es: ".$registro['id_usuario'];
	}
?>