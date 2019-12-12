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
		<LINK rel="stylesheet" type="text/css" href="CSS\estilos_supervisores.css" media="screen"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		
	</HEAD>

		<script type="text/javascript">
      var no_controlador;
      var areaSeleccionada;
      var idEncuesta;
      var fecha_encuesta;
      var hora_encuesta;

      function IniciarDatosIniciales(no_empleado,encuesta){
        $.ajax({
          type:"post",
          url:"PHP/actualizarSelects.php",
          success: function(resp){
            if(resp.localeCompare('error')==0){
            alert("error");
            }
            else{
              eval(resp);
              no_controlador=no_empleado;
              idEncuesta=encuesta;       
              document.getElementById('listaControladores').style.display="none";
              document.getElementById('div_datosInicialesEvaluacion').style.display="block";
            }
          }
        });         
      }
      function iniciarPreguntaFiltro(){
      hora=document.getElementById('hora_encuesta').value;
      if(document.getElementById('entrada_fecha').value.localeCompare('')!=0){
        fecha_encuesta=document.getElementById('entrada_fecha').value;
      }
      else{
        n =  new Date();  
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();
        fecha_encuesta= y + "-" + m + "-" + d;
      }
      if(hora.localeCompare('')!=0){
        hora_encuesta=hora;
        $.ajax({
          type:"post",
          url:"PHP/obtenerPreguntaFiltro.php",
          success: function(resp){
            if(resp.localeCompare('error')==0){
            alert("error");
            }
            else{
              eval(resp);
              document.getElementById('div_datosInicialesEvaluacion').style.display="none";
              document.getElementById('div_preguntaFiltro').style.display="block";
            }
          }
        });
      }
      else{
        alert("Debes indicar una hora de apliación de encuesta");
      }
      
    }
    function habilitarFinFiltro(){
      document.getElementById('boton_siguientePreguntaFiltro').disabled=false;
      document.getElementById('boton_siguientePreguntaFiltro').style.opacity=1;
    }
    function iniciarAreaEvaluacion(){
      var respuesta;
      var turno=document.getElementById('select_turno').value;
      var posicion=document.getElementById('select_posicion').value;
      if(document.getElementById('respuestaAfirmativaPreguntaFiltro').checked){
        respuesta="si";
      }
      else{
        respuesta="no";
      }
      $.ajax({
          type:"post",
          url:"PHP/procesarRespuestaFiltro.php",
          data:{'respuesta':respuesta,'turno':turno,'posicion':posicion,'no_empleado':no_controlador,'idEncuesta':idEncuesta,'fecha_encuesta':fecha_encuesta,'hora_encuesta':hora_encuesta},
          success: function(resp){
            if(resp.localeCompare('error')==0){
              alert("error");
            }
            else{
              if(resp.localeCompare('finalizar')==0){
                alert("¡Respuesta registrada con exito!\nGracias por su participación");
                
                location.reload();
              }
              else{
                  obtenerAreasEvaluacion();
                  document.getElementById('div_preguntaFiltro').style.display="none";
                  document.getElementById('div_areaEvaluacion').style.display="block";
                
              }
              
            }
          }
      });      
    }
    function cancelarEvaluacion(){
      location.reload();
    }
    function obtenerAreasEvaluacion(){
      $.ajax({
          type:"post",
          url:"PHP/obtenerAreasEvaluacion.php",
          success: function(resp){
            if(resp.localeCompare('error')==0){
            alert("error");
            }
            else{
              eval(resp);
              document.getElementById('boton_siguienteAreaEvaluacion').disabled=true;
              document.getElementById('boton_siguienteAreaEvaluacion').style.opacity=0.6;
            }
          }
        });
    }

    function seleccionarArea(id){
      var areas=document.getElementsByClassName('areaEvaluacion');
      var i=0;
      for (i=0; i<areas.length; i++){
        areas[i].style.opacity=0.6;
      }
      document.getElementById(id).style.opacity=1;
      document.getElementById('boton_siguienteAreaEvaluacion').disabled=false;
      document.getElementById('boton_siguienteAreaEvaluacion').style.opacity=1;
      areaSeleccionada=id.replace("div_","");


    }
    function iniciarEncuesta(){
      $.ajax({
        type:"post",
        url:"PHP/obtenerPreguntas.php",
        data:{'area':areaSeleccionada},
        success: function(resp){
          if(resp.localeCompare("error")==0){
            alert("error");
          }
          else{
            if(resp.localeCompare("sinpreguntas")==0){
              document.getElementById('boton_finalizarEncuesta').disabled=true;
              document.getElementById('boton_finalizarEncuesta').style.opacity=0.6;
              document.getElementById('tabla_Preguntas').innerHTML="<TR style='width:100%'><TD style='width:100%; text-align:center; font-family: sans-serif'><h4>No hay Preguntas Definidas en esta encuesta</h4><TD></TR>";
            }
            else{
              document.getElementById('tabla_Preguntas').innerHTML=resp;
              colorearTabla();
              
            }
            document.getElementById('contenedorSecundario').style.display="none";
            document.getElementById('contenedorPrincipal_encuesta').style.display="block";
            
          }
        }
      });
      
    }
    function guardarRespuestas(){
      var selectsRespuestas=document.getElementsByClassName('selectRespuesta');
      var respuestas="";
      for(i=0; i<selectsRespuestas.length; i++){
        respuestas=respuestas+selectsRespuestas[i].id+":"+selectsRespuestas[i].value+";";
      }
      var turno=document.getElementById('select_turno').value;
      var posicion=document.getElementById('select_posicion').value;
      $.ajax({
        type:"post",
        url:"PHP/guardarRespuestas.php",
        data:{'respuestas':respuestas,'turno':turno,'posicion':posicion,'area':areaSeleccionada,'fecha_encuesta':fecha_encuesta,'hora_encuesta':hora_encuesta,'id_encuesta':idEncuesta,'no_controlador':no_controlador},
        success: function(resp){
          if(resp.localeCompare("error")==0){
            alert("error");
          }
          else{
            alert("¡Respuestas guardadas con éxito!\nGracias por su colaboración.");
            location.reload();
          }
        }
      });
      
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
      function buscarControladores(){
        var palabraClave=document.getElementById('entrada_nombreUsuario').value;
        var f = new Date();
        var fecha=(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
        if(document.getElementById('entrada_fecha').value.localeCompare('')!=0){
          fecha=document.getElementById('entrada_fecha').value;
        }        
        $.ajax({
          type:"post",
          url:"PHP/buscarControladores.php",
          data:{'palabraClave':palabraClave,'fecha':fecha},
          success: function(resp){
            eval(resp);
          }
        });
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
        data:{'tipo':3},
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

			<div id="div_identificadorPagina">
				<div id="div_iconoPagina">
					<img src="iconos\usuarios.png" style="width: 90%; height: 90%">
				</div>
				<div id="div_etiquetaPagina">
					<label id="etiquetaPagina">Área de Supervisores</label>
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
								(Supervisor)
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
			<DIV id="contenedorSecundario"><DIV id="listaControladores" style="width: 100%; height: 100%">
        <DIV class="etiqueta_tab">
              <h4>Buscar Controlador</h4>
        </DIV>
          <DIV id="div_busquedaModificaciones" class="div_busqueda">
              <DIV id="div_tabla_busquedaControladores" class="div_tablaBusqueda">
                <TABLE id="tabla_busquedaControladores" class="tabla_Busqueda">
                  <TR class="fila_tablaControladores">
                    <TD class="columna_tablaControladores" style="text-align: center">
                     Palabra clave (Nombre o número de empleado):
                    </TD>
                    <TD class="columna_tablaControladores">
                      <INPUT type="text" id="entrada_nombreUsuario" class="entrada">
                    </TD>
                  </TR>
                  <TR class="columna_tablaControladores">
                    <TD class="columna_tablaBusquedaInicioSesion">
                      Fecha <small>(Se tomará la fecha actual si se omite este parámetro):</small> 
                    </TD>
                    <TD class="columna_tablaControladores">
                      <INPUT type="date" id="entrada_fecha" class="entrada">
                    </TD>
                  </TR>
                </TABLE>
              </DIV>
              <DIV id="div_botonBusquedaControladores" class="div_botonBusqueda">
                <BUTTON id="boton_buscarControladores" class="botonBusqueda" onclick="buscarControladores()">Buscar</BUTTON>
              </DIV>              
          </DIV>
          <DIV class="etiqueta_tab">
               <h4>Resultados</h4>
          </DIV>
          <DIV  class="div_anuncio_resultados">
              <h5 id="anuncio_resultados" class="anuncio_resultados">Se encontraron [ ] resultados</h5>
          </DIV>
          <DIV class="contenedorResultados">
              <DIV class="contenedorTablaResultados" >
                <TABLE class="tabla_camposResultados" >
                  <TR class="fila_tablaCamposResultados">
                     <TD class="columna_noEmpleado" style="background-color: #272827; color: white">
                      N° de Empleado
                    </TD>
                    <TD class="columna_nombreUsuario" style="background-color: #272827; color: white">
                      Nombre de Usuario
                    </TD>
                    <TD class="columna_estado" style="background-color: #272827; color: white">
                     Estado del monitoreo
                    </TD>
                    <TD class="columna_accion" style="background-color: #272827; color: white">
                      Accion
                    </TD>
                  </TR>
                </TABLE>
                <TABLE id ="tabla_resultados" class="tabla_resultados">
                  
                </TABLE>
              </DIV>              
          </DIV>
			</DIV>
      <DIV id="div_datosInicialesEvaluacion" style="display:none">
          <DIV id="DIV_datosControlador" class="etiqueta_faseEvaluacion">
            <h3 style="font-family: sans-serif; color: white">Datos del controlador</h3>
          </DIV>
            <TABLE style="width: 80%; height: 60%; ">
              <TR class="filaFormulario">
                <TD class="columnaFormulario">
                  <label class="etiquetaInput">Turno: </label>
                </TD>
                <TD class="columnaFormulario">
                  <CENTER><SELECT id="select_turno" class="select_datosControlador"></SELECT></CENTER>
                </TD>
              </TR>
              <TR class="filaFormulario">
                <TD class="columnaFormulario">
                  <label class="etiquetaInput">Posición de control:</label>
                </TD>
                <TD class="columnaFormulario">
                  <CENTER><SELECT id="select_posicion" class="select_datosControlador"></SELECT></CENTER>
                </TD>
              </TR>
              <TR class="filaFormulario">
                <TD class="columnaFormulario">
                  <label class="etiquetaInput">Hora de apliación de la encuesta:</label>
                </TD>
                <TD class="columnaFormulario">
                  <CENTER><INPUT type="time" id="hora_encuesta" class="select_datosControlador"></CENTER>
                </TD>
              </TR>
            </TABLE>
            <DIV id="div_botonesDatosControlador">
              <button id="boton_siguienteDatosControlador" class="botones_DatosControlador" onclick="iniciarPreguntaFiltro()">Siguiente</button>
              <button id="boton_cancelarDatosControlador" class="botones_DatosControlador" onclick="cancelarEvaluacion()">Cancelar</button>
            </DIV>
        </DIV>
        <DIV id="div_preguntaFiltro" style="display:none">
          <DIV class="etiqueta_faseEvaluacion">
            <h3 style="font-family: sans-serif; color: white">Pregunta Filtro</h3>
          </DIV>
          <DIV id="div_descripcionPreguntaFiltro">
            <h2 id="descripcionPreguntaFiltro" style="font-family: sans-serif; color: #424949">
              ¿Está en condiciones óptimas para realizar su turno?
            </h2>
          </DIV>
          <DIV id="div_respuestasPreguntaFiltro">
            <TABLE style="width: 10%; height: 100%;">
              <TR>
                <TD ><label class="etiquetaInput">Si</label></TD>
                <TD><INPUT type="radio" id="respuestaAfirmativaPreguntaFiltro" value="si" name="respuesta" onchange="habilitarFinFiltro()"></TD>
              </TR>
              <TR>
                <TD><label class="etiquetaInput">No</label></TD>
                <TD><INPUT type="radio" id="respuestaNegativaPreguntaFiltro" value="no" name="respuesta" onchange="habilitarFinFiltro()"></TD>
              </TR>

            </TABLE>            
          </DIV>
          <DIV id="botones_preguntaFiltro">
            <button id="boton_siguientePreguntaFiltro" class="botones_preguntaFiltro" onclick="iniciarAreaEvaluacion()" disabled style="opacity: 0.6">Siguiente</button>
            <button id="boton_cancelarPreguntaFiltro" class="botones_preguntaFiltro" onclick="cancelarEvaluacion()">Cancelar</button>
          </DIV>
        </DIV>
        <DIV id="div_areaEvaluacion" style="display: none">
          <DIV id="DIV_areaEvaluacion" class="etiqueta_faseEvaluacion">
            <h3 style="font-family: sans-serif; color: white">Selección de Área de Evaluación</h3>
          </DIV>
          <DIV id="div_listaAreasEvaluacion">
            <DIV id="listaAreaEvaluacion">
              
            </DIV>
          </DIV>
          <DIV id="div_botonesAreaEvaluacion">
            <button id="boton_siguienteAreaEvaluacion" class="botones_areaEvaluacion" onclick="iniciarEncuesta()">Siguiente</button>
            <button id="boton_cancelarAreaEvaluacion" class="botones_areaEvaluacion" onclick="cancelarEvaluacion()">Cancelar</button>
          </DIV>
        </DIV>

      </DIV>
      <DIV id="contenedorPrincipal_encuesta" style="display: none">
        <DIV class="etiqueta_faseEvaluacion">
            <h3 id="tituloEncuesta" style="font-family: sans-serif; color: white">Encuesta</h3>
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
            <TABLE id="tabla_Preguntas" style="width: 100%; height: 90%">

            </TABLE>
          </DIV>          
        </DIV>
        <DIV id="div_botones_encuesta">
          <button id="boton_finalizarEncuesta" class="botones_encuesta" onclick="guardarRespuestas()">Finalizar</button>
          <button id="boton_cancelarEncuesta" class="botones_encuesta" onclick="cancelarEvaluacion()">Cancelar</button>
        </DIV>
      </DIV>
		</DIV>		
	</BODY>
  <script type="text/javascript">
    
  </script>
</HTML>