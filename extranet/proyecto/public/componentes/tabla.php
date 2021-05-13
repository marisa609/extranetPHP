<?php
		//Esta clase contiene la tabla donde se van a mostrar los resultados de la tabla ies_notas
		
		// Añadimos las librerías
		include("../config.php");
		include("../conexionbd.php");
		include("../funciones.php");


		//Inicio sesión y compruebo que exista
		session_start();
		if (!isset($_SESSION['profesor'])) {
			redireccionar("index.php");
		}
		
		//Utilizamos el id para ponerlo en el WHERE y solo mostrar las notas que ha puesto el profesor en concreto
		$id = $_SESSION['id'];


		//Como la tabla tiene los id, se necesita unirla con sus respectivas para poder sacar información escrita y no solo numérica.
		//Mostramos los nombres pero sacamos los id para mandarlos a un input invisible y así capturarlos con .val() para poder insertarlos
		$query = "SELECT c.nombre AS curso, a.nombre AS asignatura, al.nombre, al.apellidos, p.usuario, n.trimestre, n.nota, 
		n.curso AS cursoID, n.asignatura AS asignaturaID, n.alumno AS alumnoID, n.profesor AS profesorID
		FROM ies_notas n
		INNER JOIN ies_asignatura a ON a.id = n.asignatura 
		INNER JOIN ies_alumno al ON al.id = n.alumno
		INNER JOIN ies_curso c ON c.id = n.curso
		INNER JOIN ies_profesor p ON p.id = n.profesor
		WHERE profesor=".$id." ";
		$result = $bd->query($query);

?>
		<table class="table table-hover table-condensed table-bordered">
		<caption>
			<br><br>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
				Agregar nuevo 
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</caption>
			<tr>
				<td>Curso</td>
				<td>Asignatura</td>
				<td>Alumno</td>
				<td>Profesor</td>
				<td>Trimestre</td>
				<td>Nota</td>
				<td>Editar</td>
			</tr>
			
		 <?php while ($fila = mysqli_fetch_array($result)) { 
			 
			 //Cuando hacemos click en cualquier botón de editar, se envían todos los valores de la consulta a la función /js/funciones.js/agregarform()
			 $datos = $fila["curso"]."||".$fila["asignatura"]."||".$fila["apellidos"]."||".$fila["usuario"]."||".$fila["trimestre"]."||".$fila["nota"]."||".
			 $fila["cursoID"]."||".$fila["asignaturaID"]."||".$fila["alumnoID"]."||".$fila["profesorID"];

		?>

			<tr>
				<td><?= $fila["curso"]; ?></td>
				<td><?= $fila["asignatura"]; ?></td>
				<td><?= $fila["apellidos"],' ',$fila["nombre"]; ?></td>
				<td><?= $fila["usuario"]; ?></td>
				<td><?= $fila["trimestre"]; ?></td>
				<td><?= $fila["nota"]; ?></td>
				<td>
					<button class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalEdicion" onclick="agregaform('<?php echo $datos ?>')"></button>
				</td>
			</tr>
			<?php 
		 }
			 ?>
		</table>
	</div>
</div>
<?php include("../desconectabd.php");?>
		

