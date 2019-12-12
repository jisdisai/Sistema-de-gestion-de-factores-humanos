<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="";
		$consultaSql="SELECT descripcionPreguntaFiltro FROM preguntafiltro ";
		$resultado=$con->ejecutarSql($consultaSql);
		if($con->hayError($resultado)==false){
			if($con->cantidadRegistros($resultado)==1){
				$registro=$con->obtenerFila($resultado);
				$innerHTML="document.getElementById('descripcionPreguntaFiltro').innerHTML='".$registro['descripcionPreguntaFiltro']."';";
				$con->cerrarConexion();
				echo utf8_encode($innerHTML);
			}
			else{
				$con->cerrarConexion();
				echo"error";
			}
		}
		else{
			$con->cerrarConexion();
			echo "error";
		}
	}
	else{
		echo"error";
	}
?>