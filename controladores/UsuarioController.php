<?php
require_once("../../Modelos/UsuarioModel.php");


class UsuarioController
{
    private $ObjUsuarioModel;

    public function __construct()
    {
        $this->ObjUsuarioModel=new UsuarioModel();
    }

    public function validar()
    {
        $Usuario = $_REQUEST['Usuario'];
        $Contra= $_REQUEST['Contra'];
        //Validar Usuario
        $ValidarUsuario=$this->ObjUsuarioModel->validarUsuario($Usuario, $Contra);
        
        if ($ValidarUsuario!=null)
        {
            session_start();
            $_SESSION["Id"]=$ValidarUsuario["IdUsuario"];
            $_SESSION["Usuario"]=$ValidarUsuario["Usuario"];
            $_SESSION["Rol"]=$ValidarUsuario["Rol"];
            $_SESSION["ImgUsuario"]=$ValidarUsuario["ImgUsuario"];
            $_SESSION["FechaRegistro"]=$ValidarUsuario["FechaRegistro"];
            
            switch ($_SESSION["Rol"]) 
            {
                case Admin:
                    header('Location: ../../Vistas/PrincipalAdmin.php');
                    break;
                case Vendedor:
                    header('Location: ../../Vistas/PrincipalVendedor.php');
                    break;
                case Bodeguero:
                    header('Location: ../../Vistas/PrincipalBodeguero.php');
                    break;
                case Cliente:
                    header('Location: ../../Vistas/PrincipalCliente.php');
                    break;
                default:
                    header('Location: ../../Vistas/Home.php');
            }  
        }
        else
        {
            header('Location: ../../Vistas/Usuario/Login.php?mensaje=Usuario o contraseña no válido, intente de nuevo');
        }
    }

    public function InsertarUsuario()
    {
        $Usuario = $_REQUEST['Usuario'];
        $Rol= $_REQUEST['Rol'];
        $Contra= $_REQUEST['Contra'];
        $Verificacion=$this->ObjUsuarioModel->VerificarExistencia($Usuario);

        if ($Verificacion!=null)
        {
            header('Location: ../../Vistas/Usuario/RegistrarUsuario.php?mensaje=El usuario '.$Usuario.' ya existe escriba uno diferente para continuar el registro');
        }
        else
        {
            //INSERTAR UN USUARIO NUEVO
            $insert=$this->ObjUsuarioModel->insertarUsuario($Usuario, $Contra, $Rol);
            if ($insert!=null)
            {
                header('Location: ../../Vistas/Usuario/RegistrarUsuario.php?mensaje=Usuario  '.$Usuario.' creado con exito!');
            }
            else
            {
                header('Location: ../../Vistas/Usuario/RegistrarUsuario.php?mensaje=Hubo un error al crear el usuario intente de nuevo.');
            }
        }  
    }

    public function VerUsuarios()
    {
        $ListaUsuarios=$this->ObjUsuarioModel->VerUsuarios();
        require_once("../../Vistas/Usuario/VerUsuarios.php");
    }

    public function Eliminar($id)
    {
        $resultado=$this->ObjUsuarioModel->eliminarUsuario($id);
        if ($resultado)
        {
            header('Location: ../../Controladores/Usuario/UsuarioController.php?Tipo=VerUsuarios');
        }
        else
        {
            echo "Hubo un error en la eliminacion del usuario.";
        }
    }

    public function RecuperarUsuario($id)
    {
        $DatosRecuperados=$this->ObjUsuarioModel->RecuperarUsuario($id);
        require_once("../../Vistas/Usuario/ModificarUsuario.php");
        
    }

    public function ActualizarUsuario()
    {
        $Id = $_REQUEST['Id'];
        $Usuario = $_REQUEST['Usuario'];
        $UsuarioAnterior = $_REQUEST['UsuarioAnterior'];
        $Rol= $_REQUEST['Rol'];
        $Contra= $_REQUEST['Contra'];
        $Verificacion=$this->ObjUsuarioModel->VerificarExistencia($Usuario);
        
        
        if ($Verificacion!=null)
        {
            if ($Usuario==$UsuarioAnterior)
            {
                //echo "Ya existe y es el original";
                //Modificar datos de Usuario existente manteniendo el mismo nombre de usuario.
                $Update=$this->ObjUsuarioModel->actualizarUsuario($Id, $Usuario, $Contra, $Rol);
                if ($Update==1)
                {
                    header('Location: ../../Controladores/Usuario/UsuarioController.php?Tipo=Cargar&Id='.$Id.'&mensaje=Datos actualizados con exito! para el usuario '.$Usuario.'');
                }
                else
                {
                    header('Location: ../../Controladores/Usuario/UsuarioController.php?Tipo=Cargar&Id='.$Id.'&mensaje=Hubo un error al actualizar el usuario o no ha modificado ningun dato, intente de nuevo.');
                }
            }
            else
            {
                //Detenemos la actualizacion cuando el usuario se quiere cambiar por otro existente
                header('Location: ../../Controladores/Usuario/UsuarioController.php?Tipo=Cargar&Id='.$Id.'&mensaje=El usuario '.$Usuario.' ya esta en uso en el sistema por otra persona, ingrese uno nuevo o deje el original.');
            }
        }
        else
        {
            //Modificar Usuario existente por un nuevo nombre de usuario
            $Update=$this->ObjUsuarioModel->actualizarUsuario($Id, $Usuario, $Contra, $Rol);
            if ($Update==1)
            {
                header('Location: ../../Controladores/Usuario/UsuarioController.php?Tipo=Cargar&Id='.$Id.'&mensaje=Datos actualizados con exito! se modificó el nombre de usuario '.$UsuarioAnterior.' por '.$Usuario.'');
            }
            else
            {
                header('Location: ../../Controladores/Usuario/UsuarioController.php?Tipo=Cargar&Id='.$Id.'&mensaje=Hubo un error al actualizar el usuario intente de nuevo.');
            }
        }
    }

}

$Tipo= $_REQUEST['Tipo'];
$ObjUsuarioController=new UsuarioController();
switch ($_REQUEST['Tipo']) 
{
    case "Login":
        $ObjUsuarioController->validar();
        break;
    case "Insertar":
        $ObjUsuarioController->InsertarUsuario();
        break;
    case "VerUsuarios":
        $ObjUsuarioController->VerUsuarios();
        break;
    case "Eliminar":
        $ObjUsuarioController->Eliminar($_REQUEST['Id']);
        break;
    case "Cargar":
        $ObjUsuarioController->RecuperarUsuario($_REQUEST['Id']);
        break;
    case "Actualizar":
        $ObjUsuarioController->ActualizarUsuario();
        break;
    default:
        echo "Operación no válida";
} 
?>