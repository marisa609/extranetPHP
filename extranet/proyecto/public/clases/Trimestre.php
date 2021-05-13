<?php

// Clase Trimestre.
class Trimestre {
    /* Definición de variables de la clase */

    private $id;
    private $nombre;
    private $nombre2;
    private $orden;

    /* Declaramos el constructor. Le pasamos un array con los datos para construir el objeto */
    
    function __construct($id, $nombre, $nombre2, $orden) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->nombre2 = $nombre2;
        $this->orden = $orden;
    }

        /* A continuación se declararán getters */

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNombre2() {
        return $this->nombre2;
    }

    public function getOrden() {
        return $this->orden;
    }

    /* A continuación se declararán setters */

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setNombre2($nombre2): void {
        $this->nombre2 = $nombre2;
    }

    function setOrden($orden): void {
        $this->orden = $orden;
    }

}

?>