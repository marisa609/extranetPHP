<?php
    function redireccionar($url) {
      // Redireccionamos al usuario a una url que nos llega por parámetro
      echo "<script type='text/javascript'>location.href='".$url."';</script>";
      exit;
    }

    function mostrarMensajeOK($msg) {
      // Mostramos al usuario los mensajes de información
      if($msg > 0 && $msg < 10) {
        $mensaje[1]="Su registro ha sido completado con éxito.";
        $mensaje[2]="Su información ha sido guardada correctamente.";
        $mensaje[3]="Su comentario se ha guardado correctamente.";
        $mensaje[4]="Su comentario sobre el alumno se ha guardado correctamente.";
        $mensaje[5]="El alumno/a ha sido insertado";
        $mensaje[6]="El usuario ha sido dado de baja";
        $mensaje[7]="7";
        $mensaje[8]="8";
        $mensaje[9]="9";
        $mensaje[10]="10";
        echo '<div class="alert alert-success">'.$mensaje[$msg].'</div>';
      } 
    }

    function mostrarMensajeERR($msg) {
      // Mostramos al usuario los mensajes de error
      if($msg > 0 && $msg < 50) {
        $mensaje[1]="Complete los campos del formulario.";
        $mensaje[2]="Los datos introducidos son incorrectos.";
        $mensaje[3]="No se ha podido insertar el alumno/a.";
        $mensaje[4]="El usuario ha sido dado de baja";
        $mensaje[5]="Introduzca el Nombre";
        $mensaje[6]="Introduzca los Apellidos";
        $mensaje[7]="Introduzca el E-mail";
        $mensaje[8]="E-mail ocupado.";
        $mensaje[9]="E-mail no válido.";
        $mensaje[10]="No tiene permisos para acceder a la Extranet.";
        $mensaje[11]="Introduzca la contraseña";
        $mensaje[12]="Introduzca el usuario";
        $mensaje[13]="Introduzca el curso";
        $mensaje[14]="El usuario no tiene el formato correcto";
        $mensaje[15]="El usuario que intenta eliminar ya existe";
        $mensaje[16]="El usuario no existe";
        $mensaje[17]="El usuario que intenta dar de baja ya lo está";
		$mensaje[18]="El usuario debe comenzar por @";
		$mensaje[19]="El nombre no tiene un formato válido.";
		$mensaje[20]="El apellido no tiene un formato válido.";
        echo '<div class="alert alert-danger">'.$mensaje[$msg].'</div>';
      } 
    }
?>
