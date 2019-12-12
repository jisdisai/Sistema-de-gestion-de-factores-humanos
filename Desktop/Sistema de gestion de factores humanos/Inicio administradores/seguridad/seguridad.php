<?php
	session_start();
	if(empty($_SESSION)){
		header('location:../../index.php');
	}
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="UTF-8">
		<LINK rel="stylesheet" type="text/css" href="CSS\estilos_seguridad.css" media="screen"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		
	</HEAD>
		<script type="text/javascript">
			function actualizarRequisitos(){
				$.ajax({
					type:"post",
					url:"PHP/actualizarRequisitos.php",
					success: function(resp){
						eval(resp);
					}
				});
  			}
  			function aplicarRequisitos(){
  				var caracterEspecial=0;
  				var digito=0;
  				var mayuscula=0;
  				var minuscula=0;

  				if(document.getElementById('caracterEspecial').checked){
  					var caracterEspecial=1;
  				}
  				if(document.getElementById('digito').checked){
  					var digito=1;
  				}
  				if(document.getElementById('mayuscula').checked){
  					var mayuscula=1;
  				}
  				if(document.getElementById('minuscula').checked){
  					var minuscula=1;
  				}
  				$.ajax({
					type:"post",
					url:"PHP/aplicarRequisitos.php",
					data:{'caracterEspecial':caracterEspecial,'digito':digito,'mayuscula':mayuscula,'minuscula':minuscula},
					success: function(resp){
						eval(resp);
					}
				});
  			}
  			function habilitarEdicionRequisitos(){
  				document.getElementById('div_botonesRequisitosVistaPrevia').style.display="none";
  				document.getElementById('div_botonesRequisitosEdicion').style.display="block";

  				cb = document.getElementsByClassName('checkbox_requisito');
  				for(i=0; i<cb.length; i++){
  					cb[i].style.opacity=1;
  					cb[i].disabled=false;
  				}
			}
			function cerrarEdicionRequisitos(){
				actualizarRequisitos();
				document.getElementById('div_botonesRequisitosEdicion').style.display="none";
				document.getElementById('div_botonesRequisitosVistaPrevia').style.display="block";
				cb = document.getElementsByClassName('checkbox_requisito');
				for(i=0; i<cb.length; i++){
					cb[i].style.opacity=0.8;
					cb[i].disabled=true;
				}
			}

			function colorearTabla(){
				var filas=document.getElementsByClassName('fila_tablaResultados');
				for(i=0; i<filas.length; i++){
					if((i%2)==0){
						filas[i].style.backgroundColor="#AEB6BF";
					}
					else{
						filas[i].style.backgroundColor="#E5E7E9";
					}
				}
			}

			function buscarRegistrosInicioSesion (){				
				var nombreUsuario=document.getElementById('entrada_nombreUsuarioInicioSesion').value;
				var fechaInicio=document.getElementById('entrada_fechaInicioSesion').value;
				$.ajax({
					type:"post",
					url:"PHP/buscarRegistrosInicioSesion.php",
					data:{'nombreUsuario':nombreUsuario, 'fechaInicio': fechaInicio},
					success: function(resp){
						eval(resp);
					}
				});
			}




			function buscarRegistrosModificaciones(){				
				var nombreUsuario=document.getElementById('entrada_nombreUsuarioModificaciones').value;
				var fechaInicio=document.getElementById('entrada_fechaModificaciones').value;
				$.ajax({
					type:"post",
					url:"PHP/buscarRegistrosModificaciones.php",
					data:{'nombreUsuario':nombreUsuario, 'fechaInicio': fechaInicio},
					success: function(resp){
						eval(resp);
            //document.getElementById('tab_registrosModificaciones').innerHTML="'"+resp+"'";
					}
				});
			}
		</script>
		<script type="text/javascript">
			function openTab(evt, idTab) {
  				// Declare all variables
  				var i, tabcontent, tablinks;

  				// Get all elements with class="tabcontent" and hide them
  				tabcontent = document.getElementsByClassName("tabContenido");
				for (i = 0; i < tabcontent.length; i++) {
    				tabcontent[i].style.display = "none";
  				}

  				// Get all elements with class="tablinks" and remove the class "active"

  				// Show the current tab, and add an "active" class to the link that opened the tab
  				document.getElementById(idTab).style.display = "block";
				
			}

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
	<BODY bgcolor="#B2BABB" style="padding: 0; margin: 0">
		<div id="encabezado">
			<button id="boton_volver" onclick="location.href='../inicio_administradores.php'">Volver</button>
			<div id="div_identificadorPagina">
				<div id="div_iconoPagina">
					<img src="iconos\seguridad.png" style="width: 90%; height: 90%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Seguridad</label>
				</div>
			</div>
			<div id="div_identificadorUsuario">
				<div id="div_iconoUsuario">
					<div id="circulo">
						<img src="iconos\administrador.png" style="width: 50%; height: 50%">
					</div>
				</div>
				<div id="div_etiquetaUsuario">
					<div id="Encabezado_nombreUsuario">
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
		<DIV id="contenedorPrincipal">
			<DIV id="contenedorSecundario">
				<div class="tab">
  					<button class="tablinks" onclick="openTab(event, 'tab_registrosInicioSesion')">Registros de Inicio de Sesión</button>
  					<button class="tablinks" onclick="openTab(event, 'tab_registrosModificaciones')">Registros de Modificaciones a la Cartilla</button>
  					<button class="tablinks" onclick="openTab(event, 'tab_requisitosPassword')">Configuración de Requisitos de Contraseñas</button>
				</div>	

				<div id="tab_registrosInicioSesion" class="tabContenido">
  					<DIV class="etiqueta_tab">
  						<h4>Parámetros de Búsqueda</h4>
  					</DIV>
  					<DIV id="div_busquedaInicioSesion" class="div_busqueda">
  						<DIV id="div_tabla_busquedaInicioSesion" class="div_tablaBusqueda">
  							<TABLE id="tabla_busquedaInicioSesion" class="tabla_Busqueda">
  								<TR class="fila_tablaBusquedaInicioSesion">
  									<TD class="columna_tablaBusquedaInicioSesion" style="text-align: center">
  										Nombre de Usuario:
  									</TD>
  									<TD class="columna_tablaBusquedaInicioSesion">
  										<INPUT type="text" id="entrada_nombreUsuarioInicioSesion" class="entrada">
  									</TD>
  								</TR>
  								<TR class="fila_tablaBusquedaInicioSesion">
  									<TD class="columna_tablaBusquedaInicioSesion">
  										Fecha: 
  									</TD>
  									<TD class="columna_tablaBusquedaInicioSesion">
  										<INPUT type="date" id="entrada_fechaInicioSesion" class="entrada">
  									</TD>
  								</TR>
  							</TABLE>
  						</DIV>
  						<DIV id="div_botonBusquedaInicioSesion" class="div_botonBusqueda">
  							<BUTTON id="boton_buscarInicioSesion" class="botonBusqueda" onclick="buscarRegistrosInicioSesion()">Buscar</BUTTON>
  						</DIV>
  					</DIV>
  					<DIV class="etiqueta_tab">
  						<h4>Resultados</h4>
  					</DIV>
  					<DIV  class="div_anuncio_resultados">
  						<h5 id="anuncio_resultadosInicioSesion" class="anuncion_resultados">Se encontraron [ ] resultados</h5>
  					</DIV>
  					<DIV class="contenedorResultados">
  						<DIV class="contenedorTablaResultados">
  							<TABLE class="tabla_camposResultados">
  								<TR class="fila_tablaCamposResultados">
  									<TD class="columna_fechaInicioSesion" style="background-color: #272827; color:white">
  										Momento del Ingreso
  									</TD>
  									<TD class="columna_nombreUsuario" style="background-color: #272827; color: white">
  										Nombre de Usuario
  									</TD>
  									<TD class="columna_tipoUsuario" style="background-color: #272827; color: white">
  										Tipo
  									</TD>
  								</TR>
  							</TABLE>
  							<TABLE id ="tabla_resultadosInicioSesion" class="tabla_resultados">
  								
  							</TABLE>
  						</DIV>  						
  					</DIV>

  					
				</div>

				<div id="tab_registrosModificaciones" class="tabContenido" style="display: none">
  					<DIV class="etiqueta_tab">
  						<h4>Parámetros de Búsqueda</h4>
  					</DIV>
  					<DIV id="div_busquedaModificaciones" class="div_busqueda">
  						<DIV id="div_tabla_busquedaModificaciones" class="div_tablaBusqueda">
  							<TABLE id="tabla_busquedaInicioSesion" class="tabla_Busqueda">
  								<TR class="fila_tablaBusquedaModicaciones">
  									<TD class="columna_tablaBusquedaInicioSesion" style="text-align: center">
  										Nombre de Usuario:
  									</TD>
  									<TD class="columna_tablaBusquedaInicioSesion">
  										<INPUT type="text" id="entrada_nombreUsuarioModificaciones" class="entrada">
  									</TD>
  								</TR>
  								<TR class="fila_tablaBusquedaInicioSesion">
  									<TD class="columna_tablaBusquedaInicioSesion">
  										Fecha: 
  									</TD>
  									<TD class="columna_tablaBusquedaInicioSesion">
  										<INPUT type="date" id="entrada_fechaModificaciones" class="entrada">
  									</TD>
  								</TR>
  							</TABLE>
  						</DIV>
  						<DIV id="div_botonBusquedaModificaciones" class="div_botonBusqueda">
  							<BUTTON id="boton_buscarModificaciones" class="botonBusqueda" onclick="buscarRegistrosModificaciones()">Buscar</BUTTON>
  						</DIV>
  					</DIV>
  					<DIV class="etiqueta_tab">
  						<h4>Resultados</h4>
  					</DIV>
  					<DIV  class="div_anuncio_resultados">
  						<h5 id="anuncio_resultadosModificaciones" class="anuncion_resultados">Se encontraron [ ] resultados</h5>
  					</DIV>
  					<DIV class="contenedorResultados">
  						<DIV class="contenedorTablaResultados" style="overflow-x: scroll;">
  							<TABLE class="tabla_camposResultados" style="width: 120%">
  								<TR class="fila_tablaCamposResultados">
  									<TD class="columna_fechaModificaciones" style="background-color: #272827; color:white">
  										Momento de la Modificación
  									</TD>
  									<TD class="columna_nombreUsuarioModificaciones" style="background-color: #272827; color: white">
  										Nombre de Usuario
  									</TD>
  									<TD class="columna_detalleModificaciones" style="background-color: #272827; color: white">
  										Detalle
  									</TD>
  								</TR>
  							</TABLE>
  							<TABLE id ="tabla_resultadosModificaciones" class="tabla_resultados"  style="width: 120%">
  								
  							</TABLE>
  						</DIV>  						
  					</DIV>
  					
				</div>

				<div id="tab_requisitosPassword" class="tabContenido" style="display:none">
  					<DIV class="etiqueta_tab">
  						<h4>Selección de Requisitos de Seguridad</h4>
  					</DIV>
  					<DIV id="div_tablaRequisitos">
  						<TABLE id="tabla_requisitos">
  							<TR class="fila_tablaRequisitos">  								
  								<TD class="columna_checkbox_tablaRequisitos">
  									<INPUT type="checkbox" class="checkbox_requisito" id="caracterEspecial"  style="opacity: 0.8" disabled>
  								</TD>
  								<TD class="columna_tablaRequisitos">
  									Solicitar al menos un caracter especial
  								</TD>
  							</TR>
  							<TR class="fila_tablaRequisitos">  								
  								<TD class="columna_checkbox_tablaRequisitos">
  									<INPUT type="checkbox" class="checkbox_requisito" id="digito" style="opacity: 0.8" disabled>
  								</TD>
  								<TD class="columna_tablaRequisitos">
  									Solicitar al menos un dígito
  								</TD>
  							</TR>
  							<TR class="fila_tablaRequisitos">  								
  								<TD class="columna_checkbox_tablaRequisitos">
  									<INPUT type="checkbox" class="checkbox_requisito" id="mayuscula"  style="opacity: 0.8" disabled>
  								</TD>
  								<TD class="columna_tablaRequisitos">
  									Solicitar al menos una letra mayúscula
  								</TD>
  							</TR>
  							<TR class="fila_tablaRequisitos">  								
  								<TD class="columna_checkbox_tablaRequisitos">
  									<INPUT type="checkbox" class="checkbox_requisito" id="minuscula"  style="opacity: 0.8" disabled>
  								</TD>
  								<TD class="columna_tablaRequisitos">
  									solicitar al menos una letra minúscula
  								</TD>
  							</TR>
  						</TABLE>
  					</DIV>
  					<DIV id="div_botonesRequisitos">
  							<DIV id="div_botonesRequisitosVistaPrevia">
  								<BUTTON id="botonEditarRequisitos" onclick="habilitarEdicionRequisitos()">Editar</BUTTON>
  							</DIV>
  							<DIV id="div_botonesRequisitosEdicion" style="display:none">
  								<BUTTON id="boton_aplicar" onclick="aplicarRequisitos()">Aplicar</BUTTON>
  								<BUTTON id="boton_cancelar" onclick="cerrarEdicionRequisitos()">Cancelar</BUTTON>
  							</DIV>						
  					</DIV>
  					
				</div>

			</DIV>			
		</DIV>
		
	</BODY>
	<script type="text/javascript">
		buscarRegistrosInicioSesion();
		buscarRegistrosModificaciones();
		actualizarRequisitos();
	</script>
</HTML>