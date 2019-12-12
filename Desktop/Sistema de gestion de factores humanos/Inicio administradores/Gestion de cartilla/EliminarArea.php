<?php
	session_start();
	if(!empty($_SESSION)){
		$con=mysqli_connect('localhost','root','','cocesna');
		$consulta=utf8_decode("DELETE FROM respuestascerradas_x_evaluacionestado WHERE idPregunta IN (SELECT pregunta.idPregunta FROM pregunta WHERE pregunta.idAreaEvaluacion IN (SELECT areaevaluacion.idAreaEvaluacion FROM areaevaluacion WHERE areaevaluacion.descripcionAreaEvaluacion='".$_POST['area']."'))");
		$resultado=$con->query($consulta);

		$consulta=utf8_decode("DELETE FROM respuestasescalas_x_evaluacionestado WHERE idPregunta IN (SELECT pregunta.idPregunta FROM pregunta WHERE pregunta.idAreaEvaluacion IN (SELECT areaevaluacion.idAreaEvaluacion FROM areaevaluacion WHERE areaevaluacion.descripcionAreaEvaluacion='".$_POST['area']."'))");
		$resultado=$con->query($consulta);

		$consulta="SELECT encuestasrealizadas.id_encuestasRealizada FROM encuestasrealizadas WHERE encuestasrealizadas.id_encuestasRealizada IN (SELECT evaluacionestado.id_encuestasRealizada FROM evaluacionestado WHERE evaluacionestado.idAreaEvaluacion IN (SELECT areaevaluacion.idAreaEvaluacion FROM areaevaluacion WHERE areaevaluacion.descripcionAreaEvaluacion='".$_POST['area']."'))";
		
		$resultadoEncuesta=$con->query($consulta);
		for($i=0; $i<mysqli_num_rows($resultadoEncuesta); $i++){
			$registroEncuesta=mysqli_fetch_array($resultadoEncuesta);
			$id_encuesta=$registroEncuesta['id_encuestasRealizada'];
			$consulta="DELETE FROM encuestasrealizadas WHERE encuestasrealizadas.id_encuestasRealizada=".$id_encuesta;
			$resultado=$con->query($consulta);

		}

		



		$consulta=utf8_decode("DELETE  FROM evaluacionestado WHERE idAreaEvaluacion = (SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion = '".$_POST['area']."')");
		$resultado=$con->query($consulta);

		$consulta=utf8_decode("DELETE FROM rangorespuestasescalaxpregunta WHERE idPregunta IN (SELECT idPregunta FROM pregunta WHERE idAreaEvaluacion = (SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion = '".$_POST['area']."'))");
		$resultado=$con->query($consulta);
		//echo("<br>".$consulta);
		//echo("<br>".mysqli_error($con));
		$consulta=utf8_decode("DELETE FROM pregunta WHERE idAreaEvaluacion = (SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion = '".$_POST['area']."')");
		$resultado=$con->query($consulta);
		//echo("<br>".$consulta);
		//echo("<br>".mysqli_error($con));
		$consulta=utf8_decode("DELETE FROM areaevaluacion WHERE descripcionAreaEvaluacion = '".$_POST['area']."'");
		$resultado=$con->query($consulta);
		//echo("<br>".$consulta);
		//echo("<br>".mysqli_error($con));

		$detalle=("Eliminó [".($_POST['area'])."] de la lista de áreas de evaluacion");
		$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
		$insertar=$con->query($insertLog);
		//echo("Área eliminada");
	}


?>