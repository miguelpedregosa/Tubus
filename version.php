<?php
$configuracion['version'] = '1.23'; // Version de Tubus, al cambiar la versión cambia la hoja de estilo
$configuracion['master_url'] = 'http://tubus.es';
$configuracion['beta'] = false;

/*
La caché de tiempos se usa para almecenar temporalmente el los datos de las llegadas a cada parada con el fin de optimizar las peticiones y no realizar llamadas 
simulataneas a los servicios externos. El tiempo de vigencia de los datos en la caché no debe superar los 30 o 35 segundos para garantizar que los datos almacenados están actualizados
*/
$configuracion['cache_dir'] = '/home/usuario/cache_tubus/'; //Ruta absoluta a la carpeta de la caché, debe tener permisos de escritura
$configuracion['cache_active'] = true; //Activar el uso de cacheo de tiempos
$configuracion['cache_expiration'] = 30; //Tiempo (en segundos) que se consideran válidos los datos de la caché de tiempos


$configuracion['mostrar_aviso'] = false;

date_default_timezone_set('Europe/Madrid');


$configuracion['reg_key'] = 'h9meD186VVkxMGbGrXAHbYeVCJi8VXF7P3Uk'; //clave para verificar el registro de usuarios

#Configuración para Twitter
$configuracion['CONSUMER_KEY'] = ''; //
$configuracion['CONSUMER_SECRET'] = ''; //

#Configuración para Facebook
$configuracion['FACEBOOK_ID'] = '';
$configuracion['FACEBOOK_SECRET'] = '';


if(!$configuracion['beta'])
{
	//ini_set('display_errors','Off');
	error_reporting(E_ALL);
	ini_set("log_errors" , "1");
	ini_set('error_log','php_errors.log');
	ini_set('display_errors','0');
}
else
{
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors','On');
}

