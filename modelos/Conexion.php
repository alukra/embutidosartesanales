<?php

class Conexion
{
        private $host="localhost";
        private $user="root";
        private $pass="secreto";
        private $db="embutidosartesanales";
        private $conBD;

        public function __construct()
        {
            $cadenaConexion="mysql:host=".$this->host.";dbname=".$this->db.";charset=utf8";
            try
            {
                $this->conBD=new PDO($cadenaConexion,$this->user,$this->pass);
                $this->conBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Conexion Exitosa.";
            }
            catch(Exception $e)
            {
                $this->conBD="Error de conexión";
                echo "ERROR: ".$e->getMessage();
            }
        }

        public function getConexion()
        {
            return $this->conBD;
        }
}

?>