<?php
	include ('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con=new Conexion();
		$innerHTML="";
		if(isset($_POST['palabraClave']) OR isset($_POST['fecha'])){
			$consultaUsers="SELECT usuarios.no_empleado, usuarios.nombre FROM usuarios INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado WHERE usuarios.idTipoUsuario IN (SELECT tiposusuario.idTipoUsuario FROM tiposusuario WHERE tiposusuario.descripcionTipoUsuario='Controlador') ";
			if(isset($_POST['palabraClave']) && strcmp($_POST['palabraClave'], "")!=0){
				$consultaUsers=$consultaUsers."AND usuarios.no_empleado LIKE '%".$_POST['palabraClave']."%' OR usuarios.nombre LIKE '%".$_POST['palabraClave']."%' ";
			}
			$resultadoUsers=$con->ejecutarSql($consultaUsers);
			if($con->cantidadRegistros($resultadoUsers)==0){
				$innerHTML=$innerHTML."document.getElementById('anuncio_resultados').innerHTML= \"No se encontraron resultados\";";
				$innerHTML=$innerHTML."document.getElementById('tabla_resultados').innerHTML= \"\";";
				
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('anuncio_resultados').innerHTML= \"Se encontraron ".$con->cantidadRegistros($resultadoUsers)." resultados\";";
				$innerHTML=$innerHTML."document.getElementById('tabla_resultados').innerHTML= \"";
				for($i=0; $i<$con->cantidadRegistros($resultadoUsers); $i++){
					$registroUsers=$con->obtenerFila($resultadoUsers);

					$innerHTML=$innerHTML."<TR class='fila_tablaResultados'>";

					$innerHTML=$innerHTML."<TD class='columna_noEmpleado'>";
					$innerHTML=$innerHTML.$registroUsers['no_empleado'];
					$innerHTML=$innerHTML."</TD>";
					$innerHTML=$innerHTML."<TD class='columna_nombreUsuario'>";
					$innerHTML=$innerHTML.$registroUsers['nombre'];
					$innerHTML=$innerHTML."</TD>";

					if(isset($_POST['fecha']) && strcmp($_POST['fecha'],"")!=0){
						$consultEvaluacion="SELECT encuestasrealizadas.id_encuestasRealizada,usuarios.no_empleado FROM usuarios INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN encuestasrealizadas ON usuarios.no_empleado = encuestasrealizadas.no_empleado WHERE encuestasrealizadas.fecha_aplicacion = '".$_POST['fecha']."' AND usuarios.no_empleado='".$registroUsers['no_empleado']."'";
						$resultadoEvaluacion=$con->ejecutarSql($consultEvaluacion);
						$registroEvaluacion=$con->obtenerFila($resultadoEvaluacion);
						if($con->cantidadRegistros($resultadoEvaluacion)>0 && strcmp($registroEvaluacion['no_empleado'], "")!=0){
							$innerHTML=$innerHTML."<TD class='columna_estado' style='color:#145A32 '>";
							$innerHTML=$innerHTML."Encuesta realizada";
							$innerHTML=$innerHTML."</TD>";
							$innerHTML=$innerHTML."<TD class='columna_accion'>";
							$innerHTML=$innerHTML."<BUTTON onclick=IniciarDatosIniciales('".$registroUsers['no_empleado']."','".$registroEvaluacion['id_encuestasRealizada']."') class='boton_accion' >Repetir Encuesta</BUTTON>";
							$innerHTML=$innerHTML."</TD>";
						}
						else{
							$innerHTML=$innerHTML."<TD class='columna_estado' style='color:#7B241C'>";
							$innerHTML=$innerHTML."Encuesta Sin realizar";
							$innerHTML=$innerHTML."</TD>";
							$innerHTML=$innerHTML."<TD class='columna_accion'>";
							$innerHTML=$innerHTML."<BUTTON onclick=IniciarDatosIniciales('".$registroUsers['no_empleado']."','no') class='boton_accion' >Realizar Encuesta</BUTTON>";
							$innerHTML=$innerHTML."</TD>";
						}
						
					}
					$innerHTML=$innerHTML."</TR>";
				}
				$innerHTML=$innerHTML."\";";
				$innerHTML=$innerHTML."colorearTabla();";
				
			}
			echo utf8_encode($innerHTML);
		}
	}
?>