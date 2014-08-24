<?php
include_once "constantes.php";
include_once "librerias/querydb.php";
$matricula = 35046503;
$datos = json_decode('[["19","asdasd"],["10","asdasd"]]');
echo querydb::AcademicoConsultaActualizar($matricula, $datos);
?>