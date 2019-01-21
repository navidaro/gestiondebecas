<?php

include_once 'Database.php';
include_once '../Entity/Usuario.php';

class UsuarioModel {
  
    public function getUsuario($us_cedula) {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from usuarios where us_cedula=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($us_cedula));
        //obtenemos el usuario especifico:
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $usuario = new Usuario($res['us_cedula'], $res['provincia_id'], $res['tipousuario_id'], $res['us_contrasenia'], $res['us_nombres']
                , $res['us_apellidos'], $res['us_telefono'], $res['us_fechanacimiento'], $res['us_vigencia'], $res['us_promedio']);
        Database::disconnect();
        //retornamos el usuario encontrado:
        return $usuario;
    }
    
}
