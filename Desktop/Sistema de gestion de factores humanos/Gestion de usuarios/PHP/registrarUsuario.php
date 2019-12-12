<?php
//'numeroEmpleado':numeroEmpleado,'nombreUsuario':nombreUsuario,'password':password,'correoUsuario':correoUsuario,'tipoUsuario':tipoUsuario
	include('conexion.php');
	include('AES.php');
	if( isset($_POST['numeroEmpleado']) && isset($_POST['nombreUsuario']) && isset($_POST['password']) && isset($_POST['correoUsuario']) && isset($_POST['tipoUsuario']) ){
		$numeroEmpleado=$_POST['numeroEmpleado'];
		$nombreUsuario=$_POST['nombreUsuario'];
		$password=$_POST['password'];
		$correoUsuario=$_POST['correoUsuario'];
		$tipoUsuario=$_POST['tipoUsuario'];
		
		$con=new Conexion();

		$passwordLetrasMayusculas = preg_match_all('/([A-Z]{1})/',$password,$foo);

		$mayuscula=0;
		$minuscula=0;
		$digito=0;
		$caracterEspecial=0;

		for ($i=0; $i<strlen($password); $i++){
			if(ctype_upper ($password[$i])){
				$mayuscula=$mayuscula+1;
			}
			if(ctype_lower($password[$i])){
				$minuscula=$minuscula+1;
			}
			if(is_numeric ($password[$i])){
				$digito=$digito+1;
			}
			if((ctype_alpha ($password[$i])==false) && (is_numeric($password[$i])==false)){
				$caracterEspecial=$caracterEspecial+1;
			}
		}

		$sentenciaSql="SELECT digito,mayuscula,minuscula,caracterEspecial FROM requisitosPassword where (digito=1) OR (mayuscula=1) OR (caracterEspecial=1) OR (minuscula=1)";
		$resultado=$con->ejecutarSql($sentenciaSql);
		$errorRequisito="La contraseña no cumple con los siguientes requisitos:";
		$contadorErroresRequisitos=0;
		if($con->hayError($resultado)==false){
					if($con->cantidadRegistros($resultado)==1){
					$registro=$con->obtenerFila($resultado);
						if( ((int)$registro['digito']==1) && ($digito==0) ){
							$errorRequisito=$errorRequisito."\nLa contraseña debe tener al menos un dígito.";
							$contadorErroresRequisitos=$contadorErroresRequisitos+1;
						}
						if( ((int)$registro['mayuscula']==1) && ($mayuscula==0) ){
							$errorRequisito=$errorRequisito."\nLa contraseña debe tener al menos una letra mayúscula.";
							$contadorErroresRequisitos=$contadorErroresRequisitos+1;
						}
						if( ((int)$registro['minuscula']==1) && ($minuscula==0) ){
							$errorRequisito=$errorRequisito."\nLa contraseña debe tener al menos una letra minúscula .";
							$contadorErroresRequisitos=$contadorErroresRequisitos+1;
						}
						if( ((int)$registro['caracterEspecial']==1) && ($caracterEspecial==0) ){
							$errorRequisito=$errorRequisito."\nLa contraseña debe tener al menos un caracterEspecial.";
							$contadorErroresRequisitos=$contadorErroresRequisitos+1;
						}

						if($contadorErroresRequisitos>0){
							echo $errorRequisito;
						}
						else{
							$passwordEncriptada=encrypt_decrypt('encrypt', $password);
							$sentenciaSql="INSERT INTO usuarios (`no_empleado`,`nombre`,`correo`,`idTipoUsuario`,`password`) VALUES ('".$numeroEmpleado."','".$nombreUsuario."', '".$correoUsuario."',(SELECT idTipoUsuario FROM tiposusuario WHERE descripcionTipoUsuario='".$tipoUsuario."'),'".$passwordEncriptada."')";
							$resultado=$con->ejecutarSql($sentenciaSql);
							if($con->hayError($resultado)==false){
								echo("¡Usuario registrado con éxito!");
							}
							else{
								echo"Error al registrar usuario: \n".$con->mostrarError($resultado);
							}
						}
						$con->cerrarConexion();
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
		echo"error";
	}
?>