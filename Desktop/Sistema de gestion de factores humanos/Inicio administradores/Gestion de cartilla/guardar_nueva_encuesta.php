<?php
	$GLOBALS['con']=mysqli_connect('localhost','root','','cocesna');
	session_start();
	foreach($_POST as $campo => $valor){
 										echo "<br />- ". $campo ." = ". $valor;
									}
	if(isset($_POST['nPregunta'])){
		if (strcmp ($_POST['nPregunta'] , 'no definido' ) == 0){
				if(isset($_POST['descripcionPregunta'])){
		if(isset($_POST['tipoRespuesta'])){
			if (strcmp ($_POST['tipoRespuesta'] , 'cerrada' ) == 0) {
				$consulta=utf8_decode("INSERT INTO pregunta (descripcionPregunta,idAreaEvaluacion,idTipoRespuesta) VALUES ('".$_POST['descripcionPregunta']."',(SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion='".$_POST['areaEvaluacion']."'),(SELECT idTipoRespuesta FROM tiporespuesta WHERE descripcionTipo='cerrada'))");
				
				$detalle=("Agregó la pregunta [".$_POST['descripcionPregunta']."] de tipo cerrada a la encuesta del área de evaluación [".$_POST['areaEvaluacion']."]");
				$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
				$insertar=$con->query($insertLog);
				

				$resultado=$con->query($consulta);
				//echo($consulta);
				echo("<br>".mysqli_error($con));
			}

			else{
				if (strcmp ($_POST['tipoRespuesta'] , 'escala' ) == 0) {
					if(isset($_POST['escalaValorMinimo'])){
						if (strcmp ($_POST['escalaValorMinimo'] , '' ) == 0) {
							echo("Valor minimo no valido");
						}
						else{
							if(isset($_POST['escalaValorMaximo'])){
								if (strcmp ($_POST['escalaValorMaximo'] , '' ) == 0) {
									echo("valor maximo no valido");
								}
								else{
									
									$consulta=utf8_decode("INSERT INTO pregunta (descripcionPregunta,idAreaEvaluacion,idTipoRespuesta) VALUES ('".$_POST['descripcionPregunta']."',(SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion='".$_POST['areaEvaluacion']."'),(SELECT idTipoRespuesta FROM tiporespuesta WHERE descripcionTipo='escala numerica'))");
									$resultadoConsulta=$con->query($consulta);

									$consulta=utf8_decode("INSERT INTO rangorespuestasescalaxpregunta (idPregunta,valorMinimo,ValorMaximo) VALUES ((SELECT idPregunta FROM pregunta WHERE descripcionPregunta = '".$_POST['descripcionPregunta']."'),".$_POST['escalaValorMinimo'].",".$_POST['escalaValorMaximo'].")");
									$resultadoConsulta=$con->query($consulta);

									$detalle=("Agregó la pregunta [".$_POST['descripcionPregunta']."] de tipo escala numérica con un rango de [".$_POST['escalaValorMinimo']."-".$_POST['escalaValorMaximo']."] a la encuesta del área de evaluación [".$_POST['areaEvaluacion']."]");
									$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
									$insertar=$con->query($insertLog);
								}
							}
							else{
								echo "Falta el valor Maximo";
							}
						}						
					}
					else{
						echo "Falta el valor Minimo";
					}
				}
				else{
					echo("Error con el tipo de respuesta");
				}
			}
		

		}
			else{
				echo("Falta el tipo de respuesta");
				}

			}
			else{
				echo("Hay un Error");
			}
		}
		else{
			$consultaDescripcionPregunta="SELECT descripcionPregunta FROM pregunta WHERE idPregunta=".$_POST['nPregunta'];
			$resultadoDescripcionPregunta=$con->query($consultaDescripcionPregunta);
			$registroDescripcionPregunta=$resultadoDescripcionPregunta->fetch_assoc();
			$old_pregunta=$registroDescripcionPregunta['descripcionPregunta'];
			if(strcmp ($_POST['tipoRespuesta'] , 'escala' ) == 0){
				
				
				$consulta = utf8_decode("SELECT idRango FROM rangorespuestasescalaxpregunta WHERE idPregunta = ".$_POST['nPregunta']);
				$resultado=$con->query($consulta);
				$old_valores="";
				$new_valores="";
				$rangoExtraido=$resultado->fetch_assoc();
				if (mysqli_num_rows($resultado)==0 && strcmp($rangoExtraido['idRango'], '')==0){
					$consulta = utf8_decode("INSERT INTO rangorespuestasescalaxpregunta (idPregunta, valorMinimo, valorMaximo) VALUES (".$_POST['nPregunta'].",".$_POST['escalaValorMinimo'].",".$_POST['escalaValorMaximo'].")");
					$resultado=$con->query($consulta);
					$old_valores="tipo: [Cerrada]";
					$new_valores="tipo: [Escala], rango: [".$_POST['escalaValorMinimo']."-".$_POST['escalaValorMaximo']."]";
				}
				else{
					$consultaRango="SELECT * FROM rangorespuestasescalaxpregunta WHERE idPregunta=".$_POST['nPregunta'];
					$resultadoRango=$con->query($consultaRango);
					$registroRango=$resultadoRango->fetch_assoc();
					$old_valores="rango: [".$registroRango['valorMinimo']."-".$registroRango['ValorMaximo']."]";
					$new_valores="rango: [".$_POST['escalaValorMinimo']."-".$_POST['escalaValorMaximo']."]";
					$consulta=utf8_decode("UPDATE rangorespuestasescalaxpregunta SET valorMinimo = ".$_POST['escalaValorMinimo'].", valorMaximo = ".$_POST['escalaValorMaximo']." WHERE idPregunta = ".$_POST['nPregunta']);
					$resultado=$con->query($consulta);

					
					
				}

				$InsertarDescripcion=utf8_decode("UPDATE pregunta set descripcionPregunta = '".$_POST['descripcionPregunta']."', idAreaEvaluacion = (SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion = '".$_POST['areaEvaluacion']."'), idTipoRespuesta = (SELECT idTipoRespuesta FROM tiporespuesta WHERE descripcionTipo='escala numerica') WHERE idPregunta = ".$_POST['nPregunta']);
				$resultadoInsertarDescripcion=$con->query($InsertarDescripcion);
				echo(mysqli_error($con));

			}
			else{
				$consulta=utf8_decode("UPDATE pregunta set descripcionPregunta = '".$_POST['descripcionPregunta']."', idAreaEvaluacion = (SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion = '".$_POST['areaEvaluacion']."'), idTipoRespuesta = (SELECT idTipoRespuesta FROM tiporespuesta WHERE descripcionTipo='cerrada') WHERE idPregunta = ".$_POST['nPregunta']);
				$resultado=$con->query($consulta);

				$consulta = utf8_decode("DELETE FROM rangorespuestasescalaxpregunta WHERE idPregunta = ".$_POST['nPregunta']);
				$resultado = $con->query($consulta);
				$old_valores="tipo: [Escala]";
				$new_valores="tipo: [Cerrada]";
				echo(mysqli_error($con));

			}
			
			$consultaDescripcionPregunta="SELECT descripcionPregunta FROM pregunta WHERE idPregunta=".$_POST['nPregunta'];
			$resultadoDescripcionPregunta=$con->query($consultaDescripcionPregunta);
			$registroDescripcionPregunta=$resultadoDescripcionPregunta->fetch_assoc();
			$new_pregunta=$registroDescripcionPregunta['descripcionPregunta'];
			if(strcmp($old_pregunta,$new_pregunta)!=0){
				$old_valores=$old_valores.", descripcion: [".$old_pregunta."]";
				$new_valores=$new_valores.", descripcion: [".$new_pregunta."]";
			}

			$old_valores=utf8_encode($old_valores);
			$new_valores=utf8_encode($new_valores);
			$detalle=("Atualizó la pregunta con id [".$_POST['nPregunta']."] de la encuesta del área de evaluación [".$_POST['areaEvaluacion']."]. Antiguos valores: (".$old_valores."). Nuevos valores: (".$new_valores.").");
			$insertLog=utf8_decode("INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".($detalle)."')");						
			$insertar=$con->query($insertLog);
		}
	}
	else{
		echo "el div no se definio";
	}
	header("location:visualizar_Encuesta.php?area=".$_POST['areaEvaluacion']);
?>