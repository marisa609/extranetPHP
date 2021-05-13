<?php
  // AÃ±adimos las librerÃ­as
    include("config.php");
    include("conexionbd.php");
    include("funciones.php");

  /*

  1.UtilizaciÃ³n de algoritmos de encriptaciÃ³n de contraseÃ±as mediante funciones PHP.

  A la hora de almacenar las contraseÃ±as dentro de una tabla en la base de datos, estas se pueden almacenar sin encriptar -como se ha relizado hasta ahora- o encriptadas. El hecho de almacenarlas sin encriptar permite a los usuarios obtener la informaciÃ³n de las contraseÃ±as comprometiendo la seguridad de la base de datos y del sitio web en cuestiÃ³n:

  a) Hasta ahora todos los alumnos y profesores tienen la contraseÃ±a "12345678" en la BBDD sin encriptar. Realiza un UPDATE sobre el campo pass de las tablas 'ies_alumno' y 'ies_profesor' utilizando un algoritmo de encriptaciÃ³n de PHP, por ejemplo MD5(). Comprueba que el alumno o profesor recien actualizado se ha almacenado con la contraseÃ±a encriptada y puede acceder a la extranet.

  Para ello, el /phpmyadmin realizo las siguientes sentencias:
      Update ies_alumno set pass = md5(pass);
      Update ies_profesor set pass = md5(pass);
      s
  Para comprobar que se ha almacenado y se puede acceder, es necesario en la SELECT especificar la enciptaciÃ³n con pass='".md5($contrasena)."'
*/
  
  if(isset($_POST["usuario"])) {
    // Manda el error que mÃ¡s abajo mostramos (en el cÃ³digo php que hay dentro del formulario HTML)
    if($_POST['usuario']==""||$_POST['contrasena']=="") redireccionar("index.php?error=1");
    else { 
      // Recojo los datos del formulario y limpio las cadenas de caracteres por si hay caracteres extraÃ±os.
      $usuario=htmlspecialchars($_POST['usuario'],ENT_QUOTES);
      $contrasena=htmlspecialchars($_POST['contrasena'],ENT_QUOTES);
      
      //Obtengo la fecha y la hora para que profesor y alumno puedan mandarla a sus respectivos ficheros
          date_default_timezone_set ('Europe/Madrid');
	  $fecha = date("d-m-yy");
	  $hora = date("H:i:s");
	  
      // Primero consulto en la tabla de los Profesores
      $ssql="SELECT * FROM ies_profesor WHERE usuario='".$usuario."' AND pass='".md5($contrasena)."' LIMIT 0,1;";
      if ($rs=$bd->query($ssql)){
        $profesor = $rs->fetch_object();
        if($profesor!=null) {
          // Redirecciono al usuario a la Extranet del profesor
          //$url_redireccionar = "extranet.php?tipousuario=profesor&id=".$profesor->id."&usuario=".$usuario;
		  $result = $bd->query($ssql);
		  $numfilas = $result->num_rows;
		  for ($x=0;$x<$numfilas;$x++) {
			  $fila = $result->fetch_object();
			  $nombreProfesor = $fila->nombre;
			  $apellidosProfesor = $fila->apellidos;
		  }
          session_start();
	          $_SESSION['profesor'] = $usuario; // contiene el usuario profesor
			  $_SESSION['nombre'] = $nombreProfesor; //contiene el nombre obtenido de la consulta
			  $_SESSION['apellidos'] = $apellidosProfesor; //contiene el apellido obtenido de la consulta
			  $_SESSION['fecha'] = $fecha; // contiene la fecha
			  $_SESSION['hora'] = $hora; // contiene la hora para que cuando el usuario realice una acciÃ³n no se actualice. Por eso, el lugar de hacerlo en fichero profesor lo hago de esta forma
          redireccionar('profesor.php');

        }else{
          // Segundo consulto en la tabla de los alumnos y saco su nombre y sus apellidos
          $ssql="SELECT * FROM ies_alumno WHERE usuario='".$usuario."' AND pass='".md5($contrasena)."' LIMIT 0,1;";
          if ($rs=$bd->query($ssql)){
            $alumno = $rs->fetch_object();
			if ($alumno!=null) {
				$result = $bd->query($ssql);
				$numfilas = $result->num_rows;
				for ($x=0;$x<$numfilas;$x++) {
					$fila = $result->fetch_object();
					$nombre = $fila->nombre;
					$apellidos = $fila->apellidos;
				}

              // Redirecciono al usuario a la Extranet del Alumnado
              //$url_redireccionar = "extranet.php?tipousuario=alumno&id=".$alumno->id."&usuario=".$usuario;
              //redireccionar($url_redireccionar);
              session_start();
	              $_SESSION['alumno'] = $usuario; //contine el usuario
				  $_SESSION['nombre'] = $nombre; //contiene el nombre obtenido de la consulta
				  $_SESSION['apellidos'] = $apellidos; //contiene el apellido obtenido de la consulta
				  $_SESSION['fecha'] = $fecha; // contiene la fecha
				  $_SESSION['hora'] = $hora; // contiene la hora para que cuando el usuario realice una acciÃ³n no se actualice. Por eso, el lugar de hacerlo en fcihero alumnos lo hago de esta forma
              redireccionar('alumno.php');
            }else{
              // El usuario no es vÃ¡lido. Y le mostramos el error.
              redireccionar("index.php?error=2");
              
            }
          }
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
  <meta charset="utf-8">
  <meta name="description" content="Tarea numero 3. Inicio - Desarrollo Web entorno Servidor">
  <meta name="author" content="Maria Isabel Fuentes">
  <title>Tarea numero 3. Inicio - Desarrollo Web entorno Servidor</title>
  <!-- Cargar el CSS de Boostrap-->
  <<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
  <main role="main" class="container my-auto">
    <div class="row">
      <div id="login" class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-12">
          <h1 class="text-center">Iniciar sesión</h1><br>
          <img class="img-fluid mx-auto d-block rounded" src="imagenes/logo.png" /><br><br>
        <?php 
          // Mostramos los mensajes de errores al usuario
          if(isset($_GET["error"])) mostrarMensajeERR($_GET["error"]); 
        ?>
        <form action="./index.php" method="post" name="login">
        @csrf
          <div class="form-group">
            <label for="correo">Usuario</label>
            <input id="usuario" name="usuario" class="form-control" placeholder="Usuario">
          </div>
          <div class="form-group">
            <label for="palabraSecreta">Contraseña</label>
            <input id="contrasena" name="contrasena" class="form-control" type="password" placeholder="ContraseÃ±a">
          </div>
          <button type="submit" class="btn btn-primary mb-2">Entrar</button>
        </form>
      </div>
    </div>
    <?php include("API_Tiempo/index.php");?>
  </main>
</body>
</html>
<?php include("desconectabd.php"); ?>