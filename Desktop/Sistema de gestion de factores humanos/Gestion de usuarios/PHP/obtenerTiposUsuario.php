<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			if(isset($_POST['idPrefijo']) && isset($_POST['clase'])){
				$idPrefijo=$_POST['idPrefijo'];
				$clase=$_POST['clase'];
				$sentenciaSql="SELECT descripcionTipoUsuario FROM tiposusuario";
				$resultado=$con->ejecutarSql($sentenciaSql);
				if($con->hayError($resultado)==false && $con->cantidadRegistros($resultado)>0){
					$innerHtml="";
					for($i=0; $i<$con->cantidadRegistros($resultado); $i++){
						$registro=$con->obtenerFila($resultado);
						$innerHtml=$innerHtml."<OPTION id='".$idPrefijo.$registro['descripcionTipoUsuario']."' class='".$clase."' value='".$registro['descripcionTipoUsuario']."' >".$registro['descripcionTipoUsuario']."</OPTION>";
					}
					$con->cerrarConexion();
					echo $innerHtml;
				}
				else{
					$con->cerrarConexion();
					echo "error";
				}
			}
			else {
				$con->cerrarConexion();
				echo "error";
			}
	}
	catch(Exception $e){
		$con->cerrarConexion();
		echo "error";
	}

?>