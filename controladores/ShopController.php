<?php

    require_once("modelos/UsuarioModel.php");
    require_once("modelos/ProductoModel.php");
    require_once("modelos/CategoriaModel.php");

    class ShopController {

        private $Usuario;
        private $Producto;
        private $Categoria;

        public function __construct(){
            $this->Usuario = new UsuarioModel();
            $this->Producto = new ProductoModel();
            $this->Categoria = new CategoriaModel();
        }

        public function index(){
            $categorias = $this->Categoria->getCategorias();
            $productos =  $this->Producto->getProductos();
            include_once("view/index.php");
        }

        public function producto($id){
            $productos =  $this->Producto->getProducto($id);
            include_once("view/producto.php");
        }

        public function categorias(){

        }

        public function producto_categoria($id){

        }

    }

?>