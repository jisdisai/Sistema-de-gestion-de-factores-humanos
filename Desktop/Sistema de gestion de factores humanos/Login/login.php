<?php
    require_once 'LoginMapper.php';
    require_once 'Login2.php';


    $loginBDAcciones = new LoginMapper();

    if(!empty($_POST)){
      $a = $_POST['numero'];
      $b = $_POST['password'];
      $resultado = $loginBDAcciones->ObtenerPorId($a, $b);

    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <LINK rel="stylesheet" type="text/css" href="CSS\stilos.css" media="screen"/>

    <title>Login</title>
  </head>
  <body style="margin: 0; padding: 0">
  	<DIV id="encabezado">
  		<div id="etiquetaPagina">Sistema de automatización de Factores Humanos</div>
  	</DIV>
  	<DIV id="contenedorPrincipal">
		<form action="login.php" method="POST" id="formulario_login">
  		<div class="fila_formulario">
    		<label for="exampleInputEmpleado" class="etiqueta">Numero de Empleado</label>
    		<div class="contenedor_input">
    			<input type="text" class="input" id="numero" name="numero" placeholder="Ingrese número empleado">
    		</div>
    		
  		</div>
  		<div class="fila_formulario">
    		<label for="exampleInputContrasenia" class="etiqueta">Contraseña</label>
    		<div class="contenedor_input">
    			<input type="password" class="input" id="password" name="password" placeholder="Ingrese Contraseña">
    		</div>
    		
  		</div>
  		<div class="fila_formulario">
  			<button type="submit" id="submit">Iniciar</button>
  		</div>
  		
  		</form>
  	</DIV>
  </body>

</html>