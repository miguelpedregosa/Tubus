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

if (isset($_POST['enviar'])){
	if (isset($_POST['cajaparada'])&&is_numeric($_POST['cajaparada'])){
		header ("Location: ".$configuracion['home_url']."/".$_POST['cajaparada']); 
	}
	else header ("Location: ".$configuracion['home_url']."/error.php?error=2"); 
}
else{
    if($logged_u['logged'] == true){
     //Compruebo si tiene favoritos
     if(have_favorites($logged_u['id_usuario'], $logged_u['tipo'])){
        $num_res = 5;
        $pinta_fav = true;
        }   
    }
    
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title()?></title>
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

	<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>
    <link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>
    
    <link rel="search" type="application/opensearchdescription+xml" title="Buscar en Tubus" href="<?=$configuracion['home_url']?>/opensearch.xml"/>
    
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
    <script src="<?=$configuracion['home_url']?>/js/jquery.touchwipe.js" type="text/javascript"></script>
    <script src="<?=$configuracion['home_url']?>/js/yqlgeo.js" type="text/javascript"></script>
    <script src="<?=$configuracion['home_url']?>/js/menuhor.js" type="text/javascript"></script>
    <?php if($configuracion['master'] == true) {?> 
    <script src="<?=$configuracion['home_url']?>/js/popup.js" type="text/javascript"></script>
   <?php } ?>
    <script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
	
<script type="text/javascript">
function add_link(url, rel) {
  var link = document.getElementById(rel) || document.createElement('link');
  link.id = rel;
  link.rel = rel;
  link.href = url;
  document.body.appendChild(link);
}


function reverse_geocoding(latitud, longitud){
var geocoder;
geocoder = new google.maps.Geocoder();
if (geocoder)
{
	var latlng = new google.maps.LatLng(latitud, longitud);
	geocoder.geocode({'latLng': latlng}, function(results, status) {
		if(status == google.maps.GeocoderStatus.OK)
		{
			if (results[0])
			{
			    
			    $("#rvsgeo").html('<img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de: '+ results[0].formatted_address);
	            $("#rvsgeo").show();	
			}
			
		}
		else
		{
			$("#rvsgeo").html('<img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de su posición.');
            $("#rvsgeo").show();	
		}
		<?php if($configuracion['master'] == true) {?> 
		
		var url = '<?=$configuracion['home_url']?>/ajax/ajaxgeociudad.php?lat='+latitud+'&long='+longitud;
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
		
	});
}


}
    
function initiate_geolocation_auto() {
        if (navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(handle_geolocation_query_auto, handle_errors_auto, {enableHighAccuracy:true});
        }
        else
        {
            gl = google.gears.factory.create('beta.geolocation');
            if(gl != null){
                gl.getCurrentPosition(handle_geolocation_query_auto, handle_errors_auto, {enableHighAccuracy:true});
            }
            else{
                //yqlgeo.get('visitor', normalize_yql_response);
            }
        }
}


function handle_errors_auto(error)
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

 function consultar_paradas_cercanas_auto(latitud, longitud){
        var url = '<?=$configuracion['home_url']?>/ajax/ajaxautogeo.php?lat='+latitud+'&long='+longitud+'&radio=2000';
        //$('#mini-ajax').show();
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
						var resultado = eval('(' + data + ')');
                        $('#georesultados').html(resultado['html']);
                        //$('#fecharesultado').show();
                        var paradas = resultado['paradas'];
                        var href_geo = '<?=$configuracion['home_url']?>/geo.php?lat='+latitud+'&long='+longitud+'&radio=2000';
                        $('#geovermas').attr('href', href_geo);
						
						//console.log(paradas[0]['label']);
						var url1 = '<?=$configuracion['home_url']?>/'+paradas[0]['label']+'/';
						add_link(url1, 'prerender');
						
						
                        
                    }
                });
        
    }




function handle_geolocation_query_auto(position){
		milat = position.coords.latitude;
		milong = position.coords.longitude;
        var lugar = reverse_geocoding(milat, milong);
        consultar_paradas_cercanas_auto(milat, milong)
}
    
jQuery(window).ready(function(){
           <?php if($geolocation_ready && $configuracion['mapa']){ ?>
           initiate_geolocation_auto(); 
           
            
           $("#boton-buscar-parada").click(function() {
				//alert('Handler for .click() called.');
				initiate_geolocation_auto(); 
			});
			
			
           
            
           <?php } ?> 
          
			
		$('#hideball').click(function(event) {
					event.preventDefault();
					$.cookie("autogeoreminder", "falso", { path: '/', expires: 365 });
					$('#geoglobo').fadeOut('slow', function() {
					// Animation complete.
					});
		});
					
             
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
          
        cargar_popup(); 
       });

    
</script>
    
	</head>
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
				<h1><span>Tubus <?=$configuracion['ciudad']?></span>
					<?php if($configuracion['master'] == true) {?> 
					<small> <a href="<?=$configuracion['home_url']?>/ciudad.php" title="Acceder a la información de otras ciudades">(Cambiar)</a></small>
					<?php } ?>
				</h1>
				<span class="liine"></span>
	
				<div>
				<?php
				if($geolocation_ready && $configuracion['mapa']){
				?>
				
	<div>
	 <h2 class="input lii" style="margin-top:15px;position:relative;height:55px;">Paradas cercanas 
	 
	 <div id="rvsgeo" style="display:none;position:absolute;left:0;top:40px;font:normal normal 13px arial,sans-serif;color:#959595;"><img id="pst-ition" style="float:left;margin-right:5px;" alt="buscar paradas" src="/style/images/positions.png" />Cerca de: </div>
	 <img id="boton-buscar-parada" alt="buscar paradas" src="/style/images/buscar-parada-peke.gif" style="float:right;margin-top:-10px;" />
	 <span id="mini-ajax" style="position:relative; display:none"><img src ="<?=$configuracion['home_url']?>/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h2>
	 <h5 class="resuelto-fecha" id="fecharesultado" style="display:none;" >Última búsqueda:</h5>
	<div class="resultados-buqueda" id="georesultados">	
        <p class="info_general" style="margin-bottom:10px;margin-left:0;">Estamos buscando paradas de <strong><?=$configuracion['ciudad'] ?></strong> cercanas a su posición ...</p>
	</div>
</div>
<p class="ver-resta"><a id="geovermas" href="<?=$configuracion['home_url']?>/geo.php?radio=2000">Ver Más Paradas</a></p>
				
				<?php } ?>
				
				<h2 class="input">Paradas de autobús urbano</h2>
				<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
				<input x-webkit-speech="x-webkit-speech" class="caja-datos" type="text" name="querystring" id="querystring"  style="margin-left:0;" />
				<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
				</form>
				<div class="contador"  style="margin-left:-12px;">Puedes buscar por dirección o directamente por el número de parada.</div>
			</div>
			<div id="datos_parada">
			<p class="ver-resto-index"><a href="<?=$configuracion['home_url']?>/lineas.php">Ver todas las líneas</a></p>
				<h2 class="input lii">Lineas</h2>
				<!-- Aquí comienda el sistema de lineas -->
				<div id="trasbordos">			
			<?php
				$lineas = lineas();
				foreach($lineas as $linea)
				{
					?>
					<span class="liine2"></span>
					<a href="<?=$configuracion['home_url']?>/linea/<?=$linea['nombre']?>" title="Ver en detalle la línea <?=$linea['nombre']?>">
					<span class="apartado-bus-trasbordos">
					<table style="width:100%;" id="linea_<?=$linea['nombre']?>">
					<tr>
					<td class="numero"><?=$linea['nombre']?></td>
					<td class="destino2"><strong>Trayecto:</strong> <?=$linea['salida']?> - <?=$linea['llegada']?></td>
					</tr>
					</table>
					</span>
					</a>
					<?php					
				}
			?>
			
			<span class="liine2"></span>
		</div>	
			</div>
			<!-- Aquí acaba el sistema de lineas -->
			<!-- Sistema de favoritos -->
            <?php
if($pinta_fav){
                $fav_sql  = "SELECT * FROM favoritos WHERE id_usuario = '".$logged_u['id_usuario']."' AND tipo_usuario = '".$logged_u['tipo']."' ORDER by fecha DESC LIMIT ".$num_res." ;"; 
                $res_fav = mysql_query($fav_sql);
                if($res_fav){
            ?>
			<h2 class="input"><a href="<?=$configuracion['home_url']?>/favoritos.php" title="Paradas favoritas">Paradas favoritas</a></h2>
			<div id="register">
            
		<?php
$primero = true;
while($rowf = mysql_fetch_array($res_fav)){
    $id_parada = $rowf['id_parada'];
    $sql2 = "SELECT id_parada, nombre, label FROM paradas WHERE id_parada = '".$id_parada."' LIMIT 1";
	$res2 = mysql_query($sql2);
	$parada = mysql_fetch_array($res2);
?>        
       <?php
       if($primero){
           $primero = false; 
        ?>
        <a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" title="<?=$rowf['nombre_parada']?>">
		<div class="touchspace" rel="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" style="position:relative;margin:25px 0 0 0;">
		<div id="fav-<?=$parada['id_parada']?>" class="botonerilla">
		<a href="<?=$configuracion['home_url']?>/edita-fav.php?parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/ediit.png" /></a>
		<a href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/borrar.png" /></a>
		</div>
		<input type="submit" id="<?=$parada['id_parada']?>" value="<?=utf8_encode(strtoupper($rowf['nombre_parada']))?> (<?=$parada['nombre']?>)" class="txt-pe2"/>
		<span class="star"></span>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        </a>
        <?php
        }
        else{
        ?>
        <a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" title="<?=$rowf['nombre_parada']?>">
		<div class="touchspace" rel="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" style="position:relative;margin:10px 0;">
		<div id="fav-<?=$parada['id_parada']?>" class="botonerilla">
		<a href="<?=$configuracion['home_url']?>/edita-fav.php?parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/ediit.png" /></a>
		<a href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$parada['id_parada']?>"><img src="<?=$configuracion['home_url']?>/style/images/borrar.png" /></a>
		</div>
        <input type="submit" id="<?=$parada['id_parada']?>" value="<?=utf8_encode(strtoupper($rowf['nombre_parada']))?> (<?=$parada['nombre']?>)" class="txt-pe2"/>
		<span class="star"></span>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        </a>
        <?php }?>
        
<?php } ?> 
        
        
		</div>
<?php }
        }
        else{
        ?>
		<h2 class="input">Paradas favoritas</h2>
			<div id="register">
		<p class="no-parada"><strong>Para añadir paradadas a <em>Favoritas</em> necesita estar registrado en Tubus. El <a href="<?=$configuracion['home_url']?>/registro.php" title="Registrarse o iniciar sesión en Tubus">registro</a> apenas le llevará 10 segundos, incluso puede usar su cuenta de Twitter o Facebook.</strong></p>
		</div>
        <?php } ?>	
			<!-- Fin del sistema de favoritos -->
		</div>
			
<?php include 'footer.php'; ?>
<?php	
}
?>
