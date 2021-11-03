<?php
require_once("conexion.php");

class ProductoModel extends Conexion{
        private $conexion;

        public function __construct(){
            $this->conexion=new Conexion();
            $this->conexion=$this->conexion->getConexion();
        }

        public function insert($nombre, $sku, $precio, $stock, $activo, $categoria_id){
            
            $sql="INSERT INTO Productos(nombre, sku, precio, stock, activo, categoria_id) VALUES(?,?,?,?,?,?)";
            $insert=$this->conexion->prepare($sql);
            $params=array($nombre, $sku, $precio, $stock, $activo, $categoria_id);
            $ResultadoInsert=$insert->execute($params);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function getProductos(){
            $sql="SELECT * FROM Productos";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function getProductosCategoria($categoria_id){
            $sql="SELECT * FROM productos WHERE categoria_id=$categoria_id";
            $execute=$this->conexion->query($sql);
            $resultado=$execute->fetchall(PDO::FETCH_ASSOC);
            return $resultado;
        }

    
        public function getProducto($id){
            $sql="SELECT * FROM Productos WHERE id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        public function updateProducto($id, $nombre, $sku, $precio, $stock, $activo, $categoria_id){          
            $sql="UPDATE Productos SET nombre=?, sku=?, precio=?, stock=?, activo=?, categoria_id=? WHERE id=?";
            $update=$this->conexion->prepare($sql);
            $params=array($nombre, $sku, $precio, $stock, $activo, $categoria_id, $id);
            $update->execute($params);
            $resultadoUpdate = $update->rowCount();
            return $resultadoUpdate;
        }
    
        public function deleteProducto(int $id){
            $sql="DELETE FROM Productos WHERE id=?"; 
            $delete=$this->conexion->prepare($sql);
            $params=array($id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }

        public function insertImagenProducto($producto_id, $nombre, $path) {
            $sql="INSERT INTO Producto_imagenes(producto_id, nombre, path) VALUES(?,?,?)";
            $insert=$this->conexion->prepare($sql);
            $params=array($producto_id, $nombre, $path);
            $ResultadoInsert=$insert->execute($arregloParametros);
            $idInsert=$this->conexion->lastInsertID();
            return $idInsert;
        }

        public function deleteImagenProducto(int $id){
            $sql="DELETE FROM Producto_imagenes WHERE id=?"; 
            $delete=$this->conexion->prepare($sql);
            $params=array($id);
            $ResultadoDelete=$delete->execute($params);
            return $ResultadoDelete;
        }

        public function showImagenProducto($id) {
            $sql="SELECT * FROM Producto_imagenes WHERE product_id=?";
            $params=array($id);
            $query=$this->conexion->prepare($sql);
            $query->execute($params);
            $resultado=$query->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

}


?>