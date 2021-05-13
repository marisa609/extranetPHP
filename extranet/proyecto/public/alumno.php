<?php
    // Añadimos las librerías
    include("config.php");
    include("conexionbd.php");
    include("funciones.php");

    //Cargamos el autoload
    require_once('./autoload.php');
    autoload(null);

    //Inicio sesión y la valido
    session_start();
    if (!isset($_SESSION['alumno'])) {
        redireccionar("index.php");
    }
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
    $fecha = $_SESSION['fecha'];
    $hora = $_SESSION['hora'];

    //Sesión de meteo
    $maxima = $_SESSION['maxima'];
    $viento = $_SESSION['viento'];
    $dia = $_SESSION['dia'];


    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <style>
            </style>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        </head>
        <body>
            <br>
            <main role="main" class="container">
                <div class="jumbotron">
                    <div class="card mb-3" style="max-width: 1800px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="imagenes/logo.png" style="max-width: 300px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <blockquote class="blockquote">
                                        <h1 id="h1">Saludos <?php echo($nombre . ' ' . $apellidos) ?></h1>
                                        <br><footer class="blockquote-footer">Fecha: <?php echo($fecha) ?></footer>
                                        <footer class="blockquote-footer">Hora: <?php echo($hora) ?></footer>
                                        <hr color="blue" size=3>
                                        <section id="alumno">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'principal') echo 'active'; ?>" aria-current="page" href="alumno.php?&contenido=principal">Curso</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'notas') echo 'active'; ?>" aria-current="page" href="alumno.php?&contenido=notas">Notas</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'avisos') echo 'active'; ?>" aria-current="page" href="alumno.php?&contenido=avisos">Avisos</a>
                                            </li>
                                        </ul>
                                        
                                        <?php

                                        if (isset($_GET["contenido"]) && $_GET["contenido"] == "principal") {

                                            //CONSULTA PARA OBTENER LOS DATOS DEL ALUMNO
                                            $query = "SELECT * FROM ies_alumno WHERE usuario='" . $_SESSION['alumno'] . "';";
                                            $result = $bd->query($query);
                                            $alumnoI = $result->fetch_object(); //datos del alumno
                                            mysqli_free_result($result);

                                            //CONSULTA PARA OBTENER EL OBJETO CURSO CON EL CURSO DEL ALUMNO
                                            $query = "SELECT nombre FROM ies_curso WHERE id=" . $alumnoI->curso . ";";
                                            $result = $bd->query($query);
                                            $cursoI = $result->fetch_object();
                                            $curso = new Curso($alumnoI->curso, $cursoI->nombre);
                                            mysqli_free_result($result);

                                            //CONSULTA PARA CREAR EL ARRAY DE ASIGNATURAS DEL ALUMNO
                                            $query = "SELECT id, nombre, nombre_corto FROM ies_asignatura WHERE curso=" . $alumnoI->curso . ";";
                                            $result = $bd->query($query);
                                            while ($asignaturaI = $result->fetch_object()) {
                                                $asignaturas[] = new Asignatura($asignaturaI->id, $asignaturaI->nombre, $asignaturaI->nombre_corto);
                                            }
                                            mysqli_free_result($result);

                                            //CARGAMOS EL ALUMNO
                                            $alumno = new Alumno($alumnoI->id, $alumnoI->usuario, $alumnoI->pass, $alumnoI->nombre, $alumnoI->apellidos, $alumnoI->telefono, $alumnoI->email, $curso, $alumnoI->activo, $alumnoI->ultimo_acceso, $asignaturas);
                                            $alumno->actualizarUltimoAcceso();


                                            //PINTAMOS LOS DATOS DEL ALUMNO
                                            //echo '<p>Hola ' . $alumno->getNombre() . ' ' . $alumno->getApellidos() . '<br>';
                                            echo '<br><p>Curso: ' . $alumno->getCurso()->getNombre() . '<br>';
                                            echo '<p><br>';
                                            foreach ($alumno->getAsignaturas() as $asignatura) {
                                                echo ' - ' . $asignatura->getNombre() . '</p>';
                                            }
                                            echo '<br>';
                                            
                                        }    

                                        //AVISOS METEO

                                        if (isset($_GET["contenido"]) && $_GET["contenido"] == "avisos") {
                                            //MOSTRAMOS LOS AVISOS
                                            if($maxima >= 45) {
                                                echo '<br><div class="alert alert-danger">AVISO: calor axfisiante. El centro permanecerá cerrado.</div>';
                                            }
                                            if ($viento >=103 && $viento <= 117) {
                                                echo '<br><div class="alert alert-danger">AVISO: viento huracanado. El centro permanecerá cerrado.'
                                                    . '<br>Riesgo: Destrucción en todas partes, lluvias muy intensas, inundaciones muy altas.</div><br>';
                                            }else if ($viento >= 118) {
                                                echo '<br><div class="alert alert-danger">AVISO: viento huracanado. El centro permanecerá cerrado.'
                                                    . '<br>Riesgo: Voladura de autos, árboles, casas, techos y personas. Puede generar un huracán o un tifón.</div>';
                                            }else {
                                                echo '<br><div class="alert alert-success">No existen avisos. El centro permanecerá abierto.</div>';
                                            }

                                        }

                                        //NOTAS  DEL ALUMNO

                                        if (isset($_GET["contenido"]) && $_GET["contenido"] == "notas") {
                                            
                                            //Obtengo el id del alumno
                                            $query = "SELECT id FROM ies_alumno WHERE usuario='".$_SESSION['alumno']."';";
                                            $result = $bd->query($query);
                                            $numfilas = $result->num_rows;
                                            $id = 0;
                                                for ($x=0;$x<$numfilas;$x++) {
                                                    $fila = $result->fetch_object();
                                                    $id=$fila->id;
                                                }

                                            //Consulta para mostrar las notas del alumno
                                            $query = "SELECT n.trimestre, a.nombre, n.nota FROM ies_notas n 
                                            INNER JOIN ies_asignatura a ON a.id = n.asignatura WHERE n.alumno=".$id." order by n.trimestre";
                                            $result = $bd->query($query);
                                            ?>
                                                <br><br>
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">TRIMESTRE</th>
                                                            <th scope="col">ASIGNATURA</th>
                                                            <th scope="col">NOTA</th>
                                                        </tr>
                                                    </thead>
                                                    <?php while ($fila = mysqli_fetch_array($result)) { ?>
                                                        <tbody>
                                                            <tr>
                                                                <td><?= $fila["trimestre"]; ?></td>
                                                                <td><?= $fila["nombre"]; ?></td>
                                                                <td><?= $fila["nota"]; ?></td>
                                                                </tr>
                                                            </tbody>
                                                    <?php } ?>
                                                </table>
                                            <?php            
                                        }
                                        
                                        //OPCIÓN VOLVER
                                        echo'<br><a href="cerrarSesionAlumno.php" class="botonSalir"><button type="button" class="btn btn-primary">Salir</button></a>
                                                </blockquote></div></div></div></div></div></main>';
                                    ?>

                                        </section>
                                        </body>
                                        </html>

            </section>
        </body>
    </html>
<?php include("desconectabd.php"); //Recomendación de Alejandro var_dump($_POST); ?>
