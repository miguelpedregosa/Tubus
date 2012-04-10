<?php
function distancia_haversin($lat1, $lat2, $long1, $long2){
	$R = (float)6371;
	$dLat = deg2rad($lat2 - $lat1);
	$dLong = deg2rad($long2 - $long1);
	
	$a = (sin($dLat/2) * sin($dLat/2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * (sin($dLong/2)*sin($dLong/2));
	$c = 2 * atan2(sqrt($a), sqrt(1-$a));
	//$c = 2 * asin(sqrt($a));
	$d = $R * $c;
	return ($d*1000);
}


