<?php
include_once("librerias/querydb.php");

function permiso($re = TRUE, $lugar = PER_BASICO){
	$per = FALSE;
	
	//Compruebo Loggeo
	if(!isset($_SESSION['user'])){
		if($re){
			header('location: loggin.php');
		}
		return FALSE;
	}
		 
	
	switch ($lugar) {
	    case PER_BASICO:
	        $per = TRUE;
	        break;
	    case PER_APUNTECA:
			//Tendria que hacer la consulta a la db
	        $per = TRUE;
	        break;
		default:
			$per = FALSE;
	}
	
	if($re && !$per){
		header('location: loggin.php');
	}
	
	return $per;
}
?>