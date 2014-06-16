/*Funcion del boton Loggin*/
$(function(){
	$("#btn_enviar").click(function(){
		$("#resultado").removeClass('show');
		$("#resultado").addClass('hide');
		
		var datos = 'numero='+$("#numero").val()+'&estante='+$("#estante").val()+'&nombre='+$("#nombre").val()+'&lugar='+$("#lugar").val()+'&apuntecaAgregar=apuntecaAgregar';
		$.ajax({
			url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
			type: 'POST',
			async: true,
			data: datos,
			success: agregoApunte,
		});
	});
})


//Identifica el lloggin y acciona
function agregoApunte(datos){
	
	console.log(Number(datos));
	var res;
	if(!isNaN(Number(datos))){
			$("#resultado").removeClass('alert alert-danger');
		    res ='<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		    res += 'Apunte agregado correctamente con id: <strong>'+datos+'</strong>';
            $("#resultado").addClass('alert alert-success');
	}else{
			$("#resultado").removeClass('alert alert-success');
			res ='<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
		    res += '<strong>Error en registrar los cambios:</br></strong>'+datos;
            $("#resultado").addClass('alert alert-danger');
	}
	
	$('#resultado').empty();
	$('#resultado').append(res);
	$("#resultado").removeClass('hide');
	$("#resultado").addClass('show');
}

$(function(){
	$("#btn_clear").click(limpiarFormulario);
})

function limpiarFormulario(){
	$('#numero').val("");
	$('#estante').val("");
	$('#nombre').val("");
	$('#lugar').val("");
	$("#resultado").removeClass('alert alert-danger');
	$("#resultado").removeClass('alert alert-success');
	$("#resultado").removeClass('show');
	$("#resultado").addClass('hide');

}