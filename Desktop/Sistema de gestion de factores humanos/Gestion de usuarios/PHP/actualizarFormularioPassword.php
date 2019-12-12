<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			$sentenciaSql="SELECT digito,mayuscula,minuscula,caracterEspecial FROM requisitosPassword where (digito=1) OR (mayuscula=1) OR (caracterEspecial=1) OR (minuscula=1)";
			$resultado=$con->ejecutarSql($sentenciaSql);
			$innerHTML="";
			if($con->hayError($resultado)==false){
				if($con->cantidadRegistros($resultado)==1){
					$innerHTML="Introduce una contraseña que cumpla con los siguientes requisitos: <BR><CENTER><UL>";
					$registro=$con->obtenerFila($resultado);
						
					if ((int)$registro['digito'] == 1){
						$innerHTML=$innerHTML."<LI style='width: 40%'>Incluir al menos un dígito.</LI>";
					}
					if((int)$registro['mayuscula']){
						$innerHTML=$innerHTML."<LI style='width: 40%'>Incluir al menos una letra mayúscula.</LI>";
					}
					if((int)$registro['minuscula']){
						$innerHTML=$innerHTML."<LI style='width: 40%'>Incluir al menos una letra minúscula.</LI>";
					}
					if((int)$registro['caracterEspecial']){
						$innerHTML=$innerHTML."<LI style='width: 40%'>Incluir al menos un caracter especial.</LI>";
					}
					$innerHTML=$innerHTML."</CENTER></UL>";
					$con->cerrarConexion();
					echo $innerHTML;
					}
				else{
					$con->cerrarConexion();
					echo $innerHTML;
				}				
			}
			else{
				$con->cerrarConexion();
				echo "error";
			}
	}
	catch(Exception $e){
		$con->cerrarConexion();
		echo "error";
	}

?>