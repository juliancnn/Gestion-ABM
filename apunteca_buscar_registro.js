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

$(function(){
	$("#btn_clear").click(limpiar);
	$("#btn_buscar").click(buscar);
	$( "#fecha_desde" ).datepicker({ dateFormat: "yy-mm-dd",changeYear: true });
	$( "#fecha_hasta" ).datepicker({ dateFormat: "yy-mm-dd",changeYear: true });

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
	pullDatosBusqueda['desde'] = $('#fecha_desde').val();
	pullDatosBusqueda['hasta'] = $('#fecha_hasta').val();
	
	pideDatos(0);
	
}
//---------------------------
//	Pide los datos
//---------------------------
function pideDatos(paginaNueva){
		paginaActual = paginaNueva;

		var datos = '&apuntecaBuscarRegistro=apuntecaBuscarRegistro'+
				"&desde="+pullDatosBusqueda['desde']+
				"&hasta="+pullDatosBusqueda['hasta']+
				"&cantidadpagina="+cantidadpagina+
				"&pagina="+paginaActual;
				
			$.ajax({
				dataType: "json",
				url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
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
	tabla += '<td>Transaccion</td>';
	tabla += '<td>Cuando</td>';
	tabla += '<td>Apunte</td>';
	tabla += '<td>Observacion</td>';;
	tabla += '<td>Nombre y Apellido</td>';
	tabla += '<td></td>';
	tabla += '</tr>';
	tabla += '</thead><tbody>';
	
	for(var i=0;i<datos.length;i++){
		
		tabla += '<tr>';
		tabla += '<td>'+datos[i]['numTransaccion']+'</td>';
		tabla += '<td>'+datos[i]['cuando']+'</td>';
		tabla += '<td>'+(datos[i]['apunte']).concat(" (", datos[i]['apunte_id'] ,")")+'</td>';
		tabla += '<td>'+datos[i]['observacion']+'</td>';
		tabla += '<td>'+(datos[i]['nombre']).concat(", " , datos[i]['apellido'])+'</td>';
		tabla += '<td>'+'<strong><a href="persona_perfil.php?&matricula='+datos[i]['matricula']+'" target="_blank">Ver perfil</a></strong>'+'</td>';
		tabla += '</tr>';

	}
	$("#listaResultado").append(tabla);		
	$("#listaResultado").append("  </tbody> </table>");	
	
	
	//Agrego funcionalidad a los votones de detalle
	for(var i=0;i<datos.length;i++){
		$("#btn_apunte_"+datos[i]['id']).click(verDetalles);
	}
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
	$('#fecha_desde').val("");
	$('#fecha_hasta').val("");
	$('#listaResultado').empty();
}

