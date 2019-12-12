<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			if(isset($_POST['no_empleado'])){
				$no_empleado=$_POST['no_empleado'];

				$consulta="DELETE FROM respuestascerradas_x_evaluacionestado WHERE respuestascerradas_x_evaluacionestado.id_evaluacionEstado IN (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada IN (SELECT encuestasrealizadas.id_encuestasRealizada FROM encuestasrealizadas WHERE encuestasrealizadas.no_empleado= '".$no_empleado."'))";
				$resultado=$con->ejecutarSql($consulta);

				$consulta="DELETE FROM respuestasescalas_x_evaluacionestado WHERE respuestasescalas_x_evaluacionestado.id_evaluacionEstado IN (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada IN (SELECT encuestasrealizadas.id_encuestasRealizada FROM encuestasrealizadas WHERE encuestasrealizadas.no_empleado= '".$no_empleado."') )";
				$resultado=$con->ejecutarSql($consulta);

				$consulta="DELETE FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada IN (SELECT encuestasrealizadas.id_encuestasRealizada FROM encuestasrealizadas WHERE encuestasrealizadas.no_empleado = '".$no_empleado."')";
				$resultado=$con->ejecutarSql($consulta);

				$consulta="DELETE FROM encuestasrealizadas WHERE encuestasrealizadas.no_empleado = '".$no_empleado."'";
				$resultado=$con->ejecutarSql($consulta);


				$sentenciaSql="DELETE FROM usuarios WHERE no_empleado='".$no_empleado."'";
				$resultado=$con->ejecutarSql($sentenciaSql);
				
				if($con->hayError($resultado)==false){
					$con->cerrarConexion();
					echo "Usuario eliminado";
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