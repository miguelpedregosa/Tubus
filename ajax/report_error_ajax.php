<?php
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/url.php';
//require_once '../libs/rober.php';
require_once '../libs/'.$configuracion['conector'];
require_once '../libs/text.php';
require_once '../libs/functions.php';
require_once '../libs/dbconnect.php';
//require_once 'libs/movil.php';

if($_GET['ajax']=='no'){
$nombre = (int)$_GET['parada'];
$fecha = date('Y-m-d H:i:s');	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>

<title>Reporte de errores de localización de parada de autobuses | Tubus Granada</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Paradas cercanas Tubus facilita el acceso a toda la información relativa al sistema de transporte urbano granadino. Gracias a TuBus es muy sencillo conocer el tiempo estimado de llegada de cada autobús en cada parada, desde cualquier lugar y en cualquier momento." /> 
<meta name="keywords" content="bus urbano, rober, granada, tubus, autobus, urbano, granadino, tiempo real, paradas, linea 4, línea 3, estación de autobuses, metro ligero, ave, estación de trenes, fuente las batallas, marquesinas, paneles" /> 

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
<meta name="generator" content="Huruk Soluciones" />

<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<link rel="stylesheet" type="text/css" media="handheld" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>

</head> 

<body onload="load()" onunload="GUnload()">
<div id="contenedor">
	<div id="cabecera">
		
		<div id="logos">
		</div>
		
		<div id="localidad">
			<h1><a title="Ir a la portada de Tubus" href="<?=$configuracion['home_url']?>">[Granada]</a></h1>
		</div>
	</div>
	
<div id="cuerpo">

	<div id="ubicacion">
	<h1>Informar de errores en la localización de la parada <?=$nombre?></h1>  
	<p class="info_general">
	<?php
	
	$error = '';

	$sql = "Select * from paradas Where nombre = '".$nombre."'";
	$res = mysql_query($sql);
	$ip = get_real_ip();
	$user = get_userid();

	if(($nombre == '')||(mysql_num_rows($res)!=1))
		$error = 'Error. No se conoce la parada'; //se desconoce la parada;
	else{
		$sql_insert = "Insert into reportes (nombre, date_added, ip, userid) values ('".$nombre."','".$fecha."','".$ip."','".$user."')";
		if(mysql_query($sql_insert)){
			//no ha habido problema en la inserción del reporte en BD
			//Mando mail y muestro mensaje de confirmación.
			$error = 'Se ha enviado el error al equipo técnico de Tubus. En breve será analizado y corregido';
			mail('info@huruk.net', 'GeoError de parada '.$nombre, 'Se ha reportado un error sobre la geolocalización de la parada '.$nombre.' por el usuario '.$user. ' con ip '.$ip);
		}
		else $error = 'Error. No se ha podido enviar el reporte'; //se ha producido un error al insertar en base de datos;		
	}

	echo $error;
	
	?>
	</p>
	<p class="info_general">Volver a la parada <a href="<?=$configuracion['home_url']?>/<?=$nombre?>" title="Volver a la parada <?=$nombre?>"><?=$nombre?></a></p>
	</div>    
    
</div>
    
<!-- Por aqui meto mano -->
<div id="otraparada">
	 <h1>Buscar paradas de autobús</h1> 
	<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input class="caja-datos" type="text" value="" name="querystring" id="querystring" />
		<input class="datos-enviar" type="submit" value="Buscar" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puede buscar por el nombre de la calle o directamente por el número de parada.</div>
</div>
<!-- Hasta aquí -->
	
<?php include 'footer.php';

}

else{

	if(!isset($_GET['ajax'])&&isset($_GET['parada'])){
		$nombre = (int)$_GET['parada'];
		$fecha = date('Y-m-d H:i:s');
		$error = '';

		$sql = "Select * from paradas Where nombre = '".$nombre."'";
		$res = mysql_query($sql);

		$ip = get_real_ip();
		$user = get_userid();

		if(($nombre == '')||(mysql_num_rows($res)!=1))
			$error = 'Error. Parada desconocida'; //se desconoce la parada;
		else{
			$sql_insert = "Insert into reportes (nombre, date_added, ip, userid) values ('".$nombre."','".$fecha."','".$ip."','".$user."')";
			if(mysql_query($sql_insert)){
				//no ha habido problema en la inserción del reporte en BD
				//Mando mail y muestro mensaje de confirmación.
				$error = 'Gracias por su colaboración';
				mail('info@huruk.net', 'GeoError de parada '.$nombre, 'Se ha reportado un error sobre la geolocalización de la parada '.$nombre.' por el usuario '.$user. ' con ip '.$ip);
			}
			else $error = 'Error. Vuelva a intentarlo'; //se ha producido un error al insertar en base de datos;		
		}

		echo $error;
	}
}
?>
