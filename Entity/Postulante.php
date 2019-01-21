<?php
/*
 * @author IvánDarío
 */
class Postulante {

    private $po_id;
    private $beca_id;
    private $us_cedula;
    private $po_fecha;
    private $po_descripcion;
    private $po_vigencia;
    private $po_estado;

    function __construct($po_id, $beca_id, $us_cedula, $po_fecha, $po_descripcion,  $po_estado, $po_vigencia) {
        $this->po_id = $po_id;
        $this->beca_id = $beca_id;
        $this->us_cedula = $us_cedula;
        $this->po_fecha = $po_fecha;
        $this->po_descripcion = $po_descripcion;
        $this->po_vigencia = $po_vigencia;
        $this->po_estado = $po_estado;
    }

    function getPo_id() {
        return $this->po_id;
    }

    function getBeca_id() {
        return $this->beca_id;
    }

    function getUs_cedula() {
        return $this->us_cedula;
    }

    function getPo_fecha() {
        return $this->po_fecha;
    }

    function getPo_descripcion() {
        return $this->po_descripcion;
    }

    function getPo_vigencia() {
        return $this->po_vigencia;
    }

    function getPo_estado() {
        return $this->po_estado;
    }

    function setPo_id($po_id) {
        $this->po_id = $po_id;
    }

    function setBeca_id($beca_id) {
        $this->beca_id = $beca_id;
    }

    function setUs_cedula($us_cedula) {
        $this->us_cedula = $us_cedula;
    }

    function setPo_fecha($po_fecha) {
        $this->po_fecha = $po_fecha;
    }

    function setPo_descripcion($po_descripcion) {
        $this->po_descripcion = $po_descripcion;
    }

    function setPo_vigencia($po_vigencia) {
        $this->po_vigencia = $po_vigencia;
    }

    function setPo_estado($po_estado) {
        $this->po_estado = $po_estado;
    }


}
