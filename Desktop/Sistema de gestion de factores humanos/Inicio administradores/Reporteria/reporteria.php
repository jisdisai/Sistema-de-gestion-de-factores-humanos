<?php
	session_start();
	if(empty($_SESSION)){
		header('location:../Login/login.php');
	}
?>

<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<TITLE>Área de R.R.H.H.</TITLE>
		<META charset="utf-8">
		<LINK rel="stylesheet" type="text/css" href="CSS\estilos_rrhh.css" media="screen"/>
		<LINK rel="stylesheet" type="text/css" href="CSS\toggle.css" media="screen"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="plotly/plotly-latest.min.js"></script>
	</HEAD>
	<script type="text/javascript">

		function eliminarEntrada(id_encuesta){
				if(confirm("¿Estás seguro de querer eliminar permanentemente este registro?")){
	   				$.ajax({
						type:"post",
						url:"PHP/eliminarEncuesta.php",
						data:{'id_encuesta':id_encuesta},
						success: function(resp){
							if(resp.localeCompare("error")==0){
								alert("Ocurrió un error al tratar de eliminar el registro");
								
							}
							else{
								alert(resp);
								location.reload();
							}
						}	
					});
				}
				else{
	   				return false;
				}
		}
		function verControlador(id_encuesta){
			$.ajax({
				type:"post",
				url:"PHP/verControlador.php",
				data:{'id_encuesta':id_encuesta},
				success: function(resp){
					eval(resp);
				}
			});

		}

		function mostrarGraficas(idGrafica){
			graficas=document.getElementsByClassName('div_grafica');
			for(i=0; i<graficas.length;i++){
				graficas[i].style.display="none";
			}
			document.getElementById(idGrafica).style.display="flex";
			if(select_graficas.value.localeCompare('div_graficaBarra')==0){
				actualizarGraficaBarras();
			}
			else{
				if(select_graficas.value.localeCompare('div_graficaPie')==0){
					actualizarGraficaPie();
				}
				else{
					if(select_graficas.value.localeCompare('div_graficaIntercepciones')==0){
						actualizarGraficaIntercepciones();
					}
				}
			}

		}
		function colorearTabla(){
			
			var filas=document.getElementsByClassName('filaResultados');
				for(i=0; i<filas.length; i++){
					if((i%2)==0){
						filas[i].style.backgroundColor="#AEB6BF";
					}
					else{
						filas[i].style.backgroundColor="#E5E7E9";
						}
				}
		}
		
		function activarVista( vista ){
			var tabs=document.getElementsByClassName('tab');
			for(i=0; i<tabs.length; i++){
				tabs[i].style.backgroundColor="white";
				tabs[i].style.color="#424949";
			}
			document.getElementById(vista).style.backgroundColor="#3498DB";
			document.getElementById(vista).style.color="white";
			if(vista.localeCompare('tabGraficas')==0){
				document.getElementById('contenedorReportes').style.display="none";
				document.getElementById('contenedorGraficas').style.display="block";
			}
			else{
				if(vista.localeCompare('tabReportes')==0){
					document.getElementById('contenedorReportes').style.display="block";
					document.getElementById('contenedorGraficas').style.display="none";
				}
				
			}

		}
		function cambiarEntradaFecha(){
			if(document.getElementById('checkboxFecha').checked){
				document.getElementById('slideFecha').innerHTML="Rango";
				document.getElementById('EntradaFechaRango').style.display="flex";
				document.getElementById('entradaFechaUnica').style.display="none";
				document.getElementById('select_diaSemana').disabled=false;
			}
			else{
				document.getElementById('slideFecha').innerHTML="Única";
				document.getElementById('EntradaFechaRango').style.display="none";
				document.getElementById('entradaFechaUnica').style.display="flex";
				document.getElementById('select_diaSemana').disabled=true;
			}
		}
		function cambiarEntradaEdad(){
			if(document.getElementById('checkboxEdad').checked){
				document.getElementById('slideEdad').innerHTML="Rango";
				document.getElementById('entradaEdadRango').style.display="flex";
				document.getElementById('entradaEdadUnica').style.display="none";
			}
			else{
				document.getElementById('slideEdad').innerHTML="Única";
				document.getElementById('entradaEdadRango').style.display="none";
				document.getElementById('entradaEdadUnica').style.display="flex";
			}
		}
		function cambiarEntradaTiempoLaborar(){
			if(document.getElementById('checkboxTiempoLaborar').checked){
				document.getElementById('slideTiempoLaborar').innerHTML="Rango";
				document.getElementById('entradaTiempoRango').style.display="flex";
				document.getElementById('entradaTiempoUnico').style.display="none";
			}
			else{
				document.getElementById('slideTiempoLaborar').innerHTML="Único";
				document.getElementById('entradaTiempoRango').style.display="none";
				document.getElementById('entradaTiempoUnico').style.display="flex";
			}
		}
		/*
		var con0={x:['(Sábado) 2019-09-28'],y:[1],name:'Automedicación',type:'scatter'};
		var con1={x:['(Sábado) 2019-09-28', '(Miércoles) 2019-10-01', '(Sábado) 2019-10-05'],y:[2, 1, 1],name:'Enfermedades',type:'scatter'};
		var con2={x:['(Sábado) 2019-09-28', '(Jueves) 2019-10-02'],y:[2, 1],name:'Estado de ánimo',type:'scatter'};

		var sinFatiga={x:['(Sábado) 2019-09-28', '(Jueves) 2019-10-02'],y:[2, 2],name:'Sin Fatiga',type:'scatter'};

		dataIntercepcion = [con0, con1, con2, sinFatiga];Plotly.newPlot('plotlyChartIntercepciones', dataIntercepcion);
*/
		function actualizarGraficaIntercepciones(){
			var nombre=document.getElementById('nombreControlador').value;
			var genero=document.getElementById('select_generoControlador').value;
			var turno=document.getElementById('select_turno').value;
			var condicion=document.getElementById('select_condicion').value;
			var ajx="$.ajax({type:'post',url:'PHP/actualizarGraficaIntercepciones.php',data:{},success:function(resp){if(resp.localeCompare('error')==0){alert('error');}else{eval(resp);}}});";
			var data="data:{'nombre':'"+nombre+"','genero':'"+genero+"', 'turno':'"+turno+"', 'condicion':'"+condicion+"'},success";
			if(document.getElementById('checkboxFecha').checked){
				var fechaInicial=document.getElementById('fecha_inicial').value;
				var fechaFinal=document.getElementById('fecha_final').value;
				var diaSemana=document.getElementById('select_diaSemana').value;
				data=data.replace("},success",",'fechaInicial':'"+fechaInicial+"', 'fechaFinal':'"+fechaFinal+"','diaSemana':'"+diaSemana+"'},success");
			}
			else{
				var fechaUnica=document.getElementById('fechaUnica').value;
				data=data.replace("},success",",'fechaUnica':'"+fechaUnica+"'},success");
			}
			if(document.getElementById('checkboxEdad').checked){
				var edadInicial=document.getElementById('edadInicial').value;
				var edadFinal=document.getElementById('edadFinal').value;
				data=data.replace("},success",",'edadInicial':'"+edadInicial+"', 'edadFinal':'"+edadFinal+"'},success");
			}
			else{
				var edadUnica=document.getElementById('edadUnica').value;
				data=data.replace("},success",",'edadUnica':'"+edadUnica+"'},success");
			}
			if(document.getElementById('checkboxTiempoLaborar').checked){
				var tiempoInicial=document.getElementById('tiempoInicial').value;
				var tiempoFinal=document.getElementById('tiempoFinal').value;
				data=data.replace("},success",",'tiempoInicial':'"+tiempoInicial+"', 'tiempoFinal':'"+tiempoFinal+"'},success");
			}
			else{
				var tiempoUnico=document.getElementById('tiempoUnico').value;
				data=data.replace("},success",",'tiempoUnico':'"+tiempoUnico+"'},success");
			}
			ajx=ajx.replace("data:{},success",data);
			eval(ajx);
		}
		function actualizarGraficaBarras(){
			var nombre=document.getElementById('nombreControlador').value;
			var genero=document.getElementById('select_generoControlador').value;
			var turno=document.getElementById('select_turno').value;
			var condicion=document.getElementById('select_condicion').value;
			var ajx="$.ajax({type:'post',url:'PHP/actualizarGraficaBarras.php',data:{},success:function(resp){if(resp.localeCompare('error')==0){alert('error');}else{eval(resp);}}});";
			var data="data:{'nombre':'"+nombre+"','genero':'"+genero+"', 'turno':'"+turno+"', 'condicion':'"+condicion+"'},success";
			if(document.getElementById('checkboxFecha').checked){
				var fechaInicial=document.getElementById('fecha_inicial').value;
				var fechaFinal=document.getElementById('fecha_final').value;
				var diaSemana=document.getElementById('select_diaSemana').value;
				data=data.replace("},success",",'fechaInicial':'"+fechaInicial+"', 'fechaFinal':'"+fechaFinal+"','diaSemana':'"+diaSemana+"'},success");
			}
			else{
				var fechaUnica=document.getElementById('fechaUnica').value;
				data=data.replace("},success",",'fechaUnica':'"+fechaUnica+"'},success");
			}
			if(document.getElementById('checkboxEdad').checked){
				var edadInicial=document.getElementById('edadInicial').value;
				var edadFinal=document.getElementById('edadFinal').value;
				data=data.replace("},success",",'edadInicial':'"+edadInicial+"', 'edadFinal':'"+edadFinal+"'},success");
			}
			else{
				var edadUnica=document.getElementById('edadUnica').value;
				data=data.replace("},success",",'edadUnica':'"+edadUnica+"'},success");
			}
			if(document.getElementById('checkboxTiempoLaborar').checked){
				var tiempoInicial=document.getElementById('tiempoInicial').value;
				var tiempoFinal=document.getElementById('tiempoFinal').value;
				data=data.replace("},success",",'tiempoInicial':'"+tiempoInicial+"', 'tiempoFinal':'"+tiempoFinal+"'},success");
			}
			else{
				var tiempoUnico=document.getElementById('tiempoUnico').value;
				data=data.replace("},success",",'tiempoUnico':'"+tiempoUnico+"'},success");
			}
			ajx=ajx.replace("data:{},success",data);
			eval(ajx);
		}
		function actualizarGraficaPie(){
			var nombre=document.getElementById('nombreControlador').value;
			var genero=document.getElementById('select_generoControlador').value;
			var turno=document.getElementById('select_turno').value;
			var condicion=document.getElementById('select_condicion').value;
			var ajx="$.ajax({type:'post',url:'PHP/actualizarGraficaPie.php',data:{},success:function(resp){if(resp.localeCompare('error')==0){alert('error');}else{eval(resp);}}});";
			var data="data:{'nombre':'"+nombre+"','genero':'"+genero+"', 'turno':'"+turno+"', 'condicion':'"+condicion+"'},success";
			if(document.getElementById('checkboxFecha').checked){
				var fechaInicial=document.getElementById('fecha_inicial').value;
				var fechaFinal=document.getElementById('fecha_final').value;
				var diaSemana=document.getElementById('select_diaSemana').value;
				data=data.replace("},success",",'fechaInicial':'"+fechaInicial+"', 'fechaFinal':'"+fechaFinal+"','diaSemana':'"+diaSemana+"'},success");
			}
			else{
				var fechaUnica=document.getElementById('fechaUnica').value;
				data=data.replace("},success",",'fechaUnica':'"+fechaUnica+"'},success");
			}
			if(document.getElementById('checkboxEdad').checked){
				var edadInicial=document.getElementById('edadInicial').value;
				var edadFinal=document.getElementById('edadFinal').value;
				data=data.replace("},success",",'edadInicial':'"+edadInicial+"', 'edadFinal':'"+edadFinal+"'},success");
			}
			else{
				var edadUnica=document.getElementById('edadUnica').value;
				data=data.replace("},success",",'edadUnica':'"+edadUnica+"'},success");
			}
			if(document.getElementById('checkboxTiempoLaborar').checked){
				var tiempoInicial=document.getElementById('tiempoInicial').value;
				var tiempoFinal=document.getElementById('tiempoFinal').value;
				data=data.replace("},success",",'tiempoInicial':'"+tiempoInicial+"', 'tiempoFinal':'"+tiempoFinal+"'},success");
			}
			else{
				var tiempoUnico=document.getElementById('tiempoUnico').value;
				data=data.replace("},success",",'tiempoUnico':'"+tiempoUnico+"'},success");
			}
			ajx=ajx.replace("data:{},success",data);
			eval(ajx);
		}
		function enviarParametros(){
			var nombre=document.getElementById('nombreControlador').value;
			var genero=document.getElementById('select_generoControlador').value;
			var turno=document.getElementById('select_turno').value;
			var condicion=document.getElementById('select_condicion').value;
			var ajx="$.ajax({type:'post',url:'PHP/procesarParametros.php',data:{},success:function(resp){if(resp.localeCompare('error')==0){alert('error');}else{eval(resp);colorearTabla();actualizarGraficaBarras();actualizarGraficaPie();actualizarGraficaIntercepciones();}}});";
			var data="data:{'nombre':'"+nombre+"','genero':'"+genero+"', 'turno':'"+turno+"', 'condicion':'"+condicion+"'},success";
			if(document.getElementById('checkboxFecha').checked){
				var fechaInicial=document.getElementById('fecha_inicial').value;
				var fechaFinal=document.getElementById('fecha_final').value;
				var diaSemana=document.getElementById('select_diaSemana').value;
				data=data.replace("},success",",'fechaInicial':'"+fechaInicial+"', 'fechaFinal':'"+fechaFinal+"','diaSemana':'"+diaSemana+"'},success");
			}
			else{
				var fechaUnica=document.getElementById('fechaUnica').value;
				data=data.replace("},success",",'fechaUnica':'"+fechaUnica+"'},success");
			}
			if(document.getElementById('checkboxEdad').checked){
				var edadInicial=document.getElementById('edadInicial').value;
				var edadFinal=document.getElementById('edadFinal').value;
				data=data.replace("},success",",'edadInicial':'"+edadInicial+"', 'edadFinal':'"+edadFinal+"'},success");
			}
			else{
				var edadUnica=document.getElementById('edadUnica').value;
				data=data.replace("},success",",'edadUnica':'"+edadUnica+"'},success");
			}
			if(document.getElementById('checkboxTiempoLaborar').checked){
				var tiempoInicial=document.getElementById('tiempoInicial').value;
				var tiempoFinal=document.getElementById('tiempoFinal').value;
				data=data.replace("},success",",'tiempoInicial':'"+tiempoInicial+"', 'tiempoFinal':'"+tiempoFinal+"'},success");
			}
			else{
				var tiempoUnico=document.getElementById('tiempoUnico').value;
				data=data.replace("},success",",'tiempoUnico':'"+tiempoUnico+"'},success");
			}
			ajx=ajx.replace("data:{},success",data);
			eval(ajx);
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
		function actualizarSelects(){
			$.ajax({
				type:"post",
				url:"PHP/actualizarSelects.php",
				success: function(resp){
					if(resp.localeCompare('error')==0){
							alert(resp);
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
		actualizarSelects();
		$(document).on("click",function(e) {
	       var container = $("#div_identificadorTipoUsuario");
    	   var container2=$("#div_cerrarSesion");
        	if ( (!container.is(e.target) && container.has(e.target).length === 0) && (!container2.is(e.target) && container2.has(e.target).length === 0)) { 
           		ocultarCierreSesion();
            }
   		});
	</script>
	<BODY bgcolor="#B2BABB" style="padding: 0; margin: 0" onload="enviarParametros()">
		<div id="encabezado">
			<button id="boton_volver" onclick="location.href='../inicio_administradores.php'">Volver</button>
			<div id="div_identificadorPagina">
				<div id="div_iconoPagina">
					<img src="iconos\inicio.png" style="width: 90%; height: 90%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Reportes</label>
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
								(Administrador del Sistema)
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
		<DIV id="contenedorPrincipal">
			
			<DIV id="contenedorSecundario">
				<DIV id="contenedorTabs">
					<DIV id="tabReportes" class="tab" onclick="activarVista('tabReportes')">
						<CENTER>Reporte de Evaluaciones</CENTER>
					</DIV>
					<DIV id="tabGraficas" class="tab" onclick="activarVista('tabGraficas')">
						<CENTER>Visualización de datos</CENTER>
					</DIV>
				</DIV>
				<DIV id="contenedorVentana">
					<DIV class="ventana" id="ventanaReportes">
						<DIV class="etiqueta">
							<h4>Parámetros de Búsqueda</h4>
						</DIV>
						<DIV id="div_parametrosBusqueda">
							<CENTER style="width:100%;height: 90%">
								<TABLE id="tabla_parametrosBusqueda">
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda" >
											<DIV class="etiquetaCampo">
												Fecha de Aplicación
											</DIV>									
											<DIV class="contenedorSwitch">
												<label class="switchBtn">
    												<input id="checkboxFecha" type="checkbox" onchange="cambiarEntradaFecha()">
   													<div class="slide" id="slideFecha">Única</div>
												</label>
											</DIV>											
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV id="entradaFechaUnica" class="div_entrada">
												<input type="date" id="fechaUnica" class="entrada">
											</DIV>
											<DIV id="EntradaFechaRango" class="div_entrada" style="display: none">
												<input type="date" id="fecha_inicial" class="entrada">
												<input type="date" id="fecha_final" class="entrada">
											</DIV>
											
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV style="width: 50%; height: 100%; justify-content: center; align-items: center; display: flex; float: left">
												Día de la semana
											</DIV>			
											
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV id="entradaDiaSemana" class="div_entrada">
												<SELECT id="select_diaSemana" class="entrada" style="height: 100%; text-align-last: center" disabled>
													<OPTION value='-Omitir-'>-Omitir-</OPTION>
													<OPTION value='2'>Lunes</OPTION>
													<OPTION value='3'>Martes</OPTION>
													<OPTION value='4'>Miércoles</OPTION>
													<OPTION value='5'>Jueves</OPTION>
													<OPTION value='6'>Viernes</OPTION>
													<OPTION value='7'>Sábado</OPTION>
													<OPTION value='1'>Domingo</OPTION>
												</SELECT>
											</DIV>
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV style="width: 50%; height: 100%; justify-content: center; align-items: center; display: flex; float: left">
												Nombre
											</DIV>
																						
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV class="div_entrada">
												<input type="text"  id="nombreControlador" class="entrada">
											</DIV>											
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV style="width: 50%; height: 100%; justify-content: center; align-items: center; display: flex; float: left">
												Sexo											
											</DIV>
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV class="div_entrada">
												<SELECT id="select_generoControlador" class="entrada" style="height: 100%; text-align-last: center">
													<OPTION>-Omitir-</OPTION>
													<OPTION>Femenino</OPTION>
													<OPTION>Masculino</OPTION>
												</SELECT>
											</DIV>
											
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV class="etiquetaCampo">
												Edad
											</DIV>
											<DIV class="contenedorSwitch">
												<label class="switchBtn">
    												<input type="checkbox" id="checkboxEdad" onchange="cambiarEntradaEdad()">
   													<div class="slide" id="slideEdad">Única</div>
												</label>
											</DIV>									
											
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV id="entradaEdadUnica" class="div_entrada">
												<input type="number" id="edadUnica" class="entrada">
											</DIV>
											<DIV id="entradaEdadRango" class="div_entrada" style="display:none">
												<input type="number" id="edadInicial" class="entrada">
												<input type="number" id="edadFinal" class="entrada">
											</DIV>
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV class="etiquetaCampo">
												Tiempo de Laborar
											</DIV>
											<DIV class="contenedorSwitch">
												<label class="switchBtn">
    												<input type="checkbox" id="checkboxTiempoLaborar" onchange="cambiarEntradaTiempoLaborar()">
   													<div class="slide" id="slideTiempoLaborar">Único</div>
												</label>
											</DIV>
																		
											
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV id="entradaTiempoUnico" class="div_entrada">
												<input type="date" id="tiempoUnico" class="entrada">
											</DIV>
											<DIV id="entradaTiempoRango" class="div_entrada" style="display:none">
												<input type="date" id="tiempoInicial" class="entrada">
												<input type="date" id="tiempoFinal" class="entrada">
											</DIV>
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV style="width: 50%; height: 100%; justify-content: center; align-items: center; display: flex; float: left">
												Condición
											</DIV>			
											
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV id="entradaCondición" class="div_entrada">
												<SELECT id="select_condicion" class="entrada" style="height: 100%; text-align-last: center">
												</SELECT>
											</DIV>
										</TD>
									</TR>
									<TR class="fila_tablabusqueda">
										<TD class="columna_tablaBusqueda">
											<DIV style="width: 50%; height: 100%; justify-content: center; align-items: center; display: flex; float: left">
												Turno											
											</DIV>
										</TD>
										<TD class="columna_tablaBusqueda">
											<DIV class="div_entrada">
												<SELECT id="select_turno" class="entrada" style="height: 100%; text-align-last: center">
												</SELECT>
											</DIV>
											
										</TD>
									</TR>



								</TABLE>
							</CENTER>
							<DIV id="div_botonBuscar">
								<button id="boton_buscar" onclick="enviarParametros()">Buscar</button>
							</DIV>
						</DIV>
							<div id="openModal" class="modalDialog">
								<div>
									<a href="#close" title="Close" class="close">X</a>
									<h2>Datos del Controlador</h2>
									<div id="datosControlador">
										
										<TABLE id="Tabla_infoEncuesta">
											<TR class="fila_infoEncuesta">
												<TD id="etiqueta_momentoAplicacion" class="columna_infoEncuesta_etiqueta" style="width:20%;">
													Momento de aplicación:
												</TD>
												<TD id="valor_momentoAplicacion" class="columna_infoEncuesta">
														Hoy
												</TD>
												<TD id="etiqueta_turnoControlador" class="columna_infoEncuesta_etiqueta" >
													Turno: 
												</TD>
												<TD id="valor_turnoControlador" class="columna_infoEncuesta">
													Este
												</TD>
											</TR>
											<TR class="fila_infoEncuesta">
												<TD id="etiqueta_NombreControlador" class="columna_infoEncuesta_etiqueta" style="width:20%">
													Nombre:
												</TD>
												<TD id="valor_nombreControlador" class="columna_infoEncuesta">
													El mio
												</TD>
												<TD id="etiqueta_fechaIngresoControlador" class="columna_infoEncuesta_etiqueta">
													Fecha de ingreso:
												</TD>
												<TD id="Valor_fechaIngresoControlador" class="columna_infoEncuesta">
													Ya dias
												</TD>
											</TR>
											<TR class="fila_infoEncuesta">
												<TD id="etiqueta_GeneroControlador" class="columna_infoEncuesta_etiqueta" style="width:20%">
													Sexo:
												</TD>
												<TD id="valor_generoControlador" class="columna_infoEncuesta">
													si porfavor
												</TD>
												<TD id="etiqueta_posicionControlador" class="columna_infoEncuesta_etiqueta">
													Posición:
												</TD>
												<TD id="valor_posicionControlador" class="columna_infoEncuesta">
													esa
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

									</div>
								</div>
							</div>
						<DIV class="etiqueta">
							<h4>Resultados</h4>
						</DIV>
						<DIV id="contenedorReportes" class="resultados">
							<DIV class="div_anuncioResultados" >
								<h3 id="anuncioResultadosReportes">Se encontraron [] resultados</h3>
							</DIV>
							<DIV id="contenedorTablaReportes">
								<CENTER style="width: 100%; height: 100%;">
									<DIV id="contenedorPrincipalTablas">
										<TABLE id="tablaCamposReportes">
											<TR class="fila_tablaCamposReportes">
												<TD class="columna_reportes">
													Momento de aplicación
												</TD>
												<TD class="columna_reportes">
													Controlador
												</TD>
												<TD class="columna_reportes">
													Resultado de la evaluación
												</TD>
												<TD class="columna_reportes">
													Acción
												</TD>
											</TR>									
										</TABLE>
										<TABLE id="tablaResultados">
										
										</TABLE>
									</DIV>
								</CENTER>
							</DIV>
						</DIV>
						<DIV id="contenedorGraficas">
							<DIV id="div_selectGraficas">
								<SELECT id="select_graficas" onchange="mostrarGraficas(document.getElementById('select_graficas').value)">
									<OPTION value="div_graficaBarra">Ocurrencias por cada condición</OPTION>
									<OPTION value="div_graficaPie">Porcentaje de cada condición</OPTION>
									<OPTION value="div_graficaIntercepciones">Indice por fecha</OPTION>
								</SELECT>
							</DIV>
							<DIV class="div_anuncioResultados" >
								<h3 id="anuncioResultadosGraficas">Se encontraron [] resultados</h3>
							</DIV>
							<DIV id="div_graficaBarra" class="div_grafica">
								<div id="plotlyChart" sytle="width:100%; height:100%"></div>
							</DIV>
							<DIV id="div_graficaPie" class="div_grafica" style="display: none">
								<div id="plotlyChartPie" sytle="width:100%; height:100%"></div>
							</DIV>
							<DIV id="div_graficaIntercepciones" class="div_grafica" style="display: none">
								<div id="plotlyChartIntercepciones" sytle="width:100%; height:100%"></div>
								
							</DIV>
						</DIV>
					</DIV>
					
				</DIV>
			</DIV>
		</DIV>

	</BODY>
</HTML>
