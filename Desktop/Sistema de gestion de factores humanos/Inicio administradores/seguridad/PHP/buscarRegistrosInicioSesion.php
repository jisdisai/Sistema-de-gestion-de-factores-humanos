<?php
	include ('conexion.php');
	session_start();
	if(!empty($_SESSION)){
		$con=new Conexion();
		$innerHTML="";
		if(isset($_POST['nombreUsuario']) && isset($_POST['fechaInicio'])){
			$consultaUsers="SELECT user.username, logins.fecha,logins.hora, tiposusuario.descripcionTipoUsuario FROM user INNER JOIN usuarios ON user.username = usuarios.nombre INNER JOIN personal on usuarios.no_empleado = personal.no_empleado INNER JOIN tiposusuario ON usuarios.idTipoUsuario = tiposusuario.idTipoUsuario INNER JOIN logins ON user.id = logins.id_user [ WHERE comodin ]";
			if(strcmp($_POST['nombreUsuario'], "")!=0){
				$consultaUsers=str_replace("comodin", "user.username LIKE ('%".$_POST['nombreUsuario']."%') AND comodin", $consultaUsers);
			}
			if(strcmp($_POST['fechaInicio'], "")!=0){
				$consultaUsers=str_replace("comodin", "logins.fecha LIKE ('%".$_POST['fechaInicio']."%') AND comodin", $consultaUsers);
			}
			$consultaUsers=str_replace(" [ WHERE comodin ]", "", $consultaUsers);
			$consultaUsers=str_replace("[ WHERE", "WHERE", $consultaUsers);
			$consultaUsers=str_replace(" AND comodin ]", "", $consultaUsers);
			$consultaUsers=str_replace(" comodin ]", "", $consultaUsers);
			$resultadoUsers=$con->ejecutarSql($consultaUsers);
			if($con->cantidadRegistros($resultadoUsers)==0){
				$innerHTML=$innerHTML."document.getElementById('anuncio_resultadosInicioSesion').innerHTML= \"No se encontraron resultados\";";
				$innerHTML=$innerHTML."document.getElementById('tabla_resultadosInicioSesion').innerHTML= \"\";";
				
			}
			else{
				$innerHTML=$innerHTML."document.getElementById('anuncio_resultadosInicioSesion').innerHTML= \"Se encontraron ".$con->cantidadRegistros($resultadoUsers)." resultados\";";
				$innerHTML=$innerHTML."document.getElementById('tabla_resultadosInicioSesion').innerHTML= \"";
				for($i=0; $i<$con->cantidadRegistros($resultadoUsers); $i++){
					$registroUsers=$con->obtenerFila($resultadoUsers);

					$innerHTML=$innerHTML."<TR class='fila_tablaResultados'>";

					$innerHTML=$innerHTML."<TD class='columna_fechaInicioSesion'>";
					$innerHTML=$innerHTML.$registroUsers['fecha']." (".$registroUsers['hora'].")";
					$innerHTML=$innerHTML."</TD>";
					$innerHTML=$innerHTML."<TD class='columna_nombreUsuario'>";
					$innerHTML=$innerHTML.$registroUsers['username'];
					$innerHTML=$innerHTML."</TD>";
					$innerHTML=$innerHTML."<TD class='columna_tipoUsuario'>";
					$innerHTML=$innerHTML.$registroUsers['descripcionTipoUsuario'];
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