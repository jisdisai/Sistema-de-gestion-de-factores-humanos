<?php
	if(isset($_POST['afirmativaSeleccionada']) && isset($_POST['negativaSeleccionada'])){
		$con=mysqli_connect('localhost','root','','cocesna');
		$consulta=utf8_decode("UPDATE respuestafiltroxaccion SET idAccionRespuestaFiltro = (SELECT idAccionRespuestaFiltro FROM accionrespuestafiltro WHERE descripcionAccion = '".$_POST['afirmativaSeleccionada']."') WHERE valorRespuesta ='Si'");
		$resultado=$con->query($consulta);

		$error1 = mysqli_error($con);

		$consulta2=utf8_decode("UPDATE respuestafiltroxaccion SET idAccionRespuestaFiltro = (SELECT idAccionRespuestaFiltro FROM accionrespuestafiltro WHERE descripcionAccion = '".$_POST['negativaSeleccionada']."') WHERE valorRespuesta ='No'");
		$resultado=$con->query($consulta2);
		$error2=mysqli_error($con);

	}
	else{
		echo "Algo salió mal";
	}
?>
	

