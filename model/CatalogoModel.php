<?php

include_once '../Entity/Catalogo.php';

class CatalogoModel {
   
    function getCatalogo($ca_id) {
        //obtenemos la informacion de la base de datos
        $pdo = Database::connect();
        $sql = "select * from catalogos where ca_id=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($ca_id));
        //obtenemos el catalogo especifico
        $res = $consulta->fetch(PDO::FETCH_ASSOC);
        $catalogo = new Catalogo($res['ca_id'], $res['tipocatalogo_id'], $res['ca_nombre'], $res['ca_descripcion'], $res['ca_vigencia']);
        Database::disconnect();
        //retornamos el catalogo encontrado
        return $catalogo;
    }
    
}
