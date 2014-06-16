var alerta = false; //Muestra el cartel de alerta

$(function(){
	$("#matricula").blur(function(){		 
		var matricula = $('#matricula').val();
		$.ajax({
			dataType: "json",
			url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
			type: 'POST',
			async: true,
			data: 'consultaPerfil=consultaPerfil&matricula='+matricula,
			success: rellena,
		});
	});
})


function rellena(datos){
	$('#nombre').val(datos[0].nombre);
	$('#apellido').val(datos[0].apellido);
	$('#email').val(datos[0].email);
	$('#celular').val(datos[0].celular);
	$('#carrera').val(datos[0].id_carrera);
	$('#btn_enviar').empty();
	$('#btn_enviar').append("Actualizar");

}


$(function(){
	$("#btn_enviar").click(function(){	
		alerta = true;
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
				success: enviaFormulario,
		});
	});
})

$(function(){
	$("#btn_clear").click(limpiarFormulario);
})

function enviaFormulario(datos){
		
		var res;
		
		if(datos=='vacio'){
			$("#resultado").addClass('alert alert-danger');
			res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
			res += '<strong>Error desconocido! (NO MYSQL)</strong> <br> Usuario no registrado.';
		}else if (datos[0].matricula==$('#matricula').val()){
			$("#resultado").addClass('alert alert-success');
			res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
			res += '<strong>Registrado!</strong> <br> Los cambios fueron registrados correctamente.';
		}else{
			$("#resultado").addClass('alert alert-danger');
			res = '<button type="button" class="close formulario" data-dismiss="alert">&times;</button>';
			res += '<strong>Error en la conexion mysql!</strong> <br> no se registro el usuario';
		}
		$('#resultado').empty();
		$('#resultado').append(res);
		$("#resultado").removeClass('hide');
		$("#resultado").addClass('show');
		console.log(datos);
		
}	

function limpiarFormulario(){
	alerta = false;
	$('#matricula').val("");
	$('#nombre').val("");
	$('#apellido').val("");
	$('#celular').val("");
	$('#email').val("");
	$("#resultado").removeClass('alert alert-success');
	$("#resultado").removeClass('alert alert-danger');
	$("#resultado").removeClass('show');
	$("#resultado").addClass('hide');
	$('#btn_enviar').empty();
	$('#btn_enviar').append("Registrar");
	
	
}