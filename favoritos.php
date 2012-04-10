<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";

$logged_u=is_logged();

if($logged_u['logged'] == false){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}

//Limito la busqueda 
$resultados = 15000; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pag"]; 
if (!$pagina) { 
   	 $inicio = 0; 
   	 $pagina=1; 
} 
else { 
   	$inicio = ($pagina - 1) * $resultados; 
} 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title('Mis paradas favoritas')?></title>
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
    <script src="<?=$configuracion['home_url']?>/js/jquery.touchwipe.js"></script>
    <script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
    
    <script type="text/javascript">
    jQuery(window).ready(function(){
            
             
        $(".touchspace").touchwipe({
            wipeLeft: function(e) { 
                var favid = '#fav-'+e.target.id;
                var $zona = $(favid);
                    $zona.animate({
                        right: parseInt($zona.css('right'),10) == -200 ?
                        0 : -200
                     });
                },
            wipeRight: function(e) { 
                var favid = '#fav-'+e.target.id;
                var $zona = $(favid);
                    $zona.animate({
                        right: parseInt($zona.css('right'),10) == -200 ?
                        0 : -200
                     });
                },
            min_move_x: 20,
            preventDefaultEvents: true
        });
       
        $('.touchspace').click(function(event) {
           window.location=$(this).attr('rel'); 
        });
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
<?php
        if(have_favorites($logged_u['id_usuario'], $logged_u['tipo'])){
		$pag_sql  = "SELECT * FROM favoritos WHERE id_usuario = '".$logged_u['id_usuario']."' AND tipo_usuario = '".$logged_u['tipo']."'";
		$res_pag = mysql_query($pag_sql);
		$num_total_resultados = mysql_num_rows($res_pag); 
		//calculo el total de páginas 
		$total_paginas = ceil($num_total_resultados / $resultados);  		
		
		$fav_sql  = "SELECT * FROM favoritos WHERE id_usuario = '".$logged_u['id_usuario']."' AND tipo_usuario = '".$logged_u['tipo']."' ORDER by fecha DESC LIMIT " . $inicio . "," . $resultados; 
        $res_fav = mysql_query($fav_sql);
        if($res_fav){
        
?>        
        <!--Maqueta nueva-->
		<div id="sub-cont">
		<h1><span>MIS PARADAS FAVORITAS</span></h1>
		<span class="liine"></span>		
		<div id="register">
    
<?php
$dispositivo = mobile_device_detect();

$primero = true;
while($rowf = mysql_fetch_array($res_fav)){
    $id_parada = $rowf['id_parada'];
    $sql2 = "SELECT nombre, label, id_parada FROM paradas WHERE id_parada = '".$id_parada."' LIMIT 1";
	$res2 = mysql_query($sql2);
	$parada = mysql_fetch_array($res2);
?>        
       <?php
       if($primero){
           $primero = false; 
        ?>
        <a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" title="<?=utf8_encode($rowf['nombre_parada'])?>">
		<div class="touchspace" rel="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" style="position:relative;margin:25px 0 0 0;">
		<?php 
		if($dispositivo[1]!='Windows Phone'){
		?>
		<div id="fav-<?=$parada['id_parada']?>" class="botonerilla">
		<a href="<?=$configuracion['home_url']?>/edita-fav.php?parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/ediit.png" /></a>
		<a href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/borrar.png" /></a>
		</div>
		<?php
		}
        ?>
		<input type="submit" id="<?=$parada['id_parada']?>" value="<?=utf8_encode(strtoupper($rowf['nombre_parada']))?> (<?=$parada['nombre']?>)" class="txt-pe2"/>
		<span class="star"></span>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        </a>
        <?php
        }else{
        ?>
        <a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" title="<?=utf8_encode($rowf['nombre_parada'])?>">
		<div class="touchspace" rel="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" style="position:relative;margin:10px 0;">
		<?php 
		if($dispositivo[1]!='Windows Phone'){
		?>
		<div id="fav-<?=$parada['id_parada']?>" class="botonerilla">
		<a href="<?=$configuracion['home_url']?>/edita-fav.php?parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/ediit.png" /></a>
		<a href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/borrar.png" /></a>
		</div>
		<?php
		}
        ?>
        <input id="<?=$parada['id_parada']?>" type="submit" value="<?=utf8_encode(strtoupper($rowf['nombre_parada']))?> (<?=$parada['nombre']?>)" class="txt-pe2"/>
		<span class="star"></span>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        </a>
        
<?php }
} ?>        
		</div>
		<p class="ver-resto fav-edit"><a href="<?=$configuracion['home_url']?>/edita-fav.php">Editar Mis Favoritas</a></p>
		</div>
		<!--Fin de maqueta nueva-->
      
<?php } }
else echo '<div id="sub-cont">
		<h1><span>MIS PARADAS FAVORITAS</span></h1>
		<span class="liine"></span>
		
		<div id="register">
		<p class="error-p">No hay  <strong>paradas favoritas</strong> que mostrar.</p>
		</div>
		<p class="ver-resto vuelta"><a href="'.$configuracion['home_url'].'/user">Volver a la cuenta</a></p>
		</div> ';
?>
<?php include 'caja-busqueda.php' ?>      
</div>
<?php include 'footer.php'; ?>
