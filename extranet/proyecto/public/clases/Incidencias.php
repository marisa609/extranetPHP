<?php

/**
 * Description of Alumno
 *
 * @author María Isabel Fuentes 
 */
class Incidencias {

    //put your code here 


    /* Definición de variables de la clase */
    private $id;
    private $profesor; //Objeto profesor
    private $fecha; //DateTime
    private $estado;
    private $detalles;
    private $enviadoOK = true; // va a ser el que comprobará los datos

    /* Declaramos el constructor. Le pasamos un array con los datos para construir el objeto */

    function __construct($id, $profesor, $fecha, $estado, $detalles) {
        $this->id = $id;
        $this->profesor = $profesor; // objeto profesor
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->detalles = $detalles;
    }

    /* A continuación se declararán getters */

    function getId() {
        return $this->id;
    }

    function getProfesor() {
        return $this->profesor;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getEstado() {
        return $this->estado;
    }

    function getDetalles() {
        return $this->detalles;
    }

    /* A continuación se declararán setters */

    function setId($id): void {
        $this->id = $id;
    }

    function setProfesor($profesor): void {
        $this->profesor = $profesor;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    function setEstado($estado): void {
        $this->estado = $estado;
    }

    function setDetalles($detalles): void {
        $this->detalles = $detalles;
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

    //Método para actualizar una incidencia.

    function actualizar(Incidencias $incidencia) {
        $query = "UPDATE ies_incidencia SET profesor = '" . $incidencia->getId() . "'  "
                . "SET fecha = '" . $incidencia->getFecha() . "'  "
                . "SET estado = '" . $incidencia->getEstado() . "'  "
                . "SET detalles = '" . $incidencia->getDetalles() . "'  "
                . "WHERE id='" . $incidencia->getProfesor() . "';";
        $result = $bd->query($query);

        if (!$query) {
            printf("Error: %s\n", $bd->error);
            exit();
        } else {
            redireccionar("mensajes.php?ok=5");
        }
    }

}
