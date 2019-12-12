<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="document.getElementById('select_turno').innerHTML='<OPTION>-Omitir-</OPTION>";
		$consultaSql="SELECT encuestasrealizadas.id_encuestasRealizada, encuestasrealizadas.fecha_aplicacion, encuestasrealizadas.hora_aplicacion, usuarios.no_empleado, usuarios.nombre, encuestasrealizadas.condicion_optima,turnos.turno FROM encuestasrealizadas INNER JOIN usuarios on encuestasrealizadas.no_empleado = usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado=personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno";
		$data="data:{'nombre':'','genero':'-Omitir-', 'turno':'-Omitir-', 'condicion':'-Omitir-','fechaUnica':'','edadUnica':'','tiempoUnico':''}";
		$data2="data:{'nombre':'','genero':'-Omitir-', 'turno':'-Omitir-', 'condicion':'-Omitir-','fechaInicial':'', 'fechaFinal':'','diaSemana':'-Omitir-','edadInicial':'', 'edadFinal':'','tiempoInicial':'', 'tiempoFinal':''},success";
		if( (isset($_POST['nombre']) && strcmp($_POST['nombre'],'')==0) &&  (isset($_POST['genero']) && strcmp($_POST['genero'],'-Omitir-')==0) && (isset($_POST['turno']) && strcmp($_POST['turno'],'-Omitir-')==0) &&  (isset($_POST['condicion']) && strcmp($_POST['condicion'],'-Omitir-')==0) &&  ((isset($_POST['fechaUnica']) && strcmp($_POST['fechaUnica'], '')==0) || (isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && strcmp($_POST['fechaInicial'], '')==0 && strcmp($_POST['fechaFinal'], '')==0) ) && ( (isset($_POST['edadUnica']) && strcmp($_POST['edadUnica'], '')==0) || (isset($_POST['edadInicial']) && isset($_POST['edadFinal']) && strcmp($_POST['edadInicial'], '')==0 && strcmp($_POST['edadFinal'], '')==0)) && ( (isset($_POST['tiempoUnico']) && strcmp($_POST['tiempoUnico'], '')==0) || (isset($_POST['tiempoInicial']) && isset($_POST['tiempoFinal']) && strcmp($_POST['tiempoInicial'], '')==0 && strcmp($_POST['tiempoFinal'], '')==0)  ) &&( (!isset($_POST['diaSemana'])) || (strcmp($_POST['diaSemana'], '-Omitir-')==0) )){
			
			$resultado=$con->ejecutarSql($consultaSql);
			$cantidadResultados=$con->cantidadRegistros($resultado);
			$innerHTML="document.getElementById('anuncioResultadosReportes').innerHTML='Se encontraron ".$cantidadResultados." resultados';";

			if($cantidadResultados>0){
				$innerHTML=$innerHTML."document.getElementById('tablaResultados').innerHTML='";
				for ($i=0; $i<$cantidadResultados; $i++){
					$registro=$con->obtenerFila($resultado);
					$innerHTML=$innerHTML."<TR class=\"filaResultados\" id=\"filaResultado-".utf8_encode($registro['id_encuestasRealizada'])."\">";
					
					$innerHTML=$innerHTML."<TD class=\"campoResultado\">".utf8_encode($registro['fecha_aplicacion'])." (".utf8_encode($registro['hora_aplicacion']).")</TD>";
					$innerHTML=$innerHTML."<TD class=\"campoResultado\">".utf8_encode($registro['nombre'])."</TD>";
					if(strcmp($registro['condicion_optima'], '1')==0){
						$innerHTML=$innerHTML."<TD class=\"campoResultado\">Sin fatiga</TD>";
						$innerHTML=$innerHTML."<TD class=\"campoResultado\"><BUTTON  class=\"botonVerRespuestas\" onclick=\"verControlador(\'".$registro['id_encuestasRealizada']."\')\" style=\"width:50%; height:100px; float:left\">".utf8_encode("Ver Controlador")."</BUTTON><BUTTON class=\"botonEliminarEntrada\" value=".$registro['id_encuestasRealizada']." style=\"width:50%; height:100px; float:right\" onclick=\"eliminarEntrada(\'".$registro['id_encuestasRealizada']."\')\">".utf8_encode("Eliminar Entrada")."</BUTTON></TD>";

					}
					else{
						$consultaSql2="SELECT areaevaluacion.descripcionAreaEvaluacion FROM areaevaluacion INNER JOIN evaluacionestado ON evaluacionestado.idAreaEvaluacion=areaevaluacion.idAreaEvaluacion WHERE evaluacionestado.id_encuestasRealizada=".$registro['id_encuestasRealizada'];
						$resultado2=$con->ejecutarSql($consultaSql2);
						$registro2=$con->obtenerFila($resultado2);
						$innerHTML=$innerHTML."<TD class=\"campoResultado\">".utf8_encode($registro2['descripcionAreaEvaluacion'])."</TD>";
						$innerHTML=$innerHTML."<TD class=\"campoResultado\"><FORM method=\"POST\" action=\"verEncuesta.php\" style=\"width:50%; height:100px; float:left\"><BUTTON type=\"submit\" class=\"botonVerRespuestas\" value=".$registro['id_encuestasRealizada']." name=\"no_encuesta\" style=\"width:100%; height:100%;\">".utf8_encode("Ver respuestas")."</BUTTON></FORM><BUTTON class=\"botonEliminarEntrada\" value=".$registro['id_encuestasRealizada']." style=\"width:50%; height:100px; float:right\" onclick=\"eliminarEntrada(\'".$registro['id_encuestasRealizada']."\')\">".utf8_encode("Eliminar Entrada")."</BUTTON></TD>";
					}

					$innerHTML=$innerHTML."</TR>";
				}
				$innerHTML=$innerHTML."';";
			}
			else{
				
				$innerHTML=$innerHTML."document.getElementById('tablaResultados').innerHTML='';";	
			}
			echo $innerHTML;
			


		}
		else{
			$resultado="";
			$consultaSql=$consultaSql." WHERE AND finconsulta";
			if(isset($_POST['nombre']) && strcmp($_POST['nombre'],'')!=0){
				$consultaSql=str_replace("AND finconsulta", " (usuarios.nombre LIKE ('%".$_POST['nombre']."%')) AND finconsulta", $consultaSql);
			}
			if(isset($_POST['genero']) && strcmp($_POST['genero'], '-Omitir-')!=0){
				if(strcmp($_POST['genero'], 'Femenino')){
					$consultaSql=str_replace("AND finconsulta", " AND (personal.sexo='M') AND finconsulta", $consultaSql);
				}
				else{
					if(strcmp($_POST['genero'], 'Masculino')){
						$consultaSql=str_replace("AND finconsulta", " AND (personal.sexo='F') AND finconsulta", $consultaSql);
					}
				}
			}
			if(isset($_POST['edadUnica']) && strcmp($_POST['edadUnica'], '')!=0){
				$consultaSql=str_replace("AND finconsulta", " AND (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  = ".$_POST['edadUnica'].") AND finconsulta", $consultaSql);
			}
			else{
				if(isset($_POST['edadInicial']) && isset($_POST['edadFinal']) && strcmp($_POST['edadInicial'],'')!=0 && strcmp($_POST['edadFinal'], '')!=0){
					$consultaSql=str_replace("AND finconsulta", " AND (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  BETWEEN ".$_POST['edadInicial']." AND ".$_POST['edadFinal'].") AND finconsulta", $consultaSql);
				}
				
			}
			if(isset($_POST['fechaUnica']) && strcmp($_POST['fechaUnica'], '')!=0){
				$consultaSql=str_replace("AND finconsulta", " AND (encuestasrealizadas.fecha_aplicacion = STR_TO_DATE( '".$_POST['fechaUnica']."', '%Y-%m-%d' ) ) AND finconsulta", $consultaSql);
			}
			else{
				if(isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && strcmp($_POST['fechaInicial'],'')!=0 && strcmp($_POST['fechaFinal'], '')!=0){
					$consultaSql=str_replace("AND finconsulta", " AND (encuestasrealizadas.fecha_aplicacion BETWEEN STR_TO_DATE( '".$_POST['fechaInicial']."', '%Y-%m-%d' ) AND STR_TO_DATE( '".$_POST['fechaFinal']."', '%Y-%m-%d' ) )", $consultaSql);
				}
			}
			if(isset($_POST['tiempoUnico']) && strcmp($_POST['tiempoUnico'], '')!=0){
				$consultaSql=str_replace("AND finconsulta", " AND (personal.fecha_ingreso = STR_TO_DATE( '".$_POST['tiempoUnico']."', '%Y-%m-%d' ) ) AND finconsulta", $consultaSql);
			}
			else{
				if(isset($_POST['tiempoInicial']) && isset($_POST['tiempoFinal']) && strcmp($_POST['tiempoInicial'],'')!=0 && strcmp($_POST['tiempoFinal'], '')!=0){
					$consultaSql=str_replace("AND finconsulta", " AND (personal.fecha_ingreso  BETWEEN STR_TO_DATE( '".$_POST['tiempoInicial']."', '%Y-%m-%d' )  AND STR_TO_DATE( '".$_POST['tiempoFinal']."', '%Y-%m-%d' ) ) AND finconsulta", $consultaSql);
				}
				
			}
			if(isset($_POST['turno']) AND strcmp($_POST['turno'], '-Omitir-')!=0){
				$consultaSql=str_replace("AND finconsulta", " AND ( turnos.turno='".$_POST['turno']."') AND finconsulta", $consultaSql);
			}
			if(isset($_POST['condicion']) && strcmp($_POST['condicion'], '-Omitir-')!=0){
				if(strcmp($_POST['condicion'], 'Sin fatiga')==0){
					$consultaSql=str_replace("AND finconsulta", " AND ( encuestasrealizadas.condicion_optima = 1)", $consultaSql);
				}
				else{
					$consultaSql=str_replace(" FROM encuestasrealizadas", ", evaluacionestado.idAreaEvaluacion, areaevaluacion.descripcionAreaEvaluacion FROM encuestasrealizadas INNER JOIN evaluacionestado ON encuestasrealizadas.id_encuestasRealizada = evaluacionestado.id_encuestasRealizada INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion= areaevaluacion.idAreaEvaluacion ", $consultaSql);
					$consultaSql=str_replace("AND finconsulta", " AND ( areaevaluacion.descripcionAreaEvaluacion='".$_POST['condicion']."') AND finconsulta", $consultaSql);

				}
			}
			if(isset($_POST['diaSemana']) && strcmp($_POST['diaSemana'], '-Omitir-')!=0){
				$consultaSql=str_replace("AND finconsulta", " AND (DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) = ".$_POST['diaSemana'].")", $consultaSql);
				
			}

			$consultaSql=str_replace("AND finconsulta", ";",$consultaSql);
			$consultaSql=str_replace(" WHERE  AND ", " WHERE ",$consultaSql);
			
			$resultado=$con->ejecutarSql($consultaSql);
			$cantidadResultados=$con->cantidadRegistros($resultado);
			
			$innerHTML="document.getElementById('anuncioResultadosReportes').innerHTML='Se encontraron ".$cantidadResultados." resultados';";

			if($cantidadResultados>0){
				$innerHTML=$innerHTML."document.getElementById('tablaResultados').innerHTML='";
				for ($i=0; $i<$cantidadResultados; $i++){
					$registro=$con->obtenerFila($resultado);
					$innerHTML=$innerHTML."<TR class=\"filaResultados\" id=\"filaResultado-".utf8_encode($registro['id_encuestasRealizada'])."\">";
					
					$innerHTML=$innerHTML."<TD class=\"campoResultado\">".utf8_encode($registro['fecha_aplicacion'])." (".utf8_encode($registro['hora_aplicacion']).")</TD>";
					$innerHTML=$innerHTML."<TD class=\"campoResultado\">".utf8_encode($registro['nombre'])."</TD>";
					if(strcmp($registro['condicion_optima'], '1')==0){
						$innerHTML=$innerHTML."<TD class=\"campoResultado\">Sin fatiga</TD>";
						$innerHTML=$innerHTML."<TD class=\"campoResultado\"><BUTTON  class=\"botonVerRespuestas\" onclick=\"verControlador(\'".$registro['id_encuestasRealizada']."\')\" style=\"width:50%; height:100px; float:left\">".utf8_encode("Ver Controlador")."</BUTTON><BUTTON class=\"botonEliminarEntrada\" value=".$registro['id_encuestasRealizada']." style=\"width:50%; height:100px; float:right\" onclick=\"eliminarEntrada(\'".$registro['id_encuestasRealizada']."\')\">".utf8_encode("Eliminar Entrada")."</BUTTON></TD>";

					}
					else{
						$consultaSql2="SELECT areaevaluacion.descripcionAreaEvaluacion FROM areaevaluacion INNER JOIN evaluacionestado ON evaluacionestado.idAreaEvaluacion=areaevaluacion.idAreaEvaluacion WHERE evaluacionestado.id_encuestasRealizada=".$registro['id_encuestasRealizada'];
						$resultado2=$con->ejecutarSql($consultaSql2);
						$registro2=$con->obtenerFila($resultado2);
						$innerHTML=$innerHTML."<TD class=\"campoResultado\">".utf8_encode($registro2['descripcionAreaEvaluacion'])."</TD>";
						$innerHTML=$innerHTML."<TD class=\"campoResultado\"><FORM method=\"POST\" action=\"verEncuesta.php\" style=\"width:50%; height:100px; float:left\"><BUTTON type=\"submit\" class=\"botonVerRespuestas\" value=".$registro['id_encuestasRealizada']." name=\"no_encuesta\" style=\"width:100%; height:100%;\">".utf8_encode("Ver respuestas")."</BUTTON></FORM><BUTTON class=\"botonEliminarEntrada\" value=".$registro['id_encuestasRealizada']." style=\"width:50%; height:100px; float:right\" onclick=\"eliminarEntrada(\'".$registro['id_encuestasRealizada']."\')\">".utf8_encode("Eliminar Entrada")."</BUTTON></TD>";
					}

					$innerHTML=$innerHTML."</TR>";
				}
				$innerHTML=$innerHTML."';";
			}
			else{

				$innerHTML=$innerHTML."document.getElementById('tablaResultados').innerHTML='';";	
			}
			echo $innerHTML;


		
		}
		if($con->hayError($resultado)==false){

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