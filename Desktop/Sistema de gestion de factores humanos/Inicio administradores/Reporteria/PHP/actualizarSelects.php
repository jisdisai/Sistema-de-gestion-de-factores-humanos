<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="document.getElementById('select_turno').innerHTML='<OPTION>-Omitir-</OPTION>";
		$consultaSql="SELECT turno FROM turnos";
		$resultado=$con->ejecutarSql($consultaSql);
		if($con->hayError($resultado)==false){
			for($i=0; $i<$con->cantidadRegistros($resultado);$i++){
				$registro=$con->obtenerFila($resultado);
				$innerHTML=$innerHTML."<OPTION>".$registro['turno']."</OPTION>";
			}
			$innerHTML=$innerHTML."';";
			$innerHTML=$innerHTML."document.getElementById('select_condicion').innerHTML='<OPTION>-Omitir-</OPTION><OPTION>Sin fatiga</OPTION>";
			$consultaSql="SELECT descripcionAreaEvaluacion FROM areaevaluacion";
			$resultado=$con->ejecutarSql($consultaSql);
			if($con->hayError($resultado)==false){
				for($i=0; $i<$con->cantidadRegistros($resultado);$i++){
					$registro=$con->obtenerFila($resultado);
					$innerHTML=$innerHTML."<OPTION>".$registro['descripcionAreaEvaluacion']."</OPTION>";
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