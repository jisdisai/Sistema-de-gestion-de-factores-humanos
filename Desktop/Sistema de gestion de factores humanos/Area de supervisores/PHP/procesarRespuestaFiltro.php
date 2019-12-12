<?php
	include('conexion.php');
	include('fecha.php');
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['respuesta']) && isset($_POST['turno']) && isset($_POST['posicion'])&&isset($_POST['idEncuesta']) && isset($_POST['fecha_encuesta']) && isset($_POST['hora_encuesta'])){
			$respuesta=$_POST['respuesta'];
			$turno=$_POST['turno'];
			$posicion=$_POST['posicion'];
			$con = new Conexion();
			if(strcmp($respuesta, "si")==0){
				
				$fechaActual= new Fecha();
				date_default_timezone_set('America/Tegucigalpa');
				if(strcmp($_POST['idEncuesta'], 'no')!=0){
					
					$sentenciaSql="DELETE FROM respuestascerradas_x_evaluacionestado WHERE respuestascerradas_x_evaluacionestado.id_evaluacionEstado IN (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada='".$_POST['idEncuesta']."')";
					$resultado=$con->ejecutarSql($sentenciaSql);

					$sentenciaSql="DELETE FROM respuestasescalas_x_evaluacionestado WHERE respuestasescalas_x_evaluacionestado.id_evaluacionEstado IN (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada='".$_POST['idEncuesta']."')";
					$resultado=$con->ejecutarSql($sentenciaSql);

					$sentenciaSql="DELETE FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada='".$_POST['idEncuesta']."'";
					$resultado=$con->ejecutarSql($sentenciaSql);

					$sentenciaSql="UPDATE encuestasrealizadas SET fecha_aplicacion='".$_POST['fecha_encuesta']."', hora_aplicacion='".$_POST['hora_encuesta']."', id_posicion=(SELECT posicion.id_posicion FROM posicion WHERE posicion.posicion='".$posicion."'), id_turno=(SELECT turnos.id_turno FROM turnos WHERE turnos.turno='".$turno."'),no_empleado='".$_POST['no_empleado']."',condicion_optima=1 WHERE encuestasrealizadas.id_encuestasRealizada=".$_POST['idEncuesta'];
					
					$resultado = $con->ejecutarSql($sentenciaSql);
					echo "finalizar";
					
				}	
				else{
					$sentenciaSql="INSERT INTO encuestasrealizadas (no_empleado,id_turno,id_posicion,hora_aplicacion,fecha_aplicacion,condicion_optima) VALUES ('".$_POST['no_empleado']."',(SELECT id_turno FROM turnos WHERE turno='".$turno."'),(SELECT id_posicion FROM posicion WHERE posicion = '".$posicion."'),'".$_POST['hora_encuesta']."','".$_POST['fecha_encuesta']."',1);";
					$resultado = $con->ejecutarSql($sentenciaSql);
					if($con->hayError($resultado)==false){
						$con->cerrarConexion();
						echo "finalizar";
					}
					else{
						$con->cerrarConexion();
						echo "error";
					}
				}
				//$consultaEncuesta="SELECT encuestasrealizadas.id_encuestasRealizada FROM encuestasrealizadas WHERE encuestasrealizadas.id_encuestasRealizada=".$_POST['idEncuesta'];
				//$resultadoEncuesta=$con->ejecutarSql($consultaEncuesta);

				
				
				//echo $consultaEncuesta;

				
			}
			else{
				$con->cerrarConexion();
				echo "evaluar";
			}
		}	
		else{
			echo"error";
		}	
	}
	else{
		echo"error";
	}
?>