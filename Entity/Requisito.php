<?php
/*
 * @author IvánDarío
 */
class Requisito {

    private $re_id;
    private $beca_id;
    private $re_nombre;
    private $re_descripcion;
    private $re_obligatorio;
    private $re_vigencia;
    
    function __construct($re_id, $beca_id, $re_nombre, $re_descripcion, $re_obligatorio, $re_vigencia) {
        $this->re_id = $re_id;
        $this->beca_id = $beca_id;
        $this->re_nombre = $re_nombre;
        $this->re_descripcion = $re_descripcion;
        $this->re_obligatorio = $re_obligatorio;
        $this->re_vigencia = $re_vigencia;
    }

    function getRe_id() {
        return $this->re_id;
    }

    function getBeca_id() {
        return $this->beca_id;
    }

    function getRe_nombre() {
        return $this->re_nombre;
    }

    function getRe_descripcion() {
        return $this->re_descripcion;
    }

    function getRe_obligatorio() {
        return $this->re_obligatorio;
    }

    function getRe_vigencia() {
        return $this->re_vigencia;
    }

    function setRe_id($re_id) {
        $this->re_id = $re_id;
    }

    function setBeca_id($beca_id) {
        $this->beca_id = $beca_id;
    }

    function setRe_nombre($re_nombre) {
        $this->re_nombre = $re_nombre;
    }

    function setRe_descripcion($re_descripcion) {
        $this->re_descripcion = $re_descripcion;
    }

    function setRe_obligatorio($re_obligatorio) {
        $this->re_obligatorio = $re_obligatorio;
    }

    function setRe_vigencia($re_vigencia) {
        $this->re_vigencia = $re_vigencia;
    }

}
