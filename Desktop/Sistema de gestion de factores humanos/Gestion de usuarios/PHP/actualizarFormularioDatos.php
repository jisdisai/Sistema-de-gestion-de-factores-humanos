<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			if(isset($_POST['numeroEmpleado'])){
				$numeroEmpleado=$_POST['numeroEmpleado'];
				$sentenciaSql="SELECT * FROM personal WHERE no_empleado='".$numeroEmpleado."'";
				$resultado=$con->ejecutarSql($sentenciaSql);
				$innerHTML="";
				if($con->hayError($resultado)==false){
					if($con->cantidadRegistros($resultado)==1){
						$registro=$con->obtenerFila($resultado);
						$innerHTML="
							document.getElementById('NUEmpleado2').value='".$registro['no_empleado']."';
							document.getElementById('nombreUsuario').value='".utf8_encode($registro['nombres'])." ".utf8_encode($registro['apellidos'])."';
						";
						$con->cerrarConexion();
						echo $innerHTML;
					}
					else{
						$con->cerrarConexion();
						echo "error";
					}				
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