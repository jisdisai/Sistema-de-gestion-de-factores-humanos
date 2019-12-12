<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con = new Conexion();
		$innerHTML="document.getElementById('select_turno').innerHTML='<OPTION>-Omitir-</OPTION>";

		$consultaSql="SELECT COUNT(evaluacionestado.id_evaluacionEstado) AS 'ocurrencias',areaevaluacion.descripcionAreaEvaluacion AS 'condicion' FROM evaluacionestado INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion = areaevaluacion.idAreaEvaluacion INNER JOIN encuestasrealizadas ON evaluacionestado.id_encuestasRealizada=encuestasrealizadas.id_encuestasRealizada INNER JOIN usuarios ON encuestasrealizadas.no_empleado = usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno INNER JOIN posicion ON encuestasrealizadas.id_posicion = posicion.id_posicion GROUP BY evaluacionestado.idAreaEvaluacion ";

		$data="data:{'nombre':'','genero':'-Omitir-', 'turno':'-Omitir-', 'condicion':'-Omitir-','fechaUnica':'','edadUnica':'','tiempoUnico':''}";
		$data2="data:{'nombre':'','genero':'-Omitir-', 'turno':'-Omitir-', 'condicion':'-Omitir-','fechaInicial':'', 'fechaFinal':'','diaSemana':'-Omitir-','edadInicial':'', 'edadFinal':'','tiempoInicial':'', 'tiempoFinal':''},success";
		$definirData="dataPie = [{labels: ['comodin'],values: [comodin],type: 'pie'}];var layout = {height: 400,width: 500};";

		$consultaSql=$consultaSql." ;";
		if( (isset($_POST['nombre']) && strcmp($_POST['nombre'],'')==0) &&  (isset($_POST['genero']) && strcmp($_POST['genero'],'-Omitir-')==0) && (isset($_POST['turno']) && strcmp($_POST['turno'],'-Omitir-')==0) &&  (isset($_POST['condicion']) && strcmp($_POST['condicion'],'-Omitir-')==0) &&  ((isset($_POST['fechaUnica']) && strcmp($_POST['fechaUnica'], '')==0) || (isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && strcmp($_POST['fechaInicial'], '')==0 && strcmp($_POST['fechaFinal'], '')==0) ) && ( (isset($_POST['edadUnica']) && strcmp($_POST['edadUnica'], '')==0) || (isset($_POST['edadInicial']) && isset($_POST['edadFinal']) && strcmp($_POST['edadInicial'], '')==0 && strcmp($_POST['edadFinal'], '')==0)) && ( (isset($_POST['tiempoUnico']) && strcmp($_POST['tiempoUnico'], '')==0) || (isset($_POST['tiempoInicial']) && isset($_POST['tiempoFinal']) && strcmp($_POST['tiempoInicial'], '')==0 && strcmp($_POST['tiempoFinal'], '')==0)  ) &&( (!isset($_POST['diaSemana'])) || (strcmp($_POST['diaSemana'], '-Omitir-')==0) )){
			
			$resultado=$con->ejecutarSql($consultaSql);
			$cantidadResultados=$con->cantidadRegistros($resultado);
			$totalOcurrencias=0;			

			if($cantidadResultados>0){
				
				for($i=0; $i<$cantidadResultados; $i++){
					$registro=$con->obtenerFila($resultado);
					$totalOcurrencias=$totalOcurrencias+(int)$registro['ocurrencias'];
					$definirData=str_replace("']","','".$registro['condicion']."']",$definirData);
        			$definirData=str_replace("],type",",".$registro['ocurrencias']."],type",$definirData);
				}

				$consultaSql2="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias' FROM encuestasrealizadas INNER JOIN personal ON encuestasrealizadas.no_empleado=personal.no_empleado INNER JOIN usuarios ON encuestasrealizadas.no_empleado = usuarios.no_empleado WHERE encuestasrealizadas.condicion_optima=1 ";
				$resultado2=$con->ejecutarSql($consultaSql2);
				
				if($con->cantidadRegistros($resultado2)>0){
					if(strcmp($registro['ocurrencias'],'0')!=0){
						$registro2=$con->obtenerFila($resultado2);
						$totalOcurrencias=$totalOcurrencias+(int)$registro2['ocurrencias'];
						$innerHTML="document.getElementById('anuncioResultadosGraficas').innerHTML='Se encontraron ".$totalOcurrencias." resultados';";
						$definirData=str_replace("']","','Sin Fatiga']",$definirData);
        				$definirData=str_replace("],type",",".$registro['ocurrencias']."],type",$definirData);

						$definirData=str_replace("'comodin',","",$definirData);
						$definirData=str_replace("comodin,","",$definirData);

						$innerHTML=$innerHTML.$definirData."Plotly.newPlot('plotlyChartPie', dataPie);";
					}
					else{
						$innerHTML="document.getElementById('anuncioResultadosGraficas').innerHTML='No se encontraron resultados';";
						$innerHTML=$innerHTML."dataPie = [{labels: [],values: [],type: 'pie'}];var layout = {height: 400,width: 500}; Plotly.newPlot('plotlyChartPie', dataPie);";
					}

					

				}


			}
			else{
				
				
			}
			echo utf8_encode($innerHTML);
			


		}
		else {
			$consultaSql=str_replace(" GROUP BY ", " WHERE [ comodin ] GROUP BY ", $consultaSql);
			$consultaSql2="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) as 'ocurrencias' FROM encuestasrealizadas INNER JOIN personal ON encuestasrealizadas.no_empleado=personal.no_empleado INNER JOIN usuarios ON encuestasrealizadas.no_empleado = usuarios.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno=turnos.id_turno WHERE [ (encuestasrealizadas.condicion_optima=1) AND comodin ] ";
			if(isset($_POST['condicion']) && strcmp($_POST['condicion'], '-Omitir-')!=0){
				if(strcmp($_POST['condicion'], 'Sin fatiga')==0){
					$consultaSql="SELECT COUNT(encuestasrealizadas.id_encuestasRealizada) AS 'ocurrencias' FROM encuestasrealizadas INNER JOIN usuarios ON encuestasrealizadas.no_empleado=usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno INNER JOIN posicion ON encuestasrealizadas.id_posicion = posicion.id_posicion WHERE [ (encuestasrealizadas.condicion_optima=1) AND comodin ] ";

				}
				else{
					$consultaSql="SELECT COUNT(evaluacionestado.id_evaluacionEstado) AS 'ocurrencias',areaevaluacion.descripcionAreaEvaluacion AS 'condicion' FROM evaluacionestado INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion = areaevaluacion.idAreaEvaluacion INNER JOIN encuestasrealizadas ON evaluacionestado.id_encuestasRealizada=encuestasrealizadas.id_encuestasRealizada INNER JOIN usuarios ON encuestasrealizadas.no_empleado = usuarios.no_empleado INNER JOIN personal ON usuarios.no_empleado = personal.no_empleado INNER JOIN turnos ON encuestasrealizadas.id_turno = turnos.id_turno INNER JOIN posicion ON encuestasrealizadas.id_posicion = posicion.id_posicion WHERE [ (areaevaluacion.descripcionAreaEvaluacion='".$_POST['condicion']."') AND comodin ] ";
				}
				/*else{
					$consultaSql=str_replace(" FROM encuestasrealizadas", ", evaluacionestado.idAreaEvaluacion, areaevaluacion.descripcionAreaEvaluacion FROM encuestasrealizadas INNER JOIN evaluacionestado ON encuestasrealizadas.id_encuestasRealizada = evaluacionestado.id_encuestasRealizada INNER JOIN areaevaluacion ON evaluacionestado.idAreaEvaluacion= areaevaluacion.idAreaEvaluacion ", $consultaSql);
					$consultaSql=str_replace("AND finconsulta", " ( areaevaluacion.descripcionAreaEvaluacion='".$_POST['condicion']."') AND finconsulta", $consultaSql);
				}*/
			}

			$consultaSql=$consultaSql." ;";
			$resultado="";
			if(isset($_POST['nombre']) && strcmp($_POST['nombre'],'')!=0){
				$consultaSql=str_replace(" comodin ", " (usuarios.nombre LIKE ('%".$_POST['nombre']."%')) AND comodin ", $consultaSql);
				$consultaSql2=str_replace(" comodin ", " (usuarios.nombre LIKE ('%".$_POST['nombre']."%')) AND comodin ", $consultaSql2);
			}
			if(isset($_POST['genero']) && strcmp($_POST['genero'], '-Omitir-')!=0){
				if(strcmp($_POST['genero'], 'Femenino')){
					$consultaSql=str_replace(" comodin ", " (personal.sexo='M') AND comodin ", $consultaSql);
					$consultaSql2=str_replace(" comodin ", " (personal.sexo='M') AND comodin ", $consultaSql2);
				}
				else{
					if(strcmp($_POST['genero'], 'Masculino')){
						$consultaSql=str_replace(" comodin ", " (personal.sexo='F') AND comodin ", $consultaSql);
						$consultaSql2=str_replace(" comodin ", " (personal.sexo='F') AND comodin ", $consultaSql2);
					}
				}
			}
			if(isset($_POST['edadUnica']) && strcmp($_POST['edadUnica'], '')!=0){
				$consultaSql=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  = ".$_POST['edadUnica'].") AND comodin ", $consultaSql);
				$consultaSql2=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  = ".$_POST['edadUnica'].") AND comodin ", $consultaSql2);
			}
			else{
				if(isset($_POST['edadInicial']) && isset($_POST['edadFinal']) && strcmp($_POST['edadInicial'],'')!=0 && strcmp($_POST['edadFinal'], '')!=0){
					$consultaSql=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  BETWEEN ".$_POST['edadInicial']." AND ".$_POST['edadFinal'].") AND comodin ", $consultaSql);
					$consultaSql2=str_replace(" comodin ", " (TIMESTAMPDIFF (YEAR, personal.fecha_nacimiento,CURDATE() )  BETWEEN ".$_POST['edadInicial']." AND ".$_POST['edadFinal'].") AND comodin ", $consultaSql2);
				}
				
			}
			if(isset($_POST['fechaUnica']) && strcmp($_POST['fechaUnica'], '')!=0){
				$consultaSql=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion = STR_TO_DATE( '".$_POST['fechaUnica']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql);
				$consultaSql2=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion = STR_TO_DATE( '".$_POST['fechaUnica']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql2);
			}
			else{
				if(isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && strcmp($_POST['fechaInicial'],'')!=0 && strcmp($_POST['fechaFinal'], '')!=0){
					$consultaSql=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion BETWEEN STR_TO_DATE( '".$_POST['fechaInicial']."', '%Y-%m-%d' ) AND STR_TO_DATE( '".$_POST['fechaFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql);
					$consultaSql2=str_replace(" comodin ", " (encuestasrealizadas.fecha_aplicacion BETWEEN STR_TO_DATE( '".$_POST['fechaInicial']."', '%Y-%m-%d' ) AND STR_TO_DATE( '".$_POST['fechaFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql2);
				}
			}
			if(isset($_POST['tiempoUnico']) && strcmp($_POST['tiempoUnico'], '')!=0){
				$consultaSql=str_replace(" comodin ", " (personal.fecha_ingreso = STR_TO_DATE( '".$_POST['tiempoUnico']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql);
				$consultaSql2=str_replace(" comodin ", " (personal.fecha_ingreso = STR_TO_DATE( '".$_POST['tiempoUnico']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql2);
			}
			else{
				if(isset($_POST['tiempoInicial']) && isset($_POST['tiempoFinal']) && strcmp($_POST['tiempoInicial'],'')!=0 && strcmp($_POST['tiempoFinal'], '')!=0){
					$consultaSql=str_replace(" comodin ", " (personal.fecha_ingreso  BETWEEN STR_TO_DATE( '".$_POST['tiempoInicial']."', '%Y-%m-%d' )  AND STR_TO_DATE( '".$_POST['tiempoFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql);
					$consultaSql2=str_replace(" comodin ", " (personal.fecha_ingreso  BETWEEN STR_TO_DATE( '".$_POST['tiempoInicial']."', '%Y-%m-%d' )  AND STR_TO_DATE( '".$_POST['tiempoFinal']."', '%Y-%m-%d' ) ) AND comodin ", $consultaSql2);
				}
				
			}
			if(isset($_POST['turno']) AND strcmp($_POST['turno'], '-Omitir-')!=0){
				$consultaSql=str_replace(" comodin ", " ( turnos.turno='".$_POST['turno']."') AND comodin ", $consultaSql);
				$consultaSql2=str_replace(" comodin ", " ( turnos.turno='".$_POST['turno']."') AND comodin ", $consultaSql2);
			}
			
			if(isset($_POST['diaSemana']) && strcmp($_POST['diaSemana'], '-Omitir-')!=0){
				$consultaSql=str_replace(" comodin ", " (DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) = ".$_POST['diaSemana'].") AND comodin ", $consultaSql);
				$consultaSql2=str_replace(" comodin ", " (DAYOFWEEK(encuestasrealizadas.fecha_aplicacion) = ".$_POST['diaSemana'].") AND comodin ", $consultaSql2);
				
			}
			$consultaSql=str_replace(" WHERE [", " WHERE ",$consultaSql);
			$consultaSql2=str_replace(" WHERE [", " WHERE ", $consultaSql2);
			$consultaSql=str_replace(" AND comodin ] ", " ", $consultaSql);
			$consultaSql2=str_replace(" AND comodin ] ", " ", $consultaSql2);
			
			
			$resultado=$con->ejecutarSql($consultaSql);
			$cantidadResultados=0;
			
			

			if($con->cantidadRegistros($resultado)>0){
				for ($i=0; $i<$con->cantidadRegistros($resultado); $i++){
					$registro=$con->obtenerFila($resultado);
						$cantidadResultados=$cantidadResultados+(int)$registro['ocurrencias'];
						if(strcmp($registro['ocurrencias'], '0')!=0){
							if(strcmp($_POST['condicion'], 'Sin fatiga')==0){
								$definirData=str_replace("']","','Sin Fatiga']",$definirData);
        						$definirData=str_replace("],type",",".$registro['ocurrencias']."],type",$definirData);
        						

							}
							else{
								$definirData=str_replace("']","','".$registro['condicion']."']",$definirData);
        						$definirData=str_replace("],type",",".$registro['ocurrencias']."],type",$definirData);
        						
							}
							
						}
						else{
							$innerHTML="document.getElementById('anuncioResultadosGraficas').innerHTML='No se encontraron resultados';";
							$innerHTML=$innerHTML."dataPie = [{labels: [],values: [],type: 'pie'}];var layout = {height: 400,width: 500}; Plotly.newPlot('plotlyChartPie', dataPie);";
						}						
				}
				if(strcmp($_POST['condicion'], '-Omitir-')==0){

					$resultado2=$con->ejecutarSql($consultaSql2);
					if($con->cantidadRegistros($resultado2)>0){
						$registro2=$con->obtenerFila($resultado2);
						if($con->cantidadRegistros($resultado2)>0){
							if(strcmp($registro2['ocurrencias'],'0')!=0){
								$cantidadResultados=$cantidadResultados+(int)$registro2['ocurrencias'];
								$definirData=str_replace("']","','Sin Fatiga']",$definirData);
        						$definirData=str_replace("],type",",".$registro2['ocurrencias']."],type",$definirData);
							}							
						}
						
					}
				}
				$innerHTML="document.getElementById('anuncioResultadosGraficas').innerHTML='Se encontraron ".$cantidadResultados." resultados';";
				$innerHTML=$innerHTML.$definirData; 
				$innerHTML=str_replace("'comodin',","",$innerHTML);
				$innerHTML=str_replace("['comodin']","[]",$innerHTML);
				$innerHTML=str_replace("comodin,","",$innerHTML);
				$innerHTML=str_replace("[comodin],","[],",$innerHTML);
				$innerHTML=$innerHTML." Plotly.newPlot('plotlyChartPie', dataPie);"; 
				
			

				
			}
			else{
				$innerHTML="document.getElementById('anuncioResultadosGraficas').innerHTML='No se encontraron resultados';";
				$innerHTML=$innerHTML."dataPie = [{labels: [],values: [],type: 'pie'}];var layout = {height: 400,width: 500}; Plotly.newPlot('plotlyChartPie', dataPie);";
			}

			echo utf8_encode($innerHTML);


		}		

	}
	else{
		echo"error";
	}
?>