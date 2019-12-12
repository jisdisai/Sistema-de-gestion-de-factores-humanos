<?php
	include ('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="";
		$consultaRequisitos="SELECT requisitospassword.caracterEspecial, requisitospassword.digito, requisitospassword.mayuscula, requisitospassword.minuscula FROM requisitospassword";
		$resultadoRequisitos=$con->ejecutarSql($consultaRequisitos);
		if($con->cantidadRegistros($resultadoRequisitos)==1){
			$registroRequisitos=$con->obtenerFila($resultadoRequisitos);
			if(strcmp($registroRequisitos['caracterEspecial'], '1')==0){
				$innerHTML=$innerHTML."document.getElementById('caracterEspecial').checked=true;";
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('caracterEspecial').checked=false;";
			}
			if(strcmp($registroRequisitos['digito'], '1')==0){
				$innerHTML=$innerHTML."document.getElementById('digito').checked=true;";
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('digito').checked=false;";
			}
			if(strcmp($registroRequisitos['mayuscula'], '1')==0){
				$innerHTML=$innerHTML."document.getElementById('mayuscula').checked=true;";
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('mayuscula').checked=false;";
			}
			if(strcmp($registroRequisitos['minuscula'], '1')==0){
				$innerHTML=$innerHTML."document.getElementById('minuscula').checked=true;";
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('minuscula').checked=false;";
			}
			echo $innerHTML;
		}
	}
?>