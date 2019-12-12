<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			if(isset($_POST['idPrefijo']) && isset($_POST['clase']) && isset($_POST['tipoUsuario'])){
				$idPrefijo=$_POST['idPrefijo'];
				$clase=$_POST['clase'];
				$tipoUsuario=$_POST['tipoUsuario'];
				if(strcmp ($tipoUsuario , "Todos" ) == 0){
						$sentenciaSql="SELECT usuarios.no_empleado, tiposusuario.descripcionTipoUsuario, usuarios.nombre, usuarios.correo FROM usuarios INNER JOIN tiposusuario ON (usuarios.idTipoUsuario=tiposusuario.idTipoUsuario)";
				}
				else{
					$sentenciaSql="SELECT usuarios.no_empleado, tiposusuario.descripcionTipoUsuario, usuarios.nombre, usuarios.correo FROM usuarios INNER JOIN tiposusuario ON (usuarios.idTipoUsuario=tiposusuario.idTipoUsuario) WHERE usuarios.idTipoUsuario IN (SELECT idTipoUsuario FROM tiposusuario WHERE descripcionTipoUsuario='".$tipoUsuario."')";
				
				}
				$resultado=$con->ejecutarSql($sentenciaSql);
				if($con->hayError($resultado)==false){
					$innerHTML="";
					if($con->cantidadRegistros($resultado)>0){
						for($i=0; $i<$con->cantidadRegistros($resultado); $i++){
							$registro=$con->obtenerFila($resultado);
							$fila =
							"<TR class='".$clase."' style='width:100%'>

									<TD style='width:20%; text-align:center; overflow-x: scroll'>".utf8_encode($registro['no_empleado'])."</TD>
									<TD style='width:10%; text-align:center; overflow-x: scroll'>".utf8_encode($registro['descripcionTipoUsuario'])."</TD>
									<TD style='width:25%; text-align:center; overflow-x: scroll'>".utf8_encode($registro['nombre'])."</TD>
									<TD style='width:25%; text-align:center; overflow-x: scroll'>".utf8_encode($registro['correo'])."</TD>
									<TD style='width:20%; text-align:center'>
											<BUTTON id='boton_editarUsuario' onclick=\"abrirFormularioEditarUsuario('".utf8_encode($registro['no_empleado'])."','".utf8_encode($registro['nombre'])."','".utf8_encode($registro['correo'])."','".utf8_encode($registro['descripcionTipoUsuario'])."')\">Editar</BUTTON>
											<BUTTON id='boton_eliminarUsuario' onclick=\"eliminarUsuario('".utf8_encode($registro['no_empleado'])."')\">Eliminar</BUTTON>
									</TD>
							</TR>";
							$innerHTML=$innerHTML.$fila;
						}
					}
					else{
						$innerHTML="<TR> <TD style='text-align:center'>No hay usuarios registrados<TD></TR>";
					}
					$con->cerrarConexion();
					echo $innerHTML;
				}
				else{
					$con->cerrarConexion();
					echo "error";
				}
			}
			else {
				$con->cerrarConexion();
				echo "error";
			}
	}
	catch(Exception $e){
		$con->cerrarConexion();
		echo "error";
	}
?>