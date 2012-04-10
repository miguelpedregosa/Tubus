<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';

$ip = get_real_ip();
$userid = get_userid();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("¿Qué es Tubus? Preguntas frecuentes")?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Aviso lega, privacidad y condiciones de uso de Tubus." /> 
<meta name="keywords" content="bus urbano, rober, granada, tubus, autobus, urbano, granadino, tiempo real, paradas, metro ligero, ave, fuente las batallas, marquesinas, paneles" /> 

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

<script language="JavaScript"> 
usuario="contacto" 
dominio="tubus.es" 
conector="@" 


function dame_correo(){ 
   return usuario + conector + dominio 
} 

function escribe_enlace_correo(){ 
   document.write("<a href='mailto:" + dame_correo() + "'>" + dame_correo() + "</a>") 
}
 
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
		<h1><span>Todo sobre Tubus</span></h1>
		<span class="liine"></span>
<?php include_once 'ad.php'; ?>		
	
	<h2 id="1">¿Qué es Tubus?</h2>
	<p>Tubus es un proyecto web que pretende incentivar y apoyar el uso del transporte público acercando a los usuarios del mismo toda la información relevante que pudieran necesitar. 
    Nuestra labor es la de hacerte llegar la información que necesitas sin importar con qué dispositivo te conectes a Internet.</p>
	
    <h2 id="2">¿Qué ciudades y medios de transporte soporta actualmente Tubus?</h2>
    <p>Actualmente tenemos cubiertas en mayor o menor medida la ciudades de: Granada (España), Valencia (España), Zaragoza (España), Barcelona (España) y Málaga (España). Nos centramos principalmente en el servicio de autobús urbano. Trabajamos para dar soporte a más servicios de transporte público de la ciudad así como añadir paulativamente nuevas ciudades a la web.</p>
    
    <h2 id="2.5">¿Cómo seleccionar una ciudad en Tubus?</h2>
    <p>Tubus está preparado para mostrar por defecto la información del transporte urbano de la ciudad desde la que el usuario se conecta. Pero, si quieres ver la información de otra ciudad, se puede acceder al intercambiador de ciudades. En la página principal, justo a la derecha del nombre de tu ciudad aparece un enlace para cambiar. Si se sigue este enlace, se presentarán en pantalla todas las ciudades con las que cuente el sistema hasta ese momento, pudiendo el usuario ya seleccionar aquella que le interese. En cualquier caso, siempre se puede acceder al intercambiador a través de la dirección del <em><?php echo anchor("ciudad.php",'intercambiador de cuidades', 'Intercambiador de ciudades en Tubus');?></em> para seleccionar una ciudad diferente</p>
    
    <h2 id="3">¿Cómo funciona Tubus?</h2>
    <p>El funcionamiento de Tubus es muy sencillo, dependiendo de la información que quieras obtener se procede de una forma u otra. Para obtener toda la información de una parada necesitarás su número de parada, una vez que tengas dicho número solamente tienes que cargar la siguiente dirección web en su navegador <em>http://tubus.es/#numero#/</em> ej: <em>http://tubus.es/304/</em> Puedes usar <?php echo anchor("buscador.php",'nuestro buscador', 'Buscar paradas en Tubus');?> para encontrar paradas por su número o por la dirección de la parada <em>Ej: <?php echo anchor('buscador.php?querystring=beethoven', 'Beethoven', 'Buscar paradas en la calle Beethoven')?></em></p>
	
    <h2 id="4">¿Dónde puedo encontrar el número de la parada?</h2>
    <p>El número de cada parada suele estar en la marquesina de la misma, en el cartel dónde aparece el plano de la ciudad y las líneas urbanas. En otras ocasiones aparece en una pequeña pegatina que puede estar pegada en cualquier parte de la marquesina o poste informativo de la parada. En algunas ocasiones las paradas no tienen visible su número de parada por alguna razón, en este caso prueba usando el buscador.</p>
    
    <h2 id="5">¿Está actualizada la información sobre las llegadas de cada parada?</h2>
    <p>Si, al menos todo lo actualizada que pueda estar la información en las distintas webs de los transportes municipales, de donde consultamos los datos. Para mejorar el rendimiento y evitar sobrecargas en las páginas que utilizamos como fuente de datos, cacheamos los resultados durante 30 segundos como máximo, de forma que si simultáneamente varias personas consultan la misma parada solo haremos una consulta a la web de la empresa municipal de transportes, en intervalos de 30 segundos, en lugar hacer una consulta diferente por cada visitante de Tubus.</p>
    
    <h2 id="6">¿Para qué necesito Tubus si están las páginas web de las empresas municipales de transportes?</h2>
    <p>En nuestra opinión, todo es mejorable y las webs de las empresas municipales de transportes se pueden mejorar bastante en temas de diseño y usabilidad. Encontrar la información de una parada no suele ser intuitivo y requiere de varios clic, hacen uso de iframes y otros elementos web que pueden no mostrarse adecuadamente en todos los navegadores. Intentar obtener dicha información a través de un navegador móvil es una tarea bastante más complicada que si hacemos uso de Tubus</p>
    
    <h2 id="7">Obtengo un error a la hora de obtener las próximas llegadas de una parada. ¿A que se debe?</h2>
    <p>No es raro que haya errores en el sistema que usan las distintas empresas municipales de transportes para mostrar la información en sus páginas web, en dicho caso no podremos obtener la información que nos solicita y Tubus le mostrará un error. De igual forma obtendrá un error si se encuentra fuera del horario de tránsito de autobuses o si la parada ha sido desactivada.</p>
    
    <h2 id="8">¿Qué es la búsqueda de paradas cercanas?</h2>
    <p>La búsqueda de paradas cercanas es una utilidad de Tubus que le permite obtener todas la paradas de autobús cercanas a su posición actual (en un radio de 300 metros). Necesita de un navegador web que soporte la geolocalización de html 5 para poder enviarnos su localización. Actualmente iPhone y Android soportan geolocalización, así como las últimas versiones de Google Chrome, Mozilla Firefox y Safari. Se trata de una utlidad en fase beta ya que no disponemos de la ubicación de todas las paradas.</p>
    
    <h2 id="9">¿Por qué no aparece ningún resultado al buscar paradas cercanas a mi posición?</h2>
    <p>En primer lugar debes asegurarte que el navegador web que estás usando para acceder a Tubus soporta la geolocalización, en algunos dispositivos deberás establecer los ajustes pertinenetes para permitir al navegador hacer uso del sistema GPS o similar, consulta el manual de usuario. Si sigues sin obtener paradas cercanas asegúrate que al menos te ubica correctamente en el mapa de situación. Por último, puede ser que no haya paradas cercanas geolocalizadas por Tubus.</p>
    
    <h2 id="10">¿Por qué no están geolocalizadas todas las paradas de la ciudad?</h2>
    <p>La geolocalización de las paradas se realiza por parte del equipo de Tubus, desplazándonos personalmente parada por parada para obtener la localización física del lugar. Vamos incorporando paradas nuevas prácticamente todos los días, en el mapa de la web podrás ver el porcentaje de paradas geolocalizadas. Si te encuentras físicamente en una parada que no dispone de ubicación (no aparece el mapa de situación) y cuentas con un dispositivo que soporte geolocalización puedes ayudar a Tubus, enviándonos la localización de la misma. Solamente tienes que hacer clic en el botón que aparece en la parte superior izquierda de la pantalla. Si te equivocas al enviar la posición o no aparece en el lugar correcto puedes volver a enviar la localización.</p>
    
    <h2 id="11">He encontrado una parada mal situada o que ha cambiado de ubicación ¿Qué hago?</h2>
    <p>Debajo del mapa de situación de cada parada encontrar un enlace titulado "Reportar error", al hacer clc en él nos puedes enviar un aviso en el que especificas que la parada que estés vistando no está bien geolocalizada. El equipo de Tubus tratará de solventar y corregir la posición de la misma en la mayor brevedad de tiempo posible.</p>
    
    <h2 id="13">El buscador de la web no encuentra la parada que busco ¿Qué pudo hacer?</h2>
    <p>El buscador de la web trata de localizar paradas buscando por dirección. Introduce la dirección de forma más precisa para refinar los resultados, incluir el número de la calle ayuda a obtener resultados más precisos.</p>
     
    
    
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>
</div>
<?php include 'footer.php'; ?>
