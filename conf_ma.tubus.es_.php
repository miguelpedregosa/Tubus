<?php
require_once 'version.php';
$configuracion['home_url'] = 'http://'.$_SERVER['SERVER_NAME']; // Home url, without tralling slash
//$configuracion['version'] = '1.5'; // Home url, without tralling slash
$configuracion['ciudad'] = 'Málaga'; // Home url, without tralling slash
$configuracion['webtitle'] = 'Tubus '.$configuracion['ciudad'];
//$configuracion['cache_dir'] = '/home/tubus/cache/'; //Cache folder for data
//$configuracion['cache_active'] = true; //Active the cache use
$configuracion['cache_prefix'] = 'ma.tubus'; 

$configuracion['OAUTH_CALLBACK'] = $configuracion['home_url'].'/twitter.php'; //

//Configuracion de la base de datos
$configuracion['bd_servidor'] = ''; //Servidor
$configuracion['bd_usuario'] = ''; //Usuario
$configuracion['bd_password'] = ''; //Password
$configuracion['bd_basedatos'] = 'tubus_ma'; //

$configuracion['conector'] = 'emt_ma.php'; //

//Datos para mostrar el mapa de la ciudad
$configuracion['mapa_lat'] = 36.72974; 
$configuracion['mapa_long'] = -4.42328; //
$configuracion['mapa'] = false; //

//Pie de pagina
$configuracion['texto_pie'] = 'La información referente a las llegadas en tiempo real de los autobuses urbanos es proporcionada directamente por EMT Málaga, de manera pública y abierta a través de su página web (http://www.emtmalaga.es/) En ningún caso Tubus se hace responsable de la fiabilidad o exactitud de la misma, siendo exclusivamente la labor de Tubus proporcionar un acceso más universal y accesible a dicha información.'; //


