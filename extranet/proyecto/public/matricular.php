<?php

//Inicio sesión del profesor
/* if (!isset($_SESSION['profesor'])) {
    redireccionar("index.php");
    $mostrar = 1;
} */
$nombreProfesor = $_SESSION['nombre'];
$apellidosProfesor = $_SESSION['apellidos'];
$nombreCursoTutor = $_SESSION['nombreCursoTutor'];
$tutor = $_SESSION['tutor'];

//DECLARACIÓN DE VARIABLES
$usuario = "";
$contrasena = "";
$nombre = "";
$apellidos = "";
$telefono = "";
$email = "";
$estado = "";
$activo = 0;
$enviadoOK = true;


//LIMPIEZA DE VARIABLES Y ASIGNACIÓN
if (isset($_POST["inputUsuario"]) && isset($_POST['inputContrasena']) && isset($_POST['inputNombre']) && isset($_POST['inputApellidos']) && isset($_POST['inputTelefono']) && isset($_POST['inputEmail']) && isset($_POST['inputEstado'])) {

    //VALIDACIÓN DE DATOS
    if ($_POST['inputUsuario'] == "") {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=12");
        $enviadoOK = false;
    }
    if ($_POST['inputNombre'] == "") {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=5");
        $enviadoOK = false;
    }
    if ($_POST['inputContrasena'] == "") {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=11");
        $enviadoOK = false;
    }
    if ($_POST['inputApellidos'] == "") {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=6");
        $enviadoOK = false;
    }

    $usuario = htmlspecialchars($_POST['inputUsuario'], ENT_QUOTES);
    $contrasena = htmlspecialchars($_POST['inputContrasena'], ENT_QUOTES);
    $nombre = htmlspecialchars($_POST['inputNombre'], ENT_QUOTES);
    $apellidos = htmlspecialchars($_POST['inputApellidos'], ENT_QUOTES);
    $telefono = htmlspecialchars($_POST['inputTelefono'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['inputEmail'], ENT_QUOTES);
    $estado = htmlspecialchars($_POST['inputEstado'], ENT_QUOTES);

    //VALIDO LOS DATOS INTRODUCIDOS POR EL USUARIO UNA VEZ HAN SIDO CAPTURADOS Y ALMACENADOS EN SUS RESPECTIVAS VARIABLES
    // el e-mail ya se está validando del el html, pero en caso de ser necesario la función es esta: if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { redireccionar("profesor.php?&contenido=listadoMatricular&error=9"); $enviadoOK = false;  }
    if (!preg_match("/^@/", $usuario)) {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=18");
        $enviadoOK = false;
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=19");
        $enviadoOK = false;
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $apellidos)) {
        redireccionar("profesor.php?&contenido=listadoMatricular&error=20");
        $enviadoOK = false;
    }

    if($estado == 'Activo'){
        $activo = 1;
    } 
    
    /*OBJETO ALUMNO
     * Lo creamos y lo insertamos si todo está correcto
     */
    $alumno = new Alumno('', $usuario, $contrasena , $nombre, $apellidos, $telefono, $email, $tutor, $activo, '', '');
    //INSERTAR ALUMNO
    if ($enviadoOK == true) {
        $query = "INSERT INTO ies_alumno (usuario, pass, nombre, apellidos, telefono, email, curso, activo) values ('".$alumno->getUsuario()."','" . md5($alumno->getPass()) . "','".$alumno->getNombre()."','".$alumno->getApellidos()."','".$alumno->getTelefono()."','".$alumno->getEmail()."', $tutor,$activo);";
        $result = $bd->query($query);
        if(!$result){                                                                                                               
            printf("Error: %s\n", $bd->error); 
            exit();
        } else {
            redireccionar("profesor.php?&contenido=listadoMatricular&ok=5");          
        }
    }
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
    <body>
        <br><br><br>
        <main role="main" class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Matrícula</h1>
                    <hr size=3><br><br>
                    <form action="" method="post">
                        <div class="form-group row">
                            <label for="inputUsuario" class="col-sm-2 col-form-label">Usuario</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputUsuario" name="inputUsuario" placeholder="@usuario">
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="inputContrasena" class="col-sm-2 col-form-label">Contraseña</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputContrasena" name="inputContrasena" placeholder="12345678">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputApellidos" class="col-sm-2 col-form-label">Apellidos</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputApellidos" name="inputApellidos" placeholder="Apellidos">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTelefono" class="col-sm-2 col-form-label">Teléfono</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputTelefono" name="inputTelefono" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" name="inputEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Curso</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control text-center" value="<?php echo($nombreCursoTutor) ?>" disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Estado</label>  
                            <div class="col-sm-10">                      
                                <select id="inputEstado" name="inputEstado" class="form-control">
                                    <option selected>Activo</option>
                                    <option>Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <?php 
                            //Mostramos mensajes de error
                            if (isset($_GET["error"])) mostrarMensajeERR($_GET["error"]);
                            if (isset($_GET["ok"])) mostrarMensajeOK($_GET["ok"]);
                        ?>
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Insertar</button>
                        <a href="profesor.php"><button type="button" class="btn btn-secondary btn-lg btn-block btn-danger">Volver</button></a>
                        
                    </form>
                    <br><br>
                </div>
            </div> 
        </main>
    </body>
</html>        
