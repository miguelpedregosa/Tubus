<?php
ini_set("display_errors" , 1);

require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";
require_once "system.php";

//Asignación de variables
$steps = NULL;
$parada_id = intval($_GET['id_parada']);
$nombre_parada = obtener_nombre_parada($parada_id);
$coordenadas_parada=array();

$calle = '';

if(isset($_POST['submit']) && $_POST['location']!=''){
	$parada_id = intval($_POST['id_parada']);
	$coordenadas_parada = get_coordenadas($parada_id);
	$nombre_parada = obtener_nombre_parada($parada_id);
	$ciudad = $configuracion['ciudad'];
	$address = urlencode($_POST['location'].'. '.$ciudad.', Spain');
	
	$trasbordos_parada = obtener_lineas_parada($parada_id);
	
	$url_info = "http://maps.google.com/maps/api/geocode/json?address=".$address."&sensor=false";
	$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_URL, $url_info);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
	$resultado = utf8_encode(curl_exec($ch));
	$error = curl_error($ch);
	$json = json_decode($resultado);
	
	if($json->status == 'OK'){		
		$miposicion = ($json->results[0]->geometry->location);
		$calle = utf8_decode($json->results[0]->formatted_address);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title("Indicaciones paso a paso para llegar a la parada $parada_id")?></title>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<meta http-equiv="Expires" content="0" />
	<meta http-equiv="Last-Modified" content="0" />
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta name="Robots" content="noarchive" />
	<meta name="rating" content="general" /> 
	
	<link rel="apple-touch-startup-image" href="http://m.tubus.es/style/images/screen.png" />

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
    
    <?php
    if(isset($_POST['submit']) && $_POST['location']!=''){
    ?>
    <script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
    <script src="http://maps.google.es/maps/api/js?sensor=false&language=es" type="text/javascript"></script>
    
    <script type="text/javascript">
	var watchProcess = null;
	var timestamp = 0;
	var map;
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	   
	var IconBusAzul = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-azul.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	var IconBusRojo = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-rojo.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	var IconPersona = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/persona.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	
	function pintar_ruta(result){
		var totalrutas = result.routes.length;
		var paso=1;
		var rutas, tramo;
		var camino='';
		
		for (route in result.routes){
			rutas = result.routes[route];
			for(leg in rutas.legs){
				tramos = rutas.legs[leg];
				for(step in tramos.steps){
					camino += '<span class="liine2"></span>';
					camino += '<span class="apartado-bus-trasbordos">';
					camino += '<table style="width:100%;" id="linea_'+paso+'">';
					camino += '<tr>';
					camino += '<td class="numero">'+paso+'.</td>';
					camino += '<td class="destino2"><strong>'+tramos.steps[step].instructions+'</strong> '+tramos.steps[step].distance.text+'</td>';
					camino += '</tr>';
					camino += '</table>';
					camino += '</span>';
					paso++;
				}
			}
		}
		camino += '<span class="liine2"></span>';
		
		$('#trasbordos').html(camino);		
	}
    
    function pintar_error(status){
		var mensaje='';
		var html='';
		
		switch(status){
			case google.maps.DirectionsStatus.INVALID_REQUEST:
				mensaje ="La solicitud proporcionada no es válida.";
				break;
			case google.maps.DirectionsStatus.MAX_WAYPOINTS_EXCEEDED:
				mensaje = 'Se proporcionaron demasiados hitos. El número máximo de hitos permitido es ocho, además del origen y del destino.';
				break;
			case google.maps.DirectionsStatus.NOT_FOUND:
				mensaje = "No se ha podido codificar geográficamente el origen, el destino o los hitos.";
				break;
			case google.maps.DirectionsStatus.OVER_QUERY_LIMIT:
				mensaje = "La página web ha superado el límite de solicitudes en un período de tiempo demasiado breve.";
				break;
			case google.maps.DirectionsStatus.OK:
				mensaje = "La respuesta contiene un valor válido.";
				break;
			case google.maps.DirectionsStatus.REQUEST_DENIED:
				mensaje = "No se permite el uso del servicio de indicaciones en la página web.";
				break;
			case google.maps.DirectionsStatus.UNKNOWN_ERROR:
				mensaje = "No se pudo procesar una solicitud de indicaciones debido a un error del servidor. Puede que la solicitud se realice correctamente si lo intentas de nuevo.";
				break;
			case google.maps.DirectionsStatus.ZERO_RESULTS:
				mensaje = "No se encontró ninguna ruta entre el origen y el destino."
				break;
		}
		
		html = '<span class="liine2"></span><span class="apartado-bus-trasbordos"><table style="width:100%;" id="linea_0"><tr><td class="numero">&nbsp;</td><td class="destino2"><strong>'+mensaje+'</strong></td></tr></table></span><span class="liine2"></span>';
		$('#trasbordos').html(html);		
	}
    
    function pintarMapa(miposicion, parada){
				
		var start = new google.maps.LatLng(miposicion[0],miposicion[1]);
		var end = new google.maps.LatLng(parada[0],parada[1]);
		
		var estilo_mapa = [
			{
			featureType: "transit.station.bus",
			elementType: "labels",
			stylers: [
				{ visibility: "off" }
			]
			}
		];
		
		var opciones = {
				zoom: 16,
				center: start,
				scrollwheel: false,
				streetViewControl: false,
				navigationControl: true,
				navigationControlOptions: {
					style: google.maps.NavigationControlStyle.DEFAULT
					},
				scaleControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'tubus']
					}
		};		

		map = new google.maps.Map(document.getElementById("map"), opciones);
		
		var styledMapOptions = {
					name: "Tubus"
			}

		var TubusMapType = new google.maps.StyledMapType(estilo_mapa, styledMapOptions);

		map.mapTypes.set('tubus', TubusMapType);
		map.setMapTypeId('tubus');
     	
		var marker_mipos = new google.maps.Marker({
			position: start, 
			map: map,
			icon: IconPersona
		});
					
		var marker_bs = new google.maps.Marker({
			position: end, 
			map: map,
			icon: IconBusRojo
		});
		
		var message = "Esto es un mensaje de prueba";
		var open = false;
		
		<?php
		$sal_g = '';
		foreach($trasbordos_parada as $linea_p){
		$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_p['color']).";\">".addslashes($linea_p['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_p['llegada'])."</p>";
		};
					
		$globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".addslashes($nombre_parada['nombre'])."/\">Parada nº ".addslashes($nombre_parada['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes($nombre_parada['label'])."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"></p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
		echo 'var html_globo = \''.$globohtml.'\';'."\n";
				
		?>
		
		var infowindow = new google.maps.InfoWindow(
			{ 
				content: html_globo
			});
		
		google.maps.event.addListener(marker_bs, 'click', function(event) {
			if(open == false){
				infowindow.open(map,marker_bs);
				open = true;
			}
			else{
				open = false;
				infowindow.close();
			}
		});
		
		var rendererOptions = {
			suppressMarkers: true
		}		
		
		directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);	
		directionsDisplay.setMap(map);
				
		var request = {
			origin:start, 
			destination:end,
			travelMode: google.maps.DirectionsTravelMode.WALKING,
			optimizeWaypoints: true,
			unitSystem: google.maps.DirectionsUnitSystem.METRIC,
			region: "es"
		 };
					
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
					pintar_ruta(result);
					directionsDisplay.setDirections(result);
			}
			else
			{
				pintar_error(status);
			}
			
		});
		
		$('#ubicacion').show();
	}
    
    function handle_geolocation_query(){
		var arrayRapido = [12,45,"array inicializado en su declaración"]
		
		var miposicion = [<?=$miposicion->lat?>,<?=$miposicion->lng?>];
		var parada = [<?=$coordenadas_parada['latitud']?>,<?=$coordenadas_parada['longitud']?>];
				
		pintarMapa(miposicion,parada);        
	}
	
	
    jQuery(window).ready(function(){
		handle_geolocation_query();
	});
	   
    </script>    
    <?php
	}
    ?>
	</head>
	<body>
	<div id="contenedor">
		<?php require_once 'header.php'; ?>		
		
		<div id="cuerpo">
        <?php include_once 'menu-horizontal.php'; ?>
		<div id="sub-cont" class="zona-paradas">
			<h1><span>Ruta a la parada <?=$nombre_parada['label']?> (<a href="<?=$configuracion['home_url']?>/<?=$parada_id?>" title="Ir a la parada <?=$parada_id?>"><?=$parada_id?></a>)</span></h1>
			<span class="liine"></span>
			
			<form method="post" action="nroute.php" id="register" name="register" autocomplete="off" >
				<label>Mi <span>dirección actual</span> es:</label><input maxlength="75" type="text" name="location" value="<?= $calle ?>" />
				<input type="hidden" name="id_parada" value="<?= $parada_id ?>" />
				<div style="position:relative;margin:15px 0;">
				<input type="submit" name="submit" value="CALCULAR RUTA" />
				<span class="btn-der"></span>
				<span class="btn-izq"></span>
				</div>
			 </form>
			 <?php
				if(isset($_POST['submit']) && $_POST['location']!=''){
			 ?>
			 <div id="datos_parada">				
				<h2 class="input lii">Indicaciones paso a paso <span id="mini-ajax" style="position:relative; display:none"><img src ="<?=$configuracion['home_url']?>/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h2>
				<!-- Aquí comienda el sistema de indicaciones -->
				<div id="trasbordos">			
					<span class="liine2"></span>
				</div>	
			</div>
			<?php } ?>		

			<div id="ubicacion" style="display:none">
				<h1>Mapa de la ruta</h1>   
			<div id="map" style="width: 85%; height: 20em"></div>
			
			</div>
			<span class="liine2"></span>
		</div>
		
		<!-- Por aqui meto mano -->
<div id="otraparada">
        <h1>Buscar paradas de autobús</h1> 
       <form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
               <input class="caja-datos" type="text" value="<?=$direccion?>" name="querystring" id="querystring" />
               <input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
       </form>
       <div class="contador">Puedes buscar por dirección o directamente por el número de parada.</div>
</div>
<!-- Hasta aquí -->
			
<?php include 'footer.php'; ?>
