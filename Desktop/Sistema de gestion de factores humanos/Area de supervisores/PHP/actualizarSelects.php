<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="document.getElementById('select_posicion').innerHTML='";
		$consultaSql="SELECT posicion FROM posicion";
		$resultado=$con->ejecutarSql($consultaSql);
		if($con->hayError($resultado)==false){
			for($i=0; $i<$con->cantidadRegistros($resultado);$i++){
				$registro=$con->obtenerFila($resultado);
				$innerHTML=$innerHTML."<OPTION>".$registro['posicion']."</OPTION>";
			}
			$innerHTML=$innerHTML."';";
			$innerHTML=$innerHTML."document.getElementById('select_turno').innerHTML='";
			$consultaSql="SELECT turno FROM turnos";
			$resultado=$con->ejecutarSql($consultaSql);
			if($con->hayError($resultado)==false){
				for($i=0; $i<$con->cantidadRegistros($resultado);$i++){
					$registro=$con->obtenerFila($resultado);
					$innerHTML=$innerHTML."<OPTION>".$registro['turno']."</OPTION>";
				}
				$innerHTML=$innerHTML."';";
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