<?php
require_once 'system.php';
require_once 'libs/cache_kit.php';
require_once 'libs/url.php';
require_once 'libs/helpers.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/text.php';
require_once 'libs/functions.php';
require_once 'libs/dbconnect.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';
//require_once 'libs/movil.php';

$nombre = (int)$_GET['parada'];
$fecha = date('Y-m-d H:i:s');	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title("Reportar un error")?></title>
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
	<div id="sub-cont">
	
	<?php
	if(isset($_POST['enviar'])){
		$nombre = (int)$_POST['parada'];
		$errortype = $_POST['errortype'];
		$comentarios = $_POST['comentarios'];
		$htmlform = '';
		
		if(strlen($_POST['comentarios'])>5){
			$sql = "Select * from paradas Where nombre = '".$nombre."'";
			$res = mysql_query($sql);
			$ip = get_real_ip();
			$aviso="";
			
			$logged_u =  is_logged();
			if($logged_u['logged'])
				$user = $logged_u['id_usuario'];
			else $user = get_userid();
			
			switch($errortype){
				case 'geo';
					$tipo = "Error en la geolocalización de la parada";
					break;
				case 'lineas';
					$tipo = "Error en las lineas de la parada";
					break;
				case 'nombre';
					$tipo = "Error en el nombre de la parada";
					break;
				case 'otros';
					$tipo = "Error en la parada";
					break;
			}
			
			$sql_insert = "Insert into reportes (nombre, date_added, ip, userid, tipo, comentarios) values ('".$nombre."','".$fecha."','".$ip."','".$user."','".$errortype."','".$comentarios."')";
			if(mysql_query($sql_insert)){
				//no ha habido problema en la inserción del reporte en BD
				//Mando mail y muestro mensaje de confirmación.
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
				$aviso = 'Se ha enviado el error al equipo técnico de Tubus. En breve será analizado y corregido';
				$mensaje = '';
				mail('info@huruk.net', $tipo.' '.$nombre.' '.$ciudad, 'Se ha reportado un error en la parada '.$nombre.' de '.$ciudad.' por el usuario '.$user. ' con ip '.$ip.' Puedes verla en http://'.$subdominio.'tubus.es/'.$nombre."\n\n\nError: ".$comentarios);
				
			}
			else $aviso = 'Error. No se ha podido enviar el reporte'; //se ha producido un error al insertar en base de datos;
		}
		else{
			$aviso = 'Error. Debes especificar el fallo'; //se ha producido un error al insertar en base de datos;	
			$htmlform='
			<form name="errorForm" id="register" action="report_error.php" method="POST">
				
				<p><input type="hidden" name="parada" value="'.$nombre.'" /></p>
				<p>
				  <label for="errortype"><span>Problema detectado *</span></label>
				  <select id="errortype" name="errortype">
					<option value="geo" '.($errortype == "geo"? ' selected="selected"':'').'>Error en la geolocalización de la parada</option>
					<option value="lineas" '.($errortype == "lineas"? ' selected="selected"':'').'>Error en las lineas de la parada</option>
					<option value="nombre" '.($errortype == "nombre"? ' selected="selected"':'').'>Error en el nombre de la parada</option>
					<option value="otros" '.($errortype == "otros"? ' selected="selected"':'').'>Otro error...</option>
				  </select>
				</p>
				<p>
				  <label for="comentarios"><span>Más detalles *</span></label>
				  <textarea id="comentarios" name="comentarios" cols="35"></textarea>
				</p>
				<div style="position:relative;margin:15px 0;">
				<input type="submit" name="enviar" value="ENVIAR ERROR" />
				<span class="btn-der"></span>
				<span class="btn-izq"></span>
				</div>
			</form>';
		}
	?>
	<h1><span>Error en parada: <?=$nombre?></span></h1>
		<span class="liine"></span>
		<p>&nbsp;</p>
		<p><?=$aviso?></p>
		<?= $htmlform ?>
	
	<p class="info_general returner">Volver a la parada <a href="<?=$configuracion['home_url']?>/<?=$nombre?>" title="Volver a la parada <?=$nombre?>"><?=$nombre?></a></p>
	<?php
	}
	else{
	?>
	<h1><span>Error en parada: <?=$nombre?></span></h1>
		<span class="liine"></span>
	<form name="errorForm" id="register" action="report_error.php" method="POST">
		
		<p><input type="hidden" name="parada" value="<?=$nombre?>" /></p>
		<p>
		  <label for="errortype"><span>Problema detectado *</span></label>
		  <select id="errortype" name="errortype">
			<option value="geo">Error en la geolocalización de la parada</option>
			<option value="lineas">Error en las lineas de la parada</option>
			<option value="nombre">Error en el nombre de la parada</option>
			<option value="otros">Otro error...</option>
		  </select>
		</p>
		<p>
		  <label for="comentarios"><span>Más detalles *</span></label>
		  <textarea id="comentarios" name="comentarios" cols="35"></textarea>
		</p>
		<div style="position:relative;margin:15px 0;">
		<input type="submit" name="enviar" value="ENVIAR ERROR" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
	</form>
	<p class="info_general returner">Volver a la parada <a href="<?=$configuracion['home_url']?>/<?=$nombre?>" title="Volver a la parada <?=$nombre?>"><?=$nombre?></a></p>
	<?php
	}
	?> 	
	</div>    
    
</div>
    
<!-- Por aqui meto mano -->
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php';?>
