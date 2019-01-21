<?php
/*
 * @author IvánDarío
 */
class Usuario {
    
    private $us_cedula;
    private $provincia_id;
    private $tipousuario_id;
    private $us_contrasenia;
    private $us_nombres;
    private $us_apellidos;
    private $us_telefono;
    private $us_fechanacimiento;
    private $us_vigencia;
    private $us_promedio;
   
    function __construct($us_cedula, $provincia_id, $tipousuario_id, $us_contrasenia, $us_nombres, $us_apellidos, $us_telefono, $us_fechanacimiento, $us_vigencia, $us_promedio) {
        $this->us_cedula = $us_cedula;
        $this->provincia_id = $provincia_id;
        $this->tipousuario_id = $tipousuario_id;
        $this->us_contrasenia = $us_contrasenia;
        $this->us_nombres = $us_nombres;
        $this->us_apellidos = $us_apellidos;
        $this->us_telefono = $us_telefono;
        $this->us_fechanacimiento = $us_fechanacimiento;
        $this->us_vigencia = $us_vigencia;
        $this->us_promedio = $us_promedio;
    }

    function getUs_cedula() {
        return $this->us_cedula;
    }

    function getProvincia_id() {
        return $this->provincia_id;
    }

    function getTipousuario_id() {
        return $this->tipousuario_id;
    }

    function getUs_contrasenia() {
        return $this->us_contrasenia;
    }

    function getUs_nombres() {
        return $this->us_nombres;
    }

    function getUs_apellidos() {
        return $this->us_apellidos;
    }

    function getUs_telefono() {
        return $this->us_telefono;
    }

    function getUs_fechanacimiento() {
        return $this->us_fechanacimiento;
    }

    function getUs_vigencia() {
        return $this->us_vigencia;
    }

    function getUs_promedio() {
        return $this->us_promedio;
    }

    function setUs_cedula($us_cedula) {
        $this->us_cedula = $us_cedula;
    }

    function setProvincia_id($provincia_id) {
        $this->provincia_id = $provincia_id;
    }

    function setTipousuario_id($tipousuario_id) {
        $this->tipousuario_id = $tipousuario_id;
    }

    function setUs_contrasenia($us_contrasenia) {
        $this->us_contrasenia = $us_contrasenia;
    }

    function setUs_nombres($us_nombres) {
        $this->us_nombres = $us_nombres;
    }

    function setUs_apellidos($us_apellidos) {
        $this->us_apellidos = $us_apellidos;
    }

    function setUs_telefono($us_telefono) {
        $this->us_telefono = $us_telefono;
    }

    function setUs_fechanacimiento($us_fechanacimiento) {
        $this->us_fechanacimiento = $us_fechanacimiento;
    }

    function setUs_vigencia($us_vigencia) {
        $this->us_vigencia = $us_vigencia;
    }

    function setUs_promedio($us_promedio) {
        $this->us_promedio = $us_promedio;
    }

}
