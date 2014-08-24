<?php
include_once "../constantes.php";
include_once "querydb.php";


		/****************************************************************************************
		*
		*								USUARIOS Y PERSONAS
		*
		/****************************************************************************************/

/*------------------------------------		
 * 				Loggin
 * -----------------------------------*/

if(isset($_POST["iniciarsesion"])){
	
	$user=$_POST["dni"];
	$pass=$_POST["pass"];
	
	$res = querydb::loggin($user, $pass); 
	if($res==1){
		$_SESSION['user'] = $user;
	}
}

/*------------------------------------		
 *	devuelve el perfil de una matricula
 * -----------------------------------*/

else if(isset($_POST["consultaPerfil"])){
	permiso();
	$matricula = $_POST["matricula"];
	$res = querydb::perfil($matricula); 

}

/*------------------------------------		
 * 	Agrega o actualiza perfil de las personas
 * -----------------------------------*/

else if(isset($_POST["agregarPersona"])){
	permiso();
	$arrayDatos;
	$arrayDatos['matricula'] = $_POST["matricula"];
	$arrayDatos['nombre'] = $_POST["nombre"];
	$arrayDatos['apellido'] = $_POST["apellido"];
	$arrayDatos['email'] = $_POST["email"];
	$arrayDatos['celular'] = $_POST["celular"];
	$arrayDatos['carrera'] = $_POST["carrera"];
	
	querydb::agregarPersona($arrayDatos); 
	querydb::perfil($_POST["matricula"]); 
}

/*------------------------------------		
 *		Busqueda de personas
 * -----------------------------------*/
else if(isset($_POST["busquedaPersona"])){
	permiso();
	$dni = "";
	$nombre = "";
	$apellido = "";
	if(isset($_POST["matricula"])){$dni=$_POST["matricula"];}
	if(isset($_POST["nombre"])){$nombre=$_POST["nombre"];}
	if(isset($_POST["apellido"])){$apellido=$_POST["apellido"];}

	querydb::busquedaPersona($dni,$nombre,$apellido,0,50000);
}


		/****************************************************************************************
		*
		*								        LA APUNTECA
		*
		/****************************************************************************************/
		
/*------------------------------------		
 *		Agrega apuntes
 * -----------------------------------*/
else if(isset($_POST["apuntecaAgregar"])){
	permiso();
	querydb::addApunte($_POST['estante'], $_POST['numero'], $_POST['nombre'],$_POST['lugar']);
}

/*------------------------------------		
 *		Editar apuntes
 * -----------------------------------*/
else if(isset($_POST["apuntecaEditar"])){
	permiso();
	querydb::editarApunte($_POST['id'],$_POST['estante'], $_POST['numero'], $_POST['nombre'],$_POST['lugar']);
	echo "listo";
}

/*------------------------------------		
 *		Busqueda de apuntes
 * -----------------------------------*/
else if(isset($_POST["busquedaApunte"])){
	
	$id = "";
	$estante = "";
	$numero = "";
	$nombre = "";
	$pagina = 0;
	$cantidadpagina= 10;
	if(isset($_POST["id"])){$id=$_POST["id"];}
	if(isset($_POST["estante"])){$estante=$_POST["estante"];}
	if(isset($_POST["numero"])){$numero=$_POST["numero"];}
	if(isset($_POST["nombre"])){$nombre=$_POST["nombre"];}
	if(isset($_POST["cantidadpagina"])){$cantidadpagina=$_POST["cantidadpagina"];}
	if(isset($_POST["pagina"])){$pagina=$_POST["pagina"];}
	querydb::buscarApunte($id, $estante, $numero, $nombre,$pagina,$cantidadpagina);
	
}

/*------------------------------------		
 *			Verifica Datos
 * -----------------------------------*/
 else if(isset($_POST["apuntecaVerificaDatos"])){
 	permiso();
	$matricula = $_POST["matricula"];
	$id_libro = $_POST["id_apunte"];
	$perfil = querydb::perfil($matricula, false); 
	$apunte = querydb::buscarApunte($id_libro, "","", "",0,1, FALSE);
	
	$resultado;
	
	//Perfil del usuario
	if($perfil->num_rows==0){
		$perfil = "vacio";
	}else{
		$perfil = $perfil->fetch_all(MYSQLI_ASSOC);
	}
	
	//Arma y Muestra el resultado
	$resultado = array(0 => $perfil, 1 => $apunte);
	echo json_encode($resultado);
	
}
 
/*------------------------------------		
 *			Retiro de la apunteca
 * -----------------------------------*/
 
 else if(isset($_POST["apuntecaRetiro"])){
 	permiso();
 	if(isset($_POST["comentario"]))
 		$comentario = $_POST["comentario"];
	else
		$comentario = "";
 	querydb::apuntecaRetiro($_POST["matricula"], $_POST["id_apunte"], $comentario);
 }
 /*------------------------------------		
 *			Devuelve a la apunteca
 * -----------------------------------*/
 else if(isset($_POST["apuntecaDevuelve"])){
 	permiso();
 	if(isset($_POST["comentario"]))
 		$comentario = $_POST["comentario"];
	else
		$comentario = "";
 	querydb::apuntecaDevuelve($_POST["id_apunte"], $comentario);
 }
 
 /*------------------------------------		
 *			Registro de apunteca
 * -----------------------------------*/
 
 if(isset($_POST["apuntecaBusquedaRegistro"])){
	permiso();
	$matricula = $idApunte =  '';
	$pagina = 0; 
	$tamano = 10;
	
	if(isset($_POST["matricula"]))
		$matricula = $_POST["matricula"];
	if(isset($_POST["id_apunte"]))
		$idApunte = $_POST["id_apunte"];
	if(isset($_POST["pagina"]))
		$pagina = $_POST["pagina"];
	if(isset($_POST["tamano"]))
		$tamano = $_POST["tamano"]; 
 	querydb::apuntecaRegistro($matricula, $idApunte, $pagina, $tamano);
 }
 /*------------------------------------		
 *			Apunteca No devueltos
 * -----------------------------------*/
 
 else if(isset($_POST["apuntecaBuscarRegistro"])){
	permiso();
	$desde = $hasta =  $matricula ='';
	$pagina = 0; 
	$tamano = 10;
	
	if(isset($_POST["matricula"]))
		$matricula = $_POST["matricula"];
	if(isset($_POST["desde"]))
		$desde = $_POST["desde"];
	if(isset($_POST["hasta"]))
		$hasta = $_POST["hasta"];
	if(isset($_POST["pagina"]))
		$pagina = $_POST["pagina"];
	if(isset($_POST["cantidadpagina"]))
		$tamano = $_POST["cantidadpagina"]; 
 	querydb::apuntecaNoDevuelto($matricula, $desde, $hasta, $pagina, $tamano);
 }
		/****************************************************************************************
		*
		*								       Academico
		*
		/****************************************************************************************/
		
/*------------------------------------		
 *		Agrega Materias
 * -----------------------------------*/
else if(isset($_POST["materiaAgregar"])){
	permiso();
	echo querydb::AcademicoAddMateria($_POST['materia'],false);
}
/*------------------------------------		
 *		Lista Materias
 * -----------------------------------*/
else if(isset($_POST["listarMateria"])){
	$materia = "";
	
	if(isset($_POST["materia"]))
		$materia = $_POST["materia"];
	querydb::AcademicoListarMateria($materia);
}
/*------------------------------------		
 *		Consulta bolsa de Materias de una matricula
 * -----------------------------------*/
else if(isset($_POST["rellenaMaterias"])){
	$matricula = "";
	
	if(isset($_POST["matricula"]))
		$matricula = $_POST["matricula"];
	querydb::AcademicoBolsaMatricula($matricula);
}
/*------------------------------------		
 *		Consulta bolsa de Materias (Todas las materias o una)
 * -----------------------------------*/
else if(isset($_POST["AcademicoMateriaBolsa"])){
	if(!isset($_POST["materia"]))
		querydb::AcademicoMateriaBolsa();
	else 
		querydb::AcademicoMateriaBolsa($_POST["materia"]);	
}

/*------------------------------------		
 *		Genera una nueva bolsa de trabajo
 * -----------------------------------*/
else if(isset($_POST["bolzaUpdate"])){
	$matricula = $_POST["matricula"];
	$datos = json_decode($_POST["datos"]);
	querydb::AcademicoBolsaActualizar($matricula, $datos);
}
/*------------------------------------		
 *		Consulta Consultas de Materias de una matricula
 * -----------------------------------*/
else if(isset($_POST["rellenaMateriasConsulta"])){
	$matricula = "";
	
	if(isset($_POST["matricula"]))
		$matricula = $_POST["matricula"];
	querydb::AcademicoConsultasMatricula($matricula);
}
/*------------------------------------		
 *		Genera una nueva Consulta
 * -----------------------------------*/
else if(isset($_POST["academicoConsultaUpdate"])){
	$matricula = $_POST["matricula"];
	$datos = json_decode($_POST["datos"]);
	querydb::AcademicoConsultaActualizar($matricula, $datos);
}
/*------------------------------------		
 *		Consulta Consulta de Materias (Todas las materias o una)
 * -----------------------------------*/
else if(isset($_POST["AcademicoMateriaConsulta"])){
	if(!isset($_POST["materia"]))
		querydb::AcademicoMateriaConsulta();
	else 
		querydb::AcademicoMateriaConsulta($_POST["materia"]);	
}
?>