<?php
	include('conexion.php');
	include('fecha.php');
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['respuesta']) && isset($_POST['turno']) && isset($_POST['posicion'])){
			$respuesta=$_POST['respuesta'];
			$turno=$_POST['turno'];
			$posicion=$_POST['posicion'];
			if(strcmp($respuesta, "si")==0){
				$con = new Conexion();
				$fechaActual= new Fecha();
				date_default_timezone_set('America/Tegucigalpa');
				$sentenciaSql="INSERT INTO encuestasrealizadas (no_empleado,id_turno,id_posicion,hora_aplicacion,fecha_aplicacion,condicion_optima) VALUES ('".$_SESSION['no_empleado']."',(SELECT id_turno FROM turnos WHERE turno='".$turno."'),(SELECT id_posicion FROM posicion WHERE posicion = '".$posicion."'),'".date('H:i:s')."','".$fechaActual->obtenerFechaSql()."',1);";
				$resultado = $con->ejecutarSql($sentenciaSql);
				if($con->hayError($resultado)==false){
					$con->cerrarConexion();
					echo "finalizar";
				}
				else{
					$con->cerrarConexion();
					echo "error";
				}
			}
			else{
				$con->cerrarConexion();
				echo "evaluar";
			}
		}	
		else{
			echo"error";
		}	
	}
	else{
		echo"error";
	}
?>