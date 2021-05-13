<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profesor
 *
 * @author María Isabel Fuentes
 */
class Profesor {

    //put your code here

    /* Definición de variables de la clase */
    private $id;
    private $usuario;
    private $pass;
    private $nombre;
    private $apellidos;
    private $email;
    private $tutor_curso;
    //private $alumno; //objeto alumno

    /* Declaramos el constructor. Le pasamos un array con los datos para construir el objeto */

    function __construct($id, $usuario, $pass, $nombre, $apellidos, $email, $tutor_curso) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->tutor_curso = $tutor_curso;
        
    }
    
    

   
    
    /* A continuación se declararán getters */

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPass() {
        return $this->pass;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getTutor_curso() {
        return $this->tutor_curso;
    }
    
    function getAlumno() {
        return $this->alumno;
    }

    /* A continuación se declararán setters */

    function setId($id): void {
        $this->id = $id;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setPass($pass): void {
        $this->pass = $pass;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos): void {
        $this->apellidos = $apellidos;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setTutor_curso($tutor_curso): void {
        $this->tutor_curso = $tutor_curso;
    }
    
    function setAlumno($alumno): void {
        $this->alumno = $alumno;
    }

}
