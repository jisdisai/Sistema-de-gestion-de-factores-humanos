<?php
	include("conexion.php");
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$no_empleado = $_SESSION['no_empleado'];
		$sql = "SELECT nombre FROM usuarios WHERE no_empleado = '".$no_empleado."'";
		$resultado = $con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){
			$registro=$con->obtenerFila($resultado);
			$nombreUsuario=$registro['nombre'];
			$con->cerrarConexion();
			echo $nombreUsuario;
		}
		else{
			$con->cerrarConexion();
			echo"error";
		}
	}
	else{
		echo("error");
	}
?>