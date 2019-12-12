<?php
	include('fecha.php');
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		setlocale(LC_ALL, "es_ES");
		$fechaActual = new Fecha();
		$con=new Conexion();
		$consultaSql="SELECT * FROM encuestasrealizadas WHERE fecha_aplicacion = '".$fechaActual->obtenerFechaSql()."' AND no_empleado='".$_SESSION['no_empleado']."'";
		$resultado=$con->ejecutarSql($consultaSql);
		$innerHTML="";
		if($con->hayError($resultado)==false){
			if($con->cantidadRegistros($resultado)>0){
				$con->cerrarConexion();
				$innerHTML="
							document.getElementById('div_fechaEvaluacion').innerHTML='Fecha:' +'".$fechaActual->obtenerFechaNormal()."';
							document.getElementById('evaluacionPendiente').style.display='none';
							document.getElementById('evaluacionRealizada').style.display='block';
							document.getElementById('boton_realizarEvaluacion').disabled=true;
							document.getElementById('boton_realizarEvaluacion').style.opacity=0.6;
				";
				echo $innerHTML;
			}
			else{
				$con->cerrarConexion();
				$innerHTML="
							document.getElementById('div_fechaEvaluacion').innerHTML='Fecha: '+'".$fechaActual->obtenerFechaNormal()."';
							document.getElementById('evaluacionPendiente').style.display='block';
							document.getElementById('evaluacionRealizada').style.display='none';
							document.getElementById('boton_realizarEvaluacion').disabled=false;
							document.getElementById('boton_realizarEvaluacion').style.opacity=1;
				";
				echo $innerHTML;
			}
		}
		else{
			$con->cerrarConexion();
			echo "error";
		}
	}
	else{
		echo "error";
	}
?>