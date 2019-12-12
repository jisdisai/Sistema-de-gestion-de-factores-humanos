<?php
	include "conexion.php";
	include "AES.php";
	session_start();
	if(!empty($_SESSION)){
		$con=new Conexion();
		$consultaCorreo="SELECT correosistema.correo, correosistema.password_correo FROM correosistema";
		$resultado=$con->ejecutarSql($consultaCorreo);
		$innerHTML="";
		if($con->cantidadRegistros($resultado)==1){
			$registroCorreo=$con->obtenerFila($resultado);
			$innerHTML=$innerHTML."document.getElementById('entrada_correo').value='".$registroCorreo['correo']."';";
			$innerHTML=$innerHTML."document.getElementById('entrada_password').value='".utf8_encode(encrypt_decrypt("decrypt",$registroCorreo['password_correo']))."';";
			echo utf8_encode($innerHTML);
		}
		else{
			echo("alert('Hay más de una cuenta de correo asociada al sistema');");
		}
	}
	else{
		echo "alert('Erro al obtener la cuenta de correo del sistema');";
	}
?>