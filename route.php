<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";
require_once "system.php";
$num_res = 5;
$pinta_fav = false;
$logged_u =  is_logged();
$geolocation_ready = is_geolocation_capable();

$step = NULL;

//Asignación de variables
$parada_id = intval($_GET['id_parada']);
$nombre_parada = obtener_nombre_parada($parada_id);
$coordenadas_parada = get_coordenadas($parada_id);

if($parada_id == null || !isset($_GET["id_parada"]) || $parada_id == 0)
{
	header('Location: '.$configuracion['home_url'].'/');
	exit();
}


if(!$geolocation_ready)
{
	//Redirijo a la versión nroute
	header('Location: '.$configuracion['home_url'].'/nroute.php?id_parada='.$parada_id);
	exit();
	
}


$trasbordos_parada = obtener_lineas_parada($parada_id);



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
    
<script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
<script src="<?=$configuracion['home_url']?>/js/gears_init.js"></script>
<script src="<?=$configuracion['home_url']?>/js/yqlgeo.js"></script>
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
    
    <script src="http://maps.google.es/maps/api/js?sensor=false&language=es" type="text/javascript"></script>
    
    <script type="text/javascript">
	var watchProcess = null;
	var timestamp = 0;
	var timestamp_mapa = 0;
	var map;
	var marker_yo, marker_parada;
	var mapa_pintado = false;
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	   
	var IconBusAzul = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-azul.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	var IconBusRojo = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-rojo.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	var IconPersona = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/persona.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );

    
    function initiate_geolocation() {
        
        
        //alert("Actualizacion manual");
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
    
    
    function mostrar_pasos_ruta(resultado)
    {
		//console.log(resultado);
		var myRoute = resultado.routes[0].legs[0];
		var html = '';
		
		
		//Recorro los pasos 
		for (var i = 0; i < myRoute.steps.length; i++) {
				
				var instrucciones = myRoute.steps[i].instructions;
				var distancia = myRoute.steps[i].distance;
				var duracion = myRoute.steps[i].duration;
				
				
				html = html + '<span class="liine2"></span>' + '<span class="apartado-bus-trasbordos">' + '<table style="width:100%;" id="linea_' +(i+1) +'">' + '<tr>' + '<td class="numero">'+ (i+1) +'.</td>' + '<td class="destino2"><strong>' + instrucciones + '</strong> '+distancia.text +'</td>' + '</tr>' + '</table>' + '</span>';						
		}
			
		html = html + '<span class="liine2"></span>';
		$('#trasbordos').html(html);
		
	}
	
	function error_directions()
	{
		var html = '<span class="liine2"></span> <span class="apartado-bus-trasbordos"> <table style="width:100%;" id="linea_1"> <tr> <td class="numero">&nbsp;</td> <td class="destino2"><strong>Lamentamos nos poder ofrecer este servicio temporalmente. Pedimos disculpas por las molestias causadas</td> </tr> </table> </span> <span class="liine2"></span>';
		$('#trasbordos').html(html);
	}
    
    
    
    function pintarMapa(miposicion, parada){
		
		var start = new google.maps.LatLng(miposicion['latitud'],miposicion['longitud']);
		var end = new google.maps.LatLng(parada['latitud'],parada['longitud']);
		
		//Pinto el mapa en el navegador
		
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
     
     //Pinto el punto donde me encuentro y el punto de destino
			
		 marker_yo = new google.maps.Marker({
			position: start, 
			map: map,
			icon: IconPersona
		});
					
		marker_parada = new google.maps.Marker({
			position: end, 
			map: map,
			icon: IconBusRojo
		});
		
		
		var infowindow = new google.maps.InfoWindow(); 
					   
		<?php
		$sal_g = '';
		foreach($trasbordos_parada as $linea_p){
		$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_p['color']).";\">".addslashes($linea_p['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_p['llegada'])."</p>";
		};
					
		$globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".addslashes($nombre_parada['nombre'])."/\">Parada nº ".addslashes($nombre_parada['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes($nombre_parada['label'])."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"></p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
		echo 'var html_globo = \''.$globohtml.'\';'."\n";
				
		?>
					   
		infowindow.setContent(html_globo);
		
		google.maps.event.addListener(marker_parada, 'click', function() {
							infowindow.open(map, marker_parada);
						});
		
		//Hago la petición a la API de direcciones y la pinto en el mapa
		
		var rendererOptions = {
			suppressMarkers: true
		}		
		
		directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		directionsDisplay.setMap(map); //enlace los resultados con el mapa que acabo de pintar
		
		var request = {
			origin:start, 
			destination:end,
			travelMode: google.maps.DirectionsTravelMode.WALKING,
			optimizeWaypoints: true,
			region: "es"
		 };
					
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				//Pinto la ruta en el mapa y actualizo la tabla de indicaciones
				mostrar_pasos_ruta(result);
				directionsDisplay.setDirections(result);
				
			}
			else
			{
				//Muestro un mensaje de error al usuario
				error_directions();
			}
		});
				
		
		//Actualizo la fecha de pintado del mapa
		var ahoritaf = new Date();
        timestamp_mapa = ahoritaf.getTime()/1000;
	}
    
    function actualizarMapa(miposicion, parada )
    {
		
		var start = new google.maps.LatLng(miposicion['latitud'],miposicion['longitud']);
		var end = new google.maps.LatLng(parada['latitud'],parada['longitud']);
		
		var tiempo_antes = timestamp_mapa;
        var ahorita = new Date();
        var tiempo_ahora = ahorita.getTime()/1000;
        var diferencia = tiempo_ahora - tiempo_antes;
		
		directionsDisplay.setMap(map);
		
		
		if(diferencia >= 60)
		{

		var request = {
			origin:start, 
			destination:end,
			travelMode: google.maps.DirectionsTravelMode.WALKING,
			optimizeWaypoints: true
		 };
		 
		 directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				
					//Pinto los pasos actualizados y el mapa
					mostrar_pasos_ruta(result);
					directionsDisplay.setDirections(result);
					
			}
			else
			{
				error_directions();
			}
		});
		
		
		marker_yo.setPosition(start);
		
		var ahoritaf = new Date();
        timestamp_mapa = ahoritaf.getTime()/1000;
       }
       else
       {
		   //Actualizo solo el marcador del muñeco
		   marker_yo.setPosition(start);
		   
	   }
	
	}
	
	
    
    
    
    function handle_geolocation_query(position){
		
		var url_route;
		//Esta es mi posición
		milat = position.coords.latitude;
		milong = position.coords.longitude;		
		
		//url_route = '<?=$configuracion['home_url']?>/ajax/route-ajax.php?id_parada=<?= $parada_id ?>&miposicion='+milat+','+milong;
		$('#mini-ajax').show();
		
		var miposicion = new Array();
		miposicion['latitud'] = milat;
		miposicion['longitud'] = milong;
		
		var parada = new Array();
		parada['latitud'] = <?=$coordenadas_parada['latitud']?>;
		parada['longitud'] = <?=$coordenadas_parada['longitud']?>;
		
		
		if(!mapa_pintado) //El mapa se repinta si se pide a mano o cada 200s para o cargar demasiado la página
					{
						//alert("Pinto el mapa");
						pintarMapa(miposicion,parada);
						mapa_pintado = true;
					}
		else
					{
						//alert('Actualizar el  mapa');
						actualizarMapa(miposicion,parada);
					}
					
		$('#ubicacion').show();
	    $('#mini-ajax').hide();
		
		var ahoritaf = new Date();
        timestamp = ahoritaf.getTime()/1000;
	}
	
	function handle_errors(error)
    {
        switch(error.code)
        {
            case error.PERMISSION_DENIED: 
                alert("Debes dar permiso para acceder a tu localizacion ");
                /*$('#georesultados').html('<p class="info_general">Debes dar permiso para acceder a tu localización</p>');
                $('#mini-ajax').hide();*/
            break;

            case error.POSITION_UNAVAILABLE: 
                alert("No se ha podido detectar tu posicion actual");
                /*$('#georesultados').html('<p class="info_general">No se ha podido detectar tu posicion actual</p>');
                $('#mini-ajax').hide();*/
            break;

            case error.TIMEOUT: 
                alert("Tiempo de espera agotado");
                /*$('#georesultados').html('<p class="info_general">Tiempo de espera agotado</p>');
                $('#mini-ajax').hide();*/
            break;

            default: 
                alert("Error desconocido");
                /*$('#georesultados').html('<p class="info_general">Error desconocido</p>');
                $('#mini-ajax').hide();*/
            break;
        }
    }
    
    function initiate_watchlocation() {  
        if (watchProcess == null) {  
         watchProcess = navigator.geolocation.watchPosition(function(position){
             var tiempo_antes = timestamp;
             var ahorita = new Date();
             var tiempo_ahora = ahorita.getTime()/1000;
             var diferencia = tiempo_ahora - tiempo_antes;
             if(diferencia >= 25){ // Las indicaciones se actualizan cada 15 segundos
						//alert("Actualizacion automática");
						$('#mini-ajax').show();
                        handle_geolocation_query(position);
					}
             }, handle_errors, {enableHighAccuracy:true});  
       }
    } 
    
    jQuery(window).ready(function(){
				
		if (navigator.geolocation){
			
			initiate_watchlocation();
		}
			
		else {
			
			initiate_geolocation();
		}
		
	
		$('#actualizarmano').click(function(event) {
			event.preventDefault();
			initiate_geolocation();
		});
		
		$('#actualizmapa').click(function(event) {
			event.preventDefault();
			initiate_geolocation();
		});
		
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
				<h1><span>Ruta a la parada <?=$nombre_parada['label']?> (<a href="<?=$configuracion['home_url']?>/<?=$parada_id?>" title="Ir a la parada <?=$parada_id?>"><?=$parada_id?></a>)</span></h1>
				<span class="liine"></span>
			
			<div id="datos_parada">
				
				<h2 class="input lii"><a title="Actualizar indicaciones" id="actualizarmano" href="#">Indicaciones paso a paso</a> <span id="mini-ajax" style="position:relative; display:none"><img src ="<?=$configuracion['home_url']?>/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h2>
				
				<!-- Aquí comienda el sistema de indicaciones -->
				<div id="trasbordos">			
				<div id="carga-ajax"><span src="<?=$configuracion['home_url']?>/style/images/image_58229.gif" class="carga-fig">Esperando ubicación...</span></div>
				<span class="liine2"></span>
				</div>	
			</div>
			<!-- Aquí acaba el sistema de indicaciones -->

			<div id="ubicacion" style="display:none">
			<h1>Mapa de la ruta (<a title="Actualizar indicaciones y mapa" id="actualizmapa" href="#">Actualizar</a>)</h1>  
			<div id="map" style="width: 85%; height: 20em"></div>
			
			</div>
			<p id="res_reporte">¿Ubicación imprecisa? <a href="<?= $configuracion['home_url'].'/nroute.php?id_parada='.$parada_id?>">Introduce tu dirección aquí</a></p>
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
