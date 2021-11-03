<?php
require_once("conexion.php");

class ProveedorPedidoModel extends Conexion
{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($proveedor_id, $total)
        {
            $sql="INSERT INTO proveedor_pedidos(proveedor_id, total) VALUES(?,?)";
            $params=array($proveedor_id, $total);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function insertDetail($producto_id, $proveedor_pedido_id,$cantidad, $precio){
            $sql="INSERT INTO proveedor_pedido_detalles(producto_id, proveedor_pedido_id, cantidad, precio) VALUES(?,?,?,?)";
            $params=array($producto_id, $proveedor_pedido_id, $cantidad, $precio);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function getPedidos()
        {
            $sql="SELECT * FROM proveedor_pedidos ORDER BY creado DESC";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getPedido($id)
        {
            $sql="SELECT * FROM proveedor_pedidos WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function getPedidoDetalle($id){
            $sql="SELECT * FROM proveedor_pedido_detalles WHERE pedido_id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

}


?>