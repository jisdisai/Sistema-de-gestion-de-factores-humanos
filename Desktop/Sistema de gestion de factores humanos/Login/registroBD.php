<?php

    class registroBD{
        public static $PDO;

        function __construct(){
            try{
                self::$PDO = new PDO('mysql:host=localhost; dbname=cocesna', 'root', '');
            }catch(Exception $ex){
                throw new Exception('Error');
            }        
        }
    }
?>