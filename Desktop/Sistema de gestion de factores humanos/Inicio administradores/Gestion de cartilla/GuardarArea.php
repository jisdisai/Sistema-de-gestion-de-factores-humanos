<?php
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['descripcionArea'])){
		$con=mysqli_connect('localhost','root','','cocesna');


		$consulta=utf8_decode("INSERT INTO areaevaluacion (descripcionAreaEvaluacion,idCartillaMonitoreoPersonal) VALUES ('".$_POST['descripcionArea']."',1)");
		$resultado=$con->query($consulta);
		$detalle=("Agregó [".($_POST['descripcionArea'])."] como nueva área de evaluacion");
		$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
		$insertar=$con->query($insertLog);
		echo("Nueva área agregada");
		

		}
		else{
			echo "Algo salió mal";
		}
	}
	
?>