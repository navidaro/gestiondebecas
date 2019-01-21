<?php

session_start();
include_once '../model/requisitoPostulanteModel.php';
$requisitoPostulanteModel = new RequisitoPostulanteModel();
$opcion = $_REQUEST['opcion'];

switch ($opcion) {

    case "upload":

        $postulante_id = $_REQUEST['postulante_id'];
        $requisito_id = $_REQUEST['requisito_id'];

        //print_r($_FILES['archivo']);
        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            $name = $_FILES['archivo']['name'];
            $data = file_get_contents($_FILES['archivo']['tmp_name']);
            $b64Doc = chunk_split(base64_encode($data));
            $requisitoPostulanteModel->insertRequisitoPostulanteFile($postulante_id, $requisito_id, $b64Doc, $name);
            header('Location: ../view/requisitoPostulante.php');
        } else {
            header('Content-Type: application/octet-stream;');
        }
        break;

    case "download":
        $postulante_id = $_REQUEST['postulante_id'];
        $requisito_id = $_REQUEST['requisito_id'];
        // Fecha Actual
        $toDay = date("Y-m-d");
        // Dar nombre aleatorio al archivo
        $name = "archive_" . $toDay . "_XXXXX_.pdf";
        // Se crea una ruta en este caso la carpeta temporal (tmp)
        $rute = "../tmp/" . $name;
        $requisitoPostulante = $requisitoPostulanteModel->getRequisitoPostulante($postulante_id, $requisito_id);
        // Decodificar base64
        $pdf_b64 = base64_decode($requisitoPostulante->getRp_archivo());
        // you record the file in existing folder
        if (file_put_contents($rute, $pdf_b64)) {
            //just to force download by the browser
            //header("Content-type: application/pdf");
            header('Content-Disposition: attachment; filename="' . $requisitoPostulante->getRp_archivo_nombre() . '"');
            //print base64 decoded
            echo $pdf_b64;
        }
        break;

    case "open":
        $postulante_id = $_REQUEST['postulante_id'];
        $requisito_id = $_REQUEST['requisito_id'];
        // Fecha Actual
        $toDay = date("Y-m-d");
        // Dar nombre aleatorio al archivo
        $name = "archive_" . $toDay . "_XXXXX_.pdf";
        // Se crea una ruta en este caso la carpeta temporal (tmp)
        $rute = "../tmp/" . $name;
        $requisitoPostulante = $requisitoPostulanteModel->getRequisitoPostulante($postulante_id, $requisito_id);
        // Decodificar base64
        $pdf_b64 = base64_decode($requisitoPostulante->getRp_archivo());
        // you record the file in existing folder
        if (file_put_contents($rute, $pdf_b64)) {
            //just to force download by the browser
            header('Content-type: application/pdf');
            //print base64 decoded
            echo $pdf_b64;
        }
        break;

    case "eliminar":
        $postulante_id = $_REQUEST['postulante_id'];
        $requisito_id = $_REQUEST['requisito_id'];
        print_r($postulante_id);
        print_r($requisito_id);
        $requisitoPostulanteModel->eliminarArchivoRequisitoPostulante($postulante_id, $requisito_id);
        $_SESSION['mensaje'] = "Archivo Eliminado!";
        header('Location: ../view/requisitoPostulante.php');
        break;

    default:
        //si no existe la opcion recibida por el controlador, siempre redirigimos la navegacion a la pagina main:
        header('Location: ../index.php');
}
