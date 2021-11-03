<?php
require_once("conexion.php");

class ProveedorModel extends Conexion{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($nombre, $nombre_contacto, $telefono, $direccion, $email){
            $sql="INSERT INTO Proveedores(nombre, nombre_contacto, telefono, direccion, email) VALUES(?,?,?,?,?)";
            $params=array($nombre, $nombre_contacto, $telefono, $direccion, $email);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($usuario);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function getProveedores(){
            $sql="SELECT * FROM Proveedores ORDER BY id ASC";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getProveedor($id){
            $sql="SELECT * FROM Proveedores WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function update(int $id, $nombre, $nombre_contacto, $telefono, $direccion, $email){
            $this->Rol=$rol;
            $sql="UPDATE Proveedores SET nombre=?, nombre_contacto=?, telefono=?, direccion=?, email=? WHERE id=?";
            $params=array($nombre, $nombre_contacto, $telefono, $direccion, $email, $id);
            $update=$this->conexion->prepare($sql);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }

        public function delete(int $id)
        {
            $sql="DELETE FROM Proveedores  WHERE id=?";
            $delete=$this->conexion->prepare($sql);
            $params=array($id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }
}


?>