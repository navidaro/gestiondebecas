<?php

require_once '../Entity/Usuario.php';
require_once '../Entity/Requisito.php';
require_once '../model/PostulanteModel.php';
require_once '../model/RequisitoModel.php';
require_once '../model/requisitoPostulanteModel.php';

session_start();
$postulanteModel = new PostulanteModel();
$requisitoModel = new RequisitoModel();
$requisitoPostulanteModel = new requisitoPostulanteModel();
//recibimos la opcion desde la vista:
$opcion = $_REQUEST['opcion'];
unset($_SESSION['mensaje']);
switch ($opcion) {

    case "insertarPostulacion":
        $beca_id = $_REQUEST['cod_beca'];
        $usuario = unserialize($_SESSION['userdata']);
        $us_cedula = $usuario->getUs_cedula();
        try {
            $postulante_id = $postulanteModel->insertarPostulacionGetId($beca_id, $us_cedula);
            $listado_requisitos = $requisitoModel->getRequisitos($beca_id);
            $requisitoPostulanteModel->insertRequisitoPostulanteList($postulante_id, $listado_requisitos);
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $_SESSION['mensaje'] = $mensaje;
        }
        //actualizamos lista de postulantes
        $postulaciones = $postulanteModel->getPostulaciones($us_cedula);
        $_SESSION['postulaciones'] = serialize($postulaciones);
        header('Location: ../view/postulante.php');
        break;

    case "eliminar":
        $cod_beca = $_REQUEST['beca_id'];
        $us_cedula = $_SESSION['user'];
        $postulanteModel->eliminarProstulacion($us_cedula, $cod_beca);
        //obtenemos la lista becas postuladas del mismo estudiante
        $postulaciones = $postulanteModel->getPostulaciones($us_cedula);
        $_SESSION['postulaciones'] = serialize($postulaciones);
        //redireccionamos a la pagina main para visualizar
        header('Location: ../view/postulante.php');
        break;

    case "requisitos":
        //obtenemos la lista de requisitos de determinada beca
        $beca_id = $_REQUEST['beca_id'];
        $us_cedula = $_SESSION['cedulauser'];

        $requisitos = $requisitoModel->getRequisitos($beca_id);
        $postulante = $postulanteModel->getPostulante($us_cedula, $beca_id);
        
        print_r($postulante);
        print_r($requisitos);
        //guardamos en sesion la lista
        $_SESSION['requisitos'] = serialize($requisitos);
        $_SESSION['postulante'] = serialize($postulante);
        //redireccionamos
        header('Location: ../view/requisitoPostulante.php');
        break;

    default:
        //si no existe la opcion recibida por el controlador, siempre redirigimos la navegacion a la pagina main:
        header('Location: ../index.php');
}
