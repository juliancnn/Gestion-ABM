/********************************************************
 * 
 * 
 *  			Funciones de botones
 *  
 *  
 *********************************************************/
$(function(){
	$("#btn_verificar").click(verificaUno);
	$("#btn_enviar").click(editaUno);
	$("#btn_clear").click(limpiarFormulario);
})


/********************************************************
 * 
 * 
 *  			Verificacion de datos
 *  
 *  
 *********************************************************/
//---------------------------
//	Verifica los datos
//---------------------------
function verificaUno(){
	var datos = 'busquedaApunte=busquedaApunte'+
				"&id="+$("#id").val();
	$("#resultado").removeClass('alert-danger alert-success');
	$.ajax({
		dataType: "json",
		url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
		type: 'POST',
		async: true,
		data: datos,
		success: verificaDos,
	});
}

function verificaDos(datos){
	$("#resultado").empty();
	
	if(datos["cantidad"]==0){		
			$("#resultado").removeClass('hide');
			$("#resultado").html('No existe un apunte con el id <strong>'+$("#id").val()+'</strong>');
            $("#resultado").addClass('show alert-danger');
	}else if(datos["cantidad"]==1){
		$("#detalle_apunte_campo").removeClass('hide');
		$("#detalle_apunte_campo").addClass('show');
		$('#id').attr('disabled','disabled');
		$('#numero').val(datos['datos'][0]['numero']);
		$('#estante').val(datos['datos'][0]['estante']);
		$('#nombre').val(datos['datos'][0]['nombre']);
		$('#lugar').val(datos['datos'][0]['id_lugar']);

		$("#btn_verificar").removeClass('show');
		$("#btn_verificar").addClass('hide');
		$("#btn_enviar").removeClass('hide');
		$("#btn_enviar").addClass('show');
		$("#btn_clear").removeClass('hide');
		$("#btn_clear").addClass('show');
	}
	
}

function limpiarFormulario(){
	$('#id').removeAttr('disabled');
	$('#id').val("");
	$('#numero').val("");
	$('#estante').val("");
	$('#nombre').val("");
	$('#lugar').val("");
	$("#resultado").empty();
	$("#resultado").removeClass('alert-danger alert-success');
	$("#resultado").removeClass('show');
	$("#resultado").addClass('hide');
	$("#detalle_apunte_campo").removeClass('show');
	$("#detalle_apunte_campo").addClass('hide');
	$("#btn_verificar").removeClass('hide');
	$("#btn_verificar").addClass('show');
	$("#btn_enviar").removeClass('show');
	$("#btn_enviar").addClass('hide');
	$("#btn_clear").removeClass('show');
	$("#btn_clear").addClass('hide');
}

//---------------------------
//	Edita el apunte
//---------------------------
function editaUno(){
	var datos = 'apuntecaEditar=apuntecaEditar'+
				"&id="+$("#id").val()+
				"&numero="+$("#numero").val()+
				"&estante="+$("#estante").val()+
				"&nombre="+$("#nombre").val()+
				"&lugar="+$("#lugar").val();
	$.ajax({
		url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
		type: 'POST',
		async: true,
		data: datos,
		success: editaDos,
	});
}

function editaDos(datos){
	limpiarFormulario();
	$("#resultado").removeClass('hide');
	$("#resultado").html('Apunte editado correctamente');
	$("#resultado").addClass('show alert-success');
	
}
