$(function(){
	$("#btn_buscar").click(function(){	
		var datos = 'busquedaPersona=busquedaPersona'+
				"&matricula="+$('#matricula').val()+
				"&nombre="+$('#nombre').val()+
				"&apellido="+$('#apellido').val();
			$.ajax({
				dataType: "json",
				url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
				type: 'POST',
				async: true,
				data: datos,
				success: enviaBusqueda,
		});
		
	});
})

function enviaBusqueda(datos){
	var tabla;
	$("#listaResultado").empty();

	if(datos=="vacio"){
		$("#listaResultado").html("La busqueda no produjo resultados");		
		return;
	}
	
	$("#listaResultado").empty();
	tabla = '<table class="table table-hover">  ';
	tabla += '<thead>';
	tabla += '<tr>';
	tabla += '<td>#</td>';
	tabla += '<td>Matricula</td>';
	tabla += '<td>Apellido</td>';
	tabla += '<td>Nombre</td>';
	tabla += '<td>Email</td>';
	tabla += '<td>Celular</td>';
	tabla += '<td>Carrera</td>';
	tabla += '</tr>';
	tabla += '</thead><tbody>';
	
	for(var i=0;i<datos.length;i++){
		
		tabla += '<tr>';
		tabla += '<td>'+(i+1)+'</td>';
		
		tabla += '<td><strong><a href="persona_perfil.php?&matricula='+datos[i]['matricula']+'" target="_blank">'+datos[i]['matricula']+'</a></td>';
		tabla += '<td>'+datos[i]['apellido']+'</td>';
		tabla += '<td>'+datos[i]['nombre']+'</td>';
		tabla += '<td>'+datos[i]['email']+'</td>';
		tabla += '<td>'+datos[i]['celular']+'</td>';
		tabla += '<td>'+datos[i]['carrera']+'</td>';
		tabla += '</tr>';

	}
	
	$("#listaResultado").append(tabla);		
	$("#listaResultado").append("  </tbody> </table>");	
}

function limpiar(){
	alerta = false;
	$('#matricula').val("");
	$('#nombre').val("");
	$('#apellido').val("");
	$('#listaResultado').empty();
}

$(function(){
	$("#btn_clear").click(limpiar);
})