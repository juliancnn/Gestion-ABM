
/***************************************************************
 * 
 *
 * 					Funcion de Botones
 * 
 * 
***************************************************************/
$(function(){
	$("#btn_clear").click(limpiarFormulario);
	$("#btn_verificar").click(verificacion);
	$("#btn_enviar").click(primerPaso);
})


/***************************************************************
 * 
 *
 * 					Verificacion de datos
 * 
 * 
***************************************************************/
function verificacion(){
	

	var matricula = $('#matricula').val();
	var id_apunte = $('#id_apunte').val();
	$('#alertaApunte').empty();
	$('#campo_apunte_id').removeClass("has-error has-warning has-success");
	
	
	$('#alertaPersona').removeClass('show');
	$('#alertaPersona').addClass("hide");
	$('#campo_persona').removeClass("has-warning");
	$("#resultado").removeClass('alert alert-success show');
	$("#resultado").addClass('hide');

	$.ajax({
		dataType: "json",
		url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
		type: 'POST',
		async: true,
		data: 'apuntecaVerificaDatos=apuntecaVerificaDatos&matricula='+matricula+'&id_apunte='+id_apunte,
		success: compruebaExistencia,
	});
	
}

function compruebaExistencia(datos){
	



	if(datos[1].length < 1 ){
		$('#campo_apunte_id').addClass("has-error");
		$('#alertaApunte').html('<div class="alert alert-danger">No existe un apunte con ese id</div>');
		return;
	}
	else if(datos[1][0].estado_id==0){
		$('#campo_apunte_id').addClass("has-success");
		$('#alertaApunte').html('<div class="alert alert-success">Apunte disponible</div>');
	}
	else if(datos[1][0].estado_id==1){
		$('#campo_apunte_id').addClass("has-warning");
		$('#alertaApunte').html('<div class="alert alert-warning">El apunte tiene una reserva, mas detalles en:</br> [link a apunte perfil]"</div>');
		return;
	}
	else if(datos[1][0].estado_id==2){
		$('#campo_apunte_id').addClass("has-warning");
		$('#alertaApunte').html('<div class="alert alert-danger">El apunte esta prestado,</br><strong><a href="apunteca_registro.php?&id_apunte='+datos[1][0].id+'" target="_blank">Ver mas detalles</a></strong></div>');
	
		return;
	}

	console.log(datos[0])
	if (datos[0]=='vacio'){
		$('#campo_persona').addClass("has-info");
		$('#alertaPersona').removeClass('hide');
		$('#alertaPersona').addClass("show");
		$('#alertaPersona').empty();
		$('#alertaPersona').append("No esta registrado, pero podes llenar todos los datos y registrar ahora");
	}
	rellena(datos);
}
/***************************************************************
 * 
 *
 * 					Funciones de formulario
 * 
 * 
***************************************************************/

function rellena(datos){
	$('#nombre_apunte').val(datos[1][0].nombre);
	$("#matricula").attr('disabled','disabled');
	$('#nombre').val(datos[0][0].nombre);
	$('#apellido').val(datos[0][0].apellido);
	$('#email').val(datos[0][0].email);
	$('#celular').val(datos[0][0].celular);
	$('#carrera').val(datos[0][0].id_carrera);
	$("#id_apunte").attr('disabled','disabled');
	
	$("#nombre_apunte_campo").removeClass('hide');
	$("#nombre_apunte_campo").addClass('show');
	
	$("#nombre_campo").removeClass('hide');
	$("#nombre_campo").addClass('show');
	
	$("#apellido_campo").removeClass('hide');
	$("#apellido_campo").addClass('show');
	
	$("#email_campo").removeClass('hide');
	$("#email_campo").addClass('show');
	
	$("#celular_campo").removeClass('hide');
	$("#celular_campo").addClass('show');
	
	$("#carrera_campo").removeClass('hide');
	$("#carrera_campo").addClass('show');
	
	$("#comentario_campo").removeClass('hide');
	$("#comentario_campo").addClass('show');
	
	$("#btn_clear").removeClass('hide');
	$("#btn_clear").addClass('show');
	
	$("#btn_enviar").removeClass('hide');
	$("#btn_enviar").addClass('show');
	
	$("#btn_verificar").removeClass('show');
	$("#btn_verificar").addClass('hide');
}
function limpiarFormulario(){
	$('#campo_apunte_id').removeClass("has-error has-warning has-success")
	$('#alertaApunte').empty();
	$('#id_apunte').val("");
	$('#nombre_apunte').val("");
	$('#matricula').val("");
	$("#matricula").removeAttr('disabled');
	$("#id_apunte").removeAttr('disabled');
	$('#nombre').val("");
	$('#apellido').val("");
	$('#email').val("");
	$('#celular').val("");
	$('#carrera').val("");
	$('#comentario').val("");
	
	$("#comentario_campo").removeClass('show');
	$("#comentario_campo").addClass('hide');
	$("#nombre_apunte_campo").removeClass('show');
	$("#nombre_apunte_campo").addClass('hide');
	$("#nombre_campo").removeClass('show');
	$("#nombre_campo").addClass('hide');
	$("#apellido_campo").removeClass('show');
	$("#apellido_campo").addClass('hide');
	$("#email_campo").removeClass('show');
	$("#email_campo").addClass('hide');
	$("#celular_campo").removeClass('show');
	$("#celular_campo").addClass('hide');
	$("#carrera_campo").removeClass('show');
	$("#carrera_campo").addClass('hide');
	$("#btn_clear").removeClass('show');
	$("#btn_clear").addClass('hide');
	$("#btn_verificar").removeClass('hide');
	$("#btn_verificar").addClass('show');
	$("#btn_enviar").removeClass('show');
	$("#btn_enviar").addClass('hide');
	$('#alertaPersona').removeClass('show');
	$('#alertaPersona').addClass("hide");
	$('#campo_persona').removeClass("has-warning");
}

/***************************************************************
 * 
 *
 * 					Funcion de agregar regtros
 * 
 * 
***************************************************************/

function primerPaso(){

	
	/* Primero actualiza el formlario de la persona */
	var datos = 'agregarPersona=agregarPersona'+
				"&matricula="+$('#matricula').val()+
				"&nombre="+$('#nombre').val()+
				"&apellido="+$('#apellido').val()+
				"&celular="+$('#celular').val()+
				"&carrera="+$('#carrera').val()+
				"&email="+$('#email').val();
		$.ajax({
				dataType: "json",
				url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
				type: 'POST',
				async: true,
				data: datos,
				success: segundoPaso,
	});
}

function segundoPaso(datos){
	
	 if (!(datos[0].matricula==$('#matricula').val())){
	 	alert('Error no se registraron los cambios de la persona ni del retiro del apunte');
	 	return;
	}
	
	datos = 'apuntecaRetiro=apuntecaRetiro'+
				"&matricula="+$('#matricula').val()+
				"&comentario="+$('#comentario').val()+
				"&id_apunte="+$('#id_apunte').val();
				
	$.ajax({
		dataType: "json",
		url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
		type: 'POST',
		async: true,
		data: datos,
		success: tercerPaso,
	});
	
}

function tercerPaso(datos){
	$('#resultado').empty();
	limpiarFormulario();
	$("#resultado").addClass('alert alert-success show');
	res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
	res += '<strong>Registrado!</strong> <br> Los cambios fueron registrados correctamente.';		
	$('#resultado').append(res);
}




