<?php

/*
 * @author TROLL
 */
include_once 'Database.php';
 include_once '../Entity/Login.php';

class LoginModel {

    public function ingresar($username, $password) {
        //obtenemos la informacion de la base de datos
        $pdo = Database::connect();
        $sql = "select * from usuarios where us_cedula=? and us_contrasenia=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($username, $password));
        //comprobacion de existencia
        $listado = array();
        foreach ($consulta as $res) {
            $Login = new Login($res['us_cedula'], $res['us_contrasenia']);
            array_push($listado, $Login);
        }
        sleep(1);
        Database::disconnect();
        if (count($listado) == 1) {
            $log = true;
        } else {
            $log = false;
        }
        return $log;
    }

}
