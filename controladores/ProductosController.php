<?php
require_once("../../Modelos/ProductosModel.php");


class ProductosController
{
    private $ObjProductosModel;

    public function __construct()
    {
        $this->ObjProductosModel=new ProductosModel();
    }

    public function InsertarProducto()
    {      
        //Verificamos si el formulario fue enviado para recibir los datos y la imagen
        if (isset($_REQUEST['subir']))
        {
            $NombreProd=$_REQUEST['NombreProd'];
            $Existencias=$_REQUEST['Existencias'];
            $PrecioVenta=$_REQUEST['PrecioVenta'];
            $CategoriaPrincipal=$_REQUEST['Categoria'];
            $SubCategoria=$_REQUEST['SubCategoria'];
            //Recogemos el archivo enviado por el formulario
            $archivo = $_FILES['FotoProd']['name'];
            //Si el archivo contiene algo y es diferente de vacio
            if (isset($archivo) && $archivo != "") 
            {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo = $_FILES['FotoProd']['type'];
                $tamano = $_FILES['FotoProd']['size'];
                $temp = $_FILES['FotoProd']['tmp_name'];
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2097152))) 
                {
                    echo '<div><b>Error. La extensión o el tamaño del archivo no es correcta.<br/>
                    - Se permiten archivos .gif, .jpg, .png. y de 2 MB como máximo.</b></div>';
                }
                else 
                {
                    //Si la imagen es correcta en tamaño y tipo se intenta subir al servidor pero con un nombre diferente para evitar conflictos
                    $nombreActual = pathinfo($archivo,PATHINFO_FILENAME); //obtenemos el nombre sin extension
                    $nombreOriginal = $nombreActual;
                    $extension = pathinfo($archivo, PATHINFO_EXTENSION); //obtenemos solo la extension
                    $archivo=$nombreOriginal.time().rand(0,99).'.'.$extension; //aqui le cambiamos nombre al archivo
                    //Se recomienda verificar si existe la carpeta destino primero y si no que la cree
                    $path = "../../Vistas/FotosProd";
                    if (!file_exists($path)) 
                    {
                        mkdir($path, 0777, true);
                    }
                    //Luego procedemos a mover el archivo de la carpeta temporal a la carpeta destino
                    if (move_uploaded_file($temp, '../../Vistas/FotosProd/'.$archivo)) 
                    {
                        //Cambiamos los permisos del archivo a 777 para poder modificar el archivo posteriormente
                        chmod('../../Vistas/FotosProd/'.$archivo, 0777);
                        //Mostramos el mensaje de que se ha subido con éxito
                        echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                        //Construimos la URL que guardaremos en la base de datos podemos guardar solo el nombre del archivo y luego recuperarlo o la url completa
                        //$URLImg="/Vistas/FotosProd/".$archivo;
                        $URLImg=$archivo;
                    }
                    else 
                    {
                        //Si no se ha podido subir la imagen, mostramos un error y regresamos
                        echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                    }
                }
            }
            else
            {
                $URLImg="FotoDefault.jpg";
            }

            //INSERTAR UN PRODUCTO NUEVO
            $insert=$this->ObjProductosModel->insertarProducto($NombreProd,$Existencias, $PrecioVenta, $CategoriaPrincipal, $SubCategoria, $URLImg);
            if ($insert!=null)
            {
                header('Location: ../../Vistas/Productos/RegistrarProducto.php?mensaje=Producto '.$NombreProd.' agregado con exito!');
            }
            else
            {
                header('Location: ../../Vistas/Productos/RegistrarProducto.php?mensaje=Hubo un error al agregar el producto intente de nuevo.');
            }
        }
        else
        {
            echo "no se ha enviado nada";
        }
    }

    public function AdministrarProductos()
    {
        $ListaProductos=$this->ObjProductosModel->VerTodosLosProductos();
        require_once("../../Vistas/Productos/GestionProductos.php");
    }

    public function Eliminar($id)
    {
        //Recuperar el nombre de la foto de la base de datos con el id del producto
        $DatosRecuperados=$this->ObjProductosModel->RecuperarProducto($id);
        //INSERTAR AQUI EL CODIGO PARA BORRAR LA FOTO DEL SERVIDOR
        if ($DatosRecuperados['URLImg']!="FotoDefault.jpg")
        {
            unlink("../../Vistas/FotosProd/".$DatosRecuperados['URLImg']); //borramos la imagen del producto del servidor
        }
        $resultado=$this->ObjProductosModel->eliminarProducto($id);
        if ($resultado)
        { 
            header('Location: ../../Controladores/Productos/ProductosController.php?Tipo=gestion');
        }
        else
        {
            echo "Hubo un error en la eliminacion del producto.";
        }
    }

    public function RecuperarProducto($id)
    {
        $DatosRecuperados=$this->ObjProductosModel->RecuperarProducto($id);
        require_once("../../Vistas/Productos/ModificarProducto.php");   
    }

    public function ActualizarProducto()
    {
        if (isset($_REQUEST['subir']))
        {
            $Id = $_REQUEST['Id'];
            $NombreProd = $_REQUEST['NombreProd'];
            $Existencias = $_REQUEST['Existencias'];
            $PrecioVenta= $_REQUEST['PrecioVenta'];
            $Categoria= $_REQUEST['Categoria'];
            $SubCategoria= $_REQUEST['SubCategoria'];
            $FotoAnterior= $_REQUEST['FotoAnterior'];
            //Recogemos el archivo enviado por el formulario
            $archivo = $_FILES['FotoProd']['name'];
            //Si el archivo contiene algo y es diferente de vacio
            if (isset($archivo) && $archivo != "") 
            {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo = $_FILES['FotoProd']['type'];
                $tamano = $_FILES['FotoProd']['size'];
                $temp = $_FILES['FotoProd']['tmp_name'];
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2097152))) 
                {
                    echo '<div><b>Error. La extensión o el tamaño del archivo no es correcta.<br/>
                    - Se permiten archivos .gif, .jpg, .png. y de 2 MB como máximo.</b></div>';
                }
                else 
                {
                    //Si la imagen es correcta en tamaño y tipo se intenta subir al servidor pero con un nombre diferente para evitar conflictos
                    $nombreActual = pathinfo($archivo,PATHINFO_FILENAME); //obtenemos el nombre sin extension
                    $nombreOriginal = $nombreActual;
                    $extension = pathinfo($archivo, PATHINFO_EXTENSION); //obtenemos solo la extension
                    $archivo=$nombreOriginal.time().rand(0,99).'.'.$extension; //aqui le cambiamos nombre al archivo
                    //Se recomienda verificar si existe la carpeta destino primero y si no que la cree
                    $path = "../../Vistas/FotosProd";
                    if (!file_exists($path)) 
                    {
                        mkdir($path, 0777, true);
                    }
                    //Luego procedemos a mover el archivo de la carpeta temporal a la carpeta destino
                    if (move_uploaded_file($temp, '../../Vistas/FotosProd/'.$archivo)) 
                    {
                        //Cambiamos los permisos del archivo a 777 para poder modificar el archivo posteriormente
                        chmod('../../Vistas/FotosProd/'.$archivo, 0777);
                        //Mostramos el mensaje de que se ha subido con éxito
                        echo '<div><b>Se ha actualizado correctamente la imagen.</b></div>';
                        //Construimos la URL que guardaremos en la base de datos podemos guardar solo el nombre del archivo y luego recuperarlo o la url completa
                        //$URLImg="/Vistas/FotosProd/".$archivo;
                        $URLImg=$archivo;
                        if ($FotoAnterior!="FotoDefault.jpg")
                        {
                            unlink("../../Vistas/FotosProd/".$FotoAnterior); //borramos la imagen del producto del servidor
                        }
                    }
                    else 
                    {
                        //Si no se ha podido subir la imagen, mostramos un error y regresamos
                        echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                    }
                }
            }
            else
            {
                $URLImg=$FotoAnterior;
            }

            //Modificar Usuario existente por un nuevo nombre de usuario
            $Update=$this->ObjProductosModel->actualizarProducto($Id, $NombreProd,$Existencias, $PrecioVenta, $Categoria, $SubCategoria, $URLImg);
            if ($Update==1)
            {
                header('Location: ../../Controladores/Productos/ProductosController.php?Tipo=Cargar&Id='.$Id.'&mensaje=Datos actualizados con exito! se actualizo correctamente el producto.');
            }
            else
            {
                header('Location: ../../Controladores/Productos/ProductosController.php?Tipo=Cargar&Id='.$Id.'&mensaje=Hubo un error al actualizar el producto o no ha modificado ningun dato, intente de nuevo.');
            }
        }
        else
        {
            echo "no se ha enviado nada";
        }
    }

}

$Tipo= $_REQUEST['Tipo'];
$ObjProductosController=new ProductosController();
switch ($_REQUEST['Tipo']) 
{
    case "agregar":
        $ObjProductosController->InsertarProducto();
        break;
    case "gestion":
        $ObjProductosController->AdministrarProductos();
        break;
    case "Eliminar":
        $ObjProductosController->Eliminar($_REQUEST['Id']);
        break;
    case "Cargar":
        $ObjProductosController->RecuperarProducto($_REQUEST['Id']);
        break;
    case "Actualizar":
        $ObjProductosController->ActualizarProducto();
        break;
    default:
        echo "Operación no válida";
} 
?>