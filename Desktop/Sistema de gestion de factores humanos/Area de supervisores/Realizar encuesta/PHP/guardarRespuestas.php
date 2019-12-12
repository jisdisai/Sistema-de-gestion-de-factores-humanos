<?php
	include('conexion.php');
	include('fecha.php');
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['area']) && isset($_POST['respuestas']) && isset($_POST['turno']) &&isset($_POST['posicion'])){
			$respuestas=preg_split('[;]', $_POST['respuestas']);
			$posicion="(SELECT id_posicion FROM posicion WHERE posicion = '".$_POST['posicion']."')";
			$turno="(SELECT id_turno FROM turnos WHERE turno = '".$_POST['turno']."')";
			$fecha=new Fecha();
			$fecha_aplicacion=$fecha->obtenerFechaSql();
			$hora_aplicacion=date("H:i:s");
			$area=$_POST['area'];
			$sql="INSERT INTO encuestasrealizadas (no_empleado,id_turno,id_posicion,hora_aplicacion,fecha_aplicacion,condicion_optima) VALUES ('".$_SESSION['no_empleado']."',".$turno.",".$posicion.",'".$hora_aplicacion."','".$fecha_aplicacion."',0)";
			$con=new Conexion();
			$resultado=$con->ejecutarSql($sql);
			$sql="SELECT id_encuestasRealizada FROM `encuestasrealizadas` WHERE (no_empleado='".$_SESSION['no_empleado']."') AND (hora_aplicacion='".$hora_aplicacion."') AND (fecha_aplicacion='".$fecha_aplicacion."')";
			$resultado=$con->ejecutarSql($sql);
			if($con->cantidadRegistros($resultado)==1){
				$registro=$con->obtenerFila($resultado);
				$id_encuesta=$registro['id_encuestasRealizada'];

				$sql="INSERT INTO evaluacionestado (idAreaEvaluacion,id_encuestasRealizada) VALUES ((SELECT idAreaEvaluacion FROM areaEvaluacion WHERE descripcionAreaEvaluacion = '".$area."'),".$id_encuesta.")";
				$resultado=$con->ejecutarSql($sql);

				$sql="SELECT id_evaluacionEstado FROM evaluacionestado WHERE id_encuestasRealizada=".$id_encuesta;
				$resultado=$con->ejecutarSql($sql);
				if($con->cantidadRegistros($resultado)==1){
					$registro=$con->obtenerFila($resultado);
					$id_evaluacionEstado=$registro['id_evaluacionEstado'];
					$sql="";
					for($i=0;$i<count($respuestas)-1;$i++){
					
						$tipoRespuesta=preg_split('[:]',( preg_split( '[-]', $respuestas[$i] )[2] ) )[0];
						$id_pregunta=preg_split('[-]', $respuestas[$i])[1];
								
						if( strcmp($tipoRespuesta,'1' ) == 0 ){
							$respuestaCerrada=preg_split('[:]',( preg_split( '[-]', $respuestas[$i] )[2] ) )[1];							
							$sql="INSERT INTO respuestascerradas_x_evaluacionestado (idPregunta,id_evaluacionEstado,respuestaCerrada) VALUES (".$id_pregunta.",".$id_evaluacionEstado.",'".$respuestaCerrada."')";
							$resultado=$con->ejecutarSql($sql);

						}
						else{
							$respuestaEscala=preg_split('[:]',( preg_split( '[-]', $respuestas[$i] )[2] ) )[1];
							$sql="INSERT INTO respuestasescalas_x_evaluacionestado (idPregunta,id_evaluacionEstado,respuestaEscala) VALUES (".$id_pregunta.",".$id_evaluacionEstado.",".$respuestaEscala.")";
							$resultado=$con->ejecutarSql($sql);						
						}
						
					}
					echo "respuestas guardadas";
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
		else{
			echo "error";
		}
				
		
	}
	else{
		echo"error";
	}
?>