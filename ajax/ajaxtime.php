<?php
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/url.php';
//require_once '../libs/rober.php';
require_once '../libs/'.$configuracion['conector'];
require_once '../libs/text.php';
require_once '../libs/functions.php';
//require_once 'libs/movil.php';

$parada_id = (int)$_GET['parada'];
$fecha = date('j/n/Y H:i:s');
$cache_active = $configuracion['cache_active'];  
$cache_folder = $configuracion['cache_dir']; 
$data_cache_id = $configuracion['cache_prefix'].'_'.'info_parada_'.$parada_id;;

$tiempo_modificacion =  @acmeCache::modified_time($data_cache_id);
$salida['fecha'] = $fecha;
$salida['modificacion'] = $tiempo_modificacion;
echo json_encode($salida);
