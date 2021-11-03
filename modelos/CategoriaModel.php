<?php
require_once("conexion.php");

class CategoriaModel extends Conexion
{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($nombre)
        {
            $sql="INSERT INTO categorias(nombre) VALUES(?)";
            $insert=$this->conexion->prepare($sql);
            $params=array($nombre);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function getCategorias()
        {
            $sql="SELECT * FROM categorias";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getCategoria($id)
        {
            $sql="SELECT * FROM categorias WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function update(int $id, $nombre)
        {
            $sql="UPDATE categorias SET nombre=? WHERE id=?";
            $update=$this->conexion->prepare($sql);
            $params=array($nombre, $id);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }
    
        public function delete(int $id)
        {
            $sql="DELETE FROM categorias WHERE id=?";
            $delete=$this->conexion->prepare($sql);
            $params=array($id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }
}


?>