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

    case "requisitosadmin":
        //obtenemos la lista de requisitos de determinada beca
        $beca_id = $_REQUEST['beca_id'];
        $us_cedula = $_REQUEST['us_cedula'];

        $requisitos = $requisitoModel->getRequisitos($beca_id);
        $postulante = $postulanteModel->getPostulante($us_cedula, $beca_id);
        //guardamos en sesion la lista
        $_SESSION['requisitos'] = serialize($requisitos);
        $_SESSION['postulante'] = serialize($postulante);
        //redireccionamos
        header('Location: ../view/requisitoAdministrador.php');
        break;

    case "aprobar":
        $postulante_id = $_REQUEST['postulante_id'];
        $requisito_id = $_REQUEST['requisito_id'];

        $requisitoPostulante = $requisitoPostulanteModel->Aprobar($postulante_id, $requisito_id);
        $_SESSION['mensaje'] = "Requisito Aprobado";
        header('Location: ../view/requisitoAdministrador.php');
        break;

    case "rechazar":
        $postulante_id = $_REQUEST['postulante_id'];
        $requisito_id = $_REQUEST['requisito_id'];
        $observacion = $_REQUEST['observacion'];

        $requisitoPostulante = $requisitoPostulanteModel->Rechazar($postulante_id, $requisito_id, $observacion);
        $_SESSION['mensaje'] = "Requisito Rechazado";
        header('Location: ../view/requisitoAdministrador.php');
        break;

    case "requisitoaprobar":
        $postulante_id = $_REQUEST['postulante_id'];
        $beca_id = $_REQUEST['beca_id'];
        $bandera = true;
        $requisitos = $requisitoModel->getRequisitos($beca_id);
        foreach ($requisitos as $requisito) {
            $requisitoPostulantedata = $requisitoPostulanteModel->getRequisitoPostulante($postulante_id, $requisito->getRe_id());
            if ($requisitoPostulantedata->getRp_estado() == 5) {
                $bandera = false;
            }
        }
        if ($bandera) {
            $requisitoPostulante = $postulanteModel->Aprobar($postulante_id);
            $postulantes = $postulanteModel->getPostulacionesAll();
            $_SESSION['postulantes'] = serialize($postulantes);
            $_SESSION['mensaje'] = "Beca Aprobada";
            header('Location: ../view/administrador.php');
        } else {
            $_SESSION['mensaje'] = "Existen Requisitos sin Revisar.";
            header('Location: ../view/administrador.php');
        }

        break;

    case "requisitorechazar":
        $postulante_id = $_REQUEST['postulante_id'];
        $beca_id = $_REQUEST['beca_id'];
        $bandera = true;
        $requisitos = $requisitoModel->getRequisitos($beca_id);
        foreach ($requisitos as $requisito) {
            $requisitoPostulantedata = $requisitoPostulanteModel->getRequisitoPostulante($postulante_id, $requisito->getRe_id());
            if ($requisitoPostulantedata->getRp_estado() == 5) {
                $bandera = false;
            }
        }
        if ($bandera) {
            $requisitoPostulante = $postulanteModel->Rechazar($postulante_id);
            $postulantes = $postulanteModel->getPostulacionesAll();
            $_SESSION['postulantes'] = serialize($postulantes);
            $_SESSION['mensaje'] = "Beca Rechazada";
            header('Location: ../view/administrador.php');
        } else {
            $_SESSION['mensaje'] = "Existen Requisitos sin Revisar.";
            header('Location: ../view/administrador.php');
        }

        break;

    default:
        //si no existe la opcion recibida por el controlador, siempre redirigimos la navegacion a la pagina main:
        header('Location: ../index.php');
}
