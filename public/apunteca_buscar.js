/********************************************************
 * 
 * 
 *  			Funciones de botones
 *  
 *  
 *********************************************************/
var cantidadpagina;
var paginaActual;
var pullDatosBusqueda;
var pullDeResultados;

$(function(){
	$("#btn_clear").click(limpiar);
	$("#btn_buscar").click(buscar);
	$("#cantidadpp").val(25)
	buscar();
})

/***************************************************************
 * 
 *
 * 					Funciones de obtener resultados
 * 
 * 
***************************************************************/

//---------------------------
//	Arma la busqueda
//---------------------------
function buscar(){
	
	cantidadpagina = $("#cantidadpp").val();
	
	paginaActual = 0;
	pullDatosBusqueda = new Array();
	pullDatosBusqueda['id_libro'] = $('#id_libro').val();
	pullDatosBusqueda['estante'] = $('#estante').val();
	pullDatosBusqueda['numero'] = $('#numero').val();
	pullDatosBusqueda['nombre'] = $('#nombre').val();
	
	pideDatos(0);
	
}
//---------------------------
//	Pide los datos
//---------------------------
function pideDatos(paginaNueva){
		paginaActual = paginaNueva;

		var datos = '&busquedaApunte=busquedaApunte'+
				"&id="+pullDatosBusqueda['id_libro']+
				"&estante="+pullDatosBusqueda['estante']+
				"&nombre="+pullDatosBusqueda['nombre']+
				"&cantidadpagina="+cantidadpagina+
				"&pagina="+paginaActual+
				"&numero="+pullDatosBusqueda['numero'];
			$.ajax({
				dataType: "json",
				url: '../librerias/formulariosajax.php?nocache='+ Math.random(),
				type: 'POST',
				async: true,
				data: datos,
				success: cargaDatos,
		});
}
		



//---------------------------
//	Carga todos los datos y arma el resultado
//---------------------------

function cargaDatos(datosCompuestos){
	var datos = datosCompuestos['datos'];
	pullDeResultados = datos;
	var tabla = "";	
	var paginasTotales = datosCompuestos['cantidad'] / cantidadpagina;
	var pullBtn = new Array();
	
	if(datosCompuestos['cantidad'] % cantidadpagina !=0)
		paginasTotales = Math.floor(paginasTotales+1);

	
	
	$("#listaResultado").empty();
	//Agrego el indice de paginas si es necesario
	if(paginasTotales>1){
		
		var cantidadVisibles = 5;
		var i=0;
		var j = paginaActual - Math.floor(cantidadVisibles/2);
				
		tabla += '<ul class="pagination">';
		if(paginaActual!=0)
			tabla += '<li id="btn_pag_atras"><a href="#">&laquo;</a></li>';

		while( (i<cantidadVisibles) && j< paginasTotales){
 			if(j>=0){
 				tabla += '<li id="btn_pag_'+j+'" pag='+j+'><a href="#">'+(j+1)+'</a></li>';
 				pullBtn[i] = ['#btn_pag_'+j,j]; //Nombre y pagina a la que lleva
				i++;
 			}else
 				j=-1;
 			j++;
 		}
 		
  		if(paginaActual+1<paginasTotales)
			tabla += '<li id="btn_pag_adelante"><a href="#">&raquo;</a></li>';
			
		tabla += '</ul>'; 
		
	}
	
	//Agrego la tabla con los resultados
	tabla += '<table class="table table-hover">  ';
	tabla += '<thead>';
	tabla += '<tr>';
	tabla += '<td>id </td>';
	tabla += '<td>Estante </td>';
	tabla += '<td>Numero </td>';
	tabla += '<td>Nombre</td>';
	tabla += '<td></td>';//Detalles
	tabla += '</tr>';
	tabla += '</thead><tbody>';
	
	for(var i=0;i<datos.length;i++){
		
		if(datos[i]['estado_id']==0)
			tabla += '<tr>';
		else if(datos[i]['estado_id']==1)
			tabla += '<tr class="warning">';
		else if(datos[i]['estado_id']==2)
			tabla += '<tr class="danger">';
		tabla += '<td>'+datos[i]['id']+'</td>';
		tabla += '<td>'+datos[i]['estante']+'</td>';
		tabla += '<td>'+datos[i]['numero']+'</td>';
		tabla += '<td>'+datos[i]['nombre']+'</td>';
		tabla += '</tr>';

	}
	$("#listaResultado").append(tabla);		
	$("#listaResultado").append("  </tbody> </table>");	
	
	//Agrego la funcionalidad de los botones del indice
	$("#btn_pag_"+paginaActual).addClass("active");
	
	if(paginaActual!=0){
		$("#btn_pag_atras").click(function(){
			pideDatos(paginaActual-1);
		});
	}
	if(paginaActual+1<paginasTotales){
		$("#btn_pag_adelante").click(function(){
			pideDatos(paginaActual+1);
		});
	}

	for(var i=0; i < pullBtn.length; i++){
		$(pullBtn[i][0]).click(function(){
			pideDatos($(this).attr("pag"));
		});
	}

}


//---------------------------
//	Limpia el formulario y los resultados
//---------------------------
function limpiar(){
	$('#id_libro').val("");
	$('#nombre').val("");
	$('#estante').val("");
	$('#numero').val("");
	$('#listaResultado').empty();
}
