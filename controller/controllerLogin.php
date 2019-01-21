<?php

require_once '../model/LoginModel.php';
require_once '../model/UsuarioModel.php';
require_once '../model/PostulanteModel.php';
require_once '../model/CatalogoModel.php';
require_once '../Entity/Catalogo.php';

session_start();
$loginModel = new loginModel();
$UsuarioModel = new UsuarioModel();
$postulanteModel = new postulanteModel();
$catalogoModel = new CatalogoModel();
//recibimos la opcion desde la vista:
$opcion = $_REQUEST['opcion'];
unset($_SESSION['mensaje']);

switch ($opcion) {
    case "Ingreso":
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $res = $loginModel->ingresar($user, $pass);
        $validate = $postulanteModel->validarCI($user);
        if ($validate < 0) {
            $_SESSION['mensaje'] = "La cédula ingresada es incorrecta";
            header('Location: ../index.php');
        } else {
            if ($user == "" || $pass == "") {
                $_SESSION['mensaje'] = "Ingrese los Campos Solicitados";
                header('Location: ../index.php');
            } else {
                if ($res) {
                    $_SESSION['mensaje'] = "Acceso Correcto";
                    $usuario = $UsuarioModel->getUsuario($user);
                    $_SESSION['userdata'] = serialize($usuario);
                    //se verifica el rol del usuario
                    $tipo_usuario = $catalogoModel->getCatalogo($usuario->getTipousuario_id());

                    if ($tipo_usuario->getCa_nombre() == "user") {
                        $postulaciones = $postulanteModel->getPostulaciones($user);
                        $_SESSION['postulaciones'] = serialize($postulaciones);
                        //Redireccion
                        header('Location: ../view/postulante.php');
                    } else {
                        $postulantes = $postulanteModel->getPostulacionesAll();
                        $_SESSION['postulantes'] = serialize($postulantes);
                        //Redireccion
                        header('Location: ../view/administrador.php');
                    }
                } else {
                    $_SESSION['mensaje'] = "Usuario o Contraseña Incorrectos";
                    header('Location: ../index.php');
                }
            }
        }
        break;

    case "salir":
        //Inicia una nueva sesión o reanuda la existente 
        session_start();
        //Destruye toda la información registrada de una sesión
        session_destroy();
        //Redirecciona a la página de login
        header('location: ../index.php');
        break;

    default :
        //si no existe la opcion recibida por el controlador, siempre redirigimos la navegacion a la pagina main:
        header('Location: ../index.php');
}

    