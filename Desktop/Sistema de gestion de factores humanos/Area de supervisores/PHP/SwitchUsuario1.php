<?php
	include("conexion.php");
	session_start();
	if(!empty($_SESSION)){
		if ( isset($_POST['no_empleado'])){
			$con = new Conexion();
			$_SESSION['no_empleado'] = $_POST['no_empleado'];
			$sql = "SELECT nombre FROM usuarios WHERE no_empleado = '".$_POST['no_empleado']."'";
			$resultado = $con->ejecutarSql($sql);
			if($con->cantidadRegistros($resultado)==1){
				$registro=$con->obtenerFila($resultado);
				$nombreUsuario=$registro['nombre'];
				$con->cerrarConexion();
				echo $registro['nombre'];
			}
			else{
				$con->cerrarConexion();
				echo"error";
			}

		}

	}
	else{
		echo("error");
	}
?>