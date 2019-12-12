<?php
	session_start();
	if(empty($_SESSION)){
		header('location:../Login/login.php');
	}
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="utf-8">
		<TITLE>Inicio</TITLE>
		<LINK rel="stylesheet" type="text/css" href="CSS\estilos.css" media="screen"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</HEAD>
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
	<BODY bgcolor="#B2BABB" style="margin: 0; padding: 0">
		<div id="encabezado">
			<div id="div_identificadorPagina">
				<div id="div_iconoPagina">
					<img src="iconos\inicio.png" style="width: 45%; height: 80%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Inicio</label>
				</div>
			</div>
			<div id="div_identificadorUsuario">
				<div id="div_iconoUsuario">
					<div id="circulo">
						<img src="iconos\administrador.png" style="width: 55%; height: 50%">
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
		<div id="div_contenedorPrincipal">
			<div id="div_contenedorSecundario">
				<div id="div_contenedorSecundarioMitad1">
						<div id="boton_gestionCartilla" onclick="window.location = 'Gestion de cartilla/gestion_encuestas.php'">
							<div class="etiquetaEnlace">
								Gestión de Cartilla
							</div>
							<div class="iconoEnlace">
								<img src="iconos\cartilla.png" style="width: 100%; height: 100%">
							</div>
						</div>
						<div id="boton_gestionSeguridad" onclick="window.location='seguridad/seguridad.php'">
							<div class="etiquetaEnlace">
								Seguridad
							</div>
							<div class="iconoEnlace">
								<img src="iconos\seguridad.png" style="width: 100%; height: 100%">
							</div>
						</div>
				</div>
				<div id="div_contenedorSecundarioMitad2">
					<div id="boton_reportes"  onclick="window.location='Reporteria/reporteria.php'" >
						<div class="etiquetaEnlace">
								Reportes
						</div>
						<div class="iconoEnlace">
							<img src="iconos\reportes.png" style="width: 100%; height: 100%">
						</div>
					</div>
					<div id="boton_usuarios" onclick="window.location = '../gestion de usuarios/gestion_usuarios.php'"> 
						<div class="etiquetaEnlace">
							Gestión de usuarios
						</div>
						<div class="iconoEnlace">
							<img src="iconos\usuarios.png" style="width: 100%; height: 100%">
							</div>
					</div>
				</div>
			</div>
		</div>
	</BODY>
</HTML>