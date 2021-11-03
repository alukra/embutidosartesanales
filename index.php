<?php

    require_once("controladores/ShopController.php");

    $ShopController = new ShopController();
    
    //Rutas de aplicacion

    if(isset($_REQUEST['page'])){
        
        switch($_REQUEST['page']){
            case 'index': $ShopController->index(); break;
            case 'producto': $ShopController->producto($_REQUEST['producto']); break;
            case 'categorias': $ShopController->categoria(); break;
            case 'producto_categoria': $ShopController->producto_categoria(); break; 
            default : $ShopController->index(); break;
        }
    }else{
        $ShopController->index();
    }
?>