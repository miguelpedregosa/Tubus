<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/helpers.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Sub-Urban Maglev Transport ".$configuracion['ciudad'])?></title>
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
<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>
<link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>

<script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.cookie.js"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.iphone-switch.js"></script>
<script src="<?=$configuracion['home_url']?>/js/gears_init.js"></script>
<script src="<?=$configuracion['home_url']?>/js/yqlgeo.js"></script>
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.countdown.min.js"></script>
<script src="<?=$configuracion['home_url']?>/js/jquery.countdown-es.js"></script>
<script type="text/javascript">
var watchProcess = null;
var enparada = false;
var boton_pintado = false;
var liftoffTime = 25;
function initiate_watchlocation() 
{  
        if (watchProcess == null) {  
         watchProcess = navigator.geolocation.watchPosition(function(position){
                        handle_geolocation_query(position);
             }, handle_errors, {enableHighAccuracy:true});  
       }  
}  
 
function stop_watchlocation() 
{  
   if (watchProcess != null)
      {
          navigator.geolocation.clearWatch(watchProcess);
          watchProcess = null;
       }
} 


function handle_errors(error)
{
        switch(error.code)
        {
            case error.PERMISSION_DENIED: 
                alert("Debes dar permiso para acceder a tu localizacion ");
               
            break;

            case error.POSITION_UNAVAILABLE: 
                alert("No se ha podido detectar tu posicion actual");
                
            break;

            case error.TIMEOUT: 
                alert("Tiempo de espera agotado");
                
            break;

            default: 
                alert("Error desconocido");
               
            break;
        }
}

function handle_geolocation_query(position)
{
		milat = position.coords.latitude;
		milong = position.coords.longitude;
		console.log(milat);
		console.log(milong);
		
		//Ahora veo si tengo que pintar el boton o no
		if(!boton_pintado){
		var url = '<?=$configuracion['home_url']?>/ajax/ajaxsumat.php?lat='+milat+'&long='+milong;
		
		$.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
						
						var resultado = eval('(' + data + ')');
                        
                        if(resultado['enparada'] == 'si')
                        {
							boton_pintado = true;
							var parada = resultado['parada'];
							liftoffTime = resultado['contador'];
							var html = 'Se encuentra cerca de la parada <em>'+parada+'</em>.';
								$('#textodist2').html(html);
							$('#rueda').fadeOut('slow');
							$('#boton-llamar').fadeIn('slow');
						
						}
						
						
						if(resultado['enparada'] == 'cerca')
                        {
							var distancia = resultado['distancia'];
							var parada = resultado['parada'];
							var html = 'Se encuentra a <strong>'+distancia+'</strong> metros de la parada <em>'+parada+'</em>. Necesita acercarse un poco más';
								$('#textodist').html(html);
						}
						
						
						if(resultado['enparada'] == 'no')
                        {
							var html = 'Se encuentra demasiado lejos de una parada de autobús. Acérquese a alguna para continuar.';
							$('#textodist').html(html);
						
						}
						
						

                    }
                });
		
		
		
		
		}
		

}
function seacaba()
{
	$('#contdown').fadeOut('slow');
	$('#inocente').fadeIn('slow');
}

	$(document).ready(function(){
		toggle_menu();
		initiate_watchlocation();
		
		//Click en el botón 
		
		$('#boton-llamar').click(function(event) {
					event.preventDefault();
					//alert('Me has pulsado');
					$('#boton-llamar').fadeOut('slow');
					$('#contdown').fadeIn('slow');
					
					$('#contador').countdown({until: liftoffTime, onExpiry: seacaba, compact: true, description: ''});
					
					
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
 <div id="sub-cont">
				<h1><span>"Sub-Urban Maglev Transport <?=$configuracion['ciudad']?>"</span></h1>
				<span class="liine"></span>
	<div id="resuelto">
	<div class="resultados-buqueda" id="sumat-central">	
		<img src="/style/images/sumat.png" style="margin:auto;width:190px;"/> 
		<p style="font:normal normal 16px arial,sans-serif;">
		Para solicitar acceso al S.U.M.A.T. debe acercarse físicamente a una parada de autobus.
        <br /><br />Si no se encuentra físicamente en <?=$configuracion['ciudad']?> deberá <a href="ciudad.php?r=sumat.php">elegir su ciudad</a> antes de continuar.
        </p>
        
        <div id="central" style="margin:auto;">
		
		<div id="rueda">
		<h2 class="input">Detectando ubicación</h2>
		<img src= "<?=$configuracion['home_url']?>/style/images/geoo.png" style="margin:20px 0;"/>
		<p><span id="textodist" >...</span></p>
		</div>
		
		<div id="boton-llamar" style="display:none">
		<h2 class="input">Solicitar acceso</h2>
		<p>Pulse el botón para solicitar su acceso al sistema S.U.M.A.T, en su pantalla debería aparecer un contador y un código QR.
		<br />El código QR le dará acceso al vehículo, debe mostrarlo al lector de la puerta de entrada.</p>
		<img src= "<?=$configuracion['home_url']?>/style/images/buscar-parada-s.png" style="margin:20px 0;" />
		<p><span id="textodist2" >...</span></p>
		</div>
		
		<div id="contdown" style="display:none">
		<h2 class="input">Proxima llegada</h2>
		<div id="contador" style="font-size:25px;margin-bottom:20px;"></div>
		<div id="qr">
			<img src= "<?=$configuracion['home_url']?>/imagenes/sumat/qr.png" />
		</div>
		</div>
		
		
		<div id="inocente" style="display:none">
		<h2 class="input">Inocente Found</h2>
			<img src= "<?=$configuracion['home_url']?>/style/images/inocente.png" />
		
			<p id="tinocente"><br /><br />¡Lo sentimos! No existe (de momento) ningún sistema S.U.M.A.T.</p>
		</div>
		
		
		
		</div>
        
	</div>
</div>
</div>


<?php include 'footer.php'; ?>
