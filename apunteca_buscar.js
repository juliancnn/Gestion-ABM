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
	tabla += '<td># </td>';
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
		tabla += '<td>'+datos[i]['nombre']+'</td>';
		tabla += '<td><button class="btn btn-info" align="right" id_pullDeResultados='+i+' id="btn_apunte_'+datos[i]['id']+'"><span class="glyphicon glyphicon-plus"></span> Detalles</button></td>';//Detalles
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
	$('#id_libro').val("");
	$('#nombre').val("");
	$('#estante').val("");
	$('#numero').val("");
	$('#listaResultado').empty();
}

/***************************************************************
 * 
 *
 * 					Alerts / Detalles de los apuntes
 * 
 * 
***************************************************************/

function verDetalles(){
	var btn = $(this)[0];
	var i = btn.getAttribute("id_pullDeResultados");
	var detallesHTML = "<p>";
	detallesHTML += "<strong># Id del apunte:</strong>   " + pullDeResultados[i]['id'] +"</br>";
	detallesHTML +=	"<strong>Nombre:</strong>   " + pullDeResultados[i]['nombre'] +"</br>";
	detallesHTML += "<strong>Lugar:</strong>   " + pullDeResultados[i]['lugar'] +"</br>";
	detallesHTML +=	"<strong>Estante:</strong>   " + pullDeResultados[i]['estante'] +"</br>";
	detallesHTML += "<strong>Numero:</strong>   " + pullDeResultados[i]['numero'] +"</br>";
	detallesHTML +=	"<strong>Estado:</strong>   " + pullDeResultados[i]['estado'] +"</br>";
	detallesHTML +=	"<strong>En la apunteca desde:</strong>   " + pullDeResultados[i]['desde'] +"</br>";
	detallesHTML += '<strong><a href="apunteca_registro.php?&id_apunte='+pullDeResultados[i]['id']+'" target="_blank">Ver historial</a></strong></br>';
	detallesHTML += '<strong><a href="apunteca_editar.php?&id_apunte='+pullDeResultados[i]['id']+'" target="_blank">Editar apunte</a></strong>';

	detallesHTML += "</p>";

	if(pullDeResultados[i]['estado_id']==2){
		detallesHTML += '<p id="registro">';
		detallesHTML += "</p>";
		unRegistro(pullDeResultados[i]['id']);
		
		bootbox.dialog({
		  message: detallesHTML,
		  title: '<span class="glyphicon glyphicon-book"></span> Detalles del apunte',
		  buttons: {
		    btn_devolver: {
		      label: "Devolver apunte",
		      className: "btn-warning",
		      callback: function() {
		      	bootbox.prompt("Estas seguro que queres devolver el apunte? Agrega alguna observacion", function(result) {                
				  if (result === null) {                                             
				    //Example.show("Prompt dismissed");                              
				  } else {
				    	$.ajax({
								dataType: "json",
								url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
								type: 'POST',
								async: true,
								data: "apuntecaDevuelve=apuntecaDevuelve&id_apunte="+pullDeResultados[i]['id']+"&comentario="+result,
								success: cargaDatos,
						});                        
				  }
				});
		      }
		    },
		    btn_cancelar: {
		      label: "Cancelar",
		      className: "btn-primary",
		      callback: function() {
		        //Example.show("uh oh, look out!");
		      }
		    }
		  }
		});
	}else{
		bootbox.dialog({
		  message: detallesHTML,
		  title: '<span class="glyphicon glyphicon-book"></span>'+" Detalles del apunte",
		  buttons: {
		    btn_retirar: {
		      label: "Retirar apunte",
		      className: "btn-primary",
		      callback: function() {
			      	window.location="apunteca_retirar.php?id_apunte="+pullDeResultados[i]['id'];
		      }
		    },
		    btn_salir: {
		      label: "Cancelar",
		      className: "btn-default",
		      callback: function() {
		        //Example.show("uh oh, look out!");
		      }
		    }
		  }
		});
	}
	
}

function unRegistro(id){
			var datos = 'apuntecaBusquedaRegistro=apuntecaBusquedaRegistro'+
				"&id_apunte="+id+
				"&tamano=1";
			$.ajax({
				dataType: "json",
				url: 'librerias/formulariosajax.php?nocache='+ Math.random(),
				type: 'POST',
				async: true,
				data: datos,
				success: cargoUnRegistro
		});
}

function cargoUnRegistro(datos){
	
	var detalles = "<strong>En manos de:</strong>   "+datos[0]['apellido']+", " + datos[0]['nombre'] +"</br>";
	detalles += "<strong>Matricula:</strong>   " + datos[0]['persona_id'] +"</br>";
	detalles += "<strong>Observasiones:</strong>   " + datos[0]['observacion'] +"</br>";
	detalles += "<strong>Lo tiene desde:</strong>   " + datos[0]['cuando'] +"</br>";
	detalles += '<strong><a href="persona_perfil.php?&matricula='+datos[0]['persona_id']+'" target="_blank">Ver perfil completo</a></strong>';

		
	$("#registro").html(detalles);
}
