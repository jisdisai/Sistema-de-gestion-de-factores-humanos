<?php
	include('conexion.php');
	include('fecha.php');
	include 'correo.php';
	session_start();
	if(!empty($_SESSION)) {
		if(isset($_POST['area']) && isset($_POST['respuestas']) && isset($_POST['turno']) && isset($_POST['posicion']) && isset($_POST['fecha_encuesta']) && isset($_POST['hora_encuesta']) && isset($_POST['id_encuesta']) && isset($_POST['no_controlador'])){
			$respuestas=preg_split('[;]', $_POST['respuestas']);
			$posicion="(SELECT id_posicion FROM posicion WHERE posicion = '".$_POST['posicion']."')";
			$turno="(SELECT id_turno FROM turnos WHERE turno = '".$_POST['turno']."')";
			$fecha=new Fecha();
			$fecha_aplicacion=$_POST['fecha_encuesta'];
			$hora_aplicacion=$_POST['hora_encuesta'];
			$area=$_POST['area'];
			$id_encuesta=$_POST['id_encuesta'];
			$no_empleado=$_POST['no_controlador'];
			$con=new Conexion();

			if(strcmp($id_encuesta, 'no')==0){
				$sql="INSERT INTO encuestasrealizadas (no_empleado,id_turno,id_posicion,hora_aplicacion,fecha_aplicacion,condicion_optima) VALUES ('".$no_empleado."',".$turno.",".$posicion.",'".$hora_aplicacion."','".$fecha_aplicacion."',0)";			
				$resultado=$con->ejecutarSql($sql);
				
				$sql="SELECT id_encuestasRealizada FROM `encuestasrealizadas` WHERE (no_empleado='".$no_empleado."') AND (hora_aplicacion='".$hora_aplicacion."') AND (fecha_aplicacion='".$fecha_aplicacion."')";
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


						$correo=new Correo();
						$consultaNombreEmpleado="SELECT personal.nombres, personal.apellidos  FROM personal WHERE personal.no_empleado='".$no_empleado."'";
					

						$resultadoNombreEmpleado=$con->ejecutarSql($consultaNombreEmpleado);
						if($con->cantidadRegistros($resultadoNombreEmpleado)==1){
							$registroNombreEmpleado=$con->obtenerFila($resultadoNombreEmpleado);
							$mensaje="El empleado ".$registroNombreEmpleado['nombres']." ".$registroNombreEmpleado['apellidos']."(".$no_empleado.") ha indicado no estar en condiciones óptimas para trabajar y ha sido evaluado en el área de ".$area.". Momento del suceso: ".$fecha_aplicacion." (".$hora_aplicacion.").";

								$correo->enviarCorreo($mensaje);

						}

						$con->cerrarConexion();
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

			}//no_encuesta
			else{
				$sentenciaSql="DELETE FROM respuestascerradas_x_evaluacionestado WHERE respuestascerradas_x_evaluacionestado.id_evaluacionEstado IN (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada='".$id_encuesta."')";
				$resultado=$con->ejecutarSql($sentenciaSql);

				

				$sentenciaSql="DELETE FROM respuestasescalas_x_evaluacionestado WHERE respuestasescalas_x_evaluacionestado.id_evaluacionEstado IN (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada='".$id_encuesta."')";
				$resultado=$con->ejecutarSql($sentenciaSql);

				$sentenciaSql="UPDATE evaluacionestado SET evaluacionestado.idAreaEvaluacion= (SELECT idAreaEvaluacion FROM areaEvaluacion WHERE descripcionAreaEvaluacion = '".$area."') WHERE evaluacionestado.id_encuestasRealizada=".$id_encuesta;
				$resultado=$con->ejecutarSql($sentenciaSql);

				$sql="SELECT id_evaluacionEstado FROM evaluacionestado WHERE id_encuestasRealizada=".$id_encuesta;
				$resultado=$con->ejecutarSql($sql);
				$registro=$con->obtenerFila($resultado);
				if($con->cantidadRegistros($resultado)==1 && strcmp($registro['id_evaluacionEstado'], '')!=0){
					
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
					$correo=new Correo();
						$consultaNombreEmpleado="SELECT personal.nombres, personal.apellidos  FROM personal WHERE personal.no_empleado='".$no_empleado."'";
					

						$resultadoNombreEmpleado=$con->ejecutarSql($consultaNombreEmpleado);
						if($con->cantidadRegistros($resultadoNombreEmpleado)==1){
							$registroNombreEmpleado=$con->obtenerFila($resultadoNombreEmpleado);
							$mensaje="El empleado ".$registroNombreEmpleado['nombres']." ".$registroNombreEmpleado['apellidos']."(".$no_empleado.") ha indicado no estar en condiciones óptimas para trabajar y ha sido evaluado en el área de ".$area.". Momento del suceso: ".$fecha_aplicacion." (".$hora_aplicacion.").";

								$correo->enviarCorreo($mensaje);

						}
					$con->cerrarConexion();
					echo "respuestas guardadas";
				}
				else{
					$sql="UPDATE encuestasrealizadas set encuestasrealizadas.condicion_optima = 0 WHERE encuestasrealizadas.id_encuestasRealizada=".$id_encuesta;
					$resultado=$con->ejecutarSql($sql);

					$sql="INSERT INTO evaluacionestado (idAreaEvaluacion,id_encuestasRealizada) VALUES ((SELECT idAreaEvaluacion FROM areaEvaluacion WHERE descripcionAreaEvaluacion = '".$area."'),".$id_encuesta.")";

					$resultado=$con->ejecutarSql($sql);
					$id_evaluacionEstado="(SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada=".$id_encuesta.")";
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
					$correo=new Correo();
						$consultaNombreEmpleado="SELECT personal.nombres, personal.apellidos  FROM personal WHERE personal.no_empleado='".$no_empleado."'";
					

						$resultadoNombreEmpleado=$con->ejecutarSql($consultaNombreEmpleado);
						if($con->cantidadRegistros($resultadoNombreEmpleado)==1){
							$registroNombreEmpleado=$con->obtenerFila($resultadoNombreEmpleado);
							$mensaje="El empleado ".$registroNombreEmpleado['nombres']." ".$registroNombreEmpleado['apellidos']."(".$no_empleado.") ha indicado no estar en condiciones óptimas para trabajar y ha sido evaluado en el área de ".$area.". Momento del suceso: ".$fecha_aplicacion." (".$hora_aplicacion.").";

								$correo->enviarCorreo($mensaje);

						}
					echo "respuestas guardadas";
				}

			}//no_encuesta
			
		}//isset
		else{
			echo "error de los issets";
		}		
	}//sesion
	else{
		echo"error";
	}

?>