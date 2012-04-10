<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/helpers.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Mapa de paradas y líneas de ".$configuracion['ciudad'])?></title>
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
<link rel="search" type="application/opensearchdescription+xml" title="Buscar en Tubus" href="<?=$configuracion['home_url']?>/opensearch.xml"/>
<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>
<link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>

<script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
<script src="<?=$configuracion['home_url']?>/js/jquery.cookie.js"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.iphone-switch.js"></script>
<script src="<?=$configuracion['home_url']?>/js/gears_init.js"></script>
<script src="<?=$configuracion['home_url']?>/js/yqlgeo.js"></script>
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	
	
<div id="cuerpo">
 <?php include_once 'menu-horizontal.php'; ?>
 <div id="sub-cont">
				<h1><span>Paradas cercanas a mi posición</span></h1>
				<span class="liine"></span>
	<div id="datos_parada">
		<!-- <h3>Hemos buscado paradas cercanas a su posición actual en un radio de 300 metros. Si lo desea puede <a href="#otraparada">buscar por calle o nº de parada</a></h3>
        <p class="info_general">Esta funcionalidad se encuentra actualmente en <strong>beta</strong> ya que solo disponemos de un <?php echo obtener_porcentaje_paradas_geolocalizadas(); ?>% de las paradas de Granada geolocalizadas en el mapa</p>
        -->
        <div id="rvsgeo" style="display:none;position:absolute;left:12px;top:118px;font:normal normal 13px arial,sans-serif;color:#959595;"><img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de: </div>
        <p class="info_general posicion-actu">
        <img src="/style/images/buscar-parada.gif" alt="buscar paradas" id="boton-buscar-parada"/> 
		<span class="actu">Seguir mi posición</span>
        </p>
        <div class="left" id="geowatch"></div>
    </div>
	
	<span class="clear"></span>
	<div id="resuelto">
	 <h2 style="margin-top:25px; margin-bottom:30px;">Resultados de Búsqueda<span id="mini-ajax" style="position:relative; display:none"><img src ="<?=$configuracion['home_url']?>/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h2> 
	 <h5 class="resuelto-fecha" id="fecharesultado" style="display:none;" >Última búsqueda:</h5>
	<div class="resultados-buqueda" id="georesultados">	
        <?php if ($lat != "" && $long != ""){ ?>
			<p class="info_general"> Realizando búsqueda sobre un <?php echo obtener_porcentaje_paradas_geolocalizadas(); ?>% de las paradas de <?=$configuracion['ciudad']?></p>
		<?php } else {?>
			<p class="info_general"> Pulse en <strong>Buscar paradas</strong> para encontrar paradas cercanas a su posición (<?php echo obtener_porcentaje_paradas_geolocalizadas(); ?>% de las paradas geolocalizadas en <?=$configuracion['ciudad']?>)</p>
		<?php } ?>
	</div>
</div>
</div>
<div id="ubicacion" style="display:none;">
	<h1>Mi ubicación aproximada</h1>  
	<div id="map" style="width: 85%; height: 400px;" ></div>
	<p id="toggle"><a href="#" title='Ver parada a nivel de calle' onclick='toggleStreetView();return false'>Vista de Calle</a></p>
</div>
<div id="otraparada">
	 <h1>Buscar paradas de autobús</h1> 
	<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input class="caja-datos" type="text" value="" name="querystring" id="querystring" />
		<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puedes buscar por dirección o directamente por el número de parada.</div>
</div>
<?php include 'footer.php'; ?>
