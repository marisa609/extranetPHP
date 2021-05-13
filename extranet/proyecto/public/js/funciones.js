//Esta clase contiene todo el código jquery

//Esta función se encarga de recoger los valores del modal añadir para poder enviarlos con $ajax
function agregardatos(curso, asignatura, alumno, profesor, trimestre, nota){
	//Contiene la cadena que vamos a enviar
	cadena = "curso=" + curso + "&asignatura=" + asignatura + "&alumno=" + alumno + "&profesor=" + profesor + "&trimestre=" + trimestre + "&nota=" + nota;
	$.ajax({
		type:"POST",
		url:"php/agregarDatos.php",
		data:cadena,
		success:function(r){
			//Si existe un resultado significa que la tabla se ha insertado
			if(r==1){
				//cargamos la tabla de forma asíncrona
				$('#tabla').load('componentes/tabla.php');
				alertify.success("Insertado con éxito");
			}else{
				alertify.error("Fallo en el servidor");
			}
		}
	});

}

//Función encargada de mostrar los datos de la tabla en el modal editar
function agregaform(datosEdit){
	//Obtenemos los datos separados por el separador
	datos = datosEdit.split('||');
	//Según el id del input del módal añadimos la posición que tiene en el array
	$('#cursoE').val(datos[0]);
	$('#asignaturaE').val(datos[1]);
	$('#alumE').val(datos[2]);
	$('#profesorE').val(datos[3]);
	$('#trimestreE').val(datos[4]);
	$('#notaE').val(datos[5]);
	//Estos son los id para poder realizar el UPDATE
	$('#cursoID').val(datos[6]);
	$('#asignaturaID').val(datos[7]);
	$('#alumnoID').val(datos[8]);
	$('#profesorID').val(datos[9]);
	
}

//Esta función se encarga de recoger los datos del modal editar y de enviarlos con $ajax.
function actualizaDatos(){
	//Recogemos los datos del modal editar
	curso = $('#cursoE').val();
	asignatura = $('#asignaturaE').val();
	alumno = $('#alumE').val();
	profesor = $('#profesorE').val();
	trimestre = $('#trimestreE').val();
	nota = $('#notaE').val();
	//Estos vienen de input ocultos
	cursoID = $('#cursoID').val();
	asignaturaID = $('#asignaturaID').val();
	alumnoID = $('#alumnoID').val();
	profesorID = $('#profesorID').val();
	//Creamos la cadena que queremos enviar
	cadena = "curso=" + curso + "&asignatura=" + asignatura + "&alumno=" + alumno + "&profesor=" + profesor + "&trimestre=" + trimestre + "&nota=" + nota + "&cursoID=" + cursoID + "&asignaturaID=" + asignaturaID + "&alumnoID=" + alumnoID + "&profesorID=" + profesorID;
	$.ajax({
		type:"POST",
		url:"php/actualizaDatos.php",
		data:cadena,
		success:function(r){
			//Si el resultado es mayor que 0, se habrá realizado el editar
			if(r>0){
				$('#tabla').load('componentes/tabla.php');
				alertify.success("Editado con éxito");
			}else{
				alertify.error("Fallo en el servidor");
			}
		}
	});
}


