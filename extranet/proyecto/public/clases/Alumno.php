<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author María Isabel Fuentes 
 */
class Alumno {

    //put your code here 


    /* Definición de variables de la clase */
    private $id;
    private $usuario;
    private $pass;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $email;
    private $curso;  //objeto curso
    private $activo;
    private $asignaturas;  //objeto asignatura
    private $ultimoAcceso;

    /* Declaramos el constructor. Le pasamos un array con los datos para construir el objeto */

    function __construct($id, $usuario, $pass, $nombre, $apellidos, $telefono, $email, $curso, $activo, $ultimoAcceso, $asignaturas) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->curso = $curso;
        $this->activo = $activo;
        $this->setUltimoAcceso($ultimoAcceso);
        $this->asignaturas = $asignaturas;
    }

    /* A continuación se declararán getters */

    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getUltimoAcceso() {
        return $this->ultimoAcceso;
    }

    function getAsignaturas() {
        return $this->asignaturas;
    }

    /* A continuación se declararán setters */

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsario($usuario) {
        $this->usuario = $usuario;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    private function setUltimoAcceso($ultimoAcceso) {
        $this->ultimoAcceso = $ultimoAcceso;
        return $this;
    }

    function setAsignaturas($asignaturas): void {
        $this->asignaturas = $asignaturas;
    }

    public function actualizarUltimoAcceso() {
        GLOBAL $bd;
        $acceso = date('Y-m-d h:i:s');
        $ssql = "UPDATE ies_alumno SET ultimo_acceso='" . $acceso . "' WHERE id=" . $this->id;

        if ($bd->query($ssql)) {
            $this->setUltimoAcceso($acceso);
        }
        return $this;
    }

}
