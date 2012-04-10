<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';
require_once 'libs/gmaps_services.php';

$direccion = $_REQUEST['querystring'];

if(is_numeric($direccion)){
		registrar_busqueda($direccion);
		header('Location: '.$configuracion['home_url'].'/'.$direccion.'/');
		exit();
}

$primera_parada = '';


if(!isset($direccion) or strlen($direccion) <3  ){
	$buscar = false;
}
else {

//Si hemos llegado aqui, buscamos las coordenadas por dirección
$buscar = true;
$ciudad = $configuracion['ciudad'];
if($configuracion['mapa'])
	$coordenadas = direccion_to_gps($direccion, $ciudad);
else
	$cordenadas = false;
	
if($coordenadas != false)
{
	//obtener_paradas_proximas($lat1, $long1, $maxdist = 300, $pmax = 10);
	$paradas_cercanas = obtener_paradas_proximas($coordenadas['latitud'], $coordenadas['longitud'], 1500, 10);
	$numero_paradas = count($paradas_cercanas);
	$por_direccion = true;
	$direccion_g = $coordenadas['direccion'];
	
	if($numero_paradas < 1)
	{
		$salida = array();
		$por_direccion = false;
		$calle = addslashes(trim(strip_tags($direccion)));
		$paradas_cercanas = SearchByName($calle);
		$paradas_cercanas = unserialize($paradas_cercanas);
		foreach($paradas_cercanas as $parada)
		{
			$tmp['label'] = $parada['nombre'];
			$tmp['nombre'] = $parada['numero'];
			$salida[] = $tmp;
		}
		$paradas_cercanas = $salida;
		
	}
}
else {
		$salida = array();
		$por_direccion = false;
		$calle = addslashes(trim(strip_tags($direccion)));
		$paradas_cercanas = SearchByName($calle);
		$paradas_cercanas = unserialize($paradas_cercanas);	
		foreach($paradas_cercanas as $parada)
		{
			$tmp['label'] = $parada['nombre'];
			$tmp['nombre'] = $parada['numero'];
			$salida[] = $tmp;
		}
		$paradas_cercanas = $salida;	
}

// Ahora miro a ver cuantos resultados tengo y los pinto
$numero_paradas = count($paradas_cercanas);
if($numero_paradas > 0)
{
$primera_parada = $paradas_cercanas[0]['nombre'];
}


}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>

<title><?=html_title("Buscador de paradas")?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Buscador de paradas Tubus facilita el acceso a toda la información relativa al sistema de transporte urbano granadino. Gracias a TuBus es muy sencillo conocer el tiempo estimado de llegada de cada autobús en cada parada, desde cualquier lugar y en cualquier momento." /> 
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
<link rel="prerender" href="<?=$configuracion['home_url']?>/<?=$primera_parada?>">
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
<?php include_once 'ad.php'; ?>
<div id="sub-cont" class="zona-paradas">
			<h1><span>Buscar paradas de autobús</span></h1>
            <span class="liine"></span>
	            
	<div id="datos_parada">
		<?php
		if(!$buscar)
			echo '<h3>Introduce una dirección para encontrar paradas cercanas a ella.</h3>';
		
		else
		{
			
				echo '<h2>Resultados de búsqueda: <em>'.$direccion.'</em> (<a href="#otraparada">Cambiar</a>)</h2>';
			if($por_direccion) 
				echo '<div style="font: 13px arial,sans-serif; color: rgb(149, 149, 149);" id="rvsgeo"><img src="/style/images/positions.png" alt="buscar paradas" style="float: left; margin-right: 5px;" id="pst-ition">'.$direccion_g.'</div>';
			
			
		}
		
		?>
	</div>

<div class="resultados-buqueda">	
		<?php
		if($numero_paradas > 0){
			foreach($paradas_cercanas as $parada){
                $lineas_parada = obtener_lineas_parada($parada['nombre']);
                $lineas_parada = array_elimina_duplicados($lineas_parada, 'nombre');
				$sal = '';
				//print_r($lineas_parada);
		?>		
		<a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" class="caja-buscada">
		<div class="parada-num" id="parada-<?=$parada['nombre']?>">
			<span class="ir-parada"></span>
			<h2>Parada nº <?=$parada['nombre']?></h2>
			<h3><?=$parada['label']?></h3>
            <?php if($lineas_parada != false) { ?>
			<p>Líneas: <?php foreach($lineas_parada as $linea_p){$sal .= $linea_p['nombre'].',&nbsp;';}; $sal = rtrim($sal,',&nbsp;'); echo $sal;?></p>
            <?php } ?>
        </div>
		</a>
		
		<?php }
		}
		else if($buscar)
		{
			?>
			<p>No se han encontrado resultados para la dirección buscada</p>
			<?php
		}
		
		 ?>
	</div>
</div>


<!-- Por aqui meto mano -->
<div id="otraparada">
	 <h1>Buscar paradas de autobús</h1> 
	<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input x-webkit-speech="x-webkit-speech" class="caja-datos" type="text" value="<?=$direccion?>" name="querystring" id="querystring" />
		<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puedes buscar por dirección o directamente por el número de parada.</div>
</div>
<!-- Hasta aquí -->

<?php include 'footer.php'; ?>	
