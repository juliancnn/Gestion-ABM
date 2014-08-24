/***************************************************************
 * 
 *
 * 					Info de Botones Menu
 * 
 * 
***************************************************************/
var arrayMenu = new Array();

var btninfo; // Info con la carga actual
var cargas; //Contador de cargas
var cargando = false;

arrayMenu.push(['btn_personas_agregar', "personas_update.php","personas_update.js"]);
arrayMenu.push(['btn_personas_buscar', "personas_buscar.php","personas_buscar.js"]);
arrayMenu.push(['btn_personas_lista', "personas_lista.php"]);

arrayMenu.push(['btn_apunteca_buscar', "apunteca_buscar.php","apunteca_buscar.js", "librerias/bootbox.min.js"]);
arrayMenu.push(['btn_apunteca_retirar', "apunteca_retirar.php","apunteca_retirar.js"]);
arrayMenu.push(['btn_apunteca_agregar', "apunteca_agregar.php","apunteca_agregar.js"]);
arrayMenu.push(['btn_apunteca_editar', "apunteca_editar.php","apunteca_editar.js"]);
arrayMenu.push(['btn_apunteca_noDev', "apunteca_buscar_registro.php", "librerias/jquery-ui-1.10.4.calendario.js", "apunteca_buscar_registro.js"]);
arrayMenu.push(['btn_apunteca_reg', "apunteca_registro.php"]);

arrayMenu.push(['btn_academico_materia', "academico_materias.php","academico_materias.js"]);
arrayMenu.push(['btn_academico_bolsa', "academico_bolsa_update.php","academico_bolsa_update.js"]);
arrayMenu.push(['btn_academico_consulta', "academico_personasConsulta_update.php","academico_personasConsulta_update.js"]);

/***************************************************************
 * 
 *
 * 				Funcion de Botones Menu
 * 
 * 
***************************************************************/
$(function(){
	
	for(var i=0;i<arrayMenu.length;i++){
			$('#'+arrayMenu[i][0]).click(cargarContenidoUno);
	}
	
	
});

/***************************************************************
 * 
 *
 *				Funciones de carga de contenido
 * 
 * 
***************************************************************/
function cargarContenidoUno(){
	$(this).parent().parent().parent().parent().find( "li" ).removeClass('active');
	$(this).parent().parent().parent().addClass('active');
	var btnName = $(this).attr("id"); 
	cargas = 0;
	cargaToggle();

	for(i=0;i<arrayMenu.length;i++){
		if(arrayMenu[i][0]==btnName){
			btninfo = arrayMenu[i];
			break;
		}
	}
	$("#contenedorPrincipal").load(btninfo[1]+'?nocache='+ Math.random()+' #contenido', Math.random(), cargarContenidoDos);

}

function cargarContenidoDos(data){
	
	if(cargas+2==btninfo.length){
		cargaToggle();
		return;
	}else{
		cargas++;
	}
	$.ajax({
	  url: btninfo[cargas+1],
	  dataType: "script",
	  success: cargarContenidoDos
	});

	
}

function cargaToggle(){
	
	if(cargando){
		$("#cargandiDIV").remove();
		$("#contenedorPrincipal").removeClass('hide');
		$("#contenedorPrincipal").addClass('show');
		
	}else{
		generateCoverDiv('cargandiDIV','#000000', 50);
		$("#cargandiDIV").html('<h1> Cargando...</h1>');
		$("#contenedorPrincipal").removeClass('hide');
		$("#contenedorPrincipal").addClass('show');
	}
	cargando = !cargando;
	
	
}

function generateCoverDiv(id, color, opacity){
	var navegador=1;
	if(navigator.userAgent.indexOf("MSIE")>0) navegador=0;

   
    var layer=document.createElement('div');
    layer.id=id;
    layer.style.width="100%";
	layer.style.height="100%";
    layer.style.backgroundColor=color;
    layer.style.position='absolute';
    layer.style.top=0;
    layer.style.left=0;
    layer.style.zIndex=100;
    if(navegador==0) layer.style.filter='alpha(opacity='+opacity+')';
    else layer.style.opacity=opacity/100;
   
    document.body.appendChild(layer);
}
