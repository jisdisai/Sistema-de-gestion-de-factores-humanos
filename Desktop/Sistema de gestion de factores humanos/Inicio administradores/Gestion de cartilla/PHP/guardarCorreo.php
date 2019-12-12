<?php
	include "conexion.php";
	include "AES.php";
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['nuevoCorreo']) && strcmp($_POST['nuevoCorreo'], '')!=0 && isset($_POST['password_correo']) && strcmp($_POST['password_correo'], '')!=0){
			$nuevoCorreo=$_POST['nuevoCorreo'];
			$password_correo=$_POST['password_correo'];
			$con=new Conexion();
			$insertarCorreo="SELECT correoSistema.id_correo FROM correoSistema";
			$resultado=$con->ejecutarSql($insertarCorreo);
			if($con->cantidadRegistros($resultado)>0){
				$insertarCorreo="UPDATE correoSistema SET correoSistema.correo = '".$nuevoCorreo."', correoSistema.password_correo='".encrypt_decrypt("encrypt",$password_correo)."' WHERE correoSistema.id_correo = 1";
				$resultado=$con->ejecutarSql($insertarCorreo);
				echo "¡Cambio efectuado con éxito!";
			}
			else{
				$insertarCorreo="INSERT INTO correoSistema (correoSistema.correo,correoSistema.password_correo) VALUES ('".$nuevoCorreo."','".encrypt_decrypt("encrypt",$password_correo)."')";
				$resultado=$con->ejecutarSql($insertarCorreo);
				echo "¡Cambio efectuado con éxito!";
			}
		}
		else{
			echo "eror";
		}
	}
	else{
		echo "error";
	}
?>