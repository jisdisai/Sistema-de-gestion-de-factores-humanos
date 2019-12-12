<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		function obtenerDia ($indice){
			$dia="dia";
			if(strcmp($indice, '1')==0){
				$dia="Domingo";
			}
			else{
				if(strcmp($indice, '2')==0){
					$dia="Lunes";
				}
				else{
					if(strcmp($indice, '3')==0){
						$dia="Miércoles";
					}
					else{
						if(strcmp($indice, '4')==0){
							$dia="Jueves";
						}
						else{
							if(strcmp($indice, '5')==0){
								$dia="Viernes";
							}
							else{
								$dia="Sábado";								
							}
						}
					}
				}
			}
			return $dia;
		}

		$con = new Conexion();
		$innerHTML="";

		$consultaSqlEvaluaciones="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias', areaevaluacion.descripcionAreaEvaluacion AS 'condicion', DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) AS 'diaSemana', encuestasrealizadas.fecha_aplicacion FROM encuestasrealizadas INNER JOIN evaluacionestado ON encuestasrealizadas.id_encuestasRealizada = evaluacionestado.id_encuestasRealizada INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion = areaevaluacion.idAreaEvaluacion INNER JOIN usuarios ON encuestasrealizadas.no_empleado= usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno WHERE (areaevaluacion.descripcionAreaEvaluacion=['condicion']) AND comodin GROUP BY (encuestasrealizadas.fecha_aplicacion) ORDER BY encuestasrealizadas.fecha_aplicacion ASC";
		$consultaSqlSinFatiga="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias', DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) as 'diaSemana', encuestasrealizadas.fecha_aplicacion FROM encuestasrealizadas INNER JOIN usuarios ON encuestasrealizadas.no_empleado= usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno WHERE (encuestasrealizadas.condicion_optima=1) AND comodin GROUP BY (encuestasrealizadas.fecha_aplicacion) ORDER BY encuestasrealizadas.fecha_aplicacion ASC";
		$data="data:{'nombre':'','genero':'-Omitir-', 'turno':'-Omitir-', 'condicion':'-Omitir-','fechaUnica':'','edadUnica':'','tiempoUnico':''}";
		$data2="data:{'nombre':'','genero':'-Omitir-', 'turno':'-Omitir-', 'condicion':'-Omitir-','fechaInicial':'', 'fechaFinal':'','diaSemana':'-Omitir-','edadInicial':'', 'edadFinal':'','tiempoInicial':'', 'tiempoFinal':''},success";
		$plantillaData="var nuevaArea={x:['comodin'],y:[comodin],name:'nuevaArea',type:'scatter'};";
		$asocPlotly="dataIntercepcion = [comodin];";

		if( (isset($_POST['nombre']) && strcmp($_POST['nombre'],'')==0) &&  (isset($_POST['genero']) && strcmp($_POST['genero'],'-Omitir-')==0) && (isset($_POST['turno']) && strcmp($_POST['turno'],'-Omitir-')==0) &&  (isset($_POST['condicion']) && strcmp($_POST['condicion'],'-Omitir-')==0) &&  ((isset($_POST['fechaUnica']) && strcmp($_POST['fechaUnica'], '')==0) || (isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && strcmp($_POST['fechaInicial'], '')==0 && strcmp($_POST['fechaFinal'], '')==0) ) && ( (isset($_POST['edadUnica']) && strcmp($_POST['edadUnica'], '')==0) || (isset($_POST['edadInicial']) && isset($_POST['edadFinal']) && strcmp($_POST['edadInicial'], '')==0 && strcmp($_POST['edadFinal'], '')==0)) && ( (isset($_POST['tiempoUnico']) && strcmp($_POST['tiempoUnico'], '')==0) || (isset($_POST['tiempoInicial']) && isset($_POST['tiempoFinal']) && strcmp($_POST['tiempoInicial'], '')==0 && strcmp($_POST['tiempoFinal'], '')==0)  ) &&( (!isset($_POST['diaSemana'])) || (strcmp($_POST['diaSemana'], '-Omitir-')==0) )){
		//Arreglar consultas
			$consultaSqlEvaluaciones=str_replace(" AND comodin "," ", $consultaSqlEvaluaciones);
			$consultaSqlSinFatiga=str_replace(" AND comodin "," ", $consultaSqlSinFatiga);
		//Obtener evaluaciones de estado por fecha

			$consultaCondiciones="SELECT areaevaluacion.descripcionAreaEvaluacion as 'condicion' FROM areaevaluacion";		
			$resultadoCondiciones=$con->ejecutarSql($consultaCondiciones);
			$cantidadCondiciones=$con->cantidadRegistros($resultadoCondiciones);
			$totalOcurrencias=0;	

			if($cantidadCondiciones>0){				
				for($i=0; $i<$cantidadCondiciones; $i++){

					$registroCondicion=$con->obtenerFila($resultadoCondiciones);
					

					$consultaSqlEvaluaciones=str_replace("['condicion']", "'".utf8_encode($registroCondicion['condicion']."'"), $consultaSqlEvaluaciones);
					$consultaSqlEvaluaciones=str_replace(" AND comodin ", " ", $consultaSqlEvaluaciones);

					
					$resultadoEvaluaciones=$con->ejecutarSql($consultaSqlEvaluaciones);
					
					

					$plantillaVar="var nuevaArea={x:['comodin_x'],y:[comodin_y],name:'nuevaArea',type:'scatter'};";
					$definirVar=str_replace("name:'nuevaArea'", "name:'".utf8_encode($registroCondicion['condicion'])."'", $plantillaVar);
					$definirVar=str_replace("var nuevaArea", "var con".$i."", $definirVar);

					
					

					for($j=0; $j<$con->cantidadRegistros($resultadoEvaluaciones); $j++){
						$registroEvaluaciones=$con->obtenerFila($resultadoEvaluaciones);

						$definirVar=str_replace("'comodin_x'","'(".obtenerDia($registroEvaluaciones['diaSemana']).") ".$registroEvaluaciones['fecha_aplicacion']."', 'comodin_x'",$definirVar);
        				$definirVar=str_replace("comodin_y",$registroEvaluaciones['ocurrencias'].", comodin_y",$definirVar);
					}
					$asocPlotly=str_replace("comodin", "con".$i.", comodin", $asocPlotly);
					$definirVar=str_replace(", 'comodin_x'", "", $definirVar);
					$definirVar=str_replace("'comodin_x'", "", $definirVar);
					$definirVar=str_replace(", comodin_y", "", $definirVar);
					$definirVar=str_replace("comodin_y", "", $definirVar);
					
					$innerHTML=$innerHTML.$definirVar;
					

					$consultaSqlEvaluaciones="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias', areaevaluacion.descripcionAreaEvaluacion AS 'condicion', DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) AS 'diaSemana', encuestasrealizadas.fecha_aplicacion FROM encuestasrealizadas INNER JOIN evaluacionestado ON encuestasrealizadas.id_encuestasRealizada = evaluacionestado.id_encuestasRealizada INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion = areaevaluacion.idAreaEvaluacion INNER JOIN usuarios ON encuestasrealizadas.no_empleado= usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno WHERE (areaevaluacion.descripcionAreaEvaluacion=['condicion']) AND comodin GROUP BY (encuestasrealizadas.fecha_aplicacion) ORDER BY encuestasrealizadas.fecha_aplicacion ASC";

				}
				//$asocPlotly=str_replace(", comodin", "", $asocPlotly);
				//$innerHTML=$innerHTML.$asocPlotly;
				
				$consultaSqlSinFatiga=str_replace(" AND comodin ", " ", $consultaSqlSinFatiga);

						
				$resultadoSinFatiga=$con->ejecutarSql($consultaSqlSinFatiga);
				
				if($con->cantidadRegistros($resultadoSinFatiga)>0){
					$definirVar="var sinFatiga={x:['comodin_x'],y:[comodin_y],name:'Sin Fatiga',type:'scatter'};";
					for($i=0; $i<$con->cantidadRegistros($resultadoSinFatiga); $i++){
						$registroSinFatiga=$con->obtenerFila($resultadoSinFatiga);
						$definirVar=str_replace("'comodin_x'","'(".obtenerDia($registroSinFatiga['diaSemana']).") ".$registroSinFatiga['fecha_aplicacion']."', 'comodin_x'",$definirVar);
        				$definirVar=str_replace("comodin_y",$registroSinFatiga['ocurrencias'].", comodin_y",$definirVar);
        				
					}
					$definirVar=str_replace(", 'comodin_x'", "", $definirVar);
					$definirVar=str_replace(", comodin_y", "", $definirVar);
					$innerHTML=$innerHTML.$definirVar;
					$asocPlotly=str_replace("comodin", "sinFatiga", $asocPlotly);
				}
				$asocPlotly=str_replace(", comodin", "", $asocPlotly);
				$innerHTML=$innerHTML.$asocPlotly."Plotly.newPlot('plotlyChartIntercepciones', dataIntercepcion);";
				

			}
			else{
				
				
			}
			echo ($innerHTML);
			


		}
		else {
			$consultaSqlEvaluaciones="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias', areaevaluacion.descripcionAreaEvaluacion AS 'condicion', DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) AS 'diaSemana', encuestasrealizadas.fecha_aplicacion FROM encuestasrealizadas INNER JOIN evaluacionestado ON encuestasrealizadas.id_encuestasRealizada = evaluacionestado.id_encuestasRealizada INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion = areaevaluacion.idAreaEvaluacion INNER JOIN usuarios ON encuestasrealizadas.no_empleado= usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno  WHERE [ (areaevaluacion.descripcionAreaEvaluacion=['condicion']) AND comodin ] GROUP BY (encuestasrealizadas.fecha_aplicacion) ORDER BY encuestasrealizadas.fecha_aplicacion ASC";
			$consultaSqlSinFatiga="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias', DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) as 'diaSemana', encuestasrealizadas.fecha_aplicacion FROM encuestasrealizadas INNER JOIN usuarios ON encuestasrealizadas.no_empleado= usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno  WHERE [ (encuestasrealizadas.condicion_optima=1) AND comodin ] GROUP BY (encuestasrealizadas.fecha_aplicacion) ORDER BY encuestasrealizadas.fecha_aplicacion ASC";

			$plantillaData="var nuevaArea={x:['comodin'],y:[comodin],name:'nuevaArea',type:'scatter'};";
			$asocPlotly="dataIntercepcion = [comodin];";

			
			$resultado="";


			if(isset($_POST['nombre']) && strcmp($_POST['nombre'],'')!=0){
				$consultaSqlEvaluaciones=str_replace(" comodin ", " (usuarios.nombre LIKE ('%".$_POST['nombre']."%')) AND comodin ", $consultaSqlEvaluaciones);
				$consultaSqlSinFatiga=str_replace(" comodin ", " (usuarios.nombre LIKE ('%".$_POST['nombre']."%')) AND comodin ", $consultaSqlSinFatiga);
			}
			if(isset($_POST['genero']) && strcmp($_POST['genero'], '-Omitir-')!=0){
				if(strcmp($_POST['genero'], 'Femenino')){
					$consultaSqlEvaluaciones=str_replace(" comodin ", " (personal.sexo='M') AND comodin ", $consultaSqlEvaluaciones);
					$consultaSqlSinFatiga=str_replace(" comodin ", " (personal.sexo='M') AND comodin ", $consultaSqlSinFatiga);
				}
				else{
					if(strcmp($_POST['genero'], 'Masculino')){
						$consultaSqlEvaluaciones=str_replace(" comodin ", " (personal.sexo='F') AND comodin ", $consultaSqlEvaluaciones);
						$consultaSqlSinFatiga=str_replace(" comodin ", " (personal.sexo='F') AND comodin ", $consultaSqlSinFatiga);
					}
				}
			}
			if(isset($_POST['edadUnica']) && strcmp($_POST['edadUnica'], '')!=0){
				$consultaSqlEvaluaciones=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  = ".$_POST['edadUnica'].") AND comodin ", $consultaSqlEvaluaciones);
				$consultaSqlSinFatiga=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  = ".$_POST['edadUnica'].") AND comodin ", $consultaSqlSinFatiga);
			}
			else{
				if(isset($_POST['edadInicial']) && isset($_POST['edadFinal']) && strcmp($_POST['edadInicial'],'')!=0 && strcmp($_POST['edadFinal'], '')!=0){
					$consultaSqlEvaluaciones=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  BETWEEN ".$_POST['edadInicial']." AND ".$_POST['edadFinal'].") AND comodin ", $consultaSqlEvaluaciones);
					$consultaSqlSinFatiga=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  BETWEEN ".$_POST['edadInicial']." AND ".$_POST['edadFinal'].") AND comodin ", $consultaSqlSinFatiga);
				}
				
			}
			if(isset($_POST['fechaUnica']) && strcmp($_POST['fechaUnica'], '')!=0){
				$consultaSqlEvaluaciones=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion = STR_TO_DATE( '".$_POST['fechaUnica']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlEvaluaciones);
				$consultaSqlSinFatiga=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion = STR_TO_DATE( '".$_POST['fechaUnica']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlSinFatiga);
			}
			else{
				if(isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && strcmp($_POST['fechaInicial'],'')!=0 && strcmp($_POST['fechaFinal'], '')!=0){
					$consultaSqlEvaluaciones=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion BETWEEN STR_TO_DATE( '".$_POST['fechaInicial']."', '%Y-%m-%d' ) AND STR_TO_DATE( '".$_POST['fechaFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlEvaluaciones);
					$consultaSqlSinFatiga=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion BETWEEN STR_TO_DATE( '".$_POST['fechaInicial']."', '%Y-%m-%d' ) AND STR_TO_DATE( '".$_POST['fechaFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlSinFatiga);
				}
			}
			if(isset($_POST['tiempoUnico']) && strcmp($_POST['tiempoUnico'], '')!=0){
				$consultaSqlEvaluaciones=str_replace(" comodin ", " (personal.fecha_ingreso = STR_TO_DATE( '".$_POST['tiempoUnico']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlEvaluaciones);
				$consultaSqlSinFatiga=str_replace(" comodin ", " (personal.fecha_ingreso = STR_TO_DATE( '".$_POST['tiempoUnico']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlSinFatiga);
			}
			else{
				if(isset($_POST['tiempoInicial']) && isset($_POST['tiempoFinal']) && strcmp($_POST['tiempoInicial'],'')!=0 && strcmp($_POST['tiempoFinal'], '')!=0){
					$consultaSqlEvaluaciones=str_replace(" comodin ", " (personal.fecha_ingreso  BETWEEN STR_TO_DATE( '".$_POST['tiempoInicial']."', '%Y-%m-%d' )  AND STR_TO_DATE( '".$_POST['tiempoFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlEvaluaciones);
					$consultaSqlSinFatiga=str_replace(" comodin ", " (personal.fecha_ingreso  BETWEEN STR_TO_DATE( '".$_POST['tiempoInicial']."', '%Y-%m-%d' )  AND STR_TO_DATE( '".$_POST['tiempoFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSqlSinFatiga);
				}
				
			}
			if(isset($_POST['turno']) AND strcmp($_POST['turno'], '-Omitir-')!=0){
				$consultaSqlEvaluaciones=str_replace(" comodin ", " ( turnos.turno='".$_POST['turno']."') AND comodin ", $consultaSqlEvaluaciones);
				$consultaSqlSinFatiga=str_replace(" comodin ", " ( turnos.turno='".$_POST['turno']."') AND comodin ", $consultaSqlSinFatiga);
			}
			
			if(isset($_POST['diaSemana']) && strcmp($_POST['diaSemana'], '-Omitir-')!=0){
				$consultaSqlEvaluaciones=str_replace(" comodin ", " (DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) = ".$_POST['diaSemana'].") AND comodin ", $consultaSqlEvaluaciones);
				$consultaSqlSinFatiga=str_replace(" comodin ", " (DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) = ".$_POST['diaSemana'].") AND comodin ", $consultaSqlSinFatiga);
				
			}
			$consultaSqlEvaluaciones=str_replace(" WHERE [", " WHERE ",$consultaSqlEvaluaciones);
			$consultaSqlSinFatiga=str_replace(" WHERE [", " WHERE ", $consultaSqlSinFatiga);
			$consultaSqlEvaluaciones=str_replace(" AND comodin ] ", " ", $consultaSqlEvaluaciones);
			$consultaSqlSinFatiga=str_replace(" AND comodin ] ", " ", $consultaSqlSinFatiga);
			
			
			$resultadoEvaluaciones=$con->ejecutarSql($consultaSqlEvaluaciones);
			$cantidadResultados=0;
			
			if(strcmp($_POST['condicion'], "-Omitir-")==0){
				$consultaCondiciones="SELECT areaevaluacion.descripcionAreaEvaluacion as 'condicion' FROM areaevaluacion";		
				$resultadoCondiciones=$con->ejecutarSql($consultaCondiciones);
				$cantidadCondiciones=$con->cantidadRegistros($resultadoCondiciones);
				$totalOcurrencias=0;	

				if($cantidadCondiciones>0){				
					for($i=0; $i<$cantidadCondiciones; $i++){

						$registroCondicion=$con->obtenerFila($resultadoCondiciones);
					
						$consultaSqlEvaluacionesOriginal=$consultaSqlEvaluaciones;

						$consultaSqlEvaluaciones=str_replace("['condicion']", "'".utf8_encode($registroCondicion['condicion']."'"), $consultaSqlEvaluacionesOriginal);
						$consultaSqlEvaluaciones=str_replace(" AND comodin ", " ", $consultaSqlEvaluaciones);

					
						$resultadoEvaluaciones=$con->ejecutarSql($consultaSqlEvaluaciones);
					
					

						$plantillaVar="var nuevaArea={x:['comodin_x'],y:[comodin_y],name:'nuevaArea',type:'scatter'};";
						$definirVar=str_replace("name:'nuevaArea'", "name:'".utf8_encode($registroCondicion['condicion'])."'", $plantillaVar);
						$definirVar=str_replace("var nuevaArea", "var con".$i."", $definirVar);

					
					

						for($j=0; $j<$con->cantidadRegistros($resultadoEvaluaciones); $j++){
							$registroEvaluaciones=$con->obtenerFila($resultadoEvaluaciones);

							$definirVar=str_replace("'comodin_x'","'(".obtenerDia($registroEvaluaciones['diaSemana']).") ".$registroEvaluaciones['fecha_aplicacion']."', 'comodin_x'",$definirVar);
        					$definirVar=str_replace("comodin_y",$registroEvaluaciones['ocurrencias'].", comodin_y",$definirVar);
						}
						$asocPlotly=str_replace("comodin", "con".$i.", comodin", $asocPlotly);
						$definirVar=str_replace(", 'comodin_x'", "", $definirVar);
						$definirVar=str_replace("'comodin_x'", "", $definirVar);
						$definirVar=str_replace(", comodin_y", "", $definirVar);
						$definirVar=str_replace("comodin_y", "", $definirVar);
					
						$innerHTML=$innerHTML.$definirVar;
					

						$consultaSqlEvaluaciones=$consultaSqlEvaluacionesOriginal;

					}
				//$asocPlotly=str_replace(", comodin", "", $asocPlotly);
				//$innerHTML=$innerHTML.$asocPlotly;
				
					$resultadoSinFatiga=$con->ejecutarSql($consultaSqlSinFatiga);
				
					if($con->cantidadRegistros($resultadoSinFatiga)>0){
						$definirVar="var sinFatiga={x:['comodin_x'],y:[comodin_y],name:'Sin Fatiga',type:'scatter'};";
						for($i=0; $i<$con->cantidadRegistros($resultadoSinFatiga); $i++){
							$registroSinFatiga=$con->obtenerFila($resultadoSinFatiga);
							$definirVar=str_replace("'comodin_x'","'(".obtenerDia($registroSinFatiga['diaSemana']).") ".$registroSinFatiga['fecha_aplicacion']."', 'comodin_x'",$definirVar);
        					$definirVar=str_replace("comodin_y",$registroSinFatiga['ocurrencias'].", comodin_y",$definirVar);
        				
						}
						$definirVar=str_replace(", 'comodin_x'", "", $definirVar);
						$definirVar=str_replace(", comodin_y", "", $definirVar);
						$innerHTML=$innerHTML.$definirVar;
						$asocPlotly=str_replace("comodin", "sinFatiga", $asocPlotly);
					}
					$asocPlotly=str_replace(", comodin", "", $asocPlotly);
					$innerHTML=$innerHTML.$asocPlotly."Plotly.newPlot('plotlyChartIntercepciones', dataIntercepcion);";
				}
			}
			else{
				if(isset($_POST['condicion']) && strcmp($_POST['condicion'], 'Sin fatiga')==0){
					$resultadoSinFatiga=$con->ejecutarSql($consultaSqlSinFatiga);
				
					if($con->cantidadRegistros($resultadoSinFatiga)>0){
						$definirVar="var sinFatiga={x:['comodin_x'],y:[comodin_y],name:'Sin Fatiga',type:'scatter'};";
						for($i=0; $i<$con->cantidadRegistros($resultadoSinFatiga); $i++){
							$registroSinFatiga=$con->obtenerFila($resultadoSinFatiga);
							$definirVar=str_replace("'comodin_x'","'(".obtenerDia($registroSinFatiga['diaSemana']).") ".$registroSinFatiga['fecha_aplicacion']."', 'comodin_x'",$definirVar);
        					$definirVar=str_replace("comodin_y",$registroSinFatiga['ocurrencias'].", comodin_y",$definirVar);
        				
						}
						$definirVar=str_replace(", 'comodin_x'", "", $definirVar);
						$definirVar=str_replace("'comodin_x'", "", $definirVar);
						$definirVar=str_replace(", comodin_y", "", $definirVar);
						$definirVar=str_replace("comodin_y", "", $definirVar);
						$innerHTML=$innerHTML.$definirVar;
						$asocPlotly=str_replace("comodin", "sinFatiga", $asocPlotly);
					}
					$asocPlotly=str_replace(", comodin", "", $asocPlotly);
					$innerHTML=$innerHTML.$asocPlotly."Plotly.newPlot('plotlyChartIntercepciones', dataIntercepcion);";

				}
				else{
					$consultaSqlEvaluaciones=str_replace("['condicion']", "'".$_POST['condicion']."'", $consultaSqlEvaluaciones);
					$consultaSqlEvaluaciones=str_replace(" AND comodin ", " ", $consultaSqlEvaluaciones);

					$resultadoEvaluaciones=$con->ejecutarSql($consultaSqlEvaluaciones);
					
					$plantillaVar="var nuevaArea={x:['comodin_x'],y:[comodin_y],name:'nuevaArea',type:'scatter'};";
					$definirVar=str_replace("name:'nuevaArea'", "name:'".$_POST['condicion']."'", $plantillaVar);
					$definirVar=str_replace("var nuevaArea", "var condicionada", $definirVar);

					for($j=0; $j<$con->cantidadRegistros($resultadoEvaluaciones); $j++){
							$registroEvaluaciones=$con->obtenerFila($resultadoEvaluaciones);

							$definirVar=str_replace("'comodin_x'","'(".obtenerDia($registroEvaluaciones['diaSemana']).") ".$registroEvaluaciones['fecha_aplicacion']."', 'comodin_x'",$definirVar);
        					$definirVar=str_replace("comodin_y",$registroEvaluaciones['ocurrencias'].", comodin_y",$definirVar);
        					
					}
					$asocPlotly=str_replace("comodin", "condicionada , comodin", $asocPlotly);
					$definirVar=str_replace(", 'comodin_x'", "", $definirVar);
					$definirVar=str_replace("'comodin_x'", "", $definirVar);
					$definirVar=str_replace(", comodin_y", "", $definirVar);
					$definirVar=str_replace("comodin_y", "", $definirVar);
					

					$innerHTML=$innerHTML.$definirVar;

					$asocPlotly=str_replace(", comodin", "", $asocPlotly);
					$innerHTML=$innerHTML.$asocPlotly."Plotly.newPlot('plotlyChartIntercepciones', dataIntercepcion);";

				}
			}
			echo $innerHTML;
		}

	}
	else{
		echo"error";
	}
?>