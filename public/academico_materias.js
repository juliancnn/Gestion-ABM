/********************************************************
 *
 *
 *  			Funciones de botones
 *
 *
 *********************************************************/

$(function() {
	$("#btn_buscar").click(buscarMateria);
	buscarMateria();
})

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
		url : '../librerias/formulariosajax.php?nocache=' + Math.random(),
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
	var name = btn.getAttribute("nombre_materia");
	var	infoHTML = "";

	infoHTML += '<h2>'+name+' <small>('+i+')</small></h2><br />';
	infoHTML += '<p>Pedi mas datos en el Centro de estudiantes</br></p><p id="listaBolsa"></p>';
	bootbox.alert(infoHTML);

	$.ajax({
		dataType : "json",
		url : '../librerias/formulariosajax.php?nocache=' + Math.random(),
		type : 'POST',
		async : true,
		data : "AcademicoMateriaBolsa=AcademicoMateriaBolsa&materia=" + i,
		success : rellenaVerInfo,
	});
	

}

function rellenaVerInfo(datos){
	
	if(datos.length==0){
		$('#listaBolsa').append("Vacio");
		return;
	}
	
	var table = '<table class="table table-hover">';
	table += '<thead><tr>';
	table += '<th>Nombre</th>';
	table += '<th>Precio</th>';
	table += '<th>comentarios</th>';
	table += '<th>email</th>';
	table += '</tr></thead>';
	
	for (var i = 0; i < datos.length; i++) {
		table += '<tbody><tr>';
		table += '<td>'+datos[i]['apellido']+', '+datos[i]['nombre']+'</td>';
		table += '<td>'+datos[i]['precio']+'</td>';
		table += '<td>'+datos[i]['comentario']+'</td>';
		table += '<td>'+datos[i]['email']+'</td>';
		table += '</tr><tbody>';
		
	}
	$('#listaBolsa').append(table);

}


