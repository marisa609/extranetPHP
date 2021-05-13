<?php 

  //Recibimos por sesión el id del profesor para mostrar el id del profesor y que ese profesor no pueda introducir ningún otro id que no sea el suyo
  $id = $_SESSION['id']; 

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css"> 

	  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  	<link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">

	  <script src="librerias/jquery-3.2.1.min.js"></script>
  	<script src="js/funciones.js"></script>
	  <script src="librerias/bootstrap/js/bootstrap.js"></script>
	  <script src="librerias/alertifyjs/alertify.js"></script>
  	<script src="librerias/select2/js/select2.js"></script> 
</head>
<body>
    <!--Aquí se recargará la tabla-->
    <div class="container">
	    <div id="tabla"></div>
	  </div> 


    <!-- Añadir -->

    <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Ingrese la nota</h4>
          </div>
          <div class="modal-body">
                  <label>Curso</label>
                <input type="text" name="" id="cursoN" class="form-control input-sm">
                <label>Asignatura</label>
                <input type="text" name="" id="asignaturaN" class="form-control input-sm">
                <label>Alumno</label>
                <input type="text" name="" id="alumN" class="form-control input-sm">
                <label>Profesor</label>
                <input type="text" name="" id="profesorN" class="form-control input-sm" value="<?php echo($id)?>" disabled>
                <label>Trimestre</label>
                <input type="text" name="" id="trimestreN" class="form-control input-sm">
              <label>Nota</label>
                <input type="text" name="" id="notaN" class="form-control input-sm">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
            Agregar
            </button>
           
          </div>
        </div>
      </div>
    </div>
    
    <!-- Edidar -->
    
    <div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
          </div>
          <div class="modal-body">
                <label>Curso</label>
                <input type="text" name="" id="cursoE" class="form-control input-sm" disabled>
                <label>Asignatura</label>
                <input type="text" name="" id="asignaturaE" class="form-control input-sm" disabled>
                <label>Alumno</label>
                <input type="text" name="" id="alumE" class="form-control input-sm" disabled>
                <label>Profesor</label>
                <input type="text" name="" id="profesorE" class="form-control input-sm" disabled>
                <label>Trimestre</label>
                <input type="text" name="" id="trimestreE" class="form-control input-sm"disabled>
                <label>Nota</label>
                <input type="text" name="" id="notaE" class="form-control input-sm">
                <input type="text" hidden="" id="cursoID" name="">
                <input type="text" hidden="" id="asignaturaID" name="">
                <input type="text" hidden="" id="alumnoID" name="">
                <input type="text" hidden="" id="profesorID" name="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div> 
    
    
    </body>
    </html>
    <script type="text/javascript">
        $(document).ready(function(){
        //Cargamos la tabla
        $('#tabla').load('componentes/tabla.php');   
        });
    </script> 

    <script type="text/javascript">
        $(document).ready(function(){
          //Recoge los valores del modal añadir
            $('#guardarnuevo').click(function(){
                curso = $('#cursoN').val();
                asignatura = $('#asignaturaN').val();
                alumno = $('#alumN').val();
                profesor = $('#profesorN').val();
                trimestre = $('#trimestreN').val();
                nota = $('#notaN').val();
                //Enviamos dichos valores a funciones.js para poder realizar la función asíncrona
                agregardatos(curso, asignatura, alumno, profesor, trimestre, nota);
            });

            //Cuando pulsamos el botón actiulizar de dentro del modal editar llamamos a la función de actualiza datos en funciones.js
            $('#actualizadatos').click(function(){
              actualizaDatos();
            }); 
    
        });
    </script>