<?php
	include 'conexion.php';
	$con=new Conexion();
	$consulta="SELECT * FROM tiposusuario";
	$resultado=$con->ejecutarConsulta($consulta);
	if($con->hayError($resultado)){
		echo("Algo salió mal<br>");
		echo($con->mostrarError($resultado));
	}
	else{
		echo("<br> hay ".$con->cantidadRegistros($resultado)." resultados: <br>");
		for ($i=0; $i<$con->cantidadRegistros($resultado); $i++){
			echo($con->obtenerFila($resultado)['descripcionTipoUsuario']."<br>");
		}
	}
?>