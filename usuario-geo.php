<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "system.php";

$logged_u =  is_logged();

if($logged_u['logged'] == false){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Mi cuenta")?></title>
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
<script src="<?=$configuracion['home_url']?>/js/jquery.cookie.js"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.iphone-switch.js"></script>
<script src="<?=$configuracion['home_url']?>/js/gears_init.js"></script>
<script src="<?=$configuracion['home_url']?>/js/yqlgeo.js"></script>
 <script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
 
<script type="text/javascript">
 jQuery(window).ready(function(){
        jQuery("#geoparadas").click(function(event){
        event.preventDefault();
        //$('#mini-ajax').show(); 
        initiate_geolocation();
        });
toggle_menu();
});

function initiate_geolocation() {
        if (navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(handle_geolocation_query, handle_errors, {enableHighAccuracy:true});
        }
        else
        {
            gl = google.gears.factory.create('beta.geolocation');
            if(gl != null){
                gl.getCurrentPosition(handle_geolocation_query, handle_errors, {enableHighAccuracy:true});
            }
            else{
                yqlgeo.get('visitor', normalize_yql_response);
            }
        }
}


function handle_errors(error)
{
        switch(error.code)
        {
            case error.PERMISSION_DENIED: 
                alert("Debes dar permiso para acceder a tu localizacion ");
                //$('#georesultados').html('<p class="info_general">Debes dar permiso para acceder a tu localización</p>');
                //$('#mini-ajax').hide();
            break;

            case error.POSITION_UNAVAILABLE: 
                alert("No se ha podido detectar tu posicion actual");
                //$('#georesultados').html('<p class="info_general">No se ha podido detectar tu posicion actual</p>');
                //$('#mini-ajax').hide();
            break;

            case error.TIMEOUT: 
                alert("Tiempo de espera agotado");
                //$('#georesultados').html('<p class="info_general">Tiempo de espera agotado</p>');
                //$('#mini-ajax').hide();
            break;

            default: 
                alert("Error desconocido");
                //$('#georesultados').html('<p class="info_general">Error desconocido</p>');
                //$('#mini-ajax').hide();
            break;
        }
}

function handle_geolocation_query(position){
		milat = position.coords.latitude;
		milong = position.coords.longitude;
        jQuery("#lat").val(milat);
        jQuery("#long").val(milong);
        //alert('Coordenadas: '+milat+' '+milong);
        jQuery("#geoform").submit();
}
</script>

</head>

<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	
	<div id="cuerpo">
    <?php include_once 'menu-horizontal.php'; ?>
    	<!--Maqueta nueva-->
        <form id="geoform" name="geoform" action="<?=$configuracion['home_url']?>/geo.php" method="post">
        <input type="hidden" id="lat" name="lat" value="" />
        <input type="hidden" id="long" name="long" value="" />
        </form>
		<div id="sub-cont">
		<h1><span>Mi cuenta (<a href="<?=$configuracion['home_url']?>/ciudad.php" title="Seleccionar otra ciudad"><?=$configuracion['ciudad']?></a>)</span></h1>
		<span class="liine"></span>
		<div id="seleccion-boton">
		<a href="<?=$configuracion['home_url']?>/favoritos.php"><span class="btn-usr fav">Paradas Favoritas</span></a>
		<a href="<?=$configuracion['home_url']?>/geo.php" id="geoparadas"><span class="btn-usr alr">Paradas cercanas a mi posición</span></a>
		<a href="<?=$configuracion['home_url']?>/ultimas.php"><span class="btn-usr ult">Últimas paradas visitadas</span></a>
		<a href="<?=$configuracion['home_url']?>/cuenta.php"><span class="btn-usr usr">Mi cuenta de usuario</span></a>
		<a href="<?=$configuracion['home_url']?>/logout.php"><span class="btn-usr close">Cerrar Sesión</span></a>
		</div>
		<span class="clear"></span>
		</div>
		<!--Fin de maqueta nueva-->
    
    
    
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>

