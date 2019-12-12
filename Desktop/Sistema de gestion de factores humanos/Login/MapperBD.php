<?php

    require_once 'registroBD.php';

    abstract class MapperBD extends registroBD{
        protected $selectStmt;
        protected $insertStmt;
        protected $deleteStmt;
        protected $updateStmt;
        protected $selectAllStmt;

        public abstract function ObtenerPorId($a, $b);
        public abstract function Eliminar($datos);
        public abstract function Insertar($datos);
        public abstract function Actualizar($datos);
        public abstract function ObtenerTodos();
    }
?>