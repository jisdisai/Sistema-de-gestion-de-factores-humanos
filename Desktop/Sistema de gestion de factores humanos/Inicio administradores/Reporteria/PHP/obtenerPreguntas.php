<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){

			$no_empleado=$_SESSION['no_empleado'];
			$con = new Conexion();
			$innerHTML="";
			$consultaPreguntas="SELECT * FROM pregunta WHERE pregunta.idAreaEvaluacion = (SELECT evaluacionestado.idAreaEvaluacion FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada=".$_POST['no_encuesta'].") ORDER BY idPregunta ASC";
			$resultadoPreguntas=$con->ejecutarSql($consultaPreguntas);
			if($con->hayError($resultadoPreguntas)==false) {
				if($con->cantidadRegistros($resultadoPreguntas) > 0){
					$innerHTML="document.getElementById('tabla_Peguntas').innerHTML=\"";
					for($i=0; $i<$con->cantidadRegistros($resultadoPreguntas); $i++){
						$registroPreguntas=$con->obtenerFila($resultadoPreguntas);
						$innerHTML=$innerHTML."<TR class='filaTablaPreguntas'>";
						$innerHTML=$innerHTML."<TD class='campo_noPregunta'>".($i+1)."</TD>";
						$innerHTML=$innerHTML."<TD class='campoSintomaPregunta'>".$registroPreguntas['descripcionPregunta']."</TD>";
						if(strcmp($registroPreguntas['idTipoRespuesta'],'1')==0){
							$consultaRespuesta="SELECT respuestascerradas_x_evaluacionestado.respuestaCerrada FROM respuestascerradas_x_evaluacionestado WHERE id_evaluacionEstado = (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada=".$_POST['no_encuesta'].") AND respuestascerradas_x_evaluacionestado.idPregunta=".$registroPreguntas['idPregunta'];
							$resultadoRespuesta=$con->ejecutarSql($consultaRespuesta);
							$registroRespuesta=$con->obtenerFila($resultadoRespuesta);
							$innerHTML=$innerHTML."<TD class='campo_RespuestaPregunta'>".$registroRespuesta['respuestaCerrada']."</TD>";
						}
						else{							
							$consultaRespuesta="SELECT respuestasescalas_x_evaluacionestado.respuestaEscala FROM respuestasescalas_x_evaluacionestado WHERE id_evaluacionEstado = (SELECT evaluacionestado.id_evaluacionEstado FROM evaluacionestado WHERE evaluacionestado.id_encuestasRealizada=".$_POST['no_encuesta'].") AND respuestasescalas_x_evaluacionestado.idPregunta=".$registroPreguntas['idPregunta'];
							$resultadoRespuesta=$con->ejecutarSql($consultaRespuesta);
							$registroRespuesta=$con->obtenerFila($resultadoRespuesta);							
							$innerHTML=$innerHTML."<TD class='campo_RespuestaPregunta'>".$registroRespuesta['respuestaEscala']."</TD>";
						}
						$innerHTML=$innerHTML."</TR>";
					}
					$innerHTML=$innerHTML."\";";
					$consultaInfo="SELECT encuestasrealizadas.fecha_aplicacion, encuestasrealizadas.hora_aplicacion, usuarios.nombre, personal.sexo, fecha_ingreso, TIMESTAMPDIFF(YEAR,personal.fecha_ingreso,CURDATE()) AS 'years_de_trabajar', TIMESTAMPDIFF (YEAR,personal.fecha_nacimiento,CURDATE()) AS 'edad', turnos.turno, posicion.posicion, areaevaluacion.descripcionAreaEvaluacion FROM encuestasrealizadas INNER JOIN usuarios ON encuestasrealizadas.no_empleado = usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno=turnos.id_turno INNER JOIN posicion ON encuestasrealizadas.id_posicion = posicion.id_posicion INNER JOIN evaluacionestado ON encuestasrealizadas.id_encuestasRealizada = evaluacionestado.id_encuestasRealizada INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion = areaevaluacion.idAreaEvaluacion WHERE encuestasrealizadas.id_encuestasRealizada=".$_POST['no_encuesta'];
					$resultadoInfo=$con->ejecutarSql($consultaInfo);
					$registroInfo=$con->obtenerFila($resultadoInfo);
					$innerHTML=$innerHTML."document.getElementById('valor_momentoAplicacion').innerHTML=\"".$registroInfo['fecha_aplicacion']." (".$registroInfo['hora_aplicacion'].")\";";
					$innerHTML=$innerHTML."document.getElementById('valor_nombreControlador').innerHTML=\"".$registroInfo['nombre']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_generoControlador').innerHTML=\"".$registroInfo['sexo']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_edadControlador').innerHTML=\"".$registroInfo['edad']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_turnoControlador').innerHTML=\"".$registroInfo['turno']."\";";
					$innerHTML=$innerHTML."document.getElementById('Valor_fechaIngresoControlador').innerHTML=\"".$registroInfo['fecha_ingreso']." (".$registroInfo['years_de_trabajar'].utf8_decode(" años)\";");
					$innerHTML=$innerHTML."document.getElementById('valor_posicionControlador').innerHTML=\"".$registroInfo['posicion']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_condicionControlador').innerHTML=\"".$registroInfo['descripcionAreaEvaluacion']."\";";
					$con->cerrarConexion();
					echo utf8_encode($innerHTML);
				}
				else{
					//$innerHTML="<TR style='width:100%'><TD style='width:100%; text-align:center; font-family: sans-serif'><h4>No hay Preguntas Definidas en esta encuesta</h4><TD></TR><SCRIPT type=\"text/javascript\">document.getElementById('boton_siguienteAreaEvaluacion').disabled=true;document.getElementById('boton_siguienteAreaEvaluacion').style.opacity=0.6;</SCRIPT>";//

					$con->cerrarConexion();
					//echo $innerHTML;
					echo "sinpreguntas";
				}
			}
			else{
				$con->cerrarConexion();
				echo"error";
			}
		
				
		
	}
	else{
		echo"error";
	}
?>
