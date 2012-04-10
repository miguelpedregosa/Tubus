<?php
require_once '../system.php';

$parada_id = (int)$_REQUEST['parada'];
if(isset($parada_id) && $parada_id != null){
	$url_parada = $configuracion['home_url'].'/'.$parada_id.'/qr/';
	$url_qr = 'http://chart.apis.google.com/chart?cht=qr&chl='.urlencode($url_parada).'&choe=UTF-8&chs=300x300&chld=Q|0';
	
	//Ahora capturamos el código qr
$ch = curl_init($url_qr);
$fp = fopen("images/".$parada_id.".png", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);
	
if(file_exists("images/".$parada_id.".png")){
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es"> 
<head> 
<title>Tubus - Generador de códigos QR</title> 
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
 
<link rel="stylesheet" type="text/css" media="screen" href="http://m.tubus.es/style/style_1.5.css" /> 
<link rel="stylesheet" type="text/css" media="handheld" href="http://m.tubus.es/style/style_1.5.css" /> 
<link rel="apple-touch-icon" href="http://m.tubus.es/style/images/apple-touch-icon.png"/> 
</head> 
	<body> 
	<div id="contenedor"> 
		<div id="cabecera"> 
			<div id="logos"> 
			</div> 
			<div id="localidad"> 
			<h1><a href="http://m.tubus.es" title="Ir a la portada de Tubus" >[Granada]</a></h1> 
			</div> 
		</div> 
		<div id="cuerpo"> 
			<div id="datos_parada"> 
				<h1 class="portada">Se ha generado correctamente el código QR que apunta a la siguiente dirección web: <strong><?=$url_parada ?></strong></h1> 
			</div> 
			<div id="datos_parada"> 
				<h2 class="input">Código QR</h2> 
				<div>
					<img src="<?php echo $configuracion['home_url'].'/qr/'."images/".$parada_id.".png" ?>" alt="Código QR para <?=$url_parada ?>" />
				</div>
			</div> 
	<div id="pie"> 
		<div id="a-izquierda"> 
        <h3> | &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://m.tubus.es/contacto.php" title="Contactar con Tubus">Contacto</a></h3> 
		<h3> | &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://m.tubus.es/legal.php" title="Aviso legal y política de privacidad">Privacidad</a></h3> 
		<h3>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://blog.tubus.es/" title="Blog oficial de Tubus">Blog</a></h3> 
		</div> 
		<h3>Desarrollado por: <a href="http://huruk.net/" title="Huruk">Huruk</a></h3> 
		</div> 
	</div> 				
	<script type="text/javascript"> 
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-11509350-1");
pageTracker._trackPageview();
} catch(err) {}</script> 
</body> 
</html> 	
	
	
<?php	
}	
else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es"> 
<head> 
<title>Tubus - Generador de códigos QR</title> 
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
 
<link rel="stylesheet" type="text/css" media="screen" href="http://m.tubus.es/style/style_1.5.css" /> 
<link rel="stylesheet" type="text/css" media="handheld" href="http://m.tubus.es/style/style_1.5.css" /> 
<link rel="apple-touch-icon" href="http://m.tubus.es/style/images/apple-touch-icon.png"/> 
</head> 
	<body> 
	<div id="contenedor"> 
		<div id="cabecera"> 
			<div id="logos"> 
			</div> 
			<div id="localidad"> 
			<h1><a href="http://m.tubus.es" title="Ir a la portada de Tubus" >[Granada]</a></h1> 
			</div> 
		</div> 
		<div id="cuerpo"> 
			<div id="datos_parada"> 
				<h1 class="portada">Se ha producido un error al generar el código QR que apunta a la siguiente dirección web: <strong><?=$url_parada ?></strong></h1> 
			</div> 
	<div id="pie"> 
		<div id="a-izquierda"> 
        <h3> | &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://m.tubus.es/contacto.php" title="Contactar con Tubus">Contacto</a></h3> 
		<h3> | &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://m.tubus.es/legal.php" title="Aviso legal y política de privacidad">Privacidad</a></h3> 
		<h3>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://blog.tubus.es/" title="Blog oficial de Tubus">Blog</a></h3> 
		</div> 
		<h3>Desarrollado por: <a href="http://huruk.net/" title="Huruk">Huruk</a></h3> 
		</div> 
	</div> 				
	<script type="text/javascript"> 
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-11509350-1");
pageTracker._trackPageview();
} catch(err) {}</script> 
</body> 
</html> 	


<?php	
}	
	

	
}
else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es"> 
<head> 
<title>Tubus - Generador de códigos QR</title> 
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
 
<link rel="stylesheet" type="text/css" media="screen" href="http://m.tubus.es/style/style_1.5.css" /> 
<link rel="stylesheet" type="text/css" media="handheld" href="http://m.tubus.es/style/style_1.5.css" /> 
<link rel="apple-touch-icon" href="http://m.tubus.es/style/images/apple-touch-icon.png"/> 
</head> 
	<body> 
	<div id="contenedor"> 
		<div id="cabecera"> 
			<div id="logos"> 
			</div> 
			<div id="localidad"> 
			<h1><a href="http://m.tubus.es" title="Ir a la portada de Tubus" >[Granada]</a></h1> 
			</div> 
		</div> 
		<div id="cuerpo"> 
			<div id="datos_parada"> 
				<h1 class="portada">Necesita especificar el número de parada para la que desea generar el código QR. Ej: <em><?php echo $configuracion['home_url'].'/qr/'."generator.php?parada=304"?></em></h1> 
			</div> 
	<div id="pie"> 
		<div id="a-izquierda"> 
        <h3> | &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://m.tubus.es/contacto.php" title="Contactar con Tubus">Contacto</a></h3> 
		<h3> | &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://m.tubus.es/legal.php" title="Aviso legal y política de privacidad">Privacidad</a></h3> 
		<h3>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://blog.tubus.es/" title="Blog oficial de Tubus">Blog</a></h3> 
		</div> 
		<h3>Desarrollado por: <a href="http://huruk.net/" title="Huruk">Huruk</a></h3> 
		</div> 
	</div> 				
	<script type="text/javascript"> 
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-11509350-1");
pageTracker._trackPageview();
} catch(err) {}</script> 
</body> 
</html> 	
<?php	
}
