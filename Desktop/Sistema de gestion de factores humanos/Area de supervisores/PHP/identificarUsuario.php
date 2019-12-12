<?php
	include("conexion.php");
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['tipo'])){
			$con = new Conexion();
			$no_empleado = $_SESSION['no_empleado'];
			$tipo=$_POST['tipo'];
			$sql = "SELECT * FROM usuarios WHERE usuarios.no_empleado ='".$no_empleado."' AND usuarios.idTipoUsuario=".$tipo;
			$resultado = $con->ejecutarSql($sql);
			if($con->cantidadRegistros($resultado)==1){
				$registro=$con->obtenerFila($resultado);
				$nombreUsuario=$registro['nombre'];
				$con->cerrarConexion();
				echo utf8_encode("document.getElementById('Encabezado_nombreUsuario').innerHTML='".$nombreUsuario."';");
			}
			else{
				$con->cerrarConexion();
				echo ("window.location='../index.php';");
			}

		}
		
	}
	else{
		echo("error");
	}
?>