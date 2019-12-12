<?php
	include("conexion.php");
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		if(isset($_POST['id_encuesta'])){
			$sql="DELETE FROM respuestascerradas_x_evaluacionestado WHERE respuestascerradas_x_evaluacionestado.id_evaluacionEstado=(SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada=".$_POST['id_encuesta'].");";
			
			$resultado=$con->ejecutarSql($sql);

			$sql="DELETE FROM respuestasescalas_x_evaluacionestado WHERE respuestasescalas_x_evaluacionestado.id_evaluacionEstado = (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada = ".$_POST['id_encuesta']." );";
			$resultado=$con->ejecutarSql($sql);

			$sql="DELETE FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada = ".$_POST['id_encuesta'].";";
			$resultado=$con->ejecutarSql($sql);

			$sql="DELETE FROM encuestasrealizadas WHERE encuestasrealizadas.id_encuestasRealizada= ".$_POST['id_encuesta'].";";
			$resultado=$con->ejecutarSql($sql);

			if($con->hayError($resultado)){
				echo $con->mostrarError($resultado);
			}
			else{
				echo "Registro Eliminado";
			}
		}
		else{
			$con->cerrarConexion();
			echo "error";
		}
	}
	else{
		echo("error");
	}
?>