<?php
require_once("conexion.php");

class CarritoModel extends Conexion
{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($usuario_id)
        {
            $sql="INSERT INTO carritos(usuario_id) VALUES(?)";
            $params=array($usuario_id);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function insertDetail($producto_id, $carrito_id, $cantidad){
            $sql="INSERT INTO carrito_detalles(producto_id, carrito_id, cantidad) VALUES(?,?,?)";
            $params=array($producto_id, $carrito_id, $cantidad);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($carritoDetalle);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function getcarritos()
        {
            $sql="SELECT * FROM carritos ORDER BY creado DESC";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getcarrito($id)
        {
            $sql="SELECT * FROM carritos WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function getcarritoDetalle($id){
            $sql="SELECT * FROM carrito_detalles WHERE carrito_id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function updateDetalle(int $id, int $producto_id, int $cantidad)
        {
            $sql="UPDATE carrito_detalles SET cantidad=? WHERE pedido_id = ? AND producto_id=?";
            $update=$this->conexion->prepare($sql);
            $params=array($usuario, $id);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }

        public function deleteDetalle(int $id, $producto_id)
        {
            $sql="DELETE FROM carrito_detalles WHERE pedido_id = ? AND producto_id=?";
            $$delete=$this->conexion->prepare($sql);
            $params=array($id, $producto_id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }

}


?>