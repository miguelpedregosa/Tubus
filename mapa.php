<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
//require_once 'libs/rober.php';
require_once 'libs/functions.php';
require_once "libs/helpers.php";
require_once "libs/functions.php";
require_once "libs/movil.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Mapa de localización de parada de autobuses")?></title>
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
<link rel="search" type="application/opensearchdescription+xml" title="Buscar en Tubus" href="<?=$configuracion['home_url']?>/opensearch.xml"/>
<link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>

<script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAn0Ls-T7fxbHmhbjdUfGeiRR4mkvciC68xVMfDJ-G4kipE2SDyRRJ7jLYzv2Gpvyc0Be4ogya_BmgGA" type="text/javascript"></script>
<?php
$centro['latitud'] = $configuracion['mapa_lat'];
$centro['longitud'] = $configuracion['mapa_long'];
?>
<script type="text/javascript">
//<![CDATA[
   //var geocoder;
   var map;
   var geocoder;
   var einicio = new GLatLng(37.1535, -3.6394);
   var efin = new GLatLng(37.2288, -3.5285);
   var area_buscador = new GLatLngBounds(einicio, efin );
   function load()
   {
    if (GBrowserIsCompatible()) { 
      map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.enableScrollWheelZoom();
      map.setCenter(new GLatLng(<?=$centro['latitud'] ?>, <?=$centro['longitud'] ?>), 13);
      //map.enableGoogleBar();

       var IconBusRojo = new GIcon();
	IconBusRojo.image = '<?=$configuracion['home_url']?>/style/images/punto-rojo.png';
	//busIcon.shadow = "http://chart.apis.google.com/chart?chst=d_map_pin_shadow";
	IconBusRojo.iconSize = new GSize(16, 37);
	//busIcon.shadowSize = new GSize(22, 20);
	IconBusRojo.iconAnchor = new GPoint(8, 37);
	IconBusRojo.infoWindowAnchor = new GPoint(15, 1);
      
      <?php
      $sql = "SELECT * FROM paradas WHERE latitud IS NOT NULL AND longitud IS NOT NULL ORDER BY nombre ASC";
      $res = mysql_query($sql);
      //echo 'alert('.mysql_num_rows($res).');';
      if(mysql_num_rows($res)>0){
        while($datos = mysql_fetch_array($res)){
            $idp = $datos['id_parada'];
            $nombre = $datos['nombre'];
            $label = $datos['label'];
            $latitud = $datos['latitud'];
            $longitud = $datos['longitud'];
            $lineas_parada = obtener_lineas_parada($nombre);
            $sal = '';
            $sal_g  = '';
            $globohtml = '';
            
         ?> 

			point_<?=$datos['nombre']?> = new GLatLng(<?=$datos['latitud'] ?>, <?=$datos['longitud'] ?>);
			markerOptions = { icon:IconBusRojo };
			marker_<?=$datos['nombre']?> = new GMarker(point_<?=$datos['nombre']?>,markerOptions);
             
             
             <?php
             if($lineas_parada != false){
				foreach($lineas_parada as $linea_pc){
					$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_pc['color']).";\">".addslashes($linea_pc['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_pc['llegada'])."</p>";
             };
         }
					
				   $globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".$datos['nombre']."/\">Parada nº ".addslashes($datos['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes(utf8_encode($datos['label']))."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
					echo 'var html_'.$datos['nombre'].' = \''.$globohtml.'\';'."\n";
				
            ?>
             
             GEvent.addListener(marker_<?=$datos['nombre']?>, 'click', function() {
					marker_<?=$datos['nombre']?>.openInfoWindowHtml(html_<?=$datos['nombre']?>);
					});
					
				GEvent.addListener(marker_<?=$datos['nombre']?>, 'infowindowclose', function() {
					map.setCenter(new GLatLng(<?=$datos['latitud'] ?>, <?=$datos['longitud'] ?>));
                        });
				
				map.addOverlay(marker_<?=$datos['nombre']?>);
             
             
             
            
            <?php
        }
      
      }
      ?>
    }
   }
   
   jQuery(window).ready(function(){
		
        $("#geoenviar").click(buscar_en_mapa);
        toggle_menu();
        
       });
   
   function buscar_en_mapa(){
       
       var cadenna = $("#geoquerystring").val();
            //alert(cadenna);
            cadenna = cadenna + ', <?=$configuracion['ciudad'] ?> spain';
            //geocoder = new google.maps.Geocoder(); 
            geocoder = new GClientGeocoder();
            geocoder.setBaseCountryCode('ES');
            area_buscador = new GLatLngBounds(einicio, efin );
            geocoder.setViewport(area_buscador);
            
            if (geocoder) {
                  geocoder.getLatLng(cadenna, function(point) {
       
                        if (point) {
                        map.setCenter(point,16);
                        var marker = new GMarker(point);
                        map.addOverlay(marker);
                        
                    } else {
                    //alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            
            
            }
       
       
   }
   
   
//]]>
</script>
</head> 

<body onload="load()" onunload="GUnload()">
<div id="contenedor">
	<?php require_once 'header.php'; ?>	
<div id="cuerpo">
<?php include_once 'menu-horizontal.php'; ?>
 <div id="sub-cont">
		<h1><span>Mapa de localización de paradas</span></h1>
		<span class="liine"></span>
	<div id="datos_parada">
		<h3>El siguiente mapa muestra las paradas geolocalizadas en la ciudad de <?=$configuracion['ciudad']?>. Estas paradas representan un <strong><?php echo obtener_porcentaje_paradas_geolocalizadas(); ?>%</strong> del total de paradas presentes en la ciudad. Si lo desea puede<a href="#otraparada">buscar por calle o nº de parada</a></h3>
    </div>
	<div id="ubicacion">
	<h2>Buscar en el mapa de <?=$configuracion['ciudad']?></h2>  
    <div>
    	<form action="<?=$configuracion['home_url']?>/mapa.php" method="post" name="tubusform" id="tubusform">
		<input class="caja-datos" type="text" value="<?=$calle?>" name="geoquerystring" id="geoquerystring" style="margin-left:0;"/>
		<input class="datos-enviar" type="button" value="" name="geoenviar" id="geoenviar" />
	</form>
    </div>
	<div id="map" style="width: 85%; height: 450px; margin-top:20px;"></div>
	</div>    
    </div>
</div>
    
<!-- Por aqui meto mano -->
<div id="otraparada">
	 <h1>Buscar paradas de autobús</h1> 
		<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input class="caja-datos" type="text" value="<?=$calle?>" name="querystring" id="querystring" style="margin-left:0;"/>
		<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puede buscar por el nombre de la calle o directamente por el número de parada.</div>
</div>
<!-- Hasta aquí -->
	
<?php include 'footer.php'; ?>
