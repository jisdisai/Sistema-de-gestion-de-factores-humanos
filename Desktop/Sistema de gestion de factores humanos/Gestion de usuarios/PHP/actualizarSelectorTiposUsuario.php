<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
		$sentenciaSql="SELECT descripcionTipoUsuario FROM tiposusuario";
		$resultado=$con->ejecutarSql($sentenciaSql);
		if($con->hayError($resultado)==false){
			$innerHtml="";
			for($i=0; $i<$con->cantidadRegistros($resultado); $i++){
				$registro=$con->obtenerFila($resultado);
				$innerHtml=$innerHtml."<OPTION id='option_".$registro['descripcionTipoUsuario']."' value='".$registro['descripcionTipoUsuario']."'>".$registro['descripcionTipoUsuario']."</OPTION>";
			}
			$con->cerrarConexion();
			echo $innerHtml;
		}
		else{
			$con->cerrarConexion();
			echo "error";
		}
	}
	catch(Exception $e){
		$con->cerrarConexion();
		echo "error";
	}
?>