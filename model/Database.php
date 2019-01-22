<?php

class Database {

//Propiedades estaticas con la informacion de la conexion (DSN):
    private static $dbName = 'gestionbecas';
    private static $dbHost = '172.30.239.179';
    private static $dbUsername = 'postgres';
    private static $dbUserPassword = 'root';
//Propiedad para control de la conexion:
    private static $conexion = null;
    /**
     * No se permite instanciar esta clase, se utilizan sus elementos
     * de tipo estatico.
     */
    public function __construct() {
        exit('No se permite instanciar esta clase.');
    }

    /**
     * Metodo estatico que crea una conexion a la base de datos.
     * @return type
     */
    public static function connect() {
// Una sola conexion para toda la aplicacion (singleton):
        if (null == self::$conexion) {
            try {
//                self::$conexion = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::
//                        $dbName, self::$dbUsername, self::$dbUserPassword);
                self::$conexion = new PDO("pgsql:dbname=" . self::$dbName . ";" . "host=" . self::
                        $dbHost, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$conexion;
    }

    /**
     * Metodo estatico para desconexion de la bdd.
     */
    public static function disconnect() {
        self::$conexion = null;
    }
}
