/*Funcion del boton Loggin*/
$(function(){
	$("#btn_iniciar").click(function(){
		$("#resultado").removeClass('show');
		$("#resultado").addClass('hide');
		$.ajax({
			dataType: "json",
			url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
			type: 'POST',
			async: true,
			data: '&dni='+$("#usuario").val()+'&pass='+$("#password").val()+'&iniciarsesion=iniciarsesion',
			success: precesaLogin,
		});
	});
})


//Identifica el lloggin y acciona
function precesaLogin(datos){
	if(datos==1){
		window.location="index.php";
	}else{
		$("#resultado").removeClass('hide');
		$("#resultado").addClass('show');

	}
}
