<?php
/*
 * @author IvánDarío
 */
class Beca {

    private $be_id;
    private $be_monto;
    private $be_promedio;
    private $be_nombre;
    private $be_descripcion;
    private $be_vigencia;

    function __construct($be_id, $be_monto, $be_promedio, $be_nombre, $be_descripcion, $be_vigencia) {
        $this->be_id = $be_id;
        $this->be_monto = $be_monto;
        $this->be_promedio = $be_promedio;
        $this->be_nombre = $be_nombre;
        $this->be_descripcion = $be_descripcion;
        $this->be_vigencia = $be_vigencia;
    }

    function getBe_id() {
        return $this->be_id;
    }

    function getBe_monto() {
        return $this->be_monto;
    }

    function getBe_promedio() {
        return $this->be_promedio;
    }

    function getBe_nombre() {
        return $this->be_nombre;
    }

    function getBe_descripcion() {
        return $this->be_descripcion;
    }

    function getBe_vigencia() {
        return $this->be_vigencia;
    }

    function setBe_id($be_id) {
        $this->be_id = $be_id;
    }

    function setBe_monto($be_monto) {
        $this->be_monto = $be_monto;
    }

    function setBe_promedio($be_promedio) {
        $this->be_promedio = $be_promedio;
    }

    function setBe_nombre($be_nombre) {
        $this->be_nombre = $be_nombre;
    }

    function setBe_descripcion($be_descripcion) {
        $this->be_descripcion = $be_descripcion;
    }

    function setBe_vigencia($be_vigencia) {
        $this->be_vigencia = $be_vigencia;
    }

}
