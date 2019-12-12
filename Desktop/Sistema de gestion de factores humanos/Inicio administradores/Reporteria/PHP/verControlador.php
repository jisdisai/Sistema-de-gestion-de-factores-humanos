<?php
include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
			$con = new Conexion();
			$innerHTML="";
			$consultaNEmpleado="SELECT encuestasrealizadas.no_empleado FROM encuestasrealizadas WHERE encuestasrealizadas.id_encuestasRealizada='".$_POST['id_encuesta']."'";
			$resultadoNoEmpleado=$con->ejecutarSql($consultaNEmpleado);
			$registroNEmpleado=$con->obtenerFila($resultadoNoEmpleado);
			$no_empleado=$registroNEmpleado['no_empleado'];
			
			$consultaInfo="SELECT encuestasrealizadas.fecha_aplicacion, encuestasrealizadas.hora_aplicacion, usuarios.nombre, personal.sexo, fecha_ingreso, TIMESTAMPDIFF(YEAR,personal.fecha_ingreso,CURDATE()) AS 'years_de_trabajar', TIMESTAMPDIFF (YEAR,personal.fecha_nacimiento,CURDATE()) AS 'edad', turnos.turno, posicion.posicion FROM encuestasrealizadas INNER JOIN usuarios ON encuestasrealizadas.no_empleado = usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno=turnos.id_turno INNER JOIN posicion ON encuestasrealizadas.id_posicion = posicion.id_posicion WHERE encuestasrealizadas.id_encuestasRealizada=".$_POST['id_encuesta'];
					$resultadoInfo=$con->ejecutarSql($consultaInfo);
					$registroInfo=$con->obtenerFila($resultadoInfo);
					$innerHTML=$innerHTML."document.getElementById('valor_momentoAplicacion').innerHTML=\"".$registroInfo['fecha_aplicacion']." (".$registroInfo['hora_aplicacion'].")\";";
					$innerHTML=$innerHTML."document.getElementById('valor_nombreControlador').innerHTML=\"".$registroInfo['nombre']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_generoControlador').innerHTML=\"".$registroInfo['sexo']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_edadControlador').innerHTML=\"".$registroInfo['edad']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_turnoControlador').innerHTML=\"".$registroInfo['turno']."\";";
					$innerHTML=$innerHTML."document.getElementById('Valor_fechaIngresoControlador').innerHTML=\"".$registroInfo['fecha_ingreso']." (".$registroInfo['years_de_trabajar'].utf8_decode(" años)\";");
					$innerHTML=$innerHTML."document.getElementById('valor_posicionControlador').innerHTML=\"".$registroInfo['posicion']."\";";
					$innerHTML=$innerHTML."document.getElementById('valor_condicionControlador').innerHTML=\"Sin fatiga\";";
					$con->cerrarConexion();
					$innerHTML=$innerHTML."window.location=\"#openModal\";";
					echo utf8_encode($innerHTML);
				
	}
	else{
		$con->cerrarConexion();
		echo"error";
	}		
?>