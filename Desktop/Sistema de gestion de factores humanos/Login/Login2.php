<?php

    class Login{
        private $no_empleado;
        private $idTipoUsuario;
        private $nombre;
        private $password;
        private $correo;

        public function __construct($ne, $it, $no, $pa, $co){
            $this->no_empleado = $ne;
            $this->idTipoUsuario = $it;
            $this->nombre = $no;
            $this->password = $pa;
            $this->correo = $co;
        }

        public function getNumero(){
            return $this->no_empleado;
        }

        public function getTipo(){
            return $this->idTipoUsuario;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getCorreo(){
            return $this->correo;
        }


        public function setNumero($ne){
            $this->no_empleado = $ne;
        }

        public function setTipo($it){
            $this->idTipoUsuario = $it;
        }

        public function setNombre($no){
            $this->nombre = $no;
        }

        public function setPassword($pa){
            $this->password = $pa;
        }

        public function setCorreo($co){
            $this->correo = $co;
        }

    }
?>