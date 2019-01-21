<?php

/*
 * @author IvánDarío
 */

class RequisitoPostulante {

    private $rp_id;
    private $postulante_id;
    private $requisito_id;
    private $rp_aprobado;
    private $rp_archivo;
    private $rp_archivo_nombre;
    private $rp_estado;
    private $rp_observacion;
    private $rp_vigencia;

    function __construct($rp_id, $postulante_id, $requisito_id, $rp_aprobado, $rp_archivo, $rp_archivo_nombre, $rp_estado, $rp_observacion, $rp_vigencia) {
        $this->rp_id = $rp_id;
        $this->postulante_id = $postulante_id;
        $this->requisito_id = $requisito_id;
        $this->rp_aprobado = $rp_aprobado;
        $this->rp_archivo = $rp_archivo;
        $this->rp_archivo_nombre = $rp_archivo_nombre;
        $this->rp_estado = $rp_estado;
        $this->rp_observacion = $rp_observacion;
        $this->rp_vigencia = $rp_vigencia;
    }

    function getRp_id() {
        return $this->rp_id;
    }

    function getPostulante_id() {
        return $this->postulante_id;
    }

    function getRequisito_id() {
        return $this->requisito_id;
    }

    function getRp_aprobado() {
        return $this->rp_aprobado;
    }

    function getRp_archivo() {
        return $this->rp_archivo;
    }

    function getRp_archivo_nombre() {
        return $this->rp_archivo_nombre;
    }

    function getRp_estado() {
        return $this->rp_estado;
    }

    function getRp_observacion() {
        return $this->rp_observacion;
    }

    function getRp_vigencia() {
        return $this->rp_vigencia;
    }

    function setRp_id($rp_id) {
        $this->rp_id = $rp_id;
    }

    function setPostulante_id($postulante_id) {
        $this->postulante_id = $postulante_id;
    }

    function setRequisito_id($requisito_id) {
        $this->requisito_id = $requisito_id;
    }

    function setRp_aprobado($rp_aprobado) {
        $this->rp_aprobado = $rp_aprobado;
    }

    function setRp_archivo($rp_archivo) {
        $this->rp_archivo = $rp_archivo;
    }

    function setRp_archivo_nombre($rp_archivo_nombre) {
        $this->rp_archivo_nombre = $rp_archivo_nombre;
    }

    function setRp_estado($rp_estado) {
        $this->rp_estado = $rp_estado;
    }

    function setRp_observacion($rp_observacion) {
        $this->rp_observacion = $rp_observacion;
    }

    function setRp_vigencia($rp_vigencia) {
        $this->rp_vigencia = $rp_vigencia;
    }
    
}
