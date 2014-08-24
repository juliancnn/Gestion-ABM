/********************************************************
 *
 *
 *  			Funciones de botones y automaticas
 *
 *********************************************************/
$(function() {
	inicio();
})
function inicio(){
	$("#btn_clear").click(limpiarFormulario);
	$("#btn_enviar").click(pideEnviarFormularioPersona);
	$("#matricula").blur(pideRellenarPersona);
}
var datosMateriasRellenas;
var paginaInicio;
/********************************************************
 *
 *
 *  			Formulario
 *
 *
 *********************************************************/

function limpiarFormulario() {
	alerta = false;
	$('#matricula').val("");
	$('#nombre').val("");
	$('#apellido').val("");
	$('#celular').val("");
	$('#email').val("");
	$('#listaMaterias').val("");
	$("*:checkbox").prop("checked", null);
	$("#resultado").removeClass('alert alert-success');
	$("#resultado").removeClass('alert alert-danger');
	$("#resultado").removeClass('show');
	$("#resultado").addClass('hide');

}

/********************************************************
 *
 *
 *  			Formulario Persona
 *
 *
 *********************************************************/
function pideRellenarPersona() {
	paginaInicio =  $('#contenedor_panel').html();
	var matricula = $('#matricula').val();
	$.ajax({
		dataType : "json",
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : 'consultaPerfil=consultaPerfil&matricula=' + matricula,
		success : rellenaPersona,
	});
}

function rellenaPersona(datos) {
	$('#nombre').val(datos[0].nombre);
	$('#apellido').val(datos[0].apellido);
	$('#email').val(datos[0].email);
	$('#celular').val(datos[0].celular);
	$('#carrera').val(datos[0].id_carrera);
	pideRellenarMaterias();
}

function pideEnviarFormularioPersona() {
	alerta = true;
	var datos = 'agregarPersona=agregarPersona' + "&matricula=" + $('#matricula').val() + "&nombre=" + $('#nombre').val() + "&apellido=" + $('#apellido').val() + "&celular=" + $('#celular').val() + "&carrera=" + $('#carrera').val() + "&email=" + $('#email').val();
	$.ajax({
		dataType : "json",
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : datos,
		success : enviaFormularioPersona,
	});
}

function enviaFormularioPersona(datos) {

	var res;

	if (datos == 'vacio') {
		$("#resultado").addClass('alert alert-danger');
		res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		res += '<strong>Error desconocido! (NO MYSQL)</strong> <br> Usuario no registrado.';
	} else if (datos[0].matricula == $('#matricula').val()) {
		$("#resultado").addClass('alert alert-success');
		res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		res += '<strong>Registrado!</strong> <br> Los cambios fueron registrados correctamente.';
		pideEnviarFormularioMateria();
	} else {
		$("#resultado").addClass('alert alert-danger');
		res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		res += '<strong>Error en la conexion mysql!</strong> <br> no se registro el usuario';
	}
	$('#resultado').empty();
	$('#resultado').append(res);
	$("#resultado").removeClass('hide');
	$("#resultado").addClass('show');

}

/********************************************************
 *
 *
 *  			Formulario Materias
 *
 *
 *********************************************************/
function pideRellenarMaterias() {
	var matricula = $('#matricula').val();
	$.ajax({
		dataType : "json",
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : 'rellenaMaterias=rellenaMaterias&matricula=' + matricula,
		success : rellenaMaterias,
	});
}

function rellenaMaterias(datos) {
	datosMateriasRellenas = datos;
	$("*:checkbox").prop("checked", null);

	for (var i = 0; i < datos.length; i++) {
		$("#mat_" + datos[i]['id']).prop("checked", "checked");
	}
}

function pideEnviarFormularioMateria() {
	var cantidad = $("*:checkbox").length;
	var check = [];
	var check_nombres = [];
	for (var i = 0; i < cantidad; i++) {
		if ($("*:checkbox")[i]["checked"]) {
			check[check.length] = $("*:checkbox")[i]["value"];
			check_nombres[check_nombres.length] = $('#mat_' + check[check.length - 1]).attr("nombre");
		}
	}
	//datos += "check="+JSON.stringify(check);
	generaHTMLpaso2($('#matricula').val(), $('#nombre').val() + " " + $('#apellido').val(), check, check_nombres);

}

/********************************************************
 *
 *
 *  			Nuevo formulario
 *
 *
 *********************************************************/

function generaHTMLpaso2(matricula, nombre, check, check_nombres) {
	var nuevoForm = "";
	$('#contenedor_panel').empty();

	nuevoForm += '<form class="form-inline" role="form" id=' + matricula + '> <input type="text" class="form-control" value="' + nombre + '" disabled> </br>';
	/*Genero form*/
	if (check.length == 0)
		console.log("vacio");
	else {
		for (var i = 0; i < check.length; i++) {
			nuevoForm += '<p></br><strong>' + check_nombres[i] + ' </strong>';
			nuevoForm += '<input type="hidden" name="materia" value=' + check[i] + '>';
			nuevoForm += '</br><label><small>Precio: (solo numero)</small></label></br><input type="text" class="form-control" id="precio_id_' + check[i] + '">'
			nuevoForm += '</br><label><small>Comentarios: </small></label></br><textarea id="comentario_id_' + check[i] + '" class="form-control" rows="5" mat=' + check[i] + '></textarea>'
			nuevoForm += '</p>';

		}
	}
	/*Cierro form form*/
	nuevoForm += '</form>';
	nuevoForm += '<button type="button" class="btn btn-primary" id="btn_actulizar"><span class="glyphicon glyphicon-flash"></span> Actualizar</button>';
	$('#contenedor_panel').html(nuevoForm);

	/*Relleno el form*/
	for (var i = 0; i < datosMateriasRellenas.length; i++) {
		$("#precio_id_" + datosMateriasRellenas[i]['id']).prop("value", datosMateriasRellenas[i]['precio']);
		$("#comentario_id_" + datosMateriasRellenas[i]['id']).prop("value", datosMateriasRellenas[i]['comentario']);
	}

	$("#btn_actulizar").click(pideActualizarBolza);

}

/********************************************************
 *
 *
 *  			Actualizar la boza y bolver atras
 *
 *
 *********************************************************/

function pideActualizarBolza() {
	var matricula = $("form").attr("id");
	var inputs = $(":input");
	var bolza = new Array();
	for (var i = 1; i < inputs.length - 1; i++) {
		var materia = new Array();
		materia.push(inputs[i].value);
		materia.push(inputs[++i].value);
		materia.push(inputs[++i].value);
		bolza.push(materia)

	}
	var json_datos = JSON.stringify(bolza);
	$.ajax({
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : 'bolzaUpdate=bolzaUpdate&matricula=' + matricula + "&datos=" + json_datos,
		success : actualizaBolza,
	});

}

function actualizaBolza(datos) {
	
	$('#contenedor_panel').empty();
	var msj = '<div class="alert alert-info">  <button type="button" class="close" data-dismiss="alert">&times;</button>Verificar que se haya modificado modificado en el perfil del usuario</div>'+paginaInicio;
	$('#contenedor_panel').html(msj);
   	inicio();

	return;
}
