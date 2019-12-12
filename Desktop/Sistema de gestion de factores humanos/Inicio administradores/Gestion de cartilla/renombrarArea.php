<?php
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['old_nombre']) && isset($_POST['new_nombre'])){
			$con=mysqli_connect('localhost','root','','cocesna');
			$consultaArea=utf8_decode("SELECT * FROM areaevaluacion WHERE areaevaluacion.descripcionAreaEvaluacion='".$_POST['old_nombre']."'");
			$resultadoArea=$con->query($consultaArea);
			$registroArea=$resultadoArea->fetch_assoc();
			$actualizar="UPDATE areaevaluacion SET descripcionAreaEvaluacion='".$_POST['new_nombre']."' WHERE idAreaEvaluacion='".$registroArea['idAreaEvaluacion']."'";
			$resultadoActualizar=$con->query($actualizar);

			$detalle="Renombró el área [".$_POST['old_nombre']."]. Nuevo valor: [".$_POST['new_nombre']."]";
			$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
			$insertar=$con->query($insertLog);

			echo "¡Cambios efectuados con éxito!";
		}
		else{
			echo "Error";
		}
		
	}


?>