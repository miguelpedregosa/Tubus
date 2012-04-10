<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//Asignación de variables
$geolocation_ready = is_geolocation_capable();
$cache_active = $configuracion['cache_active'];  
$cache_folder = $configuracion['cache_dir']; 
$data_cache_id = $configuracion['cache_prefix'].'_'.'info_parada_'.$parada_id;
$random = mt_rand(0,150);
$error_datos = false;
$refresh_time = 45;
$nombre_parada = obtener_nombre_parada($parada_id);
$logged_u =  is_logged();
$canonical_url = 'http://'.$configuracion['cache_prefix'].'.es/'.$parada_id.'/';

if($nombre_parada != false){ //La parada está en la base de datos, por tanto uso los valores estáticos desde aquí
    $coordenadas = get_coordenadas($parada_id);
    $paradas_cercanas = obtener_paradas_cercanas($parada_id);
    $trasbordos_parada = obtener_lineas_parada($parada_id);
    $geobloqueada = is_blocked($parada_id);
    //Puede que tenga los datos de la parada, pero no los datos de sus trasbordos, en ese caso los cojo de la matriz de La Rober
    if($trasbordos_parada == false){
        $datos_serializados = @acmeCache::fetch($data_cache_id, $configuracion['cache_expiration']); 
            if(!$datos_serializados || $accion == 'r'){ 
                $datos = infoParada($parada_id);
            if($datos == '-1'){
                $error_datos = true;
            }
        $datos_serializados = serialize($datos);
        acmeCache::save($data_cache_id, $datos_serializados); 
        } 

        $tiempo_modificacion =  @acmeCache::modified_time($data_cache_id);
        $matriz_datos = unserialize($datos_serializados);
        
        $trasbordos_parada = array();
        $numdatos = count($matriz_datos['transbordos']['linea']);
         for($i=0; $i<$numdatos; $i++){
             $tmp = array();
             $tmp['id_linea'] = null;
             $tmp['nombre'] = $matriz_datos['transbordos']['linea'][$i];
             $destinos = explode('-',$matriz_datos['transbordos']['destinos'][$i]);
             $tmp['salida'] = $destinos[1];
             $tmp['llegada'] = $destinos[0];
            
            $trasbordos_parada[] = $tmp;
         }
    }
    contar_parada($parada_id);
    registrar_historial($parada_id);
    
}
else{
    //La parada no está en la base de datos
    $datos_serializados = @acmeCache::fetch($data_cache_id, $configuracion['cache_expiration']); 
    $geobloqueada = false;
        if(!$datos_serializados || $accion == 'r'){ 
            $datos = infoParada($parada_id);
            if($datos == '-1'){
                $error_datos = true;
                $trasbordos_parada = false;
                $coordenadas = false;
                $paradas_cercanas = false;
            }
            else{
                $datos_serializados = serialize($datos);
                @acmeCache::save($data_cache_id, $datos_serializados); 
            }
            
        }
    if(!$error_datos){ //Tenemos los datos traidos desde caché o desde La Rober
         $tiempo_modificacion =  @acmeCache::modified_time($data_cache_id);
         $matriz_datos = unserialize($datos_serializados);
         //Tengo que realizar la conversión de la matriz de datos que recibo en las matrices que uso en el resto del programa
         $nombre_parada = array();
         $trasbordos_parada = array();
         
         $nombre_parada['id_parada'] = null;
         $nombre_parada['nombre'] = $parada_id;
         $nombre_parada['label'] = $matriz_datos['nombre'];
         $nombre_parada['direccion'] = null;
         $nombre_parada['zona'] = null;
         $nombre_parada['zona'] = 0;
         $nombre_parada['visitas'] = 1;
         //Ahora hago lo mismo con la matriz de transbordos
         $numdatos = count($matriz_datos['transbordos']['linea']);
         for($i=0; $i<$numdatos; $i++){
             $tmp = array();
             $tmp['id_linea'] = null;
             $tmp['nombre'] = $matriz_datos['transbordos']['linea'][$i];
             $destinos = explode('-',$matriz_datos['transbordos']['destinos'][$i]);
             $tmp['salida'] = $destinos[1];
             $tmp['llegada'] = $destinos[0];
            
            $trasbordos_parada[] = $tmp;
         }

        $coordenadas = false; //No hay coordenadas porque la parada no está en la base de datos
        $paradas_cercanas = false; //No hay paradas cercanas
        contar_parada($parada_id, $nombre_parada['label']); //Registro la parada en la base de datos para futuros usos
        registrar_historial($parada_id);
        
    }
}

/*
$geolocation_ready = is_geolocation_capable();
$random = mt_rand(0,150);
$nombre_parada = obtener_nombre_parada($parada_id);
$coordenadas = get_coordenadas($parada_id);
$trasbordos_parada = obtener_lineas_parada($parada_id);
$geobloqueada = is_blocked($parada_id);
contar_parada($parada_id, $nombre_parada['label']);
registrar_historial($parada_id);
*/ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title($nombre_parada['nombre']." ".$nombre_parada['label'])?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Parada: <?=$nombre_parada['label']?> Tubus facilita el acceso a toda la información relativa al sistema de transporte urbano granadino. Gracias a TuBus es muy sencillo conocer el tiempo estimado de llegada de cada autobús en cada parada, desde cualquier lugar y en cualquier momento." /> 
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

<link rel="canonical" href="<?=$canonical_url?>" />
<link rel="prerender" href="<?=$configuracion['home_url']?>/">

<script src="<?=$configuracion['home_url']?>/js/modernizr-1.7.min.js" type="text/javascript"></script>
<script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
 <script src="<?=$configuracion['home_url']?>/js/jquery.cookie.js"></script>
 <script src="<?=$configuracion['home_url']?>/js/gears_init.js" type="text/javascript"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.timers-1.2.js"></script>
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
<?php if($configuracion['master'] == true) {?> 
<script src="<?=$configuracion['home_url']?>/js/popup.js" type="text/javascript"></script>
<?php } ?>

<script>
    var time_act = 0;
    var lineas_reducido = '';
    var lineas_extendido = '';
    var lineas_modo = 'reducido';
    
    function actualizar_fecha(parada_id){
        var urltime = '<?=$configuracion['home_url']?>/ajax/ajaxtime.php?parada='+parada_id+'&ciudad=<?=$configuracion['cache_prefix']?>';
        
                $.ajax({
                    url: urltime,
                    cache: false,
                    success: function(data) {
                        var resultado = eval('(' + data + ')');
                        $('#fechamod').html(resultado['fecha']);
                        $('#tiempomod').html(time_act);
                        time_act = time_act + 10;
                    }
                });
    }
    
    function recargar_llegadas(parada_id, recargar){
        if(recargar == '1')
            var url = '<?=$configuracion['home_url']?>/ajax/ajax.php?parada='+parada_id+'&a=r&ciudad=<?=$configuracion['cache_prefix']?>';
        else
            var url = '<?=$configuracion['home_url']?>/ajax/ajax.php?parada='+parada_id+'&ciudad=<?=$configuracion['cache_prefix']?>';
            var urltime = '<?=$configuracion['home_url']?>/ajax/ajaxtime.php?parada='+parada_id;
            $.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
                        time_act = 0;
                        $('#llegada').html(data);
                        actualizar_fecha(parada_id);
                        
                    }
                }); 
            
            
    }
    
    function cargar_panel_llegadas(parada_id, recargar){
        $('#llegada').html('<h1>Próximos autobuses en llegar</h1><div id="carga-ajax"><span src="http://m.tubus.es/style/images/image_58229.gif" class="carga-fig">Cargando...</span></div>');
        recargar_llegadas(parada_id, recargar);
    }
    
    function init_tubus(){
        <?php
        if($logged_u['logged'] == false){
            echo 'var favorito_guardado = false;';
        }
        else{
            //Ahora compruebo si la parada ya está guardada en favoritos
            if(check_favorite($logged_u['id_usuario'], $logged_u['tipo'], $nombre_parada['id_parada']))
               echo 'var favorito_guardado = true;';
            else
               echo 'var favorito_guardado = false;'; 
            
        }
        echo "\n";
        ?>
            jQuery("#boton-refrescar").click(function(event){
            event.preventDefault();
            //$('#llegada').html('<h1>Próximos autobuses en llegar</h1><div id="carga-ajax"><span src="http://m.tubus.es/style/images/image_58229.gif" class="carga-fig">Cargando...</span></div>');
            //cargar_panel_llegadas(<?=$nombre_parada['nombre']?>,'1');
            $('#mini-ajax').show();
            recargar_llegadas(<?=$nombre_parada['nombre']?>,'1');
            });
            
            jQuery("#enlace-refrescar").click(function(event){
            event.preventDefault();
            //$('#llegada').html('<h1>Próximos autobuses en llegar</h1><div id="carga-ajax"><span src="http://m.tubus.es/style/images/image_58229.gif" class="carga-fig">Cargando...</span></div>');
            //cargar_panel_llegadas(<?=$nombre_parada['nombre']?>,'1');
            $('#mini-ajax').show();
            recargar_llegadas(<?=$nombre_parada['nombre']?>,'1');
            
            });
            
            //Primera carga del sistema
            recargar_llegadas(<?=$nombre_parada['nombre']?>,'0');
            
            //Establecemos la actualización de datos cada minuto            
            //setInterval("cargar_panel_llegadas(<?=$parada_id?>,'1')",90);
            $(document).everyTime('<?=$refresh_time?>s', function(i) {
                //alert('Recargando');
                $('#mini-ajax').show();
                recargar_llegadas(<?=$nombre_parada['nombre']?>,'1');
            });
            
            $(document).everyTime('10s', function(i) {
                actualizar_fecha(<?=$nombre_parada['nombre']?>);
            });
            
           
			jQuery("#localizarme").click(function(event){
				event.preventDefault();
				initiate_geolocation();
				});


		   //Funcionalidad para mostrar información extendida de las lineas
            
            jQuery("#mostrarlineas").click(function(event){
				event.preventDefault();
				if(lineas_modo == 'reducido')
				{
					lineas_modo = 'extendido'; //Cambio el modo de lineas para que funcione el toggle
					lineas_reducido = jQuery("#lineasparada").html();//Guardo el contenido de las lineas locales en una variable para no perderlo
					
					//Miro a ver si tengo que cargar datos de internet o los tengo ya en local.
					if(lineas_extendido == '')
					{
						//Me traigo los datos de internet y los muestro
					var url = '<?=$configuracion['home_url']?>/ajax/ajaxlineasparada.php?parada=<?=$nombre_parada['nombre']?>';
					$.ajax({
							url: url,
								cache: false,
								success: function(data) {
										lineas_extendido = data;
										jQuery("#lineasparada").html(lineas_extendido);
								}
						});
						
					}
					else
					{
						//Simplemente muestros los datos en pantalla
						jQuery("#lineasparada").html(lineas_extendido);
					}
					
				}
				else
				{
					//Camnio de modo y muestro los datos locales
					jQuery("#lineasparada").html(lineas_reducido);
					lineas_modo = 'reducido';
				}
			
            });
            
            $('#hideball').click(function(event) {
					event.preventDefault();
					$.cookie("autogeoreminder", "falso", { path: '/', expires: 365 });
					$('#geoglobo').fadeOut('slow', function() {
					// Animation complete.
					});
			});
            
            //Funcionalidad para guardar en favoritos
            jQuery("#favorito").click(function(event){
                event.preventDefault();
                var parada_id = '<?=$nombre_parada['id_parada']?>';
                var parada_nombre  = '<?=$nombre_parada['nombre']?>';
                
                
                if(favorito_guardado){
                    var url_fv = '<?=$configuracion['home_url']?>/ajax/remove_favorite.php?parada='+parada_id;  
                    //var html = '<a href="<?=$configuracion['home_url']?>/favorite.php?accion=add&parada=<?=$nombre_parada['id_parada']?>&r=<?=$nombre_parada['nombre']?>" id="favorito-add" title="Guardar en favoritos"><img src="<?=$configuracion['home_url']?>/style/images/favorito_off.png" /></a>';
					//var html = '<div id="register"><div style="position:relative;margin:25px 0;"><input type="submit" value="AÑADIR A FAVORITAS" class="txt-pe"/><span class="star2off"></span><span class="btn-der"></span><span class="btn-izq"></span></div></div>';
					var html = '<img src="<?=$configuracion['home_url']?>/style/images/fav-inactivo.png" alt="Añadir para a \'Mis Favoritas\'" />';
					var hrf = '<?=$configuracion['home_url']?>/favorite.php?accion=add&parada='+parada_id+'&r='+parada_nombre+'';
                }
                else {
                    var url_fv = '<?=$configuracion['home_url']?>/ajax/add_favorite.php?parada='+parada_id; 
                    //var html = '<a href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$nombre_parada['id_parada']?>&r=<?=$nombre_parada['nombre']?>" id="favorito-remove" title="Eliminar de favoritos"><img src="<?=$configuracion['home_url']?>/style/images/favorito_on.png" /></a>';
                    //var html = '<div id="register"><div style="position:relative;margin:25px 0;"><input type="submit" value="BORRAR DE FAVORITAS" class="txt-pe"/><span class="star"></span><span class="btn-der"></span><span class="btn-izq"></span></div></div>';
					var html = '<img src="<?=$configuracion['home_url']?>/style/images/fav.png" alt="Eliminar parada de \'Mis Favoritas\'" />';
					var hrf = '<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada='+parada_id+'&r='+parada_nombre+'';
                }
                            
                //alert(url_fv);
               
                $.ajax({
                    url: url_fv,
                    cache: false,
                    success: function(data) {
                        //alert(data);
                        if(data == 'OK'){
                            if(favorito_guardado){
                                favorito_guardado = false;
                                $('#favorito').attr('title', 'Añadir parada a \'Mis Favoritas\'');
                                
							}
                            else{
                                favorito_guardado = true;
                                $('#favorito').attr('title', 'Eliminar parada de \'Mis Favoritas\'');
							}
                            $('#favorito').html(html);
                            $('#favorito').attr('href', hrf);
                        }
                        
                    }
                }); 
            });
            
            
    }
</script>

<?php if (!$geolocation_ready || $geobloqueada ) { ?>
<script>
    jQuery(window).ready(function(){
            init_tubus();
            toggle_menu();
            cargar_popup();
       });
</script>
<?php 
}?>


<?php if ($geolocation_ready && !$geobloqueada ) { ?>

<script type="text/javascript">
    jQuery(window).ready(function(){
        init_tubus();
        toggle_menu();
		cargar_popup();
       });

</script>


<?php } ?>
<?php
if($coordenadas != false) {
	?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
//<![CDATA[
   var geocoder;
   var map;
   var panorama;
   
   var IconBusAzul = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-azul.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
   var IconBusRojo = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/punto-rojo.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
   var IconPersona = new google.maps.MarkerImage('<?=$configuracion['home_url']?>/style/images/persona.png', new google.maps.Size(16, 37), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
    
    
    function initiate_geolocation() {
        if (navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(handle_geolocation_query, handle_errors, {enableHighAccuracy:true});
        }
        else
        {
            gl = google.gears.factory.create('beta.geolocation');
            gl.getCurrentPosition(handle_geolocation_query, handle_errors, {enableHighAccuracy:true});
        }
    }

    function handle_errors(error)
    {
		/*
        switch(error.code)
        {
			
            case error.PERMISSION_DENIED: alert("Debes dar permiso para acceder a tu localizacion ");
            break;

            case error.POSITION_UNAVAILABLE: alert("No se ha podido detectar tu posicion actual");
            break;

            case error.TIMEOUT: alert("Tiempo de espera agotado");
            break;

            default: alert("Error desconocido");
            break;
            
        }
        */
    }


    function handle_geolocation_query(position){
       //alert(position.coords.latitude+' '+position.coords.longitude);
       //Pinto un icono con mi posición actual en el mapa
       var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
       marker_yo = new google.maps.Marker({
							position: latlng,
							icon: IconPersona,
							map: map
	    });
     
     <?php if($configuracion['master'] == true) {?> 
     var url = '<?=$configuracion['home_url']?>/ajax/ajaxgeociudad.php?lat='+position.coords.latitude+'&long='+position.coords.longitude+'&r=<?=$nombre_parada['nombre']?>';
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
	           
     <?php } ?>
     
     }
    

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
   
   function gmapload()
   {
        
        var estilo_mapa = [
			{
			featureType: "transit.station.bus",
			elementType: "labels",
			stylers: [
				{ visibility: "off" }
			]
			}
		];
            var centro = new google.maps.LatLng(<?=$coordenadas['latitud'] ?>, <?=$coordenadas['longitud'] ?>);
            
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
     

  		    geocoder = new google.maps.Geocoder();
  		    latlng =  new google.maps.LatLng(<?=$coordenadas['latitud'] ?>, <?=$coordenadas['longitud'] ?>)
  		      	
			//Opciones para la vista StreetView
  		    panorama = map.getStreetView();
			panorama.setPosition(latlng);
			panorama.setPov({
				heading: 180,
				zoom:1,
				pitch:0}
				);
			
	    
  		    
            geocoder.geocode({'latLng': latlng},function(results, status){
				if (status == google.maps.GeocoderStatus.OK) {
						
						if(results[0]) //Si me da la direccion
						{
						marker = new google.maps.Marker({
							position: latlng,
							icon: IconBusRojo,
							map: map
							});
					   var infowindow = new google.maps.InfoWindow(); 
					   
					   <?php
				foreach($trasbordos_parada as $linea_p){
					$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_p['color']).";\">".addslashes($linea_p['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_p['llegada'])."</p>";
				};
					
				$globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".addslashes($nombre_parada['nombre'])."/\">Parada nº ".addslashes($nombre_parada['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes($nombre_parada['label'])."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-direction-image\"></span>'+results[0].formatted_address+'</p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
				echo 'var html = \''.$globohtml.'\';'."\n";
				
				?>
					   
					   infowindow.setContent(html);
					   //infowindow.open(map, marker);
	
					   google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(map, marker);
						});	
	
						}
						else //Si no me da la direccion
						{
							
							marker = new google.maps.Marker({
							position: latlng,
							icon: IconBusRojo,
							map: map
							});
					   var infowindow = new google.maps.InfoWindow(); 
					   
					   <?php
				foreach($trasbordos_parada as $linea_p){
					$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_p['color']).";\">".addslashes($linea_p['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_p['llegada'])."</p>";
				};
					
				$globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".addslashes($nombre_parada['nombre'])."/\">Parada nº ".addslashes($nombre_parada['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes($nombre_parada['label'])."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-direction-image\"></span> - </p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
				echo 'var html = \''.$globohtml.'\';'."\n";
				
				?>
					   
					   infowindow.setContent(html);
					   //infowindow.open(map, marker);
					   
					   google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(map, marker);
						});

							
						}
				}
				else{
					//console.log("Geocoder failed due to: " + status);
				}
			});
			
			
			//Ahora repetimos el proceso con las paradas cercanas
			<?php
			if($paradas_cercanas != false){
				foreach($paradas_cercanas as $parada_c){
					$sal_g = '';
					$globohtml = '';
					$geodata = get_coordenadas((int)$parada_c['nombre']);
					$trasbordos_parada_c = obtener_lineas_parada($parada_c['nombre']);
					if($geodata != false){
		    ?>
		    
		    latlng_<?=$parada_c['nombre']?> =  new google.maps.LatLng(<?=$geodata['latitud'] ?>, <?=$geodata['longitud'] ?>)
		    
		    geocoder.geocode({'latLng': latlng_<?=$parada_c['nombre']?>},function(results, status){
				if (status == google.maps.GeocoderStatus.OK) {
					if(results[0]) //Si me da la direccion
						{
							
						marker_<?=$parada_c['nombre']?> = new google.maps.Marker({
							position: latlng_<?=$parada_c['nombre']?>,
							icon: IconBusAzul,
							map: map
							});
					   var infowindow_<?=$parada_c['nombre']?> = new google.maps.InfoWindow();	

						<?php
						foreach($trasbordos_parada_c as $linea_pc){
						$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_pc['color']).";\">".addslashes($linea_pc['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_pc['llegada'])."</p>";
						};
					
						$globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".$parada_c['nombre']."/\">Parada nº ".addslashes($parada_c['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes($parada_c['label'])."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-direction-image\"></span>'+results[0].formatted_address+'</p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
						echo 'var html = \''.$globohtml.'\';'."\n";
						?>	
							
						infowindow_<?=$parada_c['nombre']?>.setContent(html);
						
						google.maps.event.addListener(marker_<?=$parada_c['nombre']?>, 'click', function() {
							infowindow_<?=$parada_c['nombre']?>.open(map, marker_<?=$parada_c['nombre']?>);
						});
						
							
						}
						else
						{
							
						marker_<?=$parada_c['nombre']?> = new google.maps.Marker({
							position: latlng_<?=$parada_c['nombre']?>,
							icon: IconBusAzul,
							map: map
							});
					   var infowindow_<?=$parada_c['nombre']?> = new google.maps.InfoWindow();	

						<?php
						foreach($trasbordos_parada_c as $linea_pc){
						$sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".addslashes($linea_pc['color']).";\">".addslashes($linea_pc['nombre'])."</span><strong>Dirección:</strong> ".addslashes($linea_pc['llegada'])."</p>";
						};
					
						$globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".$parada_c['nombre']."/\">Parada nº ".addslashes($parada_c['nombre'])." </a></h3><p class=\"globo-parrafo\">".addslashes($parada_c['label'])."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-direction-image\"></span> - </p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";
						echo 'var html = \''.$globohtml.'\';'."\n";
						?>	
							
						infowindow_<?=$parada_c['nombre']?>.setContent(html);
						
						google.maps.event.addListener(marker_<?=$parada_c['nombre']?>, 'click', function() {
							infowindow_<?=$parada_c['nombre']?>.open(map, marker_<?=$parada_c['nombre']?>);
						});							
							
							
						}
					
				}
				else
				{
					//console.log("Geocoder failed due to: " + status);
				}

				});
		    
		    
		    
		    
		    <?php	
					}
				}
			}
            ?>
		//Ya hemos pintado el mapa
		//alert('Mapa pintado');	
		<?php if($geolocation_ready) { ?>
		//initiate_geolocation();	
		<?php } ?>
   }
//]]>
</script>
<?php } ?>
</head>

<?php
if($coordenadas != false ) {
	?>
<body onload="gmapload()">
<?php } else { ?>
<body>
<?php } ?>

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
			<td style="margin-left:10px;display:block;"><span style="font-family:arial;font-style:italic;font-size:14px;"><span id="ciudadmsg">Tubus está disponible en tu ciudad. Ir a <a href="ciudad.php?ciudad=GRANADA&r=<?=$nombre_parada['nombre']?>/" title="Acceder a la información de Granada">Tubus Granada</a></span> <small><a href="#" id="hideball" title="Cerrar mensaje y no volver a mostrar">No volver a mostrar este mensaje</a></small></span></td>
			</tr>
			</table>
			</div>	
			</div>
		<!-- Fin Mensaje de cambio de ciudad -->
	<div id="cuerpo">
    <?php include_once 'menu-horizontal.php'; ?>
    <?php include_once 'ad.php'; ?>
		<div id="sub-cont" class="zona-paradas">
			<h1><span><?=$nombre_parada['label']?></span></h1>
            <span class="liine"></span>
	
			<div id="datos_parada">
                <h2>Parada Nº <?=$nombre_parada['nombre']?></h2>
                <h3>Fecha: <span id="fechamod"><?=date('j/n/Y H:i:s')?></span></h3>
                <h3><strong>Actualizado:</strong> hace <span id="tiempomod"><?=$tiempo_modificacion?></span> s</h3>
                <a title="Actualizar datos" href="<?php echo $configuracion['home_url'].'/'.$parada_id.'/r/'.$random;?>/"><img src="<?=$configuracion['home_url']?>/style/images/boton.gif" id="boton-refrescar" alt="Transportes Rober" /></a>
                <h3 id="actualizador"><a id="enlace-refrescar" title="Actualizar datos" href="<?php echo $configuracion['home_url'].'/'.$parada_id.'/r/'.$random;?>/">Actualizar datos</a></h3>
            
            <?php
             if($coordenadas != false)
             { 
				 if($geolocation_ready)
				 {
					 $gps_button = '<a title="Indicaciones paso a paso para llegar a esta parada" href="'.$configuracion['home_url'].'/route.php?id_parada='.$nombre_parada['nombre'].'"><img src="'.$configuracion['home_url'].'/style/images/ruta.png" class="latwitt" alt="Indicaciones paso a paso para llegar a esta parada"></a>';
				 }
				 else
				 {
					 $gps_button = '<a title="Indicaciones paso a paso para llegar a esta parada" href="'.$configuracion['home_url'].'/nroute.php?id_parada='.$nombre_parada['nombre'].'"><img src="'.$configuracion['home_url'].'/style/images/ruta.png" class="latwitt" alt="Indicaciones paso a paso para llegar a esta parada"></a>';
				 }
			 }
			 else
			 {
				 	$gps_button = '<a href="#" title="No hay indicaciones paso a paso hacia esta parada :("><img src="'.$configuracion['home_url'].'/style/images/ruta2.png" class="latwitt" alt="No hay indicaciones paso a paso hacia esta parada :("></a>';
			 }
            
            
            ?>
            
                       
			<?php
            if($logged_u['logged'] == false){
            ?>

			<!-- Nueva botonera que es que lo flipas fijo-->
			<div id="socials">
			<a id="favorito-no" title="Necesita registrarse o iniciar sesión para guardar estar parada" href="<?=$configuracion['home_url']?>/login.php?r=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/fav-inactivo.png" alt="Necesita registrarse o iniciar sesión para guardar estar parada"></a>
			
			<?=$gps_button?>
			<a title="Compartir parada" href="<?=$configuracion['home_url']?>/share.php?id_parada=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/share.png" alt="Compartir parada" class="lafour"></a>
			</div>
			<!-- Fin de la Nueva botonera así que puedes dejar de fliparlo -->

            <?php
            }
            else{
            //Ahora compruebo si la parada ya está guardada en favoritos
            if(check_favorite($logged_u['id_usuario'], $logged_u['tipo'], $nombre_parada['id_parada']))
            {
            ?>

		<div id="socials">
			<a id="favorito" title="Eliminar parada de 'Mis Favoritas'" href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$nombre_parada['id_parada']?>&r=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/fav.png" alt="Eliminar parada de 'Mis Favoritas'" /></a>
			<?=$gps_button?>
			<a title="Compartir parada" href="<?=$configuracion['home_url']?>/share.php?id_parada=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/share.png" alt="Compartir parada" class="lafour"></a>
			</div>
		
		
            
            <?php
            }
            else{
            ?> 
            
            <div id="socials">
			<a id="favorito" title="Guardar en m 'Mis Favoritas'" href="<?=$configuracion['home_url']?>/favorite.php?accion=add&parada=<?=$nombre_parada['id_parada']?>&r=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/fav-inactivo.png" alt="Guardar en m 'Mis Favoritas'"></a>
			<?=$gps_button?>
			<a title="Compartir parada" href="<?=$configuracion['home_url']?>/share.php?id_parada=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/share.png" alt="Compartir parada" class="lafour"></a>
			</div>
            
            
            
            <?php
            }
        }
		?>
        
        </div>
		<div id="content">
		
		<div id="llegada">
        <h4>Próximos autobuses en llegar</h4><span class="liine2"></span><div id="carga-ajax"><span src="<?=$configuracion['home_url']?>/style/images/image_58229.gif" class="carga-fig">Cargando...</span></div>
        </div>
		<h4 class="lineas-par">Líneas en esta parada</h4>
		<a href="" id="mostrarlineas" title="" ><img src="<?=$configuracion['home_url']?>/style/images/maas.png" alt="" style="float:right;border:none;margin-top:-45px;"/></a>
		<div id="lineasparada">
		<!--Lineas en modo reducido-->
		<span class="liine2" style="margin-bottom:1px;"></span>
		<?php 
       
        if($trasbordos_parada != false){
                $trasbordos_parada = array_elimina_duplicados($trasbordos_parada, 'id_linea');
                
                foreach($trasbordos_parada as $linea){ 
					if($linea['color'] == '000000')
						$linea_color = '892E11';
					else 
						$linea_color = $linea['color'];
					$url_imag_l = $configuracion['home_url'].'/imagenes/lineas/imagen_linea.php?radio=15&borde='.$linea_color.'&linea='.$linea['nombre'];
					?>
			<img class="imaglinea" src="<?=$url_imag_l?>" title="Línea <?=$linea['nombre']?>: <?= $linea['salida'].' - '.$linea['llegada'] ?>" alt="Línea <?=$linea['nombre']?>: <?= $linea['salida'].' - '.$linea['llegada'] ?>" />
		<?php } }
        else {
        ?>
        <p class="info_general">No hay información disponible actualmente.</p>
        <?php } ?>
		<!-- Fin de lineas modo reducido-->
		</div><!-- Aqui terminan las lineas -->
		
		</div>
	</div>
    </div>
	<?php
		if($coordenadas != false) {
	?>
	<div id="ubicacion">
	<h1>Ubicación de la parada (<a href="#" id="localizarme" name="localizarme" title="Detectar mi ubicación y pintarla en el mapa">Localizarme</a>)</h1>  
	<div id="map" style="width: 80%; height: 20em"></div>
	
	<p id="res_reporte">
		<a href="<?=$configuracion['home_url']?>/report_error.php?parada=<?=$parada_id?>" id="reportar">Reportar fallo</a>
		<span id="street"><img onclick='toggleStreetView();return false' src="<?=$configuracion['home_url']?>/style/images/calle.png" alt="vista de calle" /></span>
	</p>
	</div>
	<?php } ?>    
<?php include 'caja-busqueda.php' ?>
<?php
$paradas_cercanas = obtener_paradas_cercanas($parada_id,300,4);

if($paradas_cercanas != false){
?>
<div id="datos_parada">
<h1 class="ultimas-paradas">Paradas cercanas</h1>
</div>
<div class="resultados-buqueda">	
<?php
foreach($paradas_cercanas as $datos_p){
    $lineas_parada = obtener_lineas_parada($datos_p['nombre']);
	$lineas_parada = array_elimina_duplicados($lineas_parada, 'nombre');
//	print_r($lineas_parada);die;
    $sal = '';
     ?>
<a href="<?=$configuracion['home_url']?>/<?=$datos_p['nombre']?>/" class="caja-buscada">
			<div class="parada-num2" id="parada-<?=$datos_p['nombre']?>">
				<span class="ir-parada"></span>
			<h2>Parada nº <?=$datos_p['nombre']?> <span class="metros">(<?php echo str_replace('.',',',round($datos_p['distancia'],1))?> metros aprox.)</span></h2>
			<h3><?=$datos_p['label']?></h3>
			<?php if($lineas_parada != false) { ?>
            <p>Líneas: <?php foreach($lineas_parada as $linea_p){$sal .= $linea_p['nombre'].',&nbsp;';}; $sal = rtrim($sal,',&nbsp;'); echo $sal;?></p>
			<?php } ?>
            </div>
		</a>

<?php } ?>

	
<p class="a-cerca"><a href="<?=$configuracion['home_url']?>/geo.php?lat=<?=$coordenadas['latitud']?>&long=<?=$coordenadas['longitud']?>&radio=500&parada_n=<?=$parada_id?>&nogeo=1">Ver más paradas cercanas</a></p>
<?php	
}
?>
</div>
<?php include 'footer.php'; ?>
