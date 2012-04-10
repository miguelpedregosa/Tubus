<?php
require_once 'system.php';
require_once 'libs/cache_kit.php';
require_once 'libs/url.php';
require_once 'libs/helpers.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/text.php';
require_once 'libs/functions.php';
require_once 'libs/dbconnect.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';

$nombre = (int)$_GET['parada'];
$fecha = date('Y-m-d H:i:s');	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title("Líneas de autobuses urbanos en ".$configuracion['ciudad'])?></title>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<meta http-equiv="Expires" content="0" />
	<meta http-equiv="Last-Modified" content="0" />
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta name="Robots" content="noarchive" />
	<meta name="rating" content="general" /> 

	<meta name="description" content="Tubus facilita el acceso a toda la información relativa al sistema de transporte urbano granadino. Gracias a TuBus es muy sencillo conocer el tiempo estimado de llegada de cada autobús en cada parada, desde cualquier lugar y en cualquier momento." /> 
	<meta name="keywords" content="bus urbano, rober, granada, tubus, autobus, urbano, granadino, tiempo real, paradas, linea 4, línea 3, estación de autobuses, metro ligero, ave, estación de trenes, fuente las batallas, marquesinas, paneles" /> 

	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
	<meta name="generator" content="Huruk Soluciones" />

	<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
	<link rel="stylesheet" type="text/css" media="handheld" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<!--[if IEMobile 7]> 
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/wp7_style_<?=$configuracion['version']?>.css" />
<![endif]-->
	<link rel="search" type="application/opensearchdescription+xml" title="Buscar en Tubus" href="<?=$configuracion['home_url']?>/opensearch.xml"/>
	<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>
	<link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>
    
	<link rel="prerender" href="<?=$configuracion['home_url']?>/">
	
    <script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
    <script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
    
    <script type="text/javascript"> 
    jQuery(window).ready(function(){
     toggle_menu();
    });   
    </script> 
    
    
    </head>

<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	
<div id="cuerpo">
<?php include_once 'menu-horizontal.php'; ?>
<?php include_once 'ad.php'; ?>
	<div id="sub-cont">
			<h1><span>Líneas</span></h1>
		<div id="datos_parada">
				<!-- Aquí comienda el sistema de lineas -->
				<div id="trasbordos">			
			<?php
				$lineas = lineas(false);
				foreach($lineas as $linea)
				{
					?>
					<span class="liine2"></span>
					<a href="<?=$configuracion['home_url']?>/linea/<?=$linea['nombre']?>" title="Ver en detalle la línea <?=$linea['nombre']?>">
					<span class="apartado-bus-trasbordos">
					<table style="width:100%;" id="linea_<?=$linea['nombre']?>">
					<tr>
					<td class="numero"><?=$linea['nombre']?></td>
					<?php
					if($linea['descripcion'] == "")
					{
						$trayecto = $linea['salida']." - ".$linea['llegada'];
						
					}
					else
					{
						$trayecto = utf8_encode($linea['descripcion']);
					}
					
					?>
					<td class="destino2"><strong>Trayecto:</strong> <?=$trayecto?></td>
					</tr>
					</table>
					</span>
					</a>
					<?php					
				}
			?>
			
			<span class="liine2"></span>
			<p class="ver-resto">&nbsp;</p>
		</div>	
			</div>
	</div>    
    
</div>
    
<!-- Por aqui meto mano -->
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php';?>
