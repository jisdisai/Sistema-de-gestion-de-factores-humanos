<?php
	include ('AES.php');
	use  PHPMailer \ PHPMailer \ PHPMailer ; 
	use  PHPMailer \ PHPMailer \ Exception ;

	require 'PHPMailer/src/Exception.php'; 
	require 'PHPMailer/src/PHPMailer.php'; 
	require 'PHPMailer/src/SMTP.php';

	
	class Correo{
		
		private $contactos;
		private $contenido;
		private $cuenta;
		private $con;

		public function __construct(){
						

		}
		public function enviarCorreo($contenido){
			$con= new Conexion();
			$this->contenido=$contenido;
			$consultaContactos="select correo,no_empleado from usuarios where idTipoUsuario = 3";
			$resultadoConsultaContactos=$con->ejecutarSql($consultaContactos);
			if($con->cantidadRegistros($resultadoConsultaContactos)>0){
				//$regsitroContactos=$con->obtenerFila($resultadoConsultaContactos);
				$mail = new PHPMailer();	
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'tls';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;

				$consultaCorreo="SELECT correoSistema.correo,correoSistema.password_correo FROM correoSistema";
				$resultadoCorreo=$con->ejecutarSql($consultaCorreo);
				$registroCorreo=$con->obtenerFila($resultadoCorreo);

				if($con->cantidadRegistros($resultadoCorreo)==1 && strcmp($registroCorreo['correo'],'')!=0){
					$mail->Username = $registroCorreo['correo']; //Correo de donde enviaremos los correos
					$mail->Password = encrypt_decrypt("decrypt",$registroCorreo['password_correo']);

					for($i=0; $i<$con->cantidadRegistros($resultadoConsultaContactos); $i++){
						$contacto=$con->obtenerFila($resultadoConsultaContactos);
						$correoReceptor = $contacto['correo'];
						$empleado = $contacto['no_empleado'];
						$mail->setFrom('pruebacocesna1@gmail.com', utf8_decode('Sistema de automatización de Gestión de Factores Humanos'));
						$mail->addAddress($correoReceptor, $empleado);
						$mail->Subject = 'Alerta de personal';
						$mail->Body= utf8_decode($this->contenido);
						$mail->send();

					}

				}

			}

		}
	}
	
?>