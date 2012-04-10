<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/url.php';
//require_once '../libs/rober.php';
require_once '../libs/'.$configuracion['conector'];
require_once '../libs/text.php';
require_once '../libs/functions.php';

$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];
$radio = (int)$_REQUEST['radio'];
if(!isset($radio) or $radio == '' or $radio == 0 or $radio > 5000)
    $radio = 2500;

$paradas = obtener_paradas_proximas($lat, $long, $radio);

$output = array();

if($paradas != false && count($paradas) > 0){
	
	foreach($paradas as $parada){
			if($parada['distancia'] < 150)
			{
				$output['enparada'] = 'si';
				$output['parada'] = $parada['nombre'];
				$output['distancia'] = round($parada['distancia'],1);
				$output['contador'] = mt_rand(15, 45);
				echo json_encode($output);
				exit();
			}
			
			if($parada['distancia'] < 500)
			{
				$output['enparada'] = 'cerca';
				$output['parada'] = $parada['nombre'];
				$output['distancia'] = round($parada['distancia'],1);
				echo json_encode($output);
				exit();
			}
			
	}
}

$output['enparada'] = 'no';
//$output['parada'] = $parada['nombre'];
echo json_encode($output);
exit();
