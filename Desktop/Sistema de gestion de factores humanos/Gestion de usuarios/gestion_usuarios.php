<?php
	session_start();
	if(empty($_SESSION)){
		header('location:../Login/login.php');
	}
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="UTF-8">
		<LINK rel="stylesheet" type="text/css" href="CSS3\estilos_gestion_usuarios.css" media="screen"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!--<script src="jquery.redirect-master/jquery.redirect.js"></script>-->
	</HEAD>
	<script type="text/javascript">
		function boton_busqueda_focus(){
			document.getElementById("boton_buscar").style.backgroundColor="#5DADE2";
		}
		function boton_busqueda_blur(){
			document.getElementById("boton_buscar").style.backgroundColor="#212F3C";
		}
		function abrirFormulario_agregarUsuario(){
			document.getElementById('visualizarUsuarios').style.display="none";
			document.getElementById('formulario1-agregarUsuario').style.display="block";
			$('#div_noEmpleado').show();
			//
			//$('#visualizarUsuarios').hide(1000);

		}
		function cerrarFormulario_agregarUsuario(){
			/*document.getElementById('identificadorFormulario').innerHTML="";
			document.getElementById('advertencia_numeroEmpleado').innerHTML="";
			document.getElementById('advertenciaPasswordUsario2').innerHTML="";
			document.getElementById('advertencia_nombreUsuario').innerHTML="";
			document.getElementById('nEmpleado').value="";
			document.getElementById('correoUsuario').value="";
			document.getElementById('nombreUsuario').value="";
			document.getElementById('PasswordEmpleado').value="";
			document.getElementById('visualizarUsuarios').style.display="block";
			document.getElementById('formulario1-agregarUsuario').style.display="none";
			document.getElementById('div_formularioDatosUsuario').style.display="none";
			document.getElementById('div_formularioPasswordTipo').style.display="none";*/
			location.reload();
		}
		function abrirFormulario_datosUsario(){
			if(document.getElementById('nEmpleado').value.length==0){
				document.getElementById('advertencia_numeroEmpleado').innerHTML="<CENTER><h6 style='color:#CD6155 '>¡No puedes omitir este campo! </h6></center>";
				document.getElementById('nEmpleado').focus();
			}
			else{
				document.getElementById('identificadorFormulario').innerHTML="<h3>Datos del Usuario</h3>";
				document.getElementById('identificadorFormulario').innerHTML="<h3>Datos del Usuario</h3>";
				$.ajax({
					type:"post",
					url:"PHP/validarNumeroEmpleado.php",
					data:{'numeroEmpleado':document.getElementById('nEmpleado').value},
					success: function (resp){
						if(resp.localeCompare('error')==0){
							alert("Error al validar numero");
						}
						else{
							if(resp.localeCompare('duplicidad')==0){
								document.getElementById('advertencia_numeroEmpleado').innerHTML="<CENTER><h6 style='color:#CD6155 '>¡Ya hay un usuario registrado con este número! </h6></center>";
							}
							else{
								if(resp.localeCompare('numeroValido')==0){
									$.ajax({
										type:"post",
										url:"PHP/actualizarFormularioDatos.php",
										data:{'numeroEmpleado':document.getElementById('nEmpleado').value},
										success: function(resp){
											if(resp.localeCompare('error')==0){
												document.getElementById('advertenciaDatosUsario').innerHTML="<center><h6 style='color:#CD6155 '>Advertencia: No hay ningún empleado asociado a este número </h6></center>";
												document.getElementById('NUEmpleado2').value=document.getElementById('nEmpleado').value;
											}
											else{
												eval(resp);
											}
										}
									});
									document.getElementById('div_noEmpleado').style.display="none";
									document.getElementById('div_formularioDatosUsuario').style.display="block";
								}
							}
						}
					}				
				});				
			}
		}
		function abrirFormulario_password_tipo(){
			if(document.getElementById('nombreUsuario').value.length==0){
				document.getElementById('advertencia_nombreUsuario').innerHTML="<center><h6 style='color:#CD6155 '>Advertencia:¡No puedes omitir este campo! </h6></center>";
				document.getElementById('nombreUsuario').focus();
			}
			else{
				$.ajax({
					type:"post",
					url:"PHP/actualizarFormularioPassword.php",
					success: function(resp){
						if(resp.localeCompare('error')==0){
						alert("error");
						}
						else{
							document.getElementById('advertenciaPasswordUsario').innerHTML=resp;
						}
					}
				});
				$.ajax({
					type:"post",
					url:"PHP/actualizarSelectorTiposUsuario.php",
					success: function(resp){
						if(resp.localeCompare('error')==0){
							alert("error");
						}
						else{
							document.getElementById('tipoUsuarioRegistrar').innerHTML=resp;
						}
					}
				});
				document.getElementById('div_formularioDatosUsuario').style.display="none";
				document.getElementById('div_formularioPasswordTipo').style.display="block";
			}
			
		}
		function cambiarVisivilidadPassword(event){
			var checkbox=event.target;
			if(checkbox.checked){
				$("#PasswordEmpleado").attr('type','text');
			}
			else{
				$("#PasswordEmpleado").attr('type','password');

			}
		}
		function RegistrarUsuario(){
			var numeroEmpleado=document.getElementById('nEmpleado').value;
			var nombreUsuario=document.getElementById('nombreUsuario').value;
			var password=document.getElementById('PasswordEmpleado').value;
			var correoUsuario=document.getElementById('correoUsuario').value;
			var tipoUsuario=document.getElementById('tipoUsuarioRegistrar').value;
			if(password.length>0){
				$.ajax({
					type:"post",
					url:"PHP/registrarUsuario.php",
					data:{'numeroEmpleado':numeroEmpleado,'nombreUsuario':nombreUsuario,'password':password,'correoUsuario':correoUsuario,'tipoUsuario':tipoUsuario},
					success: function(resp){
						if(resp.localeCompare('error')==0){
							alert("Error al registrar usuario");
						}
						else{
							if(resp.localeCompare('¡Usuario registrado con éxito!')==0){
								alert(resp);
								location.reload();
							}
							else{
								alert(resp);
							}
						}
					}
				});
			}
			else{
				document.getElementById('PasswordEmpleado').focus();
				document.getElementById('advertenciaPasswordUsario2').innerHTML="<CENTER><h6 style='color:#CD6155 '>¡No puedes omitir este campo! </h6></center>";
			}
			

		}

		function actualizarSelectorTiposUsuario(){
			$.ajax({
				type:"post",
				url:"PHP/obtenerTiposUsuario.php",
				data:{'idPrefijo':'option_','clase':'option_TipoUsuario'},
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert("error con el selector del tipo de ususarios");
					}
					else{
						document.getElementById('select_roles').innerHTML=document.getElementById('select_roles').innerHTML+resp;
					}
				}
			});
		}
		function actualizarListaUsuarios(){
			var tipoUsuarioseleccionado=document.getElementById('select_roles').value;
			$.ajax({
				type:"post",
				url:"PHP/obtenerUsuarios.php",
				data:{'idPrefijo':'filaTablaUsuarios_','clase':'fila_TablaUsuarios','tipoUsuario':tipoUsuarioseleccionado},
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert(resp);
					}
					else{
						document.getElementById('tabla_usuarios').innerHTML=resp;
						var filas=document.getElementsByClassName('fila_TablaUsuarios');
						for(i=0; i<filas.length; i++){
							if((i%2)==0){
								filas[i].style.backgroundColor="#AEB6BF";
							}
							else{
								filas[i].style.backgroundColor="#E5E7E9";
							}
						}
					}
				}
			});
		}
		function buscarUsuarios(){
			$.ajax({
				type:"post",
				url:"PHP/buscarUsuarios.php",
				data:{'idPrefijo':'filaTablaUsuarios_','clase':'fila_TablaUsuarios','palabraClave':document.getElementById('buscador').value},
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert(resp);
					}
					else{
						document.getElementById('tabla_usuarios').innerHTML=resp;
						var filas=document.getElementsByClassName('fila_TablaUsuarios');
						for(i=0; i<filas.length; i++){
							if((i%2)==0){
								filas[i].style.backgroundColor="#AEB6BF";
							}
							else{
								filas[i].style.backgroundColor="#E5E7E9";
							}
						}
					}
				}
			});
		}
		function eliminarUsuario(no_empleado){
			$.ajax({
				type:"post",
				url:"PHP/eliminarUsuario.php",
				data:{'no_empleado':no_empleado},
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert(resp);
					}
					else{
						alert(resp);
						location.reload();
						
					}
					
				}
			});
		}
		function actualizarUsuario(){
			var no_empleado=document.getElementById('NUEmpleado2').value;
			var nombreUsuario=document.getElementById('nombreUsuario').value;
			var correoUsuario=document.getElementById('correoUsuario').value;
			var passwordUsuario=document.getElementById('PasswordEmpleado').value;
			var tipoUsuario=document.getElementById('tipoUsuarioRegistrar').value;
			$.ajax({
				type:"post",
				url:"PHP/actualizarUsuario.php",
				data:{'no_empleado':no_empleado,'nombreUsuario':nombreUsuario,'correoUsuario':correoUsuario,'passwordUsuario':passwordUsuario,'tipoUsuario':tipoUsuario},
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert(resp);
					}
					else{
						alert(resp);
						location.reload();
					}
				}
			});

		}
		function abrirFormulario_editarPassword(no_empleado,tipoUsuario){
			document.getElementById('boton_registrarUsuario').onclick=function(){actualizarUsuario()};
			document.getElementById('div_formularioDatosUsuario').style.display="none";
			document.getElementById('div_formularioPasswordTipo').style.display="block";
			$.ajax({
				type:"post",
				url:"PHP/recuperarPassword.php",
				data:{'no_empleado':no_empleado},
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert(resp);
					}
					else{
						document.getElementById('PasswordEmpleado').value=resp;
					}
				}
			});
			$.ajax({
				type:"post",
				url:"PHP/actualizarSelectorTiposUsuario.php",
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert("error");
					}
					else{
						document.getElementById('tipoUsuarioRegistrar').innerHTML=resp;
						var id='option_'+tipoUsuario;
						$('#'+id).attr("selected",true);
						
					}
				}
			});
			$.ajax({
				type:"post",
				url:"PHP/actualizarFormularioPassword.php",
				success: function(resp){
					if(resp.localeCompare('error')==0){
						alert("error");
					}
					else{
						document.getElementById('advertenciaPasswordUsario').innerHTML=resp;
					}
				}
			});

		}
		function abrirFormularioEditarUsuario(no_empleado,nombreUsuario,correoUsuario,tipoUsuario){
			document.getElementById('boton_datosUsuario').onclick = function(){
				abrirFormulario_editarPassword(no_empleado,tipoUsuario);
			};
			document.getElementById('visualizarUsuarios').style.display="none";
			document.getElementById('div_noEmpleado').style.display="none";
			document.getElementById('formulario1-agregarUsuario').style.display="block";
			document.getElementById('div_formularioDatosUsuario').style.display="block";
			document.getElementById('NUEmpleado2').value=no_empleado;
			document.getElementById('nombreUsuario').value=nombreUsuario;
			document.getElementById('correoUsuario').value=correoUsuario;
			
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
	<BODY bgcolor="#B2BABB" style="padding: 0; margin: 0">
		<div id="encabezado">
			<button id="boton_volver" onclick="location.href='../Inicio administradores/inicio_administradores.php'">Volver</button>
			<div id="div_identificadorPagina">
				<div id="div_iconoPagina">
					<img src="iconos\usuarios.png" style="width: 90%; height: 90%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Gestión de usuarios</label>
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
			<DIV id="visualizarUsuarios" class="contenedorSecundario">
				<DIV id="barra_contenedorSecundario">
					<DIV id="seleccionadorRol">
						<label for="select_roles" style="width: 50%; height: 30%; text-align: center; color:white"> <bold>Filtrar por Rol: </bold></label>
						<SELECT id="select_roles" name="select_roles" style="width: 50%; height:30%; margin-top: 0" onchange="actualizarListaUsuarios()">
							<OPTION id="option_Todos" class="option_TipoUsuario">Todos</OPTION>
							<script type="text/javascript">
								actualizarSelectorTiposUsuario()
							</script>

						</SELECT>
					</DIV>
					<DIV id="div_buscador">
						<textarea placeholder="Buscar usuarios" id="buscador" style="resize:none; width: 60%; height: 30% " onkeyup="buscarUsuarios()"></textarea>
						<BUTTON id="boton_buscar"  style="width: 7%; height: 30%; padding: 0; margin: 0; border: none; background-color:#212F3C; border: solid; border-width: 1px; border-color:white" onmouseenter="boton_busqueda_focus()" onmouseleave='boton_busqueda_blur()' >
							<img src="iconos\icono_lupa1.png" height="100%" width="100%">
						</BUTTON>
					</DIV>
				</DIV>
				<DIV id="div_vistaPreviaUsuarios">
					<TABLE id="tabla_CamposUsuarios"  style="width:100%; height: 10%">
						<TR  style="width:100%; height: 10%; text-align: center;">
							<TD class="camposUsuarios" style="width:20%">
								No de Empleado
							</TD>
							<TD class="camposUsuarios" style="width:10%; height: 100%;">
								Rol
							</TD>
							<TD class="camposUsuarios" style="width:25%; height: 100%;">
								Nombre
							</TD>
							<TD class="camposUsuarios" style="width:25%; height: 100%;">
								Correo electrónico
							</TD>
							<TD class="camposUsuarios" style="width:20%; height: 100%;">
								Botones
							</TD>
						</TR>
					</TABLE>
					<TABLE id="tabla_usuarios" style="width: 100%; table-layout: fixed;">
						<script type="text/javascript">
							actualizarListaUsuarios();
						</script>
					</TABLE>
				</DIV>
				<DIV id="div_botonesVistaPrevia">
					<BUTTON id="boton_agregarUsuario" onclick="abrirFormulario_agregarUsuario()">Agregar Usuario</BUTTON>					
				</DIV>
			</DIV>
			<DIV id="formulario1-agregarUsuario" class="contenedorSecundario">
				<DIV id="div_barraFormulario">
					<DIV id="identificadorFormulario">
					</DIV>
					<BUTTON id="boton_cancelarNuevoUsuario" onclick="cerrarFormulario_agregarUsuario();">Cancelar</BUTTON>
				</DIV>
				<DIV id="div_noEmpleado">
					<DIV id="formulario_noEmpleado">
						<h3 style="color: #424949">Introduce un número de empleado válido para registrar</h3>
						<br>
						<textarea id="nEmpleado" style="resize:none; text-align: center"></textarea>
						<br>
						<DIV id="advertencia_numeroEmpleado"></DIV>
						<button id="boton_finNEmpleado" onclick="abrirFormulario_datosUsario()">Siguiente</button>
					</DIV>
				</DIV>
				<DIV id="div_formularioDatosUsuario" style="display: none">
						<DIV class="fila_formulario">
								<H3 id="advertenciaDatosUsario" style="width: 100%; margin: 0; padding: 0"></H3>
						</DIV>
						<DIV class="fila_formulario"></DIV>
						<DIV class="fila_formulario">
							<DIV id="etiquetaNUEmpleado" class="etiquetas_datosUsuarios">
								<H4 style="color: #424949">Número de empleado:</H4> 
							</DIV>
							<pre style='display:inline'>&#09;</pre>
							<INPUT type="text" id="NUEmpleado2" style="resize: none; text-align: center" class="campo_textoFormulario" style="text-align: center" readonly></INPUT>
						</DIV>
						<DIV class="fila_formulario"></DIV>
						<DIV class="fila_formulario">
							<DIV id="etiquetaNombreUsuario" class="etiquetas_datosUsuarios">
								<H4 style="color: #424949">Nombre de Usuario:</H4>
							</DIV>
							<pre style='display:inline'>&#09;</pre>
							<INPUT type="text" id="nombreUsuario" style="resize: none; text-align: center" class="campo_textoFormulario"></INPUT>

						</DIV>
						<DIV id="advertencia_nombreUsuario" class="fila_formulario"></DIV>
						<DIV class="fila_formulario">
							<DIV id="etiquetaCorreoUsuario" class="etiquetas_datosUsuarios">
								<H4 style="color: #424949">Correo electrónico:</H4> 
							</DIV>
							<pre style='display:inline'>&#09;</pre>
							<INPUT type="text" id="correoUsuario" style="resize: none; text-align: center" class="campo_textoFormulario"></INPUT>
						</DIV>
						<DIV class="fila_formulario"></DIV>
						<DIV class="fila_formulario">
							<DIV id="div_botonesDatosUsuarios">
								<BUTTON id="boton_datosUsuario" onclick="abrirFormulario_password_tipo()">Aceptar</BUTTON>
							</DIV>
						</DIV>				
				</DIV>
				<DIV id="div_formularioPasswordTipo" style="display: none">
						<DIV id="div_AdvertenciaDatosUsuario" style="text-align: center; margin: 0; padding: 0">
							<H5 id="advertenciaPasswordUsario" style="margin: 0; padding: 0; width: 100%; color:#CD6155 ">Introduce una contraseña que cumpla con los siguientes requisitos: </H5>
						</DIV>
						<DIV class="fila_formulario"></DIV>
						<DIV class="fila_formulario">
							<H4 id="etiquetaPassword" class="etiquetas_datosUsuarios" style="color: #424949">Contraseña:</H4>
							<pre style='display:inline'>&#09;</pre>
							<INPUT type="password" id="PasswordEmpleado" class="campo_textoFormulario" style="text-align: center"></INPUT>
						</DIV>
						<DIV class="fila_formulario" id="advertenciaPasswordUsario2">
							
						</DIV>
						<DIV class="fila_formulario">
							<H5 id="etiquetaMostrarCaracteres" class="etiquetas_datosUsuario" style="color: #515A5A">Mostrar caracteres</H5>
							<INPUT type="checkbox" id="checkbox_mostrarContraseña" value="Mostrar Caracteres" onclick="cambiarVisivilidadPassword(event)"></INPUT>
						</DIV>
						<DIV class="fila_formulario">
							<H4 id="advertenciaTipoUsuario" style="color: #424949">Selecciona el tipo de usuario que deseas registrar: </H4>
						</DIV>
						<DIV class="fila_formulario">
							<SELECT id="tipoUsuarioRegistrar">
								<OPTION>Espacio en blanco 1</OPTION>
								<OPTION>Espacio en blanco 2</OPTION>
								<OPTION>Espacio en blanco 3</OPTION>
							</SELECT>
						</DIV>
						<DIV class="fila_formulario">
							<DIV id="div_botonesregistrar">
								<BUTTON id="boton_registrarUsuario" onclick="RegistrarUsuario()">Registrar</BUTTON>
							</DIV>
						</DIV>
				</DIV>
			</DIV>	
		</DIV>
		
	</BODY>
</HTML>