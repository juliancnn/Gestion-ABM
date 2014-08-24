/********************************************************
 *
 *
 *  			Funciones de botones
 *
 *
 *********************************************************/
var tmp; //Arreglar el chanchullo este del tmp, meterlo en la consulta
$(function() {
	$("#btn_agregar").click(agregarMateria);
	$("#btn_buscar").click(buscarMateria);
	buscarMateria();
})
/********************************************************
 *
 *
 *  			Agregar materias
 *
 *
 *********************************************************/

function agregarMateria() {
	$("#resultado").removeClass();
	$("#resultado").addClass('hide');
	buscarMateria();

	$.ajax({
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : 'materiaAgregar=materiaAgregar&materia=' + $("#materia").val(),
		success : agregoMateria,
	});
}

function agregoMateria(datos) {
	$('#resultado').empty();
	$("#resultado").removeClass();
	$("#resultado").addClass('show');

	if (!isNaN(Number(datos))) {
		res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		res += 'Materia agregada agregado correctamente con id: <strong>' + datos + '</strong>';
		$("#resultado").addClass('alert alert-success');
		var temp = '<tr class="success">';
		temp += '<td>' + datos + '</td>';
		temp += '<td>' + $("#materia").val() + '</td>';
		temp += '<td align="right"><button class="btn btn-info" align="right"><span class="glyphicon glyphicon-plus"></span> info</button></td>';
		temp += '</tr>';
		$('#listaMaterias').append(temp);
	} else {
		res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		res += '<strong>Error en registrar los cambios:</br></strong>' + datos;
		$("#resultado").addClass('alert alert-danger');
	}

	$('#resultado').append(res);

}

/********************************************************
 *
 *
 *  			Busqueda de materias
 *
 *
 *********************************************************/

function buscarMateria() {
	$.ajax({
		dataType : "json",
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : "listarMateria=listarMateria&materia=" + $("#materia").val(),
		success : cargaLista,
	});
}

function cargaLista(datos) {
	var tabla = "";
	$('#listaMaterias').empty();
	for (var i = 0; i < datos.length; i++) {
		tabla += '<tr><td>' + datos[i]['id'] + '</td>';
		tabla += '<td>' + datos[i]['materia'] + '</td>';
		tabla += '<td align="right"><button class="btn btn-info" align="right" id_materia=' + datos[i]['id'] + ' nombre_materia=' + datos[i]['materia'] + ' id="btn_info_' + datos[i]['id'] + '"><span class="glyphicon glyphicon-plus"></span> info</button></td></tr>';
	}
	$('#listaMaterias').append(tabla);

	for (var i = 0; i < datos.length; i++) {
		$("#btn_info_" + datos[i]['id']).click(verInfo);
	}
}

/********************************************************
 *
 *
 *  			Busqueda de materias
 *
 *
 *********************************************************/
function verInfo() {
	var btn = $(this)[0];
	var i = btn.getAttribute("id_materia");
	tmp = i;
	var name = btn.getAttribute("nombre_materia");
	var infoHTML = "";

	infoHTML += '<h2>' + name + ' <small>(' + i + ')</small></h2><br />';
	infoHTML += '<p id="listaBolsa"></p>';
	infoHTML += '<p id="listaConsulta"></p>';

	bootbox.alert(infoHTML);

	$.ajax({
		dataType : "json",
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : "AcademicoMateriaBolsa=AcademicoMateriaBolsa&materia=" + i,
		success : rellenaVerInfoBolsa,
	});

}

function rellenaVerInfoBolsa(datos) {
	var table;
	if (datos.length == 0) {
		$('#listaBolsa').append("</br>Bolsa de trabajo vacia</br>");

	} else {

		table = '</br>Bolsa de trabajo</br><table class="table table-hover">';
		table += '<thead><tr>';
		table += '<th>Nombre</th>';
		table += '<th>Precio</th>';
		table += '<th>observaciones</th>';
		table += '<th>+Info</th>';
		table += '</tr></thead>';

		for (var i = 0; i < datos.length; i++) {
			table += '<tbody><tr>';
			table += '<td>' + datos[i]['apellido'] + ', ' + datos[i]['nombre'] + '</td>';
			table += '<td>' + datos[i]['precio'] + '</td>';
			table += '<td>' + datos[i]['comentario'] + '</td>';
			table += '<td><a href="persona_perfil.php?matricula=' + datos[i]['dni'] + '" target="_blank">Perfil</a></td>';
			table += '</tr><tbody>';
		}
		table += '</table>';
	}

	$('#listaBolsa').append(table);
	
	$.ajax({
		dataType : "json",
		url : 'librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : "AcademicoMateriaConsulta=AcademicoMateriaConsulta&materia=" + tmp,
		success : rellenaVerInfoConsulta,
	});

	

}

function rellenaVerInfoConsulta(datos) {
	var table = "";
	 
	if (datos.length == 0) {
		return;

	} else {

		table = '</br>Nos ayuda con consulta</br><table class="table table-hover">';
		table += '<thead><tr>';
		table += '<th>Nombre</th>';
		table += '<th>observaciones</th>';
		table += '<th>+Info</th>';
		table += '</tr></thead>';

		for (var i = 0; i < datos.length; i++) {
			table += '<tbody><tr>';
			table += '<td>' + datos[i]['apellido'] + ', ' + datos[i]['nombre'] + '</td>';
			table += '<td>' + datos[i]['comentario'] + '</td>';
			table += '<td><a href="persona_perfil.php?matricula=' + datos[i]['dni'] + '" target="_blank">Perfil</a></td>';
			table += '</tr><tbody>';
		}
		table += '</table>';
	}

	$('#listaConsulta').append(table);

}