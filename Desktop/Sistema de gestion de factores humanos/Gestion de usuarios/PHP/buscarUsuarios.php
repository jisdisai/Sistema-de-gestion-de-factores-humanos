<?php
	include ('conexion.php');
	try{
		$con=new Conexion();
			if(isset($_POST['idPrefijo']) && isset($_POST['clase']) && isset($_POST['palabraClave'])){
				$idPrefijo=$_POST['idPrefijo'];
				$clase=$_POST['clase'];
				$palabraClave=$_POST['palabraClave'];
				$sentenciaSql="SELECT usuarios.no_empleado, usuarios.nombre, usuarios.correo, tiposusuario.descripcionTipoUsuario FROM usuarios INNER JOIN tiposusuario ON (usuarios.idTipoUsuario = tiposusuario.idTipoUsuario) WHERE (usuarios.nombre LIKE '%".$palabraClave."%') OR (usuarios.no_empleado LIKE '%".$palabraClave."%') OR (usuarios.correo LIKE '%".$palabraClave."%') OR (tiposusuario.descripcionTipoUsuario LIKE '%".$palabraClave."%')";
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
						$innerHTML="</TABLE> <h4 style='text-align:center'>No se encontraron coincidencias</h4>";
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