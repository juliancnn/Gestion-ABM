<?php
/****************************************************************************************
*
*		Clase estatica de las consultas al server MySQL
* 
*
*	Esta basado en views y stored procedure por que fue planeada para la modificacion 
*	del diseno db sin necesidad hacer grandes cambios en el SW
*
* Autor: Julian Morales - facebook.com/juliancnn
* junio de  2014 (Epoca de elecciones)
* Aguante LA ABM!!!!!
/*****************************************************************************************/

/*Configuracion de la base de datos*/
define("DB_SERVER", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "abm");

class querydb{
	
		
		/****************************************************************************************
		*
		*								Conexion a la base de datos
		*
		/****************************************************************************************/
		function querydb(){
		}
		
		//Abre consultaSimple	
		public static function consulta($subcon, $id = FALSE){
			$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			if ($mysqli->connect_errno) {
				echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}
			if(!($res = $mysqli->query($subcon))){
				echo  "Fallo al consulta MySQL \n".$subcon."\n" ;
			}
			
			
			if($id){
				$res = $mysqli->query('select last_insert_id() id; ');
				$id = $res->fetch_assoc();
				$res = 0+$id['id']; // Convierte el string  a number con el signo +
				
			}
			$mysqli->close();
			return $res;
		}

		/****************************************************************************************
		*
		*									Personas y Usuarios
		*
		/*****************************************************************************************/

		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve 1 en caso de loggin correcto 0 de lo contrario
		 *---------------------------------------------------------------------------------------*/
		
		public static function loggin($dni, $pass, $json = true){

			$consulta = 'SELECT * FROM gestionabm_usuario where dni = '.$dni.';';
			$res = self::consulta($consulta);
			if(0 < $res->num_rows){
				$fila = $res->fetch_assoc();
				if($fila['incorrecto'] >= VECES_INCORRECTO ){
					$msj = 'Cuenta bloqueada, contacte administrador';
				}else if($fila['pass'] != $pass){
					$msj = "Password incorrecto\n".($fila['incorrecto']+1).' Intentos fallidos';
					$subcon = "UPDATE gestionabm_usuario SET incorrecto = ".($fila['incorrecto']+1)." WHERE dni = ".$dni;
					$res = self::consulta($subcon);
				}else{
					$_SESSION['user'] = $dni;
					$msj = 1;
					$subcon = "UPDATE gestionabm_usuario SET incorrecto = 0 WHERE dni = ".$dni;
					$res = self::consulta($subcon);
				}
				
			}else{
				$msj = 'El usuario no existe';
			}
			
			if($json){
				echo json_encode($msj);
			}
			return $msj;	
	
		}
		
		
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve el array de carreras
		 *---------------------------------------------------------------------------------------*/
		public static function arrayCarreras(){
			$mysqli;
			
			$consulta = "select * from gestionabm_persona_carrera";
			$res = self::consulta($consulta);
			
			return $res;	
	
		}
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve el perfil
		 *---------------------------------------------------------------------------------------*/
		
		//Devuelve el perfil de una matricula con sus datos principales
		public static function perfil($dni, $json = true){
			
			
			$consulta = "SELECT dni matricula, DATE(lastupdate) lastupdate, gestionabm_persona_info.nombre nombre, apellido, celular, email,gestionabm_persona_carrera.nombre carrera, id id_carrera
			FROM gestionabm_persona_carrera,gestionabm_persona_info 
			WHERE persona_carrera_id=id and dni=$dni;";
			
			$res = self::consulta($consulta);
	
			 if($json){
				 if($res->num_rows==0){
				 	echo json_encode("vacio");
				 }else{
				 	$fila = $res->fetch_all(MYSQLI_ASSOC);
				 	echo json_encode($fila);
				 }
				
			}
			return $res;	
	
		}
		
		/*---------------------------------------------------------------------------------------		
		 * 					Agrega/actualiza a las personas
		 *---------------------------------------------------------------------------------------*/
		
		//Agrega o actualiza personas en la db
		public static function agregarPersona($arrayDatos){

			$consulta = "INSERT `gestionabm_persona_info` (`dni`, `nombre`, `apellido`, `celular`, `email`,  `persona_carrera_id`) \n"; 
			$consulta .= 'VALUES ('.$arrayDatos['matricula'].', LOWER("'.$arrayDatos['nombre'].'"), LOWER("'.$arrayDatos['apellido'].'"), "'.$arrayDatos['celular'].'", "'.$arrayDatos['email'].'", '.$arrayDatos['carrera'].")\n";
			$consulta .= 'ON DUPLICATE KEY UPDATE nombre=LOWER("'.$arrayDatos['nombre'].'"), apellido=LOWER("'.$arrayDatos['apellido'].'"), celular="'.$arrayDatos['celular'].'", email="'.$arrayDatos['email'].'", persona_carrera_id='.$arrayDatos['carrera'];
			
			self::consulta($consulta);
			
			
		}

		/*---------------------------------------------------------------------------------------		
		 *								Busqueda de Personas
		 *---------------------------------------------------------------------------------------*/
		
		
		public static function busquedaPersona($dni, $nombre, $apellido , $pagina = 0 ,$tamano = 10, $json = TRUE){
			if($dni != ''){return self::perfil($dni);}

			$nombre = strtolower($nombre);
			$apellido = strtolower($apellido);
						
			$consulta = 'SELECT dni matricula, gestionabm_persona_info.nombre nombre, apellido, celular, email,gestionabm_persona_carrera.nombre carrera, id id_carrera
			FROM gestionabm_persona_carrera,gestionabm_persona_info 
			WHERE (persona_carrera_id=id) ';
			
			if($nombre != ''){
				$consulta .= ' and (gestionabm_persona_info.nombre like "%'.$nombre.'%") ';
				
			}
			if($apellido != ''){
				$consulta .= ' and (apellido like "%'.$apellido.'%")';
			}
			
			//$consulta .= " order by lastupdate DESC LIMIT ".sprintf($pagina*$tamano)." , ".sprintf(($pagina*$tamano)+$tamano).";";
			$consulta .= " order by lastupdate DESC LIMIT ".sprintf($pagina*$tamano)." , ".sprintf($tamano).";";
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			 if($json){
			 	//echo $consulta;
				echo json_encode($resultado);
			}

			return $resultado;	
	
		}
		/*---------------------------------------------------------------------------------------		
		 * 						Listar personas por carrera
		 *---------------------------------------------------------------------------------------*/
		
		//Devuelve el perfil de una matricula con sus datos principales
		public static function listarPersonas($carrera = ''){
			
			
			$consulta = "SELECT dni matricula, gestionabm_persona_info.nombre nombre, apellido, email
			FROM gestionabm_persona_info  ";
			
			if($carrera!='')
				$consulta .= " WHERE persona_carrera_id=$carrera;"; 
			
			
			$res = self::consulta($consulta);
			$res->fetch_all(MYSQLI_ASSOC);

			return $res;	
	
		}
		/****************************************************************************************
		 * 
		 *
		 *									LA APUNTECA
		 * 						
		 *
		/*****************************************************************************************/
		
		/*---------------------------------------------------------------------------------------		
		 *								Agrega apuntes
		 *---------------------------------------------------------------------------------------*/
		public static function addApunte($estante, $numero, $nombre, $lugar, $json = true){

			
			$consulta = 'INSERT INTO `gestionabm_apunteca_apunte`(`codigo_estante`,`codigo_numero`,`nombre`,`lugar`,`estado`, `agregado`)
VALUES (UPPER("'.$estante.'"),'.$numero.',LOWER("'.$nombre.'"),'.$lugar.','.APUNTECA_ENAPUNTECA.',  CURDATE());'; 
	
	
			$id = self::consulta($consulta, TRUE);

			
			if($json){
				echo json_encode($id);
			}
			return $id;	
	
		}
		/*---------------------------------------------------------------------------------------		
		 *								Edita apuntes
		 *---------------------------------------------------------------------------------------*/
		public static function editarApunte($id, $estante, $numero, $nombre, $lugar){

			
			$consulta = '	UPDATE gestionabm_apunteca_apunte 
							SET  `codigo_estante`=UPPER("'.$estante.'") ,`codigo_numero`='.$numero.',`nombre`=LOWER("'.$nombre.'"),`lugar`='.$lugar.'
							WHERE id='.$id.';'; 
			self::consulta($consulta);

			
			return;	
	
		}
		/*---------------------------------------------------------------------------------------		
		 *  						Lista de lugares de apuntes
		 *---------------------------------------------------------------------------------------*/
		public static function arrayApunteLugares(){
			
			$res = self::consulta("select * from gestionabm_apunteca_lugar");			
			$res = $res->fetch_all(MYSQLI_ASSOC);
			
			return $res;	
	
		}
		
		/*---------------------------------------------------------------------------------------		
		 *  						Retira Cosas de la apunteca
		 *---------------------------------------------------------------------------------------*/
		public static function apuntecaRetiro($matricula, $idApunte, $cometario = "", $json = TRUE){
			
			$consulta = 'INSERT gestionabm_apunteca_registro (retiro, observacion, apunte_id, persona_id, cuando)
						VALUES  (1, "'.$cometario.'", '.$idApunte.', '.$matricula.', CURDATE());';
			$id = self::consulta($consulta, TRUE);
			
			$consulta =	'UPDATE gestionabm_apunteca_apunte SET estado='.APUNTECA_PRESTADO.' where id='.$idApunte.';';
			self::consulta($consulta);
						
			
			if($json)
				echo json_encode($id);
			return $id;	
		}
		
		/*---------------------------------------------------------------------------------------		
		 *  						Devuelve Cosas de la apunteca
		 *---------------------------------------------------------------------------------------*/
		public static function apuntecaDevuelve($idApunte, $cometario = "", $json = TRUE){
			$lastRegistro = self::apuntecaRegistro("",$idApunte, 0,1, FALSE);
			if(count($lastRegistro)<1){
				$res = "no existe un registro para ese apunte, por que esta en apunteca o por que no existe el apunte";
				if($json)
					echo json_encode($res);
			return $res;	
			}
			
			
			$consulta = 'INSERT gestionabm_apunteca_registro (retiro, observacion, apunte_id, persona_id, cuando)
						VALUES  (0, "'.$cometario.'", '.$idApunte.', '.$lastRegistro[0]['persona_id'].',  CURDATE());';
			$id = self::consulta($consulta, TRUE);
			
			$consulta =	'UPDATE gestionabm_apunteca_apunte SET estado='.APUNTECA_ENAPUNTECA.' where id='.$idApunte.';';
			self::consulta($consulta);
						
			if($json)
				echo json_encode($id);
			return $id;	
		}
		
		/*---------------------------------------------------------------------------------------		
		 *  								Buscar apunte
		 *---------------------------------------------------------------------------------------*/
		public static function buscarApunte($id, $estante, $numero, $nombre, $pagina = 0 ,$tamano = 5, $json = TRUE){
				
			$sel = "	SELECT
						gestionabm_apunteca_apunte.id id, 
						codigo_estante estante, 
						codigo_numero numero, 
						estado_id,
						gestionabm_apunteca_apunte.nombre nombre, 
						gestionabm_apunteca_estado.estado estado,
						gestionabm_apunteca_lugar.nombre lugar,
						gestionabm_apunteca_lugar.id id_lugar,
						agregado desde";
			
			$consulta = 'FROM 
						gestionabm_apunteca_apunte, gestionabm_apunteca_estado, gestionabm_apunteca_lugar 
						where 
						(gestionabm_apunteca_apunte.lugar = gestionabm_apunteca_lugar.id 
						and gestionabm_apunteca_apunte.estado = estado_id)'; 
			
			if ($id != '') {
				$consulta .= ' and (gestionabm_apunteca_apunte.id = '.$id.') ';			
			}
			if ($estante != '') {
				$consulta .= ' and (gestionabm_apunteca_apunte.codigo_estante = "'.$estante.'") ';			
			}
			if ($numero != '') {
				$consulta .= ' and (gestionabm_apunteca_apunte.codigo_numero = '.$numero.') ';			
			}
			if ($nombre != '') {
				$consulta .= ' and (gestionabm_apunteca_apunte.nombre like "%'.$nombre.'%")';
				
			}
			
			$consulta .= 'order by gestionabm_apunteca_apunte.id';	
			$limite = 	"LIMIT ".sprintf($pagina*$tamano)." , ".sprintf($tamano).";";//.sprintf($pagina*$tamano+$tamano);	
			
			$res = self::consulta($sel." ".$consulta." ".$limite);			
			$res = $res->fetch_all(MYSQLI_ASSOC);
			$cant = self::consulta('SELECT COUNT(*) cantidad '.$consulta);
			$cant = $cant->fetch_assoc();
			
			$cant = 0 + $cant["cantidad"];
			
			$final = array(
			    "datos" => $res,
			    "cantidad" => $cant,
			);
						
			if($json){
				echo json_encode($final);
				
			}
			
			return $res;	
	
		}

		/*---------------------------------------------------------------------------------------		
		 *			  						lista el Registro
		 *---------------------------------------------------------------------------------------*/
		public static function apuntecaRegistro($matricula = "", $idApunte = "", $pagina = 0, $tamano = 10, $json = TRUE){
			
			$consulta = 'SELECT 
						gestionabm_apunteca_registro.id "numTransaccion",
						retiro,
						cuando,
						observacion,
						persona_id,
						gestionabm_persona_info.nombre nombre,
						gestionabm_persona_info.apellido apellido,
						apunte_id,
						gestionabm_apunteca_apunte.nombre apunte,
						gestionabm_apunteca_apunte.estado estado
						FROM 
						gestionabm_apunteca_registro,
						gestionabm_apunteca_apunte,
						gestionabm_persona_info
						where
						(gestionabm_apunteca_registro.apunte_id = gestionabm_apunteca_apunte.id)
						and
						(gestionabm_apunteca_registro.persona_id = gestionabm_persona_info.dni) ';
						

			if($matricula != ""){
				$consulta .= " and gestionabm_apunteca_registro.persona_id =".$matricula;
			}
			if($idApunte != ""){
				$consulta .= " and gestionabm_apunteca_apunte.id =".$idApunte;
			}			
			$consulta .= ' ORDER BY cuando DESC LIMIT '.sprintf($pagina*$tamano)." , ".sprintf($tamano);
			
			
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			 if($json){
				echo json_encode($resultado);
			}

			return $resultado;	
		}
		
		/*---------------------------------------------------------------------------------------		
		 *			  						Busca Libros no devueltos
		 *---------------------------------------------------------------------------------------*/
		public static function apuntecaNoDevuelto($matricula = '', $desde = "", $hasta = "", $pagina = 0, $tamano = 10, $json = TRUE){
				
					
				
			$sel =		'SELECT 
						reg.id "numTransaccion",
						DATE(cuando) cuando,
						observacion,
						persona_id matricula,
						per.nombre nombre,
						per.apellido apellido,
						apunte_id,
						ap.nombre apunte ';
			$consulta = ' FROM
						gestionabm_apunteca_registro as reg
						join 
						gestionabm_apunteca_apunte  as ap
						on reg.apunte_id = ap.id and ap.estado != '.APUNTECA_ENAPUNTECA.'
						join
						gestionabm_persona_info as per
						on 
						per.dni = reg.persona_id ';
			if($matricula!='')
				$consulta .= 'and per.dni = '.$matricula;
			
			$consulta .= ' join
						(SELECT 
						max(cuando) fecha
						FROM 
						gestionabm_apunteca_registro as reg
						join 
						gestionabm_apunteca_apunte  as ap
						on reg.apunte_id = ap.id and ap.estado = '.APUNTECA_PRESTADO.'
						join
						gestionabm_persona_info as per
						on 
						per.dni = reg.persona_id
						group by apunte_id) as subc
						on 
						subc.fecha = reg.cuando ';
						

			if($desde != "" && $hasta != ""){
				$consulta .= " where DATEDIFF(DATE(reg.cuando) ,\"".$desde."\") >= 0 and DATEDIFF(DATE(reg.cuando) ,\"".$hasta."\") <= 0 ";
			}
			else if($desde != ""){
				$consulta .= " where DATEDIFF(DATE(reg.cuando) ,\"".$desde."\") >= 0 ";
			}else if($hasta != ""){
				$consulta .= " where DATEDIFF(DATE(reg.cuando) ,\"".$hasta."\") <= 0  ";
			}		
			
			$limite = ' ORDER BY cuando DESC LIMIT '.sprintf($pagina*$tamano)." , ".sprintf($tamano);
			
			
			$res = self::consulta($sel.$consulta.$limite);			
			$res = $res->fetch_all(MYSQLI_ASSOC);
			$cant = self::consulta('SELECT COUNT(*) cantidad '.$consulta);
			$cant = $cant->fetch_assoc();
			
			$cant = 0 + $cant["cantidad"];
			
			$final = array(
			    "datos" => $res,
			    "cantidad" => $cant,
			);
						
			if($json){
				echo json_encode($final);
				
			}
			
			return $res;	
				
			
			
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			 if($json){
				echo json_encode($resultado);
			}

			return $resultado;	
		}
		/****************************************************************************************
		 * 
		 *
		 *										ACADEMICo
		 * 						
		 *
		/*****************************************************************************************/
		
		/*---------------------------------------------------------------------------------------		
		 *								Agrega materia
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoAddMateria($materia, $json = true){
			if($materia=="")
				return "La materia no puede estar vacia";
			$consulta = 'INSERT INTO `gestionabm_persona_materia` (`materia`) VALUES (LOWER("'.$materia.'"));';	
			$id = self::consulta($consulta, TRUE);

			if($json){
				echo json_encode($id);
			}
			return $id;	
	
		}
		
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve el array de materias
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoListarMateria($busqueda = "",$json = true){
			$mysqli;
			
			$consulta = "select * from gestionabm_persona_materia ";
			if($busqueda!="")
				$consulta .= " where gestionabm_persona_materia.materia like \"%".$busqueda."%\" ";
			$consulta .= " order by materia ASC;";
			
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			if($json){
				echo json_encode($resultado);
			}
			return $resultado;	
	
		}		
		
		/*---------------------------------------------------------------------------------------		
		 * 			Actualiza la bolza de trabajo de una matricula (Vacia y rellena)
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoBolsaActualizar($matricula, $datos){
			$mysqli;
						
			/*Vacia la bolza*/
			$consulta = 'DELETE FROM gestionABM_persona_da_bolsa WHERE dni = '.$matricula.';';
			self::consulta($consulta);
			/*Rellena las materias*/
			
			for($i=0;$i<((int)count($datos));$i++){
				$materia = $datos[$i][0];
				$precio = $datos[$i][1];
				$comentario = $datos[$i][2];
				$consulta = 'INSERT INTO gestionabm_persona_da_bolsa
							(`comentario`,
							`precio`,
							`materia_id`,
							`dni`)
							VALUES
							("'.$comentario.'",'.$precio.','.$materia.','.$matricula.');';
							 self::consulta($consulta);
			}
			
			

			return;	
	
		}	
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve la bolza de una matricula
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoBolsaMatricula($matricula ,$json = true){
			$mysqli;
			
			$consulta = 'SELECT 
							dni,
							id, materia,
							precio, comentario
							FROM 
							abm.gestionabm_persona_materia as mat
							join 
							abm.gestionabm_persona_da_bolsa as bol
							on
							mat.id = bol.materia_id
							and
							dni='.$matricula.'
							order by materia ASC;';
			
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			if($json){
				echo json_encode($resultado);
			}
			return $resultado;	
	
		}	
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve la bolza de materia
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoMateriaBolsa($materia = "" ,$json = true){
			$mysqli;
			
			$consulta = 'SELECT 
							per.dni,
							per.nombre nombre, 
							apellido, 
							celular, 
							email,
							mat.id,
							materia,
							precio, comentario
							FROM 
							gestionabm_persona_info as per
							join
							abm.gestionabm_persona_da_bolsa as bol
							on
							per.dni = bol.dni
							join 
							abm.gestionabm_persona_materia as mat
							on
							mat.id = bol.materia_id ';
			if($materia!=""){
				$consulta .= " and bol.materia_id=".$materia." ";
			}
			
			$consulta .= ' order by materia ASC;';
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			if($json){
				echo json_encode($resultado);
			}
			return $resultado;	
	
		}	
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve la Consulta de una matricula
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoConsultasMatricula($matricula ,$json = true){
			$mysqli;
			
			$consulta = 'SELECT 
							dni,
							id, 
							materia,
							comentario
							FROM 
							abm.gestionabm_persona_materia as mat
							join 
							abm.gestionABM_persona_da_materia as cons
							on
							mat.id = cons.materia_id
							and
							dni='.$matricula.'							
							order by materia ASC;';
			
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			if($json){
				echo json_encode($resultado);
			}
			return $resultado;	
	
		}
				
		/*---------------------------------------------------------------------------------------		
		 * 			Actualiza la bolza de trabajo de una matricula (Vacia y rellena)
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoConsultaActualizar($matricula, $datos){
			$mysqli;
						
			/*Vacia la bolza*/
			$consulta = 'DELETE FROM gestionabm_persona_da_materia WHERE dni = '.$matricula.';';
			self::consulta($consulta);
			/*Rellena las materias*/
			
			for($i=0;$i<((int)count($datos));$i++){
				$materia = $datos[$i][0];
				$comentario = $datos[$i][1];
				$consulta = 'INSERT INTO gestionabm_persona_da_materia
							(`comentario`,
							`materia_id`,
							`dni`)
							VALUES
							("'.$comentario.'",'.$materia.','.$matricula.');';
							 self::consulta($consulta);
			}
			
			

			return;	
	
		}	
		
		/*---------------------------------------------------------------------------------------		
		 * 					Devuelve la consulta de materia
		 *---------------------------------------------------------------------------------------*/
		public static function AcademicoMateriaConsulta($materia = "" ,$json = true){
			$mysqli;
			
			$consulta = 'SELECT 
							per.dni,
							per.nombre nombre, 
							apellido, 
							celular, 
							email,
							mat.id,
							materia,
							comentario 
							FROM 
							gestionabm_persona_info as per 
							join 
							gestionabm_persona_da_materia as cons 
							on 
							per.dni = cons.dni 
							join  
							gestionabm_persona_materia as mat 
							on 
							mat.id = cons.materia_id ';
			if($materia!=""){
				$consulta .= " and cons.materia_id=".$materia." ";
			}
			
			$consulta .= ' order by materia ASC;';
			$res = self::consulta($consulta);
			$resultado = $res->fetch_all(MYSQLI_ASSOC);
			
			if($json){
				echo json_encode($resultado);
			}
			return $resultado;	
	
		}
}
?>