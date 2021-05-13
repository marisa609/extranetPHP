<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logincidencia
 *
 * @author María Isabel Fuentes
 */
class Logincidencia {

    private $id; //id del profesor
    private $nombre; //
    private $apellidos;
    private $nuevoEstado;
    private $antiguoEstado;
    private $fecha; //DateTime

    //Constructor

    function __construct($id, $nombre, $apellidos, $nuevoEstado, $antiguoEstado, $fecha) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->nuevoEstado = $nuevoEstado;
        $this->antiguoEstado = $antiguoEstado;
        $this->fecha = $fecha;
    }

    //Getters

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNuevoEstado() {
        return $this->nuevoEstado;
    }

    function getAntiguoEstado() {
        return $this->antiguoEstado;
    }

    function getFecha() {
        return $this->fecha;
    }

    //Setters

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos): void {
        $this->apellidos = $apellidos;
    }

    function setNuevoEstado($nuevoEstado): void {
        $this->nuevoEstado = $nuevoEstado;
    }

    function setAntiguoEstado($antiguoEstado): void {
        $this->antiguoEstado = $antiguoEstado;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    public function actualizarFecha() {
        GLOBAL $bd;
        $acceso = date('Y-m-d');
        $ssql = "UPDATE ies_log_incidencias SET fecha='" . $acceso . "' WHERE id=" . $this->id;
        if ($bd->query($ssql)) {
            $this->actualizarFecha($acceso);
        }
        return $this;
    }

    //Método para insertar 

    function insertar(Logincidencia $logincidencia) {
        $query = "INSERT INTO ies_logincidencia (id, nombre, apellidos, nuevoEstado, antiguoEstado, fecha) values ('$logincidencia->$id','$logincidencia->$nombre','$logincidencia->$apellidos',,'$logincidencia->$nuevoEstado','$logincidencia->$antiguoEstado', '$logincidencia->$fecha');";
        $result = $bd->query($query);
        if (!$query) {
            printf("Error: %s\n", $bd->error);
            exit();
        } else {
            redireccionar("mensajes.php?ok=5");
        }
    }

}
