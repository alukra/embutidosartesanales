<?php
require_once("conexion.php");

class PedidoModel extends Conexion
{
        private $conexion;

        public function __construct()
        {
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($usuario_id, $concepto, $nombre, $direccion_envio, $voucher, $total, $subtotal, $igv, $descuento, $metodo_pago)
        {
            $sql="INSERT INTO pedidos(usuario_id, concepto, nombre, direccion_envio, voucher, total, subtotal, igv, descuento, metodo_pago) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $params=array($usuario_id, $concepto, $nombre, $direccion_envio, $voucher, $total, $subtotal, $igv, $descuento, $metodo_pago);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function insertDetail($producto_id, $pedido_id, $sku, $cantidad, $precio){
            $sql="INSERT INTO pedido_detalles(producto_id, pedido_id, sku, cantidad, precio) VALUES(?,?,?,?,?)";
            $params=array($producto_id, $pedido_id, $sku, $cantidad, $precio);
            $insert=$this->conexion->prepare($sql);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function getPedidos()
        {
            $sql="SELECT * FROM pedidos ORDER BY creado DESC";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
        public function getPedido($id)
        {
            $sql="SELECT * FROM pedidos WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function getPedidoDetalle($id){
            $sql="SELECT * FROM pedido_detalles WHERE pedido_id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

}


?>