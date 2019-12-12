<?php
	include ('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con=new Conexion();
		$innerHTML="";
		if(isset($_POST['nombreUsuario']) && isset($_POST['fechaInicio'])){
			$consultaSeglogs="SELECT seglog.SegLogFecha as 'fecha', seglog.SegLogHora as 'hora', seglog.SegUsrUsuario as 'username', seglog.SegLogDetalle FROM seglog [ WHERE comodin ]";
			if(strcmp($_POST['nombreUsuario'], "")!=0){
				$consultaSeglogs=str_replace("comodin", "seglog.SegUsrUsuario LIKE ('%".$_POST['nombreUsuario']."%') AND comodin", $consultaSeglogs);
			}
			if(strcmp($_POST['fechaInicio'], "")!=0){
				$consultaSeglogs=str_replace("comodin", "seglog.SegLogFecha LIKE ('%".$_POST['fechaInicio']."%') AND comodin", $consultaSeglogs);
			}
			$consultaSeglogs=str_replace(" [ WHERE comodin ]", "", $consultaSeglogs);
			$consultaSeglogs=str_replace("[ WHERE", "WHERE", $consultaSeglogs);
			$consultaSeglogs=str_replace(" AND comodin ]", "", $consultaSeglogs);
			$consultaSeglogs=str_replace(" comodin ]", "", $consultaSeglogs);
			$resultadoSeglogs=$con->ejecutarSql($consultaSeglogs);

			if($con->cantidadRegistros($resultadoSeglogs)==0){
				$innerHTML=$innerHTML."document.getElementById('anuncio_resultadosModificaciones').innerHTML= \"No se encontraron resultados\";";
				$innerHTML=$innerHTML."document.getElementById('tabla_resultadosModificaciones').innerHTML= \"\";";
				
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('anuncio_resultadosModificaciones').innerHTML= \"Se encontraron ".$con->cantidadRegistros($resultadoSeglogs)." resultados\";";
				$innerHTML=$innerHTML."document.getElementById('tabla_resultadosModificaciones').innerHTML= \"";
				for($i=0; $i<$con->cantidadRegistros($resultadoSeglogs); $i++){
					$registroSeglogs=$con->obtenerFila($resultadoSeglogs);

					$innerHTML=$innerHTML."<TR class='fila_tablaResultados'>";

					$innerHTML=$innerHTML."<TD class='columna_fechaModificaciones'>";
					$innerHTML=$innerHTML.$registroSeglogs['fecha']." (".$registroSeglogs['hora'].")";
					$innerHTML=$innerHTML."</TD>";
					$innerHTML=$innerHTML."<TD class='columna_nombreUsuarioModificaciones'>";
					$innerHTML=$innerHTML.$registroSeglogs['username'];
					$innerHTML=$innerHTML."</TD>";
					$innerHTML=$innerHTML."<TD class='columna_detalleModificaciones'>";
					$innerHTML=$innerHTML.$registroSeglogs['SegLogDetalle'];
					$innerHTML=$innerHTML."</TD>";

					$innerHTML=$innerHTML."</TR>";
				}
				$innerHTML=$innerHTML."\";";
				$innerHTML=$innerHTML."colorearTabla();";
				
			}
			echo utf8_encode($innerHTML);
		}
	}
?>