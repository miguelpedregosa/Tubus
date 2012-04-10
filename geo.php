<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/helpers.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';
if(isset($_REQUEST['menulat']) && isset($_REQUEST['menulong'])){
    $lat = $_REQUEST['menulat'];
    $long = $_REQUEST['menulong'];
}
else{    
    $lat = $_REQUEST['lat'];
    $long = $_REQUEST['long'];
}

if(isset($_REQUEST['parada_n'])){
	$no_parada = (int)$_REQUEST['parada_n'];
	$title_html = 'la parada '.$no_parada;
	$texto_mapa = 'Ubicación aproximada';
	$mi_icono = 'punto-rojo.png';
}
else{
	$no_parada = 0;
	$title_html = 'mi posición actual';
	$texto_mapa = 'Mi ubicación aproximada';
	$mi_icono = 'persona.png';
}

$radio = (int)$_REQUEST['radio'];
if(!isset($radio) or $radio == '' or $radio == 0 or $radio > 5000)
    $radio = 1800;
 //$paradas = obtener_paradas_proximas($lat, $long);
 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Paradas cercanas a ".$title_html)?></title>
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

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script>
function add_link(url, rel) {
  var link = document.getElementById(rel) || document.createElement('link');
  link.id = rel;
  link.rel = rel;
  link.href = url;
  document.body.appendChild(link);
}



   var geocoder;
   var map;
   var paradas = [];
   var watchProcess = null;
   var markers = [];
   var ventanitas = [];
   var timestamp = 0;
   var primeracarga = true;
   var radio = <?=$radio?>;
   <?php if ($lat != "" && $long != ""){ ?>
   var milat = <?= $lat ?>;
   var milong = <?= $long ?>;
   <?php } else {?>
   var milat;
   var milong;
   <?php } ?>
   
    var IconBus = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-azul.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	var IconPersona = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/<?=$mi_icono?>', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
   
   function toggleStreetView() {
				var toggle = panorama.getVisible();
				if (toggle == false) {
					
					document.getElementById( "street" ).innerHTML = "<img onclick='toggleStreetView();return false' src='<?=$configuracion['home_url']?>/style/images/meap.png' alt='vista de mapa' />";
					panorama.setVisible(true);
				} else {
					
					document.getElementById( "street" ).innerHTML = "<img onclick='toggleStreetView();return false' src='<?=$configuracion['home_url']?>/style/images/calle.png' alt='vista de calle' />";
					panorama.setVisible(false);
				}
	}
   
 jQuery(window).ready(function(){
       
       //initiate_geolocation();
       
        jQuery("#boton-buscar-parada").click(function(){
        //$('#mini-ajax').show(); 
        initiate_geolocation();
        });
        
        
        $('#geowatch').iphoneSwitch("off", 
        function() {
            initiate_watchlocation();
        },
        function() {
            stop_watchlocation();
        },
        {
            switch_on_container_path: 'iphone_switch_container_off.png'
        });
      
        <?php if ($lat != "" && $long != ""){ ?>
        primeracarga = false;
        var punto = new google.maps.LatLng(<?=$lat?>, <?=$long?>);
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({'latLng': punto},function(results, status){
				var direccion;
				
				if (status == google.maps.GeocoderStatus.OK) {
					if(results[0]){
						direccion = results[0].formatted_address;
					}
					else
					{
						direccion = ' - ';
					}
			   }
			   else
			   {
				   direccion = ' - ';
			   }
			   
			   $("#rvsgeo").html('<img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de: '+ direccion);
	           $("#rvsgeo").show();
	           //Miro a ver si está en la ciudad correcta o no
	           
	           <?php if($configuracion['master'] == true) {?> 
	           
	           	var url = '<?=$configuracion['home_url']?>/ajax/ajaxgeociudad.php?lat='+<?=$lat?>+'&long='+<?=$long?>;
				$.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
						
						var resultado = eval('(' + data + ')');
                        
                        if(resultado['mostrar'] == 'si')
                        {
							var html = resultado['mensaje'];
							$('#ciudadmsg').html(html);
							$('#geoglobo').fadeIn('slow', function() {
								// Animation complete.
							});
						
						}

                    }
                });
	           
	           //Fin de la pelicula, el mayordomo era culpable. Condenado a cadena perpetua.
	            <?php } ?>
	           //consultar_paradas_cercanas(position.coords.latitude, position.coords.longitude, direccion );
	           consultar_paradas_cercanas(<?=$lat?>, <?=$long?>, direccion);
		   });
        
        
        <?php } else { ?>

        <?php } ?>
        toggle_menu();
       
 });

  
    
function normalize_yql_response(response)
    {
        if (response.error)
        {
            var error = { code : 0 };
            handle_error(error);
            return;
        }

        var position = {
            coords :
            {
                latitude: response.place.centroid.latitude,
                longitude: response.place.centroid.longitude
            },
            address :
            {
                city: response.place.locality2.content,
                region: response.place.admin1.content,
                country: response.place.country.content
            }
        };

        handle_geolocation_query(position);
        
    }

    
    function initiate_watchlocation() {  
        if (watchProcess == null) {  
         watchProcess = navigator.geolocation.watchPosition(function(position){
             //alert(timestamp);
             var tiempo_antes = timestamp;
             var ahorita = new Date();
             var tiempo_ahora = ahorita.getTime()/1000;
             var diferencia = tiempo_ahora - tiempo_antes;
             //$('#watchcontador').html('Han pasado '+diferencia+' segundos');
             //alert("Han pasado: "+diferencia+" segundos");
             if(diferencia >= 30)
                        handle_geolocation_query(position);
             }, handle_errors, {enableHighAccuracy:true});  
       }  
    }  
 
    function stop_watchlocation() {  
        if (watchProcess != null)
            {
                navigator.geolocation.clearWatch(watchProcess);
                watchProcess = null;
            }
    } 

	function pintar_mapa(latitud, longitud, paradas, direccion){
	 //Google Maps 1.3
	$('#ubicacion').show(); //Muestro el mapa
	 var estilo_mapa = [
			{
			featureType: "transit.station.bus",
			elementType: "labels",
			stylers: [
				{ visibility: "off" }
			]
			}
		];
            var centro = new google.maps.LatLng(latitud, longitud);
            
            var opciones = {
				zoom: 16,
				center: centro,
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
			}

            
            map = new google.maps.Map(document.getElementById("map"), opciones);
            
             var styledMapOptions = {
					name: "Tubus"
			}

			var TubusMapType = new google.maps.StyledMapType(estilo_mapa, styledMapOptions);

			map.mapTypes.set('tubus', TubusMapType);
			map.setMapTypeId('tubus');
	 
	 
	 //Opciones para la vista StreetView
  		    panorama = map.getStreetView();
			panorama.setPosition(centro);
			panorama.setPov({
				heading: 180,
				zoom:1,
				pitch:0}
				);
			   
			   MImarker = new google.maps.Marker({
							position: centro,
							icon: IconPersona,
							map: map
							});
			  var MIinfowindow = new google.maps.InfoWindow(); 
			  var MIhtml = "<h3 class=\"globo-titulo\">Mi posición</h3><p class=\"globo-parrafo\">"+direccion+"</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-persona-image\"></span>Se encuentra aproximadamente aquí</p></div>";

			  MIinfowindow.setContent(MIhtml);
					   //infowindow.open(map, marker);
	
					   google.maps.event.addListener(MImarker, 'click', function() {
							MIinfowindow.open(map, MImarker);
						});	
			if(paradas){
			  for (var i = 0; i<paradas.length; i++) { 
                            var html = paradas[i]['globohtml'];
                            var llatitud = paradas[i]['latitud'];
                            var llongitud = paradas[i]['longitud'];
                
                            createMarker(llatitud, llongitud, i+1, html);
               }
		   }	
				
	
	}


 function createMarker(latitud, longitud, number, html) {
	 var point = new google.maps.LatLng(latitud, longitud);
	 markers[number] = new google.maps.Marker({
							position: point,
							icon: IconBus,
							map: map
							});
	markers[number].value = number;
	ventanitas[number] = new google.maps.InfoWindow();
	ventanitas[number].setContent(html);
	google.maps.event.addListener(markers[number], 'click', function() {
				ventanitas[number].open(map, markers[number]);
	});
	
 }


    function consultar_paradas_cercanas(latitud, longitud, direccion){
        var url = '<?=$configuracion['home_url']?>/ajax/ajaxproximity.php?lat='+latitud+'&long='+longitud+'&radio='+radio+'&no_parada=<?=$no_parada?>';
                //alert(url);
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
						var resultado = eval('(' + data + ')');
                        $('#georesultados').html(resultado['html']);
                        $('#fecharesultado').html(resultado['fecha']);
                        $('#mini-ajax').hide();
                        $('#fecharesultado').show();
                        var paradas = [];
                        paradas = resultado['paradas'];
                        pintar_mapa(latitud, longitud, paradas, direccion);
                        var ahoritaf = new Date();
                        timestamp = ahoritaf.getTime()/1000;
                        
						var url1 = '<?=$configuracion['home_url']?>/'+paradas[0]['nombre']+'/';
						add_link(url1, 'prerender');
                    }
                });
        
    }




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
                //alert("Debes dar permiso para acceder a tu localizacion ");
                $('#georesultados').html('<p class="info_general">Debes dar permiso para acceder a tu localización</p>');
                $('#mini-ajax').hide();
            break;

            case error.POSITION_UNAVAILABLE: 
                //alert("No se ha podido detectar tu posicion actual");
                $('#georesultados').html('<p class="info_general">No se ha podido detectar tu posicion actual</p>');
                $('#mini-ajax').hide();
            break;

            case error.TIMEOUT: 
                //alert("Tiempo de espera agotado");
                $('#georesultados').html('<p class="info_general">Tiempo de espera agotado</p>');
                $('#mini-ajax').hide();
            break;

            default: 
                //alert("Error desconocido");
                $('#georesultados').html('<p class="info_general">Error desconocido</p>');
                $('#mini-ajax').hide();
            break;
        }
    }


    function handle_geolocation_query(position){
		milat = position.coords.latitude;
		milong = position.coords.longitude;
        if(primeracarga){
			$('#georesultados').html('<div id="carga-ajax"><span src="<?=$configuracion['home_url']?>/style/images/image_58229.gif" class="carga-fig">Cargando...</span></div>');
			//$('#mini-ajax').show();
			primeracarga = false;
		}
		else{
			 $('#mini-ajax').show();
		}
		
		var punto = new google.maps.LatLng(milat, milong);
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({'latLng': punto},function(results, status){
				var direccion;
				
				if (status == google.maps.GeocoderStatus.OK) {
					if(results[0]){
						direccion = results[0].formatted_address;
					}
					else
					{
						direccion = ' - ';
					}
			   }
			   else
			   {
				   direccion = ' - ';
			   }
			   
			   $("#rvsgeo").html('<img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de: '+ direccion);
	           $("#rvsgeo").show();
	           
	           var url = '<?=$configuracion['home_url']?>/ajax/ajaxgeociudad.php?lat='+position.coords.latitude+'&long='+position.coords.longitude;
				$.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
						
						var resultado = eval('(' + data + ')');
                        
                        if(resultado['mostrar'] == 'si')
                        {
							var html = resultado['mensaje'];
							$('#ciudadmsg').html(html);
							$('#geoglobo').fadeIn('slow', function() {
								// Animation complete.
							});
						
						}

                    }
                });
	           
	           
	           consultar_paradas_cercanas(position.coords.latitude, position.coords.longitude, direccion );
		   });
        
       } 
    </script>
    <script>
     jQuery(window).ready(function(){
		 
		 $('#hideball').click(function(event) {
					event.preventDefault();
					$.cookie("autogeoreminder", "falso", { path: '/', expires: 365 });
					$('#geoglobo').fadeOut('slow', function() {
					// Animation complete.
					});
		});
		 
		 });
    </script>
</head> 

<!-- <body onload="load()" onunload="GUnload()"> -->
<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	<!-- Mensaje de cambio de ciudad -->
			<div class="apartado-bus" id ="geoglobo" style="display:none;margin-top:14px;">
			
            <span class="flechacaza"></span>
			<span class="sup-izq"></span>
			<span class="sup-der"></span>
			<span class="inf-izq"></span>
			<span class="inf-der"></span>
            
			<div class="apartado-contenido">
			<table>
			<tr>
			<td style="margin-left:10px;display:block;"><span style="font-family:arial;font-style:italic;font-size:14px;"><span id="ciudadmsg">Tubus está disponible en tu ciudad. Ir a <a href="ciudad.php?ciudad=GRANADA" title="Acceder a la información de Granada">Tubus Granada</a></span> <small><a href="#" id="hideball" title="Cerrar mensaje y no volver a mostrar">No volver a mostrar este mensaje</a></small></span></td>
			</tr>
			</table>
			</div>	
			</div>
		<!-- Fin Mensaje de cambio de ciudad -->
 <div id="cuerpo">
 <?php include_once 'menu-horizontal.php'; ?>
 <?php include_once 'ad.php'; ?>
 <div id="sub-cont">
				<h1><span>Paradas cercanas a <?=$title_html?></span></h1>
				<span class="liine"></span>					
	<?php if ($_GET['nogeo'] != '1') { ?>
	<div id="datos_parada_2">
        <div id="rvsgeo" style="display:none;position:absolute;left:12px;top:118px;font:normal normal 13px arial,sans-serif;color:#959595;"><img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de: </div>
        <p class="info_general posicion-actu">
        <img src="/style/images/buscar-parada.gif" alt="buscar paradas" id="boton-buscar-parada"/> 
		<span class="actu">Seguir mi posición</span>
        </p>
        <div class="left" id="geowatch"></div>
    </div>
	<?php } ?>
	<span class="clear"></span>
	<div id="resuelto">
	 <h2 style="margin-top:25px; margin-bottom:30px;">Resultados de Búsqueda<span id="mini-ajax" style="position:relative; display:none"><img src ="<?=$configuracion['home_url']?>/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h2> 
	 <h5 class="resuelto-fecha" id="fecharesultado" style="display:none;" >Última búsqueda:</h5>
	<div class="resultados-buqueda" id="georesultados">	
        <?php if ($lat != "" && $long != ""){ ?>
			<p class="info_general"> Realizando búsqueda sobre un <?php echo obtener_porcentaje_paradas_geolocalizadas(); ?>% de las paradas de <?=$configuracion['ciudad']?></p>
		<?php } else {?>
			<p class="info_general"> Pulse en <strong>Buscar paradas</strong> para encontrar paradas cercanas a su posición (<?php echo obtener_porcentaje_paradas_geolocalizadas(); ?>% de las paradas geolocalizadas en <?=$configuracion['ciudad']?>)</p>
		<?php } ?>
	</div>
</div>
</div>
<div id="ubicacion" style="display:none;">
	<h1><?=$texto_mapa?></h1>  
	<div id="map" style="width: 85%; height: 20em" ></div>
			<p id="res_reporte">
				<span id="street"><img onclick='toggleStreetView();return false' src="<?=$configuracion['home_url']?>/style/images/calle.png" alt="vista de calle" /></span>
			</p>
</div>
<div id="otraparada">
	 <h1>Buscar paradas de autobús</h1> 
	<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input class="caja-datos" type="text" value="" name="querystring" id="querystring" />
		<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puedes buscar por dirección o directamente por el número de parada.</div>
</div>
<?php include 'footer.php'; ?>
