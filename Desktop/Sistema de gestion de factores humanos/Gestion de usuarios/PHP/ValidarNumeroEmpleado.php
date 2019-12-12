<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			if(isset($_POST['numeroEmpleado'])){
				$numeroEmpleado=$_POST['numeroEmpleado'];
				$sentenciaSql="SELECT * FROM usuarios WHERE no_empleado='".$numeroEmpleado."'";
				$resultado=$con->ejecutarSql($sentenciaSql);
				if($con->hayError($resultado)==false){
					if($con->cantidadRegistros($resultado)>0){
						$con->cerrarConexion();
						echo"duplicidad";
					}
					else{
						$con->cerrarConexion();
						echo"numeroValido";
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