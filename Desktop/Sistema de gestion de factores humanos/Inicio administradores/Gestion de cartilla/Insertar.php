<?php
	include ("conexion.php");
	$con=new Conexion();
	session_start();
	if(!empty($_SESSION)){
		if(isset($_POST['tabla']) ){
			if(isset($_POST['campo'])){
				if(isset($_POST['condicion'])){
					if(isset($_POST['nuevoValor'])){
						$tabla=$_POST['tabla'];
						$campo=$_POST['campo'];
						$condicion=$_POST['condicion'];
						$consultaDescripcion="SELECT preguntafiltro.descripcionPreguntaFiltro FROM preguntafiltro WHERE ".$condicion;
						$resultadoDescripcion=$con->ejecutarConsulta($consultaDescripcion);
						$registroDescripcion=$con->obtenerFila($resultadoDescripcion);
						$nuevoValor=($_POST['nuevoValor']);
			
						$sql="UPDATE ".$tabla." SET ".$campo." = '".$nuevoValor."' WHERE ".$condicion;
						$resultado=$con->ejecutarConsulta($sql);
						$detalle=("Actualizó la descripción de la pregunta filtro. Antíguo valor: [".utf8_encode($registroDescripcion['descripcionPreguntaFiltro'])." ]. Nuevo valor: [ ".$nuevoValor." ] ");
						$insertLog="INSERT INTO seglog (SegLogFecha, SegLogHora, SegUsrKey, SegUsrUsuario, SegLogDetalle) VALUES (CURDATE(),NOW(),".$_SESSION['log_userId'].",'".$_SESSION['usuario']."','".$detalle."')";						
						$insertar=$con->ejecutarConsulta($insertLog);
						echo ("¡Cabios efectuados con éxito!");
					}
					else{
						echo ("¡Se produjo un error al tratar de efectuar los cambios!");
					}
				}
				else{
					echo ("¡Se produjo un error al tratar de efectuar los cambios!");
				}
			}
			else {
				echo ("¡Se produjo un error al tratar de efectuar los cambios!");
			}
		}
		else{
			echo ("¡Se produjo un error al tratar de efectuar los cambios!");
		}

	}

?>