<?php
    
    include 'AES.php';
    include 'conexion.php';
    require_once 'MapperBD.php';
    require_once 'Login2.php';
    
    class LoginMapper extends MapperBD{
        
        public function __construct(){
            parent::__construct();
        }

        public function ObtenerPorId($a, $b){
        	$con=new Conexion();
            
            $tes = encrypt_decrypt("encrypt",$b);

            $sql = "select * from usuarios where (no_empleado=:a)";
            $stmt = self::$PDO->prepare($sql);
            
            //$stmt->bindParam(':a', $a, PDO::PARAM_STR, 10);
            $stmt->execute(array(':a' => $a));
            
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();

            if(!is_null($result)){
                $productos[] = new Login($result['no_empleado'], 
                                            $result['idTipoUsuario'],
                                            $result['nombre'], 
                                            $result['password'], 
                                            $result['correo']);
                while($result = $stmt->fetch()){
                    $productos[] = new Login($result['no_empleado'], 
                                                $result['idTipoUsuario'],
                                                $result['nombre'], 
                                                $result['password'], 
                                                $result['correo']);
                }
                foreach($productos as $d){
                    if($tes == $d->getPassword()){
                        session_start();
                        $_SESSION['no_empleado']=$d->getNumero();




                        $idUsuario=1;
                        $consulta_idUsuario="SELECT MAX(user.id) AS 'id_usuario' FROM user";
                        $resultadoIdUsuario=$con->ejecutarSql($consulta_idUsuario);
                        $registroIdUsuario=$con->obtenerFila($resultadoIdUsuario);
                        if(strcmp($registroIdUsuario['id_usuario'],"")!=0){
							$idUsuario=$idUsuario+(int)$registroIdUsuario['id_usuario'];
						}
						$_SESSION['log_userId']=$idUsuario;
						$consultaUsuario="SELECT * FROM usuarios WHERE no_empleado='".$_SESSION['no_empleado']."'";
						$resultadoUsuario=$con->ejecutarSql($consultaUsuario);
						$registroUsuario=$con->obtenerFila($resultadoUsuario);
                        $_SESSION['usuario']=$registroUsuario['nombre'];
						$insertarLog="INSERT INTO user (id,auth_key,username,password_hash,email,created_at,updated_at) VALUES (".$idUsuario.",'auth_key".$idUsuario."','".utf8_encode($registroUsuario['nombre'])."','".$registroUsuario['password']."','".$registroUsuario['correo']."',DATE_FORMAT(CURDATE(), \"%Y%d%M\"),DATE_FORMAT(CURDATE(), \"%Y%d%M\"))";
						$resultadoLog=$con->ejecutarSql($insertarLog);
                        $insertarLogin="INSERT INTO logins (fecha,hora,id_user) VALUES (CURDATE(),NOW(),".$idUsuario.")";
                        $resultadoInsertarLogin=$con->ejecutarSql($insertarLogin);
						

                        if($d->getTipo() == 1){
                            $_SESSION['tipoUsuario']='Administrador';
                            header('Location:../Inicio administradores/inicio_administradores.php');
                        }elseif($d->getTipo() == 2){
                            $_SESSION['tipoUsuario']='Controlador';
                            header("Location: ../Area de controladores/area_controladores.php");
                        }elseif($d->getTipo() == 4){
                            $_SESSION['tipoUsuario']='R.R.H.H.';
                            header("Location: ../Area de RRHH/area_rrhh.php");
                        }elseif($d->getTipo() == 3){
                            $_SESSION['tipoUsuario']='Supervisor';
                            header("Location: ../Area de supervisores/area_supervisores.php");
                        }
                    }else{
                        echo "Numero de empleado o contrasenia incorrectos";
                        return $productos;
                    }
                }
                
                return $productos;
            
            }else 
                
                return null;
        }

        public function ObtenerPorId2($a, $b){
            $tes = encrypt_decrypt("encrypt",$b);

            $sql = "select * from usuarios where no_empleado = :a and password = :te";
            $stmt = self::$PDO->prepare($sql);
            
            $stmt->bindParam(':a', $a, PDO::PARAM_STR, 10);
            $stmt->bindParam(':te', $tes, PDO::PARAM_STR, 150);
            
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $result = $stmt->fetch();
            
            if(!is_null($result)){
                $productos = new Login($result['no_empleado'], 
                                            $result['idTipoUsuario'],
                                            $result['nombre'], 
                                            $result['password'], 
                                            $result['correo']);
                while($result = $stmt->fetch()){
                    $productos = new Login($result['no_empleado'], 
                                                $result['idTipoUsuario'],
                                                $result['nombre'], 
                                                $result['password'], 
                                                $result['correo']);
                }
                echo "Hola";
                foreach($productos as $c){
                    echo $c['no_empleado'];
                    echo $c->getTipo();
                    echo $c->getNombre();
                    echo $c->getPassword();
                    echo $c->getCorreo();
                }
                return $productos;
                }else 
                echo "Adios";
                return null;
        }

        public function Eliminar($key){
            $sql = "delete from productos where (idProducto=:key)";
            $stmt = self::$PDO->prepare($sql);
            //$stmt->execute();
            if($stmt->execute(array(':key' => $key))) {
                echo 'Se Elimino el registro: '.$key;
            }
        }

        public function Insertar($datos){
            $id = $datos->getIdentidad();
            $nom = $datos->getNombre();
            $des = $datos->getDescripcion();
            $can = $datos->getCantidad();

            $stmt = self::$PDO->prepare("insert into productos value(:identidad, :nombre, :descripcion, :cantidad)");
            $stmt->bindParam(':identidad', $id, PDO::PARAM_STR, 450);
            $stmt->bindParam(':nombre', $nom, PDO::PARAM_STR, 45);
            $stmt->bindParam(':descripcion', $des, PDO::PARAM_STR, 45);
            $stmt->bindParam(':cantidad', $can, PDO::PARAM_STR, 450);

            if ($stmt->execute())
                return true;
            else
                return false;
        }

        public function Actualizar($datos){
            //
        }

        public function ObtenerTodos(){
            $stmt = self::$PDO->prepare("select * from productos");
            $stmt->execute();
            
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();

            if(!is_null($result)){
                $productos[] = new Producto($result['idProducto'], 
                                            $result['nombre'],
                                            $result['descripcion'], 
                                            $result['cantidad']);
                while($result = $stmt->fetch()){
                    $productos[] = new Producto($result['idProducto'], 
                                                $result['nombre'],
                                                $result['descripcion'], 
                                                $result['cantidad']);
                }
                return $productos;
            
            }else 
                return null;
            
        }
    }
?>