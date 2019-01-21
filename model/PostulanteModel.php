<?php

include_once 'Database.php';
include_once '../Entity/Postulante.php';
include_once '../Entity/Beca.php';

/**
 *
 * @author IvánDarío
 */
class PostulanteModel {

    public function insertarPostulacion($cod_beca, $us_cedula) {
        $fechaActual = getdate();
        $d = $fechaActual['mday'];
        $m = $fechaActual['mon'];
        $y = $fechaActual['year'];

        $pdo = Database::connect();

        $postulaciones = $this->getPostulaciones($us_cedula);

        if ($cod_beca == 0) {
            throw new Exception("Seleccione una Beca por favor");
        }

        foreach ($postulaciones as $res) {
            if ($res->getBeca_id() == $cod_beca) {
                throw new Exception("La postulación a esta Beca está Registrada.");
            }
        }

        $sql = "insert into postulantes (po_id,beca_id,us_cedula,po_fecha, po_descripcion,  po_vigencia, po_estado) values(nextval('sq_po_id'),?,?,?,?,?,?)";
        $consulta = $pdo->prepare($sql);


        try {
            $consulta->execute(array($cod_beca, $us_cedula, "$d-$m-$y", "xxx", true, 3));
            $_SESSION['mensaje'] = "Postulación Realizada";
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

    public function insertarPostulacionGetId($cod_beca, $us_cedula) {
        $fechaActual = getdate();
        $d = $fechaActual['mday'];
        $m = $fechaActual['mon'];
        $y = $fechaActual['year'];

        $pdo = Database::connect();

        $postulaciones = $this->getPostulaciones($us_cedula);

        if ($cod_beca == 0) {
            throw new Exception("Seleccione una Beca por favor");
        }

        foreach ($postulaciones as $res) {
            if ($res->getBeca_id() == $cod_beca) {
                throw new Exception("La postulación a esta Beca está Registrada.");
            }
        }

        $sql = "insert into postulantes (po_id,beca_id,us_cedula,po_fecha, po_descripcion,  po_vigencia, po_estado) values(nextval('sq_po_id'),?,?,?,?,?,?)";
        $consulta = $pdo->prepare($sql);


        try {
            $consulta->execute(array($cod_beca, $us_cedula, "$d-$m-$y", "xxx", true, 3));
            $last_id = $pdo->lastInsertId();
            $_SESSION['mensaje'] = "Postulación Realizada";
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }

        return $last_id;
    }

    public function getPostulaciones($us_cedula) {
        //Se obtiene la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from postulantes where us_cedula=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($us_cedula));
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        //transformacion los registros en objetos
        $listado = array();
        if (count($resultado) > 0) {
            foreach ($resultado as $res) {
                $postulaciones = new Postulante($res['po_id'], $res['beca_id'], $res['us_cedula'], $res['po_fecha'], $res["po_descripcion"], $res["po_estado"], $res["po_vigencia"]);
                array_push($listado, $postulaciones);
            }
        }
        //desconectamos la base de datos
        Database::disconnect();
        //retornamos los postulaciones encontradas
        return $listado;
    }

    public function getPostulacionesAll() {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from postulantes";
        $resultado = $pdo->query($sql);
        //transformamos los registros en objetos Postulantes
        $listado = array();
        foreach ($resultado as $res) {
            $postulaciones = new Postulante($res['po_id'], $res['beca_id'], $res['us_cedula'], $res['po_fecha'], $res["po_descripcion"], $res["po_estado"], $res["po_vigencia"]);
            array_push($listado, $postulaciones);
        }
        Database::disconnect();
        //retornamos el listado resultante
        return $listado;
    }

    public function getPostulante($us_cedula, $beca_id) {
        //Se obtiene la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from postulantes where us_cedula=? and beca_id=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($us_cedula, $beca_id));
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $postulante = new Postulante($res['po_id'], $res['beca_id'], $res['us_cedula'], $res['po_fecha'], $res["po_descripcion"], $res["po_estado"], $res["po_vigencia"]);
        //desconectamos la base de datos
        Database::disconnect();
        //retornamos los postulaciones encontradas
        return $postulante;
    }

    public function eliminarProstulacion($us_cedula, $beca_id) {
        //Preparamos la conexion a la base de datos
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from postulantes where us_cedula=? and beca_id=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros
        $consulta->execute(array($us_cedula, $beca_id));
        Database::disconnect();
    }

    public function Aprobar($postulante_id) {
        $pdo = Database::connect();
        $sql = "update postulantes set po_aprobado=true, po_estado=4 where po_id=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($postulante_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

    public function Rechazar($postulante_id) {
        $pdo = Database::connect();
        $sql = "update postulantes set po_aprobado=false, po_estado=3 where po_id=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($postulante_id));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
    }

    function validarCI($strCedula) {
        if (is_null($strCedula) || empty($strCedula)) {//compruebo si que el numero enviado es vacio o null
            return -1;
        } else {//caso contrario siguir el proceso
            if (is_numeric($strCedula)) {
                $total_caracteres = strlen($strCedula); // se suma el total de caracteres
                if ($total_caracteres == 10) {//comprobar que tenga 10 digitos la cedula
                    $nro_region = substr($strCedula, 0, 2); //extraer los dos primeros caracteres de izq a der
                    if ($nro_region >= 1 && $nro_region <= 24) {// comprobar a que region pertenece esta cedula
                        $ult_digito = substr($strCedula, -1, 1); //extraer el ultimo digito de la cedula
                        //extraer los valores pares
                        $valor2 = substr($strCedula, 1, 1);
                        $valor4 = substr($strCedula, 3, 1);
                        $valor6 = substr($strCedula, 5, 1);
                        $valor8 = substr($strCedula, 7, 1);
                        $suma_pares = ($valor2 + $valor4 + $valor6 + $valor8);
                        //extraer los valores impares
                        $valor1 = substr($strCedula, 0, 1);
                        $valor1 = ($valor1 * 2);
                        if ($valor1 > 9) {
                            $valor1 = ($valor1 - 9);
                        } else {
                            
                        }
                        $valor3 = substr($strCedula, 2, 1);
                        $valor3 = ($valor3 * 2);
                        if ($valor3 > 9) {
                            $valor3 = ($valor3 - 9);
                        } else {
                            
                        }
                        $valor5 = substr($strCedula, 4, 1);
                        $valor5 = ($valor5 * 2);
                        if ($valor5 > 9) {
                            $valor5 = ($valor5 - 9);
                        } else {
                            
                        }
                        $valor7 = substr($strCedula, 6, 1);
                        $valor7 = ($valor7 * 2);
                        if ($valor7 > 9) {
                            $valor7 = ($valor7 - 9);
                        } else {
                            
                        }
                        $valor9 = substr($strCedula, 8, 1);
                        $valor9 = ($valor9 * 2);
                        if ($valor9 > 9) {
                            $valor9 = ($valor9 - 9);
                        } else {
                            
                        }

                        $suma_impares = ($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
                        $suma = ($suma_pares + $suma_impares);
                        $dis = substr($suma, 0, 1); //extraer el primer numero de la suma
                        $dis = (($dis + 1) * 10); //luego ese numero lo multiplicar x 10, consiguiendo asi la decena inmediata superior
                        $digito = ($dis - $suma);
                        if ($digito == 10) {
                            $digito = '0';
                        } else {
                            
                        }//si la suma resulta 10, el decimo digito es cero
                        if ($digito == $ult_digito) {//comparar los digitos final y ultimo
                            return 0;
                        } else {
                            return -1;
                        }
                    } else {
                        return -1;
                    }
                    return -1;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        }
    }

}
