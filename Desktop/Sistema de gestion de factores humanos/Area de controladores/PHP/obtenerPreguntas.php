<?php
	include('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['area'])){
			$area=$_POST['area'];
			$no_empleado=$_SESSION['no_empleado'];
			$con = new Conexion();
			$innerHTML="";
			
			$consulta="SELECT * FROM pregunta WHERE idAreaEvaluacion IN (SELECT idAreaEvaluacion FROM areaevaluacion WHERE descripcionAreaEvaluacion='".$area."') ORDER BY idPregunta ASC";
			$resultado=$con->ejecutarSql($consulta);
			if($con->hayError($resultado)==false){
				if($con->cantidadRegistros($resultado) > 0){

					for($i=0; $i<$con->cantidadRegistros($resultado); $i++){
						$registro=$con->obtenerFila($resultado);
						$innerHTML=$innerHTML."<TR class='filaTablaPreguntas'>";
						$innerHTML=$innerHTML."<TD class='campo_noPregunta'>".($i+1)."</TD>";
						$innerHTML=$innerHTML."<TD class='campoSintomaPregunta'>".$registro['descripcionPregunta']."</TD>";
						if(strcmp($registro['idTipoRespuesta'],'1')==0){
							$innerHTML=$innerHTML."<TD class='campo_RespuestaPregunta'><SELECT id='respuesta-".$registro['idPregunta']."-1' class='selectRespuesta'><OPTION>Si</OPTION><OPTION>No</OPTION></SELECT></TD>";
						}
						else{
							$innerHTML=$innerHTML."<TD class='campo_RespuestaPregunta'><SELECT id='respuesta-".$registro['idPregunta']."-2' class='selectRespuesta'>";
							$consulta2="SELECT valorMinimo,valorMaximo FROM rangorespuestasescalaxpregunta WHERE idPregunta=".$registro['idPregunta'];
							$resultado2=$con->ejecutarSql($consulta2);
							$registro2=$con->obtenerFila($resultado2);
							$valorMinimo=(int)$registro2['valorMinimo'];
							$valorMaximo=(int)$registro2['valorMaximo'];
							for($j=$valorMinimo; $j<=$valorMaximo; $j++){
								$innerHTML=$innerHTML."<OPTION>".$j."</OPTION>";
							}
							$innerHTML=$innerHTML."</SELECT></TD>";
						}
						$innerHTML=$innerHTML."</TR>";
					}
					$con->cerrarConexion();
					echo utf8_encode($innerHTML);
				}
				else{
					//$innerHTML="<TR style='width:100%'><TD style='width:100%; text-align:center; font-family: sans-serif'><h4>No hay Preguntas Definidas en esta encuesta</h4><TD></TR><SCRIPT type=\"text/javascript\">document.getElementById('boton_siguienteAreaEvaluacion').disabled=true;document.getElementById('boton_siguienteAreaEvaluacion').style.opacity=0.6;</SCRIPT>";//

					$con->cerrarConexion();
					//echo $innerHTML;
					echo "sinpreguntas";
				}
			}
			else{
				$con->cerrarConexion();
				echo"error";
			}
		}
				
		
	}
	else{
		echo"error";
	}
?>