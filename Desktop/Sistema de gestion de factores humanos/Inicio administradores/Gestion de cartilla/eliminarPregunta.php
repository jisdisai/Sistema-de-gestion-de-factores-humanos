<?php
	session_start();
	if (isset($_POST['numeroPregunta'])) {

		$con=mysqli_connect('localhost','root','','cocesna');
		$consultaPregunta="SELECT * FROM pregunta WHERE idPregunta=".$_POST['numeroPregunta'];
		$resultadoPregunta=$con->query($consultaPregunta);
		$registroPregunta=$resultadoPregunta->fetch_assoc();
		$consultaArea="SELECT areaevaluacion.descripcionAreaEvaluacion FROM areaEvaluacion WHERE areaevaluacion.idAreaEvaluacion=".$registroPregunta['idAreaEvaluacion'];
		
		$resultadoArea=$con->query($consultaArea);
		$registroArea=$resultadoArea->fetch_assoc(); 
 		$descripcionPregunta=$registroPregunta['descripcionPregunta'];
 		$area=$registroArea['descripcionAreaEvaluacion'];
		if(isset($_POST['tipoRespuesta'])){
			


			if(strcmp ($_POST['tipoRespuesta'] , 'cerrada' ) == 0){
				$consulta="DELETE FROM respuestascerradas_x_evaluacionestado WHERE idPregunta = ".$_POST['numeroPregunta'];
				$resultadoConsulta=$con->query($consulta);	
				$consulta="DELETE FROM pregunta WHERE idpregunta=".$_POST['numeroPregunta'];
				$resultadoConsulta=$con->query($consulta);
				

				$detalle=("Eliminó la pregunta [".utf8_encode($registroPregunta['descripcionPregunta'])."] de tipo [Cerrada] de la encuesta del área de evaluación [".$registroArea['descripcionAreaEvaluacion']."]");
				$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");
									
				$insertar=$con->query($insertLog);

				echo("Pregunta cerrada eliminada");


			}
			else{

				$consulta="DELETE FROM respuestasescalas_x_evaluacionestado WHERE idPregunta = ".$_POST['numeroPregunta'];
				$resultadoConsulta=$con->query($consulta);
				$consulta="DELETE FROM rangorespuestasescalaxpregunta WHERE idPregunta = ".$_POST['numeroPregunta'];
				$resultadoConsulta=$con->query($consulta);
				$consulta="DELETE FROM pregunta WHERE idpregunta=".$_POST['numeroPregunta'];
				$resultadoConsulta=$con->query($consulta);

				$detalle=("Eliminó la pregunta [".utf8_encode($descripcionPregunta)."] de tipo [Escala] de la encuesta del área de evaluación [".$area."]");

				$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
				$insertar=$con->query($insertLog);
				echo("Pregunta escala eliminada");

			}


		}

		
	}
?>