<?php
require_once 'CURL.php';

function direccion_to_gps($direccion, $ciudad)
{
	$salida = array();
	$cc = new CURL();
	$direccion = $direccion.' '.$ciudad. ' España';
	$direccion = urlencode($direccion);
	$url_google = 'http://maps.google.com/maps/api/geocode/json?address='.$direccion.'&sensor=false';
	$datos = json_decode($cc->get($url_google));
	
	if($datos->status != "OK")
		return false;
		
	if($datos->results[0]->geometry->location_type == "APPROXIMATE")
		return false;
	
	$salida['direccion'] = $datos->results[0]->formatted_address;
	$salida['latitud'] = $datos->results[0]->geometry->location->lat;
	$salida['longitud'] = $datos->results[0]->geometry->location->lng;
	return $salida;
}

//$gps = direccion_to_gps("Calle Arabial", "Granada");
//print_r($gps);
