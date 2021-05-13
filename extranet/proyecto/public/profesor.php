<?php
    // Añadimos las librerías
    include("config.php");
    include("conexionbd.php");
    include("funciones.php");

    //Cargamos el autoload
    require_once('./autoload.php');
    autoload(null);

    //Inicio sesión y compruebo que exista
    session_start();
    if (!isset($_SESSION['profesor'])) {
        redireccionar("index.php");
    }
    //Estas nos llegan desde index.php
    $nombreProfesor = $_SESSION['nombre'];
    $apellidosProfesor = $_SESSION['apellidos'];
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

                label {
                    font-size: 20px;
                }
                #alumno {
                    width: 60%;
                    margin-left: 42%;
                }
                h1 {
                    text-align: center;
                } 
                #menu {
                    padding-left: 39%;
                }

                #menu li {
                    display: inline;
                }
                #menu li a {
                    font-family: Arial;
                    font-size: 14px;
                    text-decoration: none;
                    float: left;
                    padding: 20px;
                    background-color: #2175bc;
                    color: #fff;
                }
                #menu li a:hover {
                    background-color: #2586d7;
                    margin-top: -2;
                }
                #profesor {
                    text-align: center;
                }


            </style>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
            
        </head>
        <body>
            <br><br>
            <section id="profesor">
                <h1 id="h1">Bienvenidx <?php echo($nombreProfesor . ' ' . $apellidosProfesor) ?></h1>
                <hr size=3>
                <?php
    //CONSULTAS DEL PROFESOR
    //MUESTRO LA FECHA
                echo '<label>Fecha: ' . $fecha . '</label>';
                echo "<br>";
    //MUESTRO LA HORA
                echo '<label>Hora: ' . $hora . '</label><br>';

                //CONSULTO LOS DATOS DEL PROFESOR
                $query = "SELECT * FROM ies_profesor WHERE apellidos='" . $apellidosProfesor . "';";
                $result = $bd->query($query);
                $profesorI = $result->fetch_object(); //datos del alumno
                mysqli_free_result($result);
                //creo el objeto profesor
                $profesor = new Profesor($profesorI->id, $_SESSION['profesor'], $profesorI->pass, $profesorI->nombre, $profesorI->apellidos, $profesorI->email, $profesorI->tutor_curso);


    //mando el campo tutor_curso que es igual al campo id de la tabla curso para poder realizar la matricula
    //más abajo envío el nombre del curso del cual es tutor
                $_SESSION['tutor'] = $profesor->getTutor_curso();



    //Si la variable tutor es = 0, significa que el profesor no es tutor
                if ($profesor->getTutor_curso() == 0) {
                    //MENÚ SUPERIOR DEL PROFESOR QUE NO ES TUTOR
                    ?>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container container text-center h-100 bg-primary d-flex justify-content-center align-items-center">
                            <nav class="navbar navbar-dark bg-primary">
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoAlumnos') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoAlumnos">ALUMNOS</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoCursos') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoCursos">CURSOS</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoTrimestres') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoTrimestres">TRIMESTRES</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoBaja') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoBaja">BAJA</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoEvaluaciones') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoEvaluaciones">EVALUACIONES</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoAvisos') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoAvisos">AVISOS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cerrarSesionProfesor.php">SALIR</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </nav>

                    <?php
                    echo "<br>";
                } else {
                    //MENÚ SUPERIOR DEL PROFESOR QUE SI ES TUTOR
                    //CONSULTA PARA SABER EL NOMBRE DEL CURSO DEL CUAL EL PROFESOR ES TUTOR
                    //Esta consultada debe ir en el Else puesto que no podemos saber el nombre del curso del cual
                    //el profesor es Tutor si dicho profesor no es tutor. En otras palabras, debemos asegurarnos
                    //de que el profesor es tutor para saber el nombre de su curso.
                    $query = "SELECT * FROM ies_curso WHERE id='" . $profesor->getTutor_curso() . "';";
                    $result = $bd->query($query);
                    $cursoI = $result->fetch_object(); //datos del alumno
                    mysqli_free_result($result);
                    //creo el objeto curso 
                    $curso = new Curso($cursoI->id, $cursoI->nombre);

                    //mando el nombre del curso del cual es tutor para recogerla en matricular.php
                    $_SESSION['nombreCursoTutor'] = $cursoI->nombre;
                    ?>

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container container text-center h-100 bg-primary d-flex justify-content-center align-items-center">
                            <nav class="navbar navbar-dark bg-primary">
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoAlumnos') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoAlumnos">ALUMNOS</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoCursos') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoCursos">CURSOS</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoTrimestres') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoTrimestres">TRIMESTRES</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoMatricular') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoMatricular">MATRICULAR</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoBaja') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoBaja">BAJA</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoEvaluaciones') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoEvaluaciones">EVALUACIONES</a>
                                        </li>
                                        <li class="nav-item <?php if (isset($_GET["contenido"]) && $_GET["contenido"] == 'listadoAvisos') echo 'active'; ?>">
                                            <a class="nav-link" href="profesor.php?&contenido=listadoAvisos">AVISOS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cerrarSesionProfesor.php">SALIR</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </nav>


                    <?php
                    echo "<br>";
                }


                //CONSULTA PARA EXTRAER LOS CAMPOS DE LOS ALUMNOS
                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoAlumnos") {
                    $query = "SELECT c.nombre AS curso, a.id, a.usuario, a.pass, a.nombre, a.apellidos, a.activo, a.telefono, a.email, a.ultimo_acceso
                                        FROM ies_curso c
                                        INNER JOIN ies_alumno a ON c.id = a.curso
                                        ;";
                    $result = $bd->query($query);
                    //como tenemos varios alumnos, necesitamos crear un array de alumnos. El curso no se va a sacar de una consulta externa
                    //el curso se obtiene de la select con un inner join a tabla curso.
                    //Al constructor le mando el campo asignatura como vacío puesto que no hace falta
                    while ($alumnoI = $result->fetch_object()) {
                        $alumnos[] = new Alumno($alumnoI->id, $alumnoI->usuario, $alumnoI->pass, $alumnoI->nombre,
                                $alumnoI->apellidos, $alumnoI->telefono,
                                $alumnoI->email, $alumnoI->curso, $alumnoI->activo, $alumnoI->ultimo_acceso, '');
                    }
                    mysqli_free_result($result);
                    //PINTO LOS DATOS 
                    ?>
                    <main role="main" class="container">
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Curso</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Apellidos</th>
                                            <th scope="col">Teléfono</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Activo</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($alumnos as $alumno) { ?>
                                        <tbody>
                                            <tr>
                                                <?php
                                                if ($alumno->getActivo() == 0) {
                                                    echo '<td bgcolor="#ec7063">' . $alumno->getCurso() . '</td>';
                                                    echo '<td bgcolor="#ec7063">' . $alumno->getNombre() . '</td>';
                                                    echo '<td bgcolor="#ec7063">' . $alumno->getApellidos() . '</td>';
                                                    echo '<td bgcolor="#ec7063">' . $alumno->getTelefono() . '</td>';
                                                    echo '<td bgcolor="#ec7063">' . $alumno->getEmail() . '</td>';
                                                    echo '<td bgcolor="#ec7063">' . $alumno->getActivo() . '</td>';
                                                } else {
                                                    echo '<td>' . $alumno->getCurso() . '</td>';
                                                    echo '<td>' . $alumno->getNombre() . '</td>';
                                                    echo '<td>' . $alumno->getApellidos() . '</td>';
                                                    echo '<td>' . $alumno->getTelefono() . '</td>';
                                                    echo '<td>' . $alumno->getEmail() . '</td>';
                                                    echo '<td>' . $alumno->getActivo() . '</td>';
                                                }
                                                ?>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div> 
                    </main>
                    <?php
                }

    // COLSULTA MENÚ CURSOS
                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoCursos") {
                    echo '<div class="card mb-3" style="max-width: 1800px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="imagenes/logo.png" style="max-width: 320px;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">';


                    //OBTENGO EL ARRAY DE CURSOS DEL OBJETO CURSO
                    $query = "SELECT * FROM ies_curso;";
                    $result = $bd->query($query);
                    while ($cursoI = $result->fetch_object()) {
                        $cursos[] = new Curso($cursoI->id, $cursoI->nombre);
                    }


                    //PINTO LOS DATOS DEL OBJETO CURSO
                    foreach ($cursos as $curso) {
                        echo "<label>Curso: " . $curso->getNombre() . "</label><br>";
                    }

                    mysqli_free_result($result); //libero la consulta

                    echo '</div></div></div></div>';
                }


                // COLSULTA MENÚ TRIMESTRES
                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoTrimestres") {
                    echo '<div class="card mb-3" style="max-width: 1800px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="imagenes/logo.png" style="max-width: 320px;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">';

                    //OBTENGO EL ARRAY DE CURSOS DEL OBJETO TRIMESTRE
                    $query = "SELECT * FROM ies_trimestres;";
                    $result = $bd->query($query);
                    while ($trimestreI = $result->fetch_object()) {
                        $trimestres[] = new Trimestre($trimestreI->id, $trimestreI->nombre, $trimestreI->nombre2, $trimestreI->orden);
                    }


                    //PINTO LOS DATOS DEL OBJETO CURSO
                    foreach ($trimestres as $trimestre) {
                        echo "<label>Trimestres: " . $trimestre->getNombre() . "</label><br>";
                    }

                    mysqli_free_result($result); //libero la consulta

                    echo '</div></div></div></div>';
                }

                //MENÚ EVALUACIONES
                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoEvaluaciones") {
                    //Envío el id del profesor
                    $_SESSION['id'] = $profesor->getId();
		            include("./tablaIndex.php");   
                }

                //MENÚ AVISOS
                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoAvisos") {
                    echo '<div class="card mb-3" style="max-width: 1800px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="imagenes/logo.png" style="max-width: 320px;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">';
                    //MOSTRAMOS LOS AVISOS
                    if($maxima >= 45) {
                        echo '<div class="alert alert-danger">AVISO: calor axfisiante. El centro permanecerá cerrado.</div>';
                    }
                    if ($viento >=103 && $viento <= 117) {
                        echo '<div class="alert alert-danger">AVISO: viento huracanado. El centro permanecerá cerrado.'
                            . '<br>Riesgo: Destrucción en todas partes, lluvias muy intensas, inundaciones muy altas.</div><br>';
                    }else if ($viento >= 118) {
                        echo '<div class="alert alert-danger">AVISO: viento huracanado. El centro permanecerá cerrado.'
                            . '<br>Riesgo: Voladura de autos, árboles, casas, techos y personas. Puede generar un huracán o un tifón.</div>';
                    }else {
                        echo '<div class="alert alert-success">No existen avisos. El centro permanecerá abierto.</div>';
                    }

                }


                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoMatricular") {
                    echo '<div class="card mb-3" style="max-width: 1800px;">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <img src="imagenes/logo.png" style="max-width: 370px;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">';
                    include("matricular.php");
                }

                if (isset($_GET["contenido"]) && $_GET["contenido"] == "listadoBaja") {
                    include("baja.php");
                }
                ?>           
            </section>
        </body>
    </html>
<?php include("desconectabd.php"); //Recomendación de Alejandro var_dump($_POST);       ?>
