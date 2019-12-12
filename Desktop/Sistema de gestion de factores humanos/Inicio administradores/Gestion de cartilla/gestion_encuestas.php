<?php
	session_start();
	if(empty($_SESSION)){
		header('location:../Login/login.php');
	}
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<TITLE>Gestión de CMP</TITLE>
		<link rel="stylesheet" type="text/css" href="CSS3\estilos_gestionCartilla.css" media="screen"/>
		<META charset="UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="jquery.redirect-master/jquery.redirect.js"></script>

	</HEAD>
	<BODY bgcolor="#B2BABB">
		<script type="text/javascript">
			var areaSeleccionada;
			

				
			function renombrarArea(){
				document.getElementById('nombreArea').value=areaSeleccionada;
				window.location="#openModal";
				//<a href="#openModal">Lanzar el modal</a>
			}
			function guardarNombreArea(){
				var old_nombre = areaSeleccionada;
				var new_nombre = document.getElementById('nombreArea').value; 
				$.ajax({
					type:'post',
					url:'renombrarArea.php',
					data:{'old_nombre':old_nombre,'new_nombre':new_nombre},
					success: function(resp){
						alert(resp);
						window.location="#closeModal";
						location.reload();						
					}});
			}
			function AbrirFormulario (evt, nombreEnlace){
				document.getElementById("preguntaFiltro").style.display="none";
				var i;
				var tabContenido;
				var tabEnlace;
				//Ocultar todos los formularios 
				tabContenido=document.getElementsByClassName("tabContenido");
				for (i=0; i<tabContenido.length; i++){
					tabContenido[i].style.display="none";
				}
				tabEnlace=document.getElementsByClassName("tabEnlace");
				for (i=0; i<tabEnlace.length; i++){
					tabEnlace[i].className = tabEnlace[i].className.replace(" activo","");

				}
				document.getElementById(nombreEnlace).style.display="block";
			}
			function editarPreguntaFiltro(){
				var i;
				var VistaPreviaBotones = document.getElementsByClassName("VistaPreviaBotones");
				for (i=0; i<VistaPreviaBotones.length; i++){
					VistaPreviaBotones[i].style.display="none";
				}
				var EdicionBotones=document.getElementsByClassName("EdicionBotones");
				for (i=0; i<EdicionBotones.length; i++){
					EdicionBotones[i].style.display="inline-block";
				}
				document.getElementById("descripcionPreguntaFiltro").removeAttribute("readonly"  , false);
				document.getElementById("descripcionPreguntaFiltro").focus();
				//document.getElementById("AccionAfirmativa").disabled=false;
				//document.getElementById("AccionNegativa").disabled=false;

				
			}
			function cambiarAccionAfirmativa(){
				if(document.getElementById("negativa1").selected){
					document.getElementById("afirmativa1").selected=false;
					document.getElementById("afirmativa2").selected=true;
				}
				else{
					document.getElementById("afirmativa1").selected=true;
					document.getElementById("afirmativa2").selected=false;
				}
			}
			function cambiarAccionNegativa(){
				if(document.getElementById("afirmativa1").selected){
					document.getElementById("negativa1").selected=false;
					document.getElementById("negativa2").selected=true;
				}
				else{
					document.getElementById("negativa1").selected=true;
					document.getElementById("negativa2").selected=false;
				}
			}
			function actualizarPreguntaFiltro(){
				<?php
					$tabla="preguntaFiltro";
					$campo="descripcionPreguntaFiltro";
					$condicion="idPreguntaFiltro=1";
				?>
				var tabla="<?php echo $tabla ?>";
				var campo="<?php echo $campo ?>";
				var condicion="<?php echo $condicion?>";
				var nuevaPreguntaFiltro=document.getElementById("descripcionPreguntaFiltro").value;
				var datain='campo='+campo;
				$.ajax({
					type:'post',
					url:'Insertar.php',
					data:{'tabla':tabla,'campo':campo,'condicion':condicion, 'nuevoValor':nuevaPreguntaFiltro},
					success: function(resp){
						alert(resp);						
					}

				});
				var afirmativaSeleccionada='no se encontró';
				var negativaSeleccionada='no se encontró';
				var afirmativas = document.getElementsByClassName('afirmativa');
				var negativas = document.getElementsByClassName('negativa');
				for(i=0; i<afirmativas.length; i++){
					if(afirmativas[i].selected){
						afirmativaSeleccionada=afirmativas[i].innerHTML;
					}
				}
				for (i=0; i<negativas.length; i++){
					if(negativas[i].selected){
						negativaSeleccionada=negativas[i].innerHTML;
					}
				}
				$.ajax({
					type:'post',
					url:'actualizarAcciones.php',
					data:{
						'afirmativaSeleccionada':afirmativaSeleccionada,
						'negativaSeleccionada':negativaSeleccionada
					},
					success: function(resp){
						location.reload();
					}
				});
			}

			function recargar(nombreEnlace){
				location.reload();		
			}

			function habiliarEdicion(evt){
				var boton=document.getElementsByClassName("btns_editarEncuestas");
				var areaEvaluacion=document.getElementsByClassName("areaEvaluacion");
				var i;
				var j;
				for (i=0; i<boton.length; i++){
					boton[i].style.opacity=1;
					boton[i].disabled=false;
				}
				areaSeleccionada=evt.currentTarget.id;
				document.getElementById("areaSeleccionada").innerHTML="Área Seleccionada: "+areaSeleccionada;
			}
			function eliminarArea(){
				$.ajax({
					type:'post',
					url:'EliminarArea.php',
					data:{
						'area':areaSeleccionada
					},
					success: function(resp){
						alert("Área eliminada");
						location.reload();
					}
				});
			}


			function visualizarEncuesta(){
				$.redirect(
					"visualizar_Encuesta.php",
					{area:areaSeleccionada},
					"POST"
					);
			}
			function abrirFormularioNuevaArea(){
				document.getElementById("areasEvaluacion").style.display="none";

				document.getElementById("formularioAgregarArea").style.display="block";
				document.getElementById('textarea_descripcionNuevaArea').focus();
				document.getElementById('textarea_descripcionNuevaArea').select();
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
					//location.reload();
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
		<div id="encabezado">
			<button id="boton_volver" onclick="location.href='../inicio_administradores.php'">Volver</button>
			<div id="div_identificadorPagina">
				<div id="div_iconoPagina">
					<img src="iconos\reportes.png" style="width: 90%; height: 90%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Gestión de Cartilla de monitoreo Personal</label>
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
			<div class="tab">
 				<button class="tabEnlace" onclick="AbrirFormulario(event, 'preguntaFiltro')">Pregunta Filtro</button>
  				<button class="tabEnlace" onclick="AbrirFormulario(event, 'areasEvaluacion')">Áreas de Evaluación</button>
  				<button class="tabEnlace" onclick="AbrirFormulario(event, 'parametros')">Parámetros Adicionales</button>
			</div>
			<div id="preguntaFiltro" class="tabContenido">
				<div id="VistaPreviaPreguntaFiltro">
					<h3 style="margin-top: 0px; margin-bottom: 0px; margin-left: 3%">Descripción</h3>
					<hr>
					<?php		
						function obtenerPreguntaFiltro(){
							$conexion=mysqli_connect('localhost','root','',"cocesna");
							$GLOBALS['conexion']=$conexion;
							$consulta="SELECT * FROM preguntafiltro WHERE idPreguntaFiltro=1";
							$resultadoConsulta=$conexion->query($consulta);
							$registro=$resultadoConsulta->fetch_assoc();
							$descripcionPreguntaFiltro=$registro["descripcionPreguntaFiltro"];
							echo utf8_encode("
							 	<center>
									<textarea id='descripcionPreguntaFiltro'  style='text-align:center;resize:none' readonly >".$descripcionPreguntaFiltro."</textarea>
								</center>
								");
						}
						obtenerPreguntaFiltro();		
					?>
				</div>
				<div id="VistaPreviaRespuestasPreguntaFiltro">
					<h3 style="margin-top: 0px; margin-bottom: 0px; margin-left: 3%">Posibles Respuestas</h3>
					<hr style="margin-top: 0px">
					<CENTER>
						<TABLE id="TablaRespuestasAcciones">
							<tr>
								<td align="center">
									Respuestas:
								</td>
								<td align="center">
									Acciones:
								</td>
							</tr>
							<tr>
								<td align="center">
									Si
								</td>
								<td id="AccionRespuestaAfirmativa" align="center">
									<div style="display:none; height: 100%; width:100%">
									<SELECT id="AccionAfirmativa" disabled >
										<?php
										$consulta=utf8_decode("SELECT accionrespuestafiltro.descripcionAccion, respuestafiltroxaccion.valorRespuesta FROM accionrespuestafiltro INNER JOIN respuestafiltroxaccion ON (accionrespuestafiltro.idAccionRespuestaFiltro = respuestafiltroxaccion.idAccionRespuestaFiltro) WHERE respuestafiltroxaccion.valorRespuesta = 'Si'");
										$resultadoConsulta=$conexion->query($consulta);
										$registro=$resultadoConsulta->fetch_assoc();
											echo utf8_encode("<OPTION value='1' SELECTED id='afirmativa1' class='afirmativa' name='".$registro['descripcionAccion']."''>".$registro['descripcionAccion']."</OPTION>");

										$consulta=utf8_decode("SELECT accionrespuestafiltro.descripcionAccion, respuestafiltroxaccion.valorRespuesta FROM accionrespuestafiltro INNER JOIN respuestafiltroxaccion ON (accionrespuestafiltro.idAccionRespuestaFiltro = respuestafiltroxaccion.idAccionRespuestaFiltro) WHERE respuestafiltroxaccion.valorRespuesta = 'No'");
										$resultadoConsulta=$conexion->query($consulta);
										$registro=$resultadoConsulta->fetch_assoc();
										echo utf8_encode("<OPTION value='2' id='afirmativa2' class='afirmativa' name='".$registro['descripcionAccion']."'>".$registro['descripcionAccion']."</OPTION>");
										?>
									</SELECT>
									</div>
									Finalizar Monitoreo
								</td>
							</tr>
							<tr>
								<td align="center">
									No
								</td>
								<td id="AccionRespuestaNegativa" align="center">
									Evaluar Estado
									<div style="display: none; height: 100%; width: 100%;">
									<SELECT id="AccionNegativa" disabled>										
										<?php
										$consulta=utf8_decode("SELECT accionrespuestafiltro.descripcionAccion, respuestafiltroxaccion.valorRespuesta FROM accionrespuestafiltro INNER JOIN respuestafiltroxaccion ON (accionrespuestafiltro.idAccionRespuestaFiltro = respuestafiltroxaccion.idAccionRespuestaFiltro) WHERE respuestafiltroxaccion.valorRespuesta = 'No'");
										$resultadoConsulta=$conexion->query($consulta);
										$registro=$resultadoConsulta->fetch_assoc();
											echo utf8_encode("<OPTION value='1' SELECTED id='negativa1' class='negativa' name='".$registro['descripcionAccion']."''>".$registro['descripcionAccion']."</OPTION>");

										$consulta=utf8_decode("SELECT accionrespuestafiltro.descripcionAccion, respuestafiltroxaccion.valorRespuesta FROM accionrespuestafiltro INNER JOIN respuestafiltroxaccion ON (accionrespuestafiltro.idAccionRespuestaFiltro = respuestafiltroxaccion.idAccionRespuestaFiltro) WHERE respuestafiltroxaccion.valorRespuesta = 'Si'");
										$resultadoConsulta=$conexion->query($consulta);
										$registro=$resultadoConsulta->fetch_assoc();
										echo utf8_encode("<OPTION value='2' id='negativa2' class='negativa' name='".$registro['descripcionAccion']."'>".$registro['descripcionAccion']."</OPTION>");
										?>
									</SELECT>
									</div>
								</td>
							</tr>
						</TABLE>
					</CENTER>
				</div>

				<div class="VistaPreviaBotones">			
  					<button class="botonEditar" id="btn_editarPreguntaFiltro" onclick="editarPreguntaFiltro();">Editar</button>
  				</div>
  				<div class="EdicionBotones">
  					<button class="botonAplicar" id="botonGuardarPreguntaFiltro" onclick="actualizarPreguntaFiltro()">Aplicar</button>
  					<button class="botonCancelar" id="botonCancelarPreguntaFiltro" onclick="recargar('Encuestas')">Cancelar</button>
  				</div>
			</div>
			<div id="openModal" class="modalDialog">
				<div>
					<a href="#close" title="Close" class="close">X</a>
					<center><h2>Renombrar Área</h2></center>
					<div id="formulario_nombreArea">
						<Center>
						<INPUT type="text" id="nombreArea">
						<button id="boton_renombrarArea" onclick="guardarNombreArea()">Aplicar</button>
						</center>
					</div>
				</div>
			</div>
			<div id="areasEvaluacion" class="tabContenido">
				<h3 style="margin-top: 0px; margin-bottom: 0px; margin-left: 3%">Áreas de evaluacion disponibles: </h3>
				<hr style="margin-top: 0px">
				<div id="VistaPreviaAreasEvaluacion">
					<div class="listaAreasEvaluacion">
  					<?php		
						function obtenerAreasEvaluacion(){
							$conexion=mysqli_connect('localhost','root','',"cocesna");
							$consulta="SELECT * FROM AreaEvaluacion";
							$resultadoConsulta=$conexion->query($consulta);
							while ($registro=$resultadoConsulta->fetch_assoc()){
								$descripcionAreaEvaluacion=$registro["descripcionAreaEvaluacion"];
									echo utf8_encode("
									<button class='areaEvaluacion' id='".$descripcionAreaEvaluacion."' onclick='habiliarEdicion(event)'>
							 		".$descripcionAreaEvaluacion."
							 		</button>							 	
									");
							}
						}
						obtenerAreasEvaluacion();	
					?>
					</div>
					<div id="btns_editarEncuestas" align="center">
						 <h3 id="areaSeleccionada" align="center" style="margin:0px"></h3>
						 <button id="btns_renombrarArea" class="btns_editarEncuestas" disabled onclick="renombrarArea()">Renombrar</button>
						<button id="btn_VisualizarEncuesta" class="btns_editarEncuestas" disabled onclick="visualizarEncuesta()">Ver Encuesta</button>
						<button id="btn_EliminarArea" class="btns_editarEncuestas" disabled onclick="eliminarArea()">Eliminar</button>
					</div>
				</div>				
				<div  id="VistaPreviaBotonesAreas">
					<button class="botonEditar" id="btn_editarAreasEvaluacion" onclick="abrirFormularioNuevaArea()">Agregar Área</button>
				</div>

			</div>
			<div id="formularioAgregarArea" class="tabContenido" style="display: none">
				<div id="div_DescripcionArea" >
					<h3 style="margin-top: 0px; margin-bottom: 0px; margin-left: 3%">Descripción</h3>
					<hr>
					<center>
						<textarea id="textarea_descripcionNuevaArea" style="text-align: center"></textarea>
					</center>
					
				</div>				
				<div id="botonesNuevaArea">
						<button id="boton_guardarArea" class="botonesNuevasAreas" onclick="
							$.ajax({
								type:'post',
								url:'GuardarArea.php',
								data:{
									'descripcionArea':document.getElementById('textarea_descripcionNuevaArea').value
								},
								success: function(resp){
									alert(resp);
									location.reload();
								}
							});
						">Guardar</button>
						<button id="boton_cancerlarArea" class="botonesNuevasAreas" onclick="AbrirFormulario(event, 'areasEvaluacion')">Cancelar</button>
				</div>
			</div>
			<script type="text/javascript">
				function editarCorreo(){
					document.getElementById('entrada_correo').readOnly=false;
					document.getElementById('entrada_password').readOnly=false;
					document.getElementById('radio_mostrarPassword').disabled=false;
					document.getElementById('entrada_correo').focus();
					document.getElementById('entrada_correo').style.opacity=1;
					document.getElementById('entrada_password').style.opacity=1;
					document.getElementById('div_botonesEditarCorreo').style.display="none";
					document.getElementById('div_botonesAplicarCorreo').style.display="block";
				}
				function cancelarCorreo() {
					obtenerCorreo();
					document.getElementById('entrada_correo').readOnly=true;
					document.getElementById('entrada_password').readOnly=true;
					document.getElementById('radio_mostrarPassword').disabled=true;
					document.getElementById('entrada_correo').style.opacity=0.8;
					document.getElementById('entrada_password').style.opacity=0.8;
					document.getElementById('div_botonesEditarCorreo').style.display="block";
					document.getElementById('div_botonesAplicarCorreo').style.display="none";
				}
				function guardarCorreo(){
					var nuevoCorreo=document.getElementById('entrada_correo').value;
					var password_correo=document.getElementById('entrada_password').value;
					$.ajax({
							type:'post',
							url:'PHP/guardarCorreo.php',
							data:{
								'nuevoCorreo':nuevoCorreo,'password_correo':password_correo
							},
							success: function(resp){
								if(resp.localeCompare('error')==0){
									alert("valor no válido");
									obtenerCorreo();
		
								}
								else{
									obtenerCorreo();
									cancelarCorreo();

								}
							
							
						}
					});
				}
				function obtenerCorreo(){
					$.ajax({
							type:'post',
							url:'PHP/obtenerCorreo.php',
							success: function(resp){
							eval(resp);
						}
					});
				}
				function visibilidadPassword(){
					if(document.getElementById('radio_mostrarPassword').checked){
						document.getElementById('entrada_password').type="text";
					}
					else{
						document.getElementById('entrada_password').type="password";
					}
				}
			</script>
			<div id="parametros" class="tabContenido">
				<div id="div_configurarCorreo">
					<DIV class="etiqueta_tab">
  						<h4>Cuenta de Correo Remitente de Notificaciones</h4>
  					</DIV>
  					<DIV id="div_campoCorreo">
  						<LABEL for="entrada_correo">Cuenta de correo:</LABEL>
  						<INPUT type="text" id="entrada_correo" readonly></INPUT>
  					</DIV>
  					<DIV id="div_campoPassword">
  						<LABEL for="entrada_correo">Contraseña:</LABEL>
  						<INPUT type="password" id="entrada_password" readonly style="text-align: center"></INPUT>
  						<LABEL>Mostrar caracteres</LABEL>
  						<input type="checkbox" id="radio_mostrarPassword" disabled onchange="visibilidadPassword()">
  					</DIV>
  					<div id="div_botonesCorreo">
  						<div id="div_botonesEditarCorreo">
  							<button id="boton_editarCorreo" onclick="editarCorreo()">Editar</button>
  						</div>
  						<div id="div_botonesAplicarCorreo" style="display:none;">
  							<button id="boton_guardarCorreo" onclick="guardarCorreo()">Aplicar</button>
  							<button id="boton_cancelarCorreo" onclick="cancelarCorreo()">Cancelar</button>
  						</div>
  					</div>
				</div>
			</div>

		</div>
		<script type="text/javascript">
			obtenerCorreo();
		</script>
	</BODY>
</HTML>