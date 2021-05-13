<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Curso
 *
 * @author María Isabel Fuentes
 */
class Curso {

    //put your code here

    /* Definición de variables de la clase */
    private $id;
    private $nombre;

    /* Declaramos el constructor. Le pasamos un array con los datos para construir el objeto */
    //asigna con el set
    function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    /* A continuación se declararán getters */

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    /* A continuación se declararán setters */

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

}
