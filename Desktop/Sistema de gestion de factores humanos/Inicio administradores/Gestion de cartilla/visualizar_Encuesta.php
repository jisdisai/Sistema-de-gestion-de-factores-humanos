<?php
	include("conexion.php");
	session_start();
	if(empty($_SESSION)){
		header('location:../Login/login.php');
	}
	if(isset($_POST['area'])){
		$GLOBALS['area']=$_POST['area'];
	}
	else{
		if(isset($_GET['area'])){

			$GLOBALS['area']=$_GET['area'];		}
		else{
			echo "Hay un error";
		}
	}
?>
<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

	function abrirFormularioNuevaPregunta(editarPreguntaExistente,numeroPregunta) {
		document.getElementById('vistaPreviaEncuesta').style.display="none";
		document.getElementById('formularioNuevaPregunta').style.display="block";
		document.getElementById('botonesVistaPreviaEncuesta').style.display="none";
		document.getElementById('botonesNuevaPregunta').style.display="block";
		document.getElementById('textAreaDespcripcionPregunta').focus();
		if(editarPreguntaExistente){
			var descripcionPregunta=document.getElementById('descripcionPregunta'+numeroPregunta).innerHTML;
			var tipoPregunta=document.getElementById('descripcionTipoPregunta'+numeroPregunta).innerHTML;
			document.getElementById('textAreaDespcripcionPregunta').value=descripcionPregunta;
			if (tipoPregunta.localeCompare('cerrada') == 0){
				document.getElementById('radioCerrada').checked="true";
				document.getElementById('radioEscala').checked="false";
				document.getElementById('respuestasCerradas').style.display="block";
				document.getElementById('limitesEscala').style.display="none";
			}
			else{
				document.getElementById('radioCerrada').checked="false";
				document.getElementById('radioEscala').checked="true";
				document.getElementById('respuestasCerradas').style.display="none";
				document.getElementById('limitesEscala').style.display="block";
				document.getElementById('valorMinimo').value=document.getElementById('valorMinimoPregunta'+numeroPregunta).innerHTML;
				document.getElementById('valorMaximo').value=document.getElementById('valorMaximoPregunta'+numeroPregunta).innerHTML;

			}
			document.getElementById('nPregunta').value=numeroPregunta;

		}


	}
	function recargar(){
		window.reload();
	}
	function eliminarPregunta(numeroPregunta,tipoRespuesta){
		var numeroPregunta=numeroPregunta;
		var tipoRespuesta=tipoRespuesta;
		$.ajax({
			type:'post',
			url:'eliminarPregunta.php',
					data:{'numeroPregunta':numeroPregunta,'tipoRespuesta':tipoRespuesta},
					success: function(resp){
						location.reload();
					}

				});
	}
</script>
<script type="text/javascript">
		function mostrarCierreSesion(){
			document.getElementById('div_cerrarSesion').style.display="flex";
		}
		function ocultarCierreSesion(){
			document.getElementById('div_cerrarSesion').style.display="none";
		}
		function cerrarSesion(){
			$.ajax({
				type:"post",
				url:"PHP/cerrarSesion.php",
				success: function(resp){
					eval(resp);
				}
			});
		}
		function identificarUsuario(){
			$.ajax({
				type:"post",
				url:"PHP/identificarUsuario.php",
				data:{'tipo':1},
				success: function(resp){
					if(resp.localeCompare('error')==0){
							alert("Error al identificar Usuario");
					}
					else{
						eval(resp);
					}						
				}
			});
		}
	</script>
	<script type="text/javascript">
		identificarUsuario();
		$(document).on("click",function(e) {
	       var container = $("#div_identificadorTipoUsuario");
    	   var container2=$("#div_cerrarSesion");
        	if ( (!container.is(e.target) && container.has(e.target).length === 0) && (!container2.is(e.target) && container2.has(e.target).length === 0)) { 
           		ocultarCierreSesion();
            }
   		});
		
	</script>
<head>
	<?php
	echo("<title>Encuesta de ".$area."</title>");
	?>
	<META chrset="UTF_8">
	<link rel="stylesheet" type="text/css" href="CSS3\estilos_visualizar_Encuesta.css" media="screen"/>
</head>
<body style="display:block" bgcolor="#B2BABB">
	<div id="encabezado">
		<button id="boton_volver" onclick="location.href='gestion_encuestas.php'">Volver</button>
		<div id="div_identificadorUsuario">
				<div id="div_iconoUsuario">
					<div id="circulo">
						<img src="iconos\administrador.png" style="width: 50%; height: 50%">
					</div>
				</div>
				<div id="div_etiquetaUsuario">
					<div id="nombreUsuario">
								Nombre de Usuario						
					</div>
					<div id="div_contenedorBarraSesion">
						<div id="div_identificadorTipoUsuario" onclick="mostrarCierreSesion()" onblur="ocultarCierreSesion()">
							<div id="identificadorTipoUsuario">
								(Administrador del sistema)
							</div>
							<div id="div_triangulo">
								<div id="triangulo"></div>
							</div>
						</div>
						<div id="div_cerrarSesion" onclick="cerrarSesion()">
							Cerrar Sesión
						</div>
					</div>
				</div>
			</div>
	</div>
	<div class="contenedorPrincipal">
		<h3 style="margin-top: 0px; margin-bottom: 0px; margin-left: 3%">Elementos de la encuesta</h3>
		<hr>
		<br style="margin=0; padding: 0">
		<div id="vistaPreviaEncuesta">
			<Table id="ColumnasTablaPreguntas">
				<tr class="filaTablaPreguntas">
					<td class="columnaPreguntas" align="center" style="width: 5%">N°</td>
					<td class="columnaPreguntas" align="center" style="width: 60%">Descripción</td>
					<td class="columnaPreguntas" align="center" style="width: 20%">Tipo de Respuesta</td>
					<td class="columnaPreguntas" align="center"></td>
				</tr>
			</Table>
			<Table id="TablaPreguntas">
					<?php
						$con=mysqli_connect("localhost","root","","cocesna");
						$consulta=utf8_decode("SELECT pregunta.idpregunta, pregunta.descripcionPregunta, tiporespuesta.descripcionTipo FROM pregunta INNER JOIN tiporespuesta on pregunta.idTipoRespuesta = tiporespuesta.idTipoRespuesta WHERE pregunta.idAreaEvaluacion IN (SELECT areaevaluacion.idAreaEvaluacion from areaevaluacion WHERE areaevaluacion.descripcionAreaEvaluacion = '".$area."')");
						$resultadoConsulta=$con->query($consulta);
						while($registro=$resultadoConsulta->fetch_assoc()){
							echo("<tr class='filaTablaPreguntas' id=\"pregunta".$registro['idpregunta']."\">");
							echo("<td class='celdaTablaPreguntas' align='center' style='width:5%'>".$registro['idpregunta']."</td>");
							echo utf8_encode("<td class='celdaTablaPreguntas' align='center' id=\"descripcionPregunta".$registro['idpregunta']."\" style='width:60%'>".$registro['descripcionPregunta']."</td>");

							if(strcmp ($registro['descripcionTipo'] , 'escala numerica' ) == 0){
								$consulta2="SELECT valorMinimo, valorMaximo FROM rangorespuestasescalaxpregunta WHERE idPregunta=".$registro['idpregunta'];
								$resultado2=$con->query($consulta2);
								$registro2=$resultado2->fetch_assoc();
								echo utf8_encode("<td class='celdaTablaPreguntas' align='center' id=\"descripcionTipoPregunta".$registro['idpregunta']."\" style='width:20%'>"
									.$registro['descripcionTipo']."<br>(<label id='valorMinimoPregunta".$registro['idpregunta']."'>".$registro2['valorMinimo']."</label> - <label id='valorMaximoPregunta".$registro['idpregunta']."'>".$registro2['valorMaximo']."</label>)</td>");

							}
							else{
								echo utf8_encode("<td class='celdaTablaPreguntas' align='center' id=\"descripcionTipoPregunta".$registro['idpregunta']."\">".$registro['descripcionTipo']."</td>");
							}
							echo ("<td class='celdaTablaPreguntas' style='paddin:0; margin:0'>
									<button class='botonEditarPregunta' onclick=\"abrirFormularioNuevaPregunta(true,".$registro['idpregunta'].")\">Editar</button>
									<button class='botonEliminarPregunta' onclick=\"eliminarPregunta(".$registro['idpregunta'].",'".$registro['descripcionTipo']."')\">Eliminar</button>
								</td>");
							echo("</tr>");
						}
					?>
					<script>
						var filas=document.getElementsByClassName('filaTablaPreguntas');
						for(i=0; i<filas.length; i++){
							if((i%2)==0){
								filas[i].style.backgroundColor="#AEB6BF";
							}
							else{
								filas[i].style.backgroundColor="#E5E7E9";
							}
						}
					</script>
			</Table>
		</div>
		<div id="formularioNuevaPregunta">
			<form method="POST" action="guardar_nueva_encuesta.php" style="width: 100%; height: 100%; padding: 0; margin: 0">
			<h3 style="margin-top: 0px; margin-bottom: 0px; margin-left: 3%">Nueva Pregunta</h3>
			<hr>
				<div id="div_informacionPregunta">
					<label for="areaEvaluacion" id="etiqueta_areaEvaluacion">Área de evaluación: </label>
					<input type="text" name="areaEvaluacion" id="areaEvaluacion" readonly="true" value="<?php echo $GLOBALS['area'];?>" >
					<br>
					<label for="nPregunta" id="etiqueta_nPregunta">Id de pregunta: </label>
					<input type='text' id="nPregunta" readonly name ='nPregunta' value='no definido' style="visibility:'hidden'">
					<br>
				</div>

				<label for="descripcionPregunta" id="etiqueta_descripcionPregunta">Descripción:</label>
				<hr style="width: 80%">
				<br>
				<input type="textArea" name="descripcionPregunta" id="textAreaDespcripcionPregunta" style="text-align: center" required="true">
				<br>
				<label id="etiqueta_tipoRespuesta">Tipo de Respuesta:</label>
				<hr style="width: 80%">
				<br>
				<div id="div_tipoRespuesta">
					<script type="text/javascript">
						function habilitarRespuestasCerradas(){
							document.getElementById('respuestasCerradas').style.display='block';
							document.getElementById('limitesEscala').style.display='none';
							document.getElementById('valorMinimo').required=false;
							document.getElementById('valorMaximo').required=false;
						}
						function habilitarRespuestasEscala(){
							document.getElementById('respuestasCerradas').style.display='none';
							document.getElementById('limitesEscala').style.display='block';
							document.getElementById('valorMinimo').required=true;
							document.getElementById('valorMaximo').required=true;
						}
						function validarValorMaximo(){
							var valorMaximo=document.getElementById('valorMaximo').value;
							var valorMinimo=document.getElementById('valorMinimo').value;
							if(((valorMaximo-valorMinimo)<0) || (valorMinimo<0) || (valorMaximo<0)){
								document.getElementById('guardarNuevaPregunta').disabled=true;
								document.getElementById('guardarNuevaPregunta').style.opacity=0.6;
								//alert("Valores no válidos para el rango de respuestas");
							}
							else{
								document.getElementById('guardarNuevaPregunta').disabled=false;
								document.getElementById('guardarNuevaPregunta').style.opacity=1;
								
							}
						}
					</script>
					
					<label class="etiquetaRadio">
						Cerrada
						<input type="radio" name="tipoRespuesta" id="radioCerrada" checked value="cerrada" onclick="habilitarRespuestasCerradas()">
					</label>
					<label class="etiquetaRadio">
						Escala numérica
						<input type="radio" name="tipoRespuesta" id="radioEscala" value="escala" onclick="habilitarRespuestasEscala()">
					</label>
					<div id="respuestasCerradas" style="display: block">
						Posibles respuestas:
						<br>
						<ul>
							<li>Si</li>
							<li>No</li>
						</ul>
					</div>
					<div id="limitesEscala" style="display: none">
						<label>
							Valor Mínimo
							<input type="number" name="escalaValorMinimo" id="valorMinimo" onchange="validarValorMaximo()">
						</label>
						<br>
						<label>
							Valor Máximo
							<input type="number" name="escalaValorMaximo" id="valorMaximo" onchange="validarValorMaximo()">
						</label>
						<br>
					</div>
				</div>

				<div id="botonesNuevaPregunta">
					<input type="submit" name="guardarNuevaPregunta" id="guardarNuevaPregunta" value ="Guardar" >
					<input type="button" id="cancelarNuevaPregunta" name="cancelarNuevaPregunta" onclick="location.reload()" value="Cancelar">
				</div>	
			</form>


	

		</div>
		<div id="botonesVistaPreviaEncuesta">
			<button id="botonAgregarPregunta" onclick="abrirFormularioNuevaPregunta(false,0)">Agregar Pregunta</button>
		</div>

	</div>
</body>
</html>

