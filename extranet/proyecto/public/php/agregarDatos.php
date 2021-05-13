<?php 

	// Añadimos las librerías
    include("../config.php");
    include("../conexionbd.php");
    include("../funciones.php");

	//Estos post vienen de Ajax en el archivo funciones.php
	$curso = $_POST['curso'];
	$asignatura = $_POST['asignatura'];
	$alumno = $_POST['alumno'];
	$profesor = $_POST['profesor'];
	$trimestre = $_POST['trimestre'];
	$nota = $_POST['nota'];

	$query = "INSERT INTO ies_notas (curso, asignatura, alumno, profesor, trimestre, nota) values ('$curso','$asignatura','$alumno','$profesor','$trimestre','$nota');";
    //pongo el echo para que devuelva si se ha realizado o no el update, es la causa de que funciona el if del $ajax
	echo $result = $bd->query($query);

	include("../desconectabd.php");

 ?>