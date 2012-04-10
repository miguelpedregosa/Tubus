<?php
require_once '../libs/dbconnect.php';
require_once '../libs/functions.php';
//Se espera el siguiente formato http://tubus.es/ajaxchecking.php?idparada=XXX&lat=XXX&long=XXX
//Si se guardan los datos bien devolvera OK en caso contrario devolvera KO

function enviar_mail_nueva_parada($parada, $lat, $long, $ip){
	$texto_email = 
   "Se ha geolocalizado la siguiente parada con éxito en Tubus:
	Número de la parada: $parada
	Longitud: $long
	Latitud: $lat
	Localizada por:	$ip
	
	Se puede ver en http://tubus.es/$parada/
	";
	$asunto = "Parada $parada geolocalizada en Tubus";
	
	mail("info@huruk.net",$asunto,$texto_email);
	
	
}

function enviar_mail_parada_actualizada($parada, $lat, $long, $ip){
	$ciudad = '';
	$subdominio = '';
	if(isset($_COOKIE['userciudad'])){
		switch($_COOKIE['userciudad']){
			case 'gr':
				$ciudad = 'Granada';
				$subdominio = 'gr.';
				break;
			case 'v':
				$ciudad = 'Valencia';
				$subdominio = 'v.';
				break;
			case 'z':
				$ciudad = 'Zaragoza';
				$subdominio = 'z.';
				break;
			case 'b':
				$ciudad = 'Barcelona';
				$subdominio = 'b.';
				break;
			case 'ma':
				$ciudad = 'Malaga';
				$subdominio = 'ma.';
				break;
			case 'do':
				$ciudad = 'Donostia';
				$subdominio = 'do.';
				break;
		}
	}
	
	$texto_email = 
   "Se ha modificado la geolocalización de la siguiente parada en Tubus ".$ciudad.":
	Número de la parada: $parada
	Longitud: $long
	Latitud: $lat
	Localizada por:	$ip
	
	Se puede ver en http://".$subdominio."tubus.es/$parada/
	";
	$asunto = "Modificada la geolozalización de la parada $parada en Tubus ".$ciudad;
	
	mail("info@huruk.net",$asunto,$texto_email);
	
	
}

//Lo primero es ver si nos pasan correctamente los parametros
$parada = $_GET['idparada'];
$long = (float)$_GET['long'];
$lat = (float)$_GET['lat'];

if(!isset($parada) or !isset($long) or !isset($lat)){ 
echo '{"resultado" : "KO"}';
	exit;
}

if($long == 0){
echo '{"resultado" : "KO"}';
	exit;
}

if($lat == 0){
echo '{"resultado" : "KO"}';
exit;
}

//Ahora compruebo si ya existe una parada con el mismo nombre en la bd
$sql = "SELECT * FROM paradas WHERE nombre = '".$parada."' LIMIT 1";
$res = mysql_query($sql);

if(!$res){
echo '{"resultado" : "KO"}';
exit;
}

$numres = mysql_num_rows($res);
if($numres == 0){
	//Inserto un nuevo valor en la base de datos
	$fecha_actual = date('Y-m-d H:i:s');
	$ip = get_real_ip();
	$sql_insert = "INSERT INTO paradas (nombre, latitud, longitud, creada, locatedby) VALUES ('".$parada."','".$lat."','".$long."','".$fecha_actual."','".$ip."') ";
	
	$resi = mysql_query($sql_insert);
	
	if($resi){
echo '{"resultado":"OK"}';
enviar_mail_nueva_parada($parada, $lat, $long, $ip);
		exit;
	}
	else{
echo '{"resultado" : "KO"}';
		exit;
	}
	
	
	
}
else{
	//Ahora tengo la misma parada ya en base de datos
	$datos = mysql_fetch_array($res);
	$blocked = $datos['blocked'];
	
	if($blocked == 0){
		//Actualizo el registro que hay en la base de datos
	//$fecha_actual = date('Y-m-d H:i:s');
	$ip = get_real_ip();
	$sql_update = "UPDATE paradas SET latitud = '".$lat."', longitud = '".$long."', locatedby = '".$ip."' WHERE nombre = '".$parada."' LIMIT 1;";
	
	$resi = mysql_query($sql_update);
	
	if($resi){
echo '{"resultado":"OK"}';
enviar_mail_parada_actualizada($parada, $lat, $long, $ip);
exit;
	}
	else{
echo '{"resultado" : "KO"}';
exit;
	}
	
	}
	else{
echo '{"resultado" : "KO"}';
exit;
	}
	
	
	
}

?>
