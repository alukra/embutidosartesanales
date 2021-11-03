<?php
require_once("conexion.php");

class UsuarioModel extends Conexion
{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($nombre, $apellido, $email, $password, $direccion, $direccion_envio, $telefono)
        {
            $sql="INSERT INTO usuarios(nombre, apellido, email, password, direccion, direccion_envio, telefono) VALUES(?,?,?,?,?,?,?)";
            $params=array($nombre, $apellido, $email, $password, $direccion, $direccion_envio, $telefono);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function login(string $email, string $password)
        {
            $sql="SELECT * FROM usuarios WHERE email=? AND password=?";
            $params=array($email,$password);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function getUsuarios()
        {
            $sql="SELECT * FROM Usuarios ORDER BY id ASC";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getUsuario($id)
        {
            $sql="SELECT * FROM Usuarios WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function update(int $id, $nombre, $apellido, $direccion, $direccion_envio, $telefono)
        {
            $sql="UPDATE usuarios SET nombre=?, apellido=?, direccion=?, direccion_envio=?, telefono=? WHERE id=?";
            $update=$this->conexion->prepare($sql);
            $params=array($nombre, $apellido, $direccion, $direccion_envio, $telefono, $id);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }

        public function updatePassword(int $id, $password)
        {
            $sql="UPDATE usuarios SET password=? WHERE id=?";
            $update=$this->conexion->prepare($sql);
            $params=array($password, $id);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }
    
        public function delete(int $id)
        {
            $sql="DELETE FROM usuarios WHERE id=?";
            $delete=$this->conexion->prepare($sql);
            $params=array($id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }
}


?>