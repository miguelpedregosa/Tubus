<?php
ini_set("display_errors" , 1);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/'.$configuracion['conector'];
//require_once '../libs/rober.php';
require_once '../libs/text.php';
require_once '../libs/functions.php';
//require_once 'libs/movil.php';

//http://beta.tubus.es/ajax/route-ajax.php?id_parada=304&miposicion=37.176487,-3.597929
$output=array();

$parada_id = intval($_GET['id_parada']);
$coordenadas_parada = get_coordenadas($parada_id);

$miposicion = explode(',',$_GET['miposicion']);
$coordenadas_miposicion=array('latitud'=>$miposicion[0], 'longitud'=>$miposicion[1]);

$data = "http://maps.google.com/maps/api/directions/xml?origin=".$coordenadas_miposicion['latitud'].",".$coordenadas_miposicion['longitud']."&destination=".$coordenadas_parada['latitud'].",".$coordenadas_parada['longitud']."&mode=walking&waypoints=optimize:true&language=es&sensor=false";

$xml = @simplexml_load_file($data);
if (!is_object($xml))
	echo "-1";
else{
	$steps = $xml->route->leg->step;
}


if((string)$xml->status=='OK'){
	$html_route='';
	$paso=1;
	foreach($steps as $step)
	{
		$html_route.='<span class="liine2"></span>';
		$html_route.='<span class="apartado-bus-trasbordos">';
		$html_route.='<table style="width:100%;" id="linea_'.$paso.'">';
		$html_route.='<tr>';
		$html_route.='<td class="numero">'.$paso.'.</td>';
		$html_route.='<td class="destino2"><strong>'.$step->html_instructions.'</strong> '.$step->distance->text.'</td>';
		$html_route.='</tr>';
		$html_route.='</table>';
		$html_route.='</span>';
		$paso++;
	}
}
if((string)$xml->status=='OVER_QUERY_LIMIT'){
	$html_route.='<span class="liine2"></span>';
	$html_route.='<span class="apartado-bus-trasbordos">';
	$html_route.='<table style="width:100%;" id="linea_'.$paso.'">';
	$html_route.='<tr>';
	$html_route.='<td class="numero">&nbsp;</td>';
	$html_route.='<td class="destino2"><strong>Lamentamos nos poder ofrecer este servicio temporalmente. Pedimos disculpas por las molestias causadas</td>';
	$html_route.='</tr>';
	$html_route.='</table>';
	$html_route.='</span>';
}

$html_route.='<span class="liine2"></span>';

$output['indicaciones'] = $html_route;
$output['origen'] = array('latitud'=>$coordenadas_miposicion['latitud'], 'longitud'=>$coordenadas_miposicion['longitud']);
$output['destino'] = array('latitud'=>$coordenadas_parada['latitud'], 'longitud'=>$coordenadas_parada['longitud']);
$output['parada_id'] = $parada_id;

echo json_encode($output);
