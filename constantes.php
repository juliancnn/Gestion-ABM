<?php
session_start();
include_once('permisos.php');

/*Algunos parametros*/
const TITULO = 'ABM Gestion';
const RAIZhttp = 'http://localhost/';
$destinoLogin = '"index.php"';

/*Loggin*/
const VECES_INCORRECTO = 10;

/* Permisos */
const PER_BASICO = 0;
const PER_APUNTECA = 1;

/*HTML*/
const PIEPAGINA = 
'	    <div id="footer">
	      <div class="container">
	        <p class="text-muted">
	        	ABM CEICiN - desde 1971 Siempre en Movimiento
	        	</br>Desarrollado por 
	        	<a href="http://fb.com/juliancnn" target="_blank">Julián Morales</a>
	        </p>
	      </div>
	    </div>';
?>