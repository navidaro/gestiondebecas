<?php

include_once 'Database.php';
include_once '../Entity/Beca.php';

class BecaModel {

    public function getBecas() {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from becas where be_vigencia=true";
        $resultado = $pdo->query($sql);
        //transformamos los registros en objetos de tipo Beca
        $listado = array();
        foreach ($resultado as $res) {
            $beca = new Beca($res['be_id'], $res['be_monto'], $res['be_promedio'], $res['be_nombre'], $res['be_descripcion'], $res['be_vigencia']);
            array_push($listado, $beca);
        }
        Database::disconnect();
        //retornamos el listado resultante
        return $listado;
    }

    public function eliminarPostulacion($cod_beca) {
        $aux = array();
        if (isset($_SESSION['becas_postuladas'])) {
            $listadoBecas = unserialize($_SESSION['becas_postuladas']);
        } else {
            $listadoBecas = array();
        }
        foreach ($listadoBecas as $res) {
            if ($res->getCod_beca() == $cod_beca) {
                
            } else {
                array_push($aux, $res);
            }
        }
        $_SESSION['becas_postuladas'] = serialize($aux);
    }

    public function getBeca($be_id) {
        //obtenemos la informacion de la base de datos
        $pdo = Database::connect();
        $sql = "select * from becas where be_id=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($be_id));
        //obtenemos la beca especifica
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $beca = new Beca($res['be_id'], $res['be_monto'], $res['be_promedio'], $res['be_nombre'], $res['be_descripcion'], $res['be_vigencia']);
        Database::disconnect();
        //retornamos la beca encontrada
        return $beca;
    }

    public function insertarBeca($be_monto, $be_promedio, $be_nombre, $be_descripcion) {
        $pdo = Database::connect();
        $sql = "insert into becas (be_id,be_monto,be_promedio,be_nombre,be_descripcion,be_vigencia) values(nextval('sq_be_id'),?,?,?,?,?)";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros:
        try {
            $consulta->execute(array($be_monto, $be_promedio, $be_nombre, $be_descripcion, true));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }

    public function eliminarBeca($be_id) {
        //Preparamos la conexion a la bdd:
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update becas set be_vigencia=false where be_id=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros
        $consulta->execute(array($be_id));
        Database::disconnect();
    }

    public function actualizarBeca($be_id, $be_monto, $be_promedio, $be_nombre, $be_descripcion) {
        $pdo = Database::connect();
        $sql = "update becas set be_monto=?,be_promedio=?,be_nombre=?,be_descripcion=? where be_id=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros
        try {
            $consulta->execute(array($be_monto, $be_promedio, $be_nombre, $be_descripcion, $be_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }

}
