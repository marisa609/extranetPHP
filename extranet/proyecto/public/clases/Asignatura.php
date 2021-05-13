<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asignatura
 *
 * @author María Isabel Fuentes
 */
class Asignatura {

    //put your code here

    /* Definición de variables de la clase */
    private $id;
    private $nombre;
    private $nombre_corto;
    //private $curso; // curso no hace falta

    /* Declaramos el constructor. Le pasamos un array con los datos para construir el objeto */

    function __construct($id, $nombre, $nombre_corto) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->nombre_corto = $nombre_corto;
    }

    /* A continuación se declararán getters */

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getNombre_corto() {
        return $this->nombre_corto;
    }

    /* A continuación se declararán setters */

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setNombre_corto($nombre_corto): void {
        $this->nombre_corto = $nombre_corto;
    }

   

}
