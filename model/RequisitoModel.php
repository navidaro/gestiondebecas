<?php

include_once 'Database.php';
include_once '../Entity/Requisito.php';
include_once '../Entity/RequisitoPostulante.php';

class RequisitoModel {

    public function getRequisitos($beca_id) {
        //Se obtiene la informacion de la base de datos
        $pdo = Database::connect();
        $sql = "select * from requisitos where beca_id=? and re_vigencia=true";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($beca_id));
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        //transformacion los registros en objetos
        $listado = array();
        if (count($resultado) > 0) {
            foreach ($resultado as $res) {
                $requisito = new Requisito($res['re_id'], $res['beca_id'], $res['re_nombre'], $res['re_descripcion'], $res["re_obligatorio"], $res["re_vigencia"]);
                array_push($listado, $requisito);
            }
        }
        //desconectamos la base de datos
        Database::disconnect();
        //retornamos los requisitos encontrados
        return $listado;
    }

    public function getRequisito($re_id) {
        //Se obtiene la informacion de la base de datos
        $pdo = Database::connect();
        $sql = "select * from requisitos where re_id=? and re_vigencia=true";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($re_id));
        //obtenemos la beca especifica
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $requisito = new Requisito($res['re_id'], $res['beca_id'], $res['re_nombre'], $res['re_descripcion'], $res["re_obligatorio"], $res["re_vigencia"]);
        //desconectamos la base de datos
        Database::disconnect();
        //retornamos los requisitos encontrados
        return $requisito;
    }

    public function getRequisitosPostulante($requisito_id, $postulante_id) {

        //Se obtiene la informacion de la base de datos
        $pdo = Database::connect();
        $sql = "select * from re_postulantes where requisito_id=? and postulante_id=? and rp_vigencia=true";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($requisito_id, $postulante_id));
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $requisitoPostulante = new RequisitoPostulante($res['rp_id'], $res['postulante_id'], $res['requisito_id'], $res['rp_aprobado'], $res["rp_archivo"], $res["rp_archivonombre"], $res["rp_estado"], $res["rp_observacion"], $res["rp_vigencia"]);
        //desconectamos la base de datos
        Database::disconnect();
        //retornamos los requisitos del postulante encontrados
        return $requisitoPostulante;
    }

    public function insertarRequisito($beca_id, $re_nombre, $re_descripcion, $re_obligatorio) {
        $pdo = Database::connect();
        $sql = "insert into requisitos (re_id,beca_id,re_nombre,re_descripcion,re_obligatorio,re_vigencia) values(nextval('sq_re_id'),?,?,?,?,?)";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros
        try {
            $consulta->execute(array($beca_id, $re_nombre, $re_descripcion, $re_obligatorio, true));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }

    public function eliminarRequisito($re_id) {
        //Preparamos la conexion a la bdd
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update requisitos set re_vigencia=false where re_id=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros
        $consulta->execute(array($re_id));
        Database::disconnect();
    }

    public function actualizarRequisito($re_id, $beca_id, $re_nombre, $re_descripcion, $re_obligatorio) {
        $pdo = Database::connect();
        $sql = "update requisitos set beca_id=?,re_nombre=?,re_descripcion=?,re_obligatorio=? where re_id=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros
        try {
            $consulta->execute(array($beca_id, $re_nombre, $re_descripcion, $re_obligatorio, $re_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }

}
