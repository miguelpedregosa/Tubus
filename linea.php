<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/lineas.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";
require_once "system.php";

if(isset($_POST['key'])){
	$fec = date('mY');
    $clave2 = $configuracion['reg_key'].':'.$fec;
    $key2 = base64_encode($clave2);
    
    if($key2 != $_POST['key']){
        header ("Location: ".$configuracion['home_url']."/lineas.php"); 
        exit();
    }
    $ldat = explode(':', strip_tags($_POST['s_cambiador']));
    $linea = $ldat[0];
    $sentido = $ldat[1];
	
	header ("Location: ".$configuracion['home_url']."/linea/".$linea."/".$sentido."/"); 
    exit();
	
}


if(!isset($num_linea) or $num_linea == ''){
  header ("Location: ".$configuracion['home_url']."/lineas.php"); 
  exit();
}

if(!isset($sentido_linea) or $sentido_linea == ''){
  header ("Location: ".$configuracion['home_url']."/lineas.php"); 
  exit();
}


$paradas_linea = obtener_paradas_lineas($num_linea,$sentido_linea);


if($paradas_linea == false){
	header ("Location: ".$configuracion['home_url']."/lineas.php"); 
  exit();
}

$datos_linea = obtener_info_linea($num_linea,$sentido_linea);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<?php $titulo_pa = 'Línea '.$num_linea.' :  '.utf8_encode($datos_linea['actual']['salida']).' - '.utf8_encode($datos_linea['actual']['llegada']); ?>
<title><?=html_title($titulo_pa)?></title>
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
<script src="<?=$configuracion['home_url']?>/js/jquery.selectboxes.min.js"></script>
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>

<script type="text/javascript">
<!--
//on page load
$(document).ready(function() {
    $("#s_cambiador").change(function() {
        var val = $(this).selectedValues();
        if (val != '') {
            //location.href=val;
            var cadena = new String(val);
            var trozos = cadena.split(':');
            var url_l = '<?=$configuracion['home_url']?>/linea/'+trozos[0]+'/'+trozos[1]+'/';
            location.href=url_l;
            
        }
    });
    toggle_menu();
});
-->
</script> 



</head>

<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	
	<div id="cuerpo">
    <?php include_once 'menu-horizontal.php'; ?>
     <?php include_once 'ad.php'; ?>
	<div id="cambiador">
	<?php
	$fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
			<form action="<?=$configuracion['home_url']?>/linea.php" method="post">
			<select id="s_cambiador" name="s_cambiador">
			<label>Sentido:</label>
			
			
			<?php
			foreach($datos_linea['trayectos'] as $trayecto)
			{
				if($trayecto['numero_trayecto'] == $sentido_linea)
				{
				?>
	<option selected="selected" value="<?=$num_linea?>:<?=$trayecto['numero_trayecto']?>"><?=utf8_encode($trayecto['salida'])?> - <?=utf8_encode($trayecto['llegada'])?></option>
				<?php
				}
				else
				{
				?>
		<option value="<?=$num_linea?>:<?=$trayecto['numero_trayecto']?>"><?=utf8_encode($trayecto['salida'])?> - <?=utf8_encode($trayecto['llegada'])?></option>
				<?php	
					
				}
			}
			
			?>
			
			</select>
			<input type="hidden" name="key" value="<?=$key?>" />
			<input type="submit" value="Cambiar">
			</form>
			</div>
<div class="resultados-buqueda lineas">	
<?php
$iterador = 0;
$longitud = count($paradas_linea);
foreach($paradas_linea as $bus_stop){
	$lineas_parada = $bus_stop['lineas'];
	$sal = '';	
	?>
	<div class="parada-num" id="parada-<?=$bus_stop['nombre'] ?>">
	<a rel="parada" href="<?=$configuracion['home_url']?>/<?=$bus_stop['nombre'] ?>/" class="caja-buscada">
	
	<?php 
	if($iterador==0) echo '<span class="linea-icon-primera"></span>';
	else if($iterador==$longitud -1)
		echo '<span class="linea-icon-ultima"></span>';
	else echo '<span class="linea-icon"></span>';
	?>
	<h2><?=$bus_stop['label'] ?> (<?=$bus_stop['nombre'] ?>)</h2>
	<?php
	
	$lineas_limpias = array_elimina_duplicados($lineas_parada, 'nombre');
	/*
	print_r($lineas_limpias); die;
	$lineas_limpias = array();
	
	
	$last_nombre = "-1hskkbvhkdkdkjgkdfjkghdkfkhhkdgjgfdghkhdfhgdlfgflgdlgld";
	foreach($lineas_parada as $linea_p)
	{
		if($linea_p['nombre'] != $last_nombre)
		{
			array_push($lineas_limpias, $linea_p);
			$last_nombre = $linea_p['nombre'];
		}
	}
	
	*/
	?>
	<p>Líneas: <?php foreach($lineas_limpias as $linea_p){$sal .= $linea_p['nombre'].',&nbsp;';}; $sal = rtrim($sal,',&nbsp;'); echo $sal;?></p>
	</a>
	<span class="liine2"></span>
	</div>

	<?php
	$iterador++;
}	
?>								
</div> 
	
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>
