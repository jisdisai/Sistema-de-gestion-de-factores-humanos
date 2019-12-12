<?php
	include ('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="";

		$digito=0;
		$caracterEspecial=0;
		$mayuscula=0;
		$minuscula=0;

		if(isset($_POST['digito']) && isset($_POST['caracterEspecial']) && isset($_POST['mayuscula']) && isset($_POST['minuscula'])){
			if(strcmp($_POST['caracterEspecial'], '1')==0){
				$caracterEspecial=1;
			}
			if(strcmp($_POST['digito'], '1')==0){
				$digito=1;
			}
			if(strcmp($_POST['mayuscula'], '1')==0){
				$mayuscula=1;
			}
			if(strcmp($_POST['minuscula'], '1')==0){
				$minuscula=1;
			}

			$actualizarRequisitos="UPDATE requisitospassword SET caracterEspecial='".$caracterEspecial."', digito='".$digito."', mayuscula='".$mayuscula."', minuscula='".$minuscula."';";
			$resultadoActualizar=$con->ejecutarSql($actualizarRequisitos);
			$con->cerrarConexion();
			$innerHTML=$innerHTML."alert('Los requisitos serán solicitados a partir de la próxima vez que se registre un nuevo usuario o se modifique una contraseña');";
			$innerHTML=$innerHTML."cerrarEdicionRequisitos();";
			echo ($innerHTML);
			
		}
	}
?>