<?php
	session_start();
	if(empty($_SESSION)){
		header('location:../Login/login.php');
	}
	if(isset($_POST['no_encuesta'])){
		echo("<INPUT type='hidden' id='no_encuesta' value='".$_POST['no_encuesta']."'>");
	}
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<TITLE>Área de controladores</TITLE>
		<META charset="UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<LINK rel="stylesheet" type="text/css" href="CSS\estilos_visualizacion_encuesta.css" media="screen"/>
	</HEAD>
	<script type="text/javascript">
		function colorearTabla(){
			tabla=document.getElementsByClassName('filaTablaPreguntas');
			for(i=0; i<tabla.length; i++){
				if(i%2==0){
					tabla[i].style.backgroundColor="#AEB6BF";
				}
				else{
					tabla[i].style.backgroundColor="#E5E7E9";
				}
			}
		}

		function obtenerPreguntas(){
			$.ajax({
				type:"post",
				url:"PHP/obtenerPreguntas.php",
				data:{'no_encuesta':document.getElementById('no_encuesta').value},
				success: function(resp){
					if(resp.localeCompare("error")==0){
						alert("error");
					}
					else{
						eval(resp);
						colorearTabla();
					}
				}
			});
		}


	</script>
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
	<BODY bgcolor="#B2BABB" id="cuerpo" onload="obtenerPreguntas()" style="margin:0; padding: 0">
		<div id="encabezado" >
			<button id="boton_volver" onclick="location.href='reporteria.php'">Volver</button>
			<div id="div_identificadorPagina">

				<div id="div_iconoPagina">
					<img src="iconos\inicio.png" style="width: 90%; height: 90%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Visualización de Encuesta</label>
				</div>
			</div>
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
								(Administrador)
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
		<CENTER>
			<DIV id="contenedorPrincipal_encuesta" >
				<DIV class="etiqueta_faseEvaluacion">
						<TABLE id="Tabla_infoEncuesta">
							<TR class="fila_infoEncuesta">
								<TD id="etiqueta_momentoAplicacion" class="columna_infoEncuesta_etiqueta" style="width:20%;">
									Momento de aplicación:
								</TD>
								<TD id="valor_momentoAplicacion" class="columna_infoEncuesta">
								</TD>
								<TD id="etiqueta_turnoControlador" class="columna_infoEncuesta_etiqueta" >
									Turno: 
								</TD>
								<TD id="valor_turnoControlador" class="columna_infoEncuesta">
								</TD>
							</TR>
							<TR class="fila_infoEncuesta">
								<TD id="etiqueta_NombreControlador" class="columna_infoEncuesta_etiqueta" style="width:20%">
									Nombre:
								</TD>
								<TD id="valor_nombreControlador" class="columna_infoEncuesta">
								</TD>
								<TD id="etiqueta_fechaIngresoControlador" class="columna_infoEncuesta_etiqueta">
									Fecha de ingreso:
								</TD>
								<TD id="Valor_fechaIngresoControlador" class="columna_infoEncuesta">
								</TD>
							</TR>
							<TR class="fila_infoEncuesta">
								<TD id="etiqueta_GeneroControlador" class="columna_infoEncuesta_etiqueta" style="width:20%">
									Sexo:
								</TD>
								<TD id="valor_generoControlador" class="columna_infoEncuesta">
								</TD>
								<TD id="etiqueta_posicionControlador" class="columna_infoEncuesta_etiqueta">
									Posición:
								</TD>
								<TD id="valor_posicionControlador" class="columna_infoEncuesta">
								</TD>
								
							</TR>
							<TR class="fila_infoEncuesta">
								<TD id="etiqueta_edadControlador" class="columna_infoEncuesta_etiqueta" style="width:20%">
									Edad:
								</TD>
								<TD id="valor_edadControlador" class="columna_infoEncuesta">
									
								</TD>
								<TD id="etiqueta_condicionControlador" class="columna_infoEncuesta_etiqueta">
									Condición:
								</TD>
								<TD id="valor_condicionControlador" class="columna_infoEncuesta">
								</TD>
							</TR>
						</TABLE>
				</DIV>
				<DIV id="div_Preguntas">
					<DIV id="contenedor_listaPreguntas">
						<TABLE id="campos_tablaPregunta" style="width:100%; height: 10%">
							<TR id="fila_camposPregunta">
								<TD  class="campo_noPregunta">
									No
								</TD>
								<TD  class="campoSintomaPregunta">
									Sintoma
								</TD>
								<TD  class="campo_RespuestaPregunta">
									Respuesta
								</TD>
							</TR>
						</TABLE>
						<TABLE id="tabla_Peguntas" style="width: 100%; height: 90%">

						</TABLE>
					</DIV>					
				</DIV>
			</DIV>
		</CENTER>
	</BODY>
</HTML>