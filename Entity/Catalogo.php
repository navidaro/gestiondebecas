<?php
/*
 * @author IvánDarío
 */
class Catalogo {
    
    private $ca_id;
    private $tipocatalogo_id;
    private $ca_nombre;
    private $ca_descripcion;
    private $ca_vigencia;
    
    function __construct($ca_id, $tipocatalogo_id, $ca_nombre, $ca_descripcion, $ca_vigencia) {
        $this->ca_id = $ca_id;
        $this->tipocatalogo_id = $tipocatalogo_id;
        $this->ca_nombre = $ca_nombre;
        $this->ca_descripcion = $ca_descripcion;
        $this->ca_vigencia = $ca_vigencia;
    }
    
    function getCa_id() {
        return $this->ca_id;
    }

    function getTipocatalogo_id() {
        return $this->tipocatalogo_id;
    }

    function getCa_nombre() {
        return $this->ca_nombre;
    }

    function getCa_descripcion() {
        return $this->ca_descripcion;
    }

    function getCa_vigencia() {
        return $this->ca_vigencia;
    }

    function setCa_id($ca_id) {
        $this->ca_id = $ca_id;
    }

    function setTipocatalogo_id($tipocatalogo_id) {
        $this->tipocatalogo_id = $tipocatalogo_id;
    }

    function setCa_nombre($ca_nombre) {
        $this->ca_nombre = $ca_nombre;
    }

    function setCa_descripcion($ca_descripcion) {
        $this->ca_descripcion = $ca_descripcion;
    }

    function setCa_vigencia($ca_vigencia) {
        $this->ca_vigencia = $ca_vigencia;
    }

}
