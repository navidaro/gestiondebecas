<?php

require_once '../model/BecaModel.php';
require_once '../model/RequisitoModel.php';
session_start();
$becaModel = new becaModel();
$requisitoModel = new RequisitoModel();
//recibimos la opcion desde la vista:
$opcion = $_REQUEST['opcion'];
//unset($_SESSION['mensaje']);
switch ($opcion) {

    case "requisitos":
        $beca_id = $_REQUEST['beca_id'];
        $_SESSION['idbecareq'] = $beca_id;
        $listado = $requisitoModel->getRequisitos($beca_id);
        $_SESSION['requisitos'] = serialize($listado);
        header('Location: ../view/crudRequisito.php');
        break;

    case "gocrear";
        $be_id = $_SESSION['idbecareq'];
        $beca = $becaModel->getBeca($be_id);
        $_SESSION['becaname'] = $beca->getBe_nombre();
        header('Location: ../view/createRequisito.php');
        break;

    case "crear":
        $re_nombre = $_REQUEST['nombre'];
        $beca_id = $_SESSION['idbecareq'];
        $re_descripcion = $_REQUEST['descripcion'];
        $re_obligatorio = $_REQUEST['obligatorio'];
        $requisitoModel->insertarRequisito($beca_id, $re_nombre, $re_descripcion, $re_obligatorio);
        $listado = $requisitoModel->getRequisitos($beca_id);
        $_SESSION['requisitos'] = serialize($listado);
        $_SESSION['mensaje'] = "Requisito Creado.";
        header('Location: ../view/crudRequisito.php');
        break;

    case "editar":
        $re_id = $_REQUEST['re_id'];
        $requisito = $requisitoModel->getRequisito($re_id);
        $_SESSION['requisito'] = serialize($requisito);
        header('Location: ../view/editRequisito.php');
        break;

    case "actualizar":
        $re_id = $_REQUEST['re_id'];
        $beca_id = $_SESSION['idbecareq'];
        $re_nombre = $_REQUEST['nombre'];
        $re_oblligatorio = $_REQUEST['oblligatorio'];
        $re_descripcion = $_REQUEST['descripcion'];
        $requisitoModel->actualizarRequisito($re_id, $beca_id, $re_nombre, $re_descripcion, $re_obligatorio);
        $listado = $requisitoModel->getRequisitos($beca_id);
        $_SESSION['requisitos'] = serialize($listado);
        $_SESSION['mensaje'] = "Requisito Actualizado.";
        header('Location: ../view/crudRequisito.php');
        break;

    case "eliminar":
        $re_id = $_REQUEST['re_id'];
        $beca_id = $_SESSION['idbecareq'];
        $requisitoModel->eliminarRequisito($re_id);
        $listado = $requisitoModel->getRequisitos($beca_id);
        $_SESSION['requisitos'] = serialize($listado);
        $_SESSION['mensaje'] = "Requisito Eliminado.";
        header('Location: ../view/crudRequisito.php');
        break;

    default:
        //si no existe la opcion recibida por el controlador, siempre redirigimos la navegacion a la pagina main:
        header('Location: ../index.php');
}