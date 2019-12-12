<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="document.getElementById('listaAreaEvaluacion').innerHTML='";
		$consultaSql="SELECT descripcionAreaEvaluacion FROM areaevaluacion;";
		$resultado=$con->ejecutarSql($consultaSql);
		if($con->hayError($resultado)==false){
			if($con->cantidadRegistros($resultado)>0){
				for($i=0;$i<$con->cantidadRegistros($resultado);$i++){
					$registro=$con->obtenerFila($resultado);
					$innerHTML=$innerHTML."<DIV id=\"div_".$registro['descripcionAreaEvaluacion']."\" class=\"areaEvaluacion\" onclick=\"seleccionarArea(\'div_".$registro['descripcionAreaEvaluacion']."\')\" >".$registro['descripcionAreaEvaluacion']."</DIV>";
				}
				$innerHTML=$innerHTML."';";
				$con->cerrarConexion();
				echo utf8_encode($innerHTML);
			}
			else{
				$innerHTML=$innerHTML."<h4>No hay Áreas disponibles</h4>';";
				$con->cerrarConexion();
				echo $innerHTML;
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