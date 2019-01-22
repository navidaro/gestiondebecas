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

    case "becas":
        $listado = $becaModel->getBecas();
        $_SESSION['becas'] = serialize($listado);
        header('Location: ../view/crudBeca.php');
        break;

    case "requisitos":
        $beca_id = $_REQUEST['beca_id'];
        $_SESSION['idbecareq'] = $beca_id;
        $listado = $requisitoModel->getRequisitos($beca_id);
        $_SESSION['requisitos'] = serialize($listado);
        header('Location: ../view/crudRequisito.php');
        break;

    case "crear":
        $be_nombre = $_REQUEST['nombre'];
        $be_monto = $_REQUEST['monto'];
        $be_descripcion = $_REQUEST['descripcion'];
        $be_promedio = $_REQUEST['promedio'];
        $becaModel->insertarBeca($be_monto, $be_promedio, $be_nombre, $be_descripcion);
        $listado = $becaModel->getBecas();
        $_SESSION['becas'] = serialize($listado);
        $_SESSION['mensaje'] = "Beca Creada.";
        header('Location: ../view/crudBeca.php');
        break;

    case "editar":
        $beca_id = $_REQUEST['beca_id'];
        $beca = $becaModel->getBeca($beca_id);
        $_SESSION['becaeditar'] = serialize($beca);
        header('Location: ../view/editBeca.php');
        break;

    case "actualizar":
        $be_id = $_REQUEST['be_id'];
        $be_nombre = $_REQUEST['nombre'];
        $be_monto = $_REQUEST['monto'];
        $be_descripcion = $_REQUEST['descripcion'];
        $be_promedio = $_REQUEST['promedio'];
        $becaModel->actualizarBeca($be_id, $be_monto, $be_promedio, $be_nombre, $be_descripcion);
        $listado = $becaModel->getBecas();
        $_SESSION['becas'] = serialize($listado);
        $_SESSION['mensaje'] = "Beca Actualizada.";
        header('Location: ../view/crudBeca.php');
        break;

    case "eliminar":
        $be_id = $_REQUEST['beca_id'];
        $becaModel->eliminarBeca($be_id);
        $listado = $becaModel->getBecas();
        $_SESSION['becas'] = serialize($listado);
        $_SESSION['mensaje'] = "Beca Eliminada.";
        header('Location: ../view/crudBeca.php');
        break;

    default:
        //si no existe la opcion recibida por el controlador, siempre redirigimos la navegacion a la pagina main:
        header('Location: ../index.php');
}