<?php
	include ('conexion.php');
	include ('AES.php');
	try{
		$con=new Conexion();
			if(isset($_POST['no_empleado'])){
				$no_empleado=$_POST['no_empleado'];
				$sentenciaSql="SELECT password FROM usuarios WHERE no_empleado='".$no_empleado."'";
				$resultado=$con->ejecutarSql($sentenciaSql);
				if($con->hayError($resultado)==false){
					$registro=$con->obtenerFila($resultado);
					if($con->cantidadRegistros($resultado)==1){
						$passwordDesencriptada=encrypt_decrypt("decrypt",$registro['password']);
						echo $passwordDesencriptada;
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