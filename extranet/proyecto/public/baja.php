<?php

//DECLARACIÓN DE VARIABLES
$usuario = "";
$enviadoOK = true;

//LIMPIEZA DE VARIABLES Y ASIGNACIÓN
if (isset($_POST["inputUsuario"])) {

    //VALIDACIÓN DE DATOS
    if ($_POST['inputUsuario'] == "") {
        redireccionar("profesor.php?&contenido=listadoBaja&error=12");
        $enviadoOK = false;
    }
    if (isset($_GET["error"]))
        mostrarMensajeERR($_GET["error"]);
    $usuario = htmlspecialchars($_POST['inputUsuario'], ENT_QUOTES);



    //ELIMINAR ALUMNO  
    //CONSULTA PARA SABER LOS DATOS DEL ALUMNO QUE QUEREMOS DAR DE BAJA
    $query = "SELECT * FROM ies_alumno WHERE usuario='$usuario';";
    $result = $bd->query($query);

    //Si el alumno introducido no existe, mandamos el error.
    if (mysqli_num_rows($result) == 0) {
        redireccionar("profesor.php?&contenido=listadoBaja&error=16");
        $enviadoOK = false;
        //si el alumno existe, continuamos:        
    } else {
        $alumnoI = $result->fetch_object(); //datos del alumno
        //CREO EL OBJETO Y LE PASO EL USUARIO
        $alumno = new Alumno('', $usuario, $alumnoI->pass, $alumnoI->nombre, $alumnoI->apellidos, $alumnoI->telefono, $alumnoI->email, $alumnoI->curso, $alumnoI->activo, $alumnoI->ultimo_acceso, '');
    }

    if ($alumno->getActivo() == 0) {
        redireccionar("profesor.php?&contenido=listadoBaja&error=17");
        $enviadoOK = false;
    } elseif ($alumno->getActivo() == 1) {
        $query = "UPDATE ies_alumno SET activo = 0 WHERE usuario='" . $alumno->getUsuario() . "';";
        $result = $bd->query($query);
        redireccionar("profesor.php?&contenido=listadoBaja&ok=6");
    } else {
        redireccionar("profesor.php?&contenido=listadoBaja&error=16"); //EL USUARIO NO ES ADECUADO
    }
    //libero la consulta
    mysqli_free_result($result);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <style>
            .botonSalir {
                padding: 10px;
                background-color: red;
                color: white;
            }
        </style> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <br><br>
    <body background="imagenes/logo.png" style="background-repeat: no-repeat; background-position: center center;">
        <main role="main" class="container">
            <div class="row">
                <div class="col-12">
                    <h1 id="h1">Eliminar alumno/a</h1>
                    <hr size=3><br>
                    <section>
                        <h3 id="h3">Introduzca el nombre de usuario del alumno/a que desea eliminar</h3><br>
                        <form action="" method="post"><br>
                            <div class="form-group row">
                                <label for="inputUsuario" class="col-sm-2 col-form-label">Usuario</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputUsuario" name="inputUsuario" placeholder="@usuario">
                                </div>
                            </div>  
                            <br><br>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Eliminar</button>
                            <a href="profesor.php"><button type="button" class="btn btn-secondary btn-lg btn-block btn-danger">Volver</button></a>
                            <br>
<?php
    // Mostramos los mensajes de errores al usuario
    if (isset($_GET["error"])) mostrarMensajeERR($_GET["error"]);
    if (isset($_GET["ok"])) mostrarMensajeOK($_GET["ok"]);
    echo "<br><br><br><br><br><br>";
?>
                        </form>
                    </section>   
                </div>
            </div> 
        </main>
    </body>
</html>

