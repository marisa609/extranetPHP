<?php
	// Se puede hacer con un único fichero, alumno.php y profesor.php llamarían al mismo
	include("funciones.php");

	session_start();
    session_destroy();
	redireccionar("index.php");
?>

            
 
