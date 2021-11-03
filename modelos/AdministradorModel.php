<?php
require_once("conexion.php");

class AdministradorModel extends Conexion{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($email, $password, $nombre, $apellido, $rol_id){
            $sql="INSERT INTO Admistradores(nombre, apellido, email, password, rol_id) VALUES(?,?,?,?,?)";
            $params=array($email, $password, $nombre, $apellido, $rol_id);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($usuario);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function login(string $email, string $password){
            $sql="SELECT * FROM Admistradores WHERE email=? AND password=?";
            $params=array($email,$password);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function getAdmistradores(){
            $sql="SELECT * FROM Admistradores ORDER BY id ASC";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getAdministrador($id){
            $sql="SELECT * FROM Admistradores WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function update(int $id, $nombre, $apellido, $rol_id){
            $this->Rol=$rol;
            $sql="UPDATE Admistradores SET nombre=?, apellido=?, rol_id=? WHERE id=?";
            $params=array( $nombre, $apellido, $rol_id, $id);
            $update=$this->conexion->prepare($sql);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }
    
        public function updatePassword(int $id, $password){
            $sql="UPDATE administradores SET password=? WHERE id=?";
            $update=$this->conexion->prepare($sql);
            $params=array($password, $id);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }

        public function delete(int $id)
        {
            $sql="DELETE FROM Admistradores  WHERE id=?";
            $delete=$this->conexion->prepare($sql);
            $params=array($id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }
}


?>