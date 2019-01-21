<?php

include_once '../Entity/RequisitoPostulante.php';
include_once 'Database.php';

/**
 *
 * @author TROLL
 * 
 */
class requisitoPostulanteModel {

    public function insertRequisitoPostulanteFile($postulante_id, $requisito_id, $rp_archivo, $rp_archivonombre) {
        $pdo = Database::connect();
        $sql = "update re_postulantes set rp_archivo=?, rp_archivonombre=? where postulante_id=? and requisito_id=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($rp_archivo, $rp_archivonombre, $postulante_id, $requisito_id));
            $_SESSION['mensaje'] = "Archivo Guardado Correctamente.";
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

    //inserta los requisitos del postulante de todos los requisitos de la beca postulada
    public function insertRequisitoPostulanteList($postulante_id, $listado_requisitos) {
        $pdo = Database::connect();

        $sql = "insert into re_postulantes (rp_id, postulante_id, requisito_id, rp_aprobado, rp_archivo, rp_archivonombre, rp_vigencia, rp_estado) values(nextval('sq_rp_id'),?,?,?,?,?,?,?)";
        $consulta = $pdo->prepare($sql);
        try {

            foreach ($listado_requisitos as $req) {
                echo "ID " . $req->getRe_id();
                $consulta->execute(array($postulante_id, $req->getRe_id(), true, "", "", true, 5));
            }
            $_SESSION['mensaje'] = "Requisitos Postulante Guardados.";
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

    public function getRequisitoPostulante($postulante_id, $requisito_id) {
        //Se obtiene la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from re_postulantes where postulante_id=? and requisito_id=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($postulante_id, $requisito_id));
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $RequisitoPostulante = new RequisitoPostulante($res['rp_id'], $res['postulante_id'], $res['requisito_id'], $res['rp_aprobado'], $res["rp_archivo"], $res["rp_archivonombre"], $res["rp_estado"], $res["rp_vigencia"], $res["rp_observacion"]);
        //desconectamos la base de datos
        Database::disconnect();
        //retornamos los postulaciones encontradas
        return $RequisitoPostulante;
    }

    public function eliminarArchivoRequisitoPostulante($postulante_id, $requisito_id) {
        $pdo = Database::connect();
        $sql = "update re_postulantes set rp_archivo='', rp_archivonombre='' where postulante_id=? and requisito_id=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($postulante_id, $requisito_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

    public function Aprobar($postulante_id, $requisito_id) {
        $pdo = Database::connect();
        $sql = "update re_postulantes set rp_aprobado=true, rp_estado=7 where postulante_id=? and requisito_id=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($postulante_id, $requisito_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }
    
     public function Rechazar($postulante_id, $requisito_id, $observacion) {
        $pdo = Database::connect();
        $sql = "update re_postulantes set rp_aprobado=false, rp_estado=6, rp_observacion=? where postulante_id=? and requisito_id=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($observacion, $postulante_id, $requisito_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

}
