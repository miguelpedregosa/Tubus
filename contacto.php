<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';
require_once 'libs/dbconnect.php';

$ip = get_real_ip();
$userid = get_userid();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Formulario de contacto")?></title>
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
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    $().ajaxStart(function() {
        $('#loading').show();
        $('#result').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#result').fadeIn('slow');
    });
    $('#form, #fat, #contact').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);

            }
        })
        
        return false;
    }); 
toggle_menu();
})  
</script>
</head>

<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	
	<div id="cuerpo">
    <?php include_once 'menu-horizontal.php'; ?>
    <?php include_once 'ad.php'; ?>
	<div id="sub-cont">
	<h1><span>Formulario de contacto</span></h1>
	<span class="liine"></span>
	<?php
	if(isset($_POST['enviar'])){
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$comentario = $_POST['mensaje'];
		$user = $_POST['userid'];
		$ip = $_POST['ip'];
		$date_added = date('Y-m-d G:i:s');
		$cabeceras = 'From: contacto@tubus.es' . "\r\n" .
			'Reply-To: '. $correo . "\r\n";
		$mensaje = '';
		$error = 0;

		//Verifico que los datos llegan correctamente
		if(strlen($nombre)<3||is_numeric($nombre)){
			$mensaje.='El nombre utilizado no es válido.<br />';
			$error = 1;
		}

		if(!preg_match('/(^[0-9a-zA-Z]+(?:[._][0-9a-zA-Z]+)*)@([0-9a-zA-Z]+(?:[._-][0-9a-zA-Z]+)*\.[0-9a-zA-Z]{2,3})$/',$correo)){
			$mensaje.='La dirección de e-mail utilizada parece no ser válida.<br />';
			$error = 1;
		}

		if(strlen($comentario)<3){
			$mensaje.='Por favor, utilice una descripción más detallada del mensaje que quiere hacernos llegar.<br />';
			$error = 1;
		}

		if($error==1)
			echo '<p><br />'.$mensaje.'Por favor, vuelva a intentarlo</p>';
		else{
			$sql = "INSERT INTO mensajes(nombre, mail, mensaje, date_added, ip, userid) VALUES ('$nombre','$correo','$comentario','$date_added','$ip','$user')";
			mysql_query($sql);
			mail('contacto@tubus.es','Tubus.es: Ha recibido una nueva consulta',
			"El usuario $nombre ha enviado una consulta desde Tubus.es\n\nSus datos de contacto son:\n - Nombre: $nombre \n - Correo: $correo \n - Mensaje: $comentario \n\nPor favor, contestar con la mayor brevedad posible.", $cabeceras);
			echo "<p><br />$nombre, tu consulta ha sido enviada correctamente. Muchas gracias</p>";
			//echo "$sql";
		}		
	}
	else{
	?>
	<form method="post" action="contacto.php" id="register" name="contact" >
	<p><label>Mi <span>Nombre </span> es:</label><input type="text" name="nombre" /></p>
	<p><label>Mi <span>Correo electronico </span>es:</label><input type="text" name="correo" /></p>
	<p><label class="mensaje">Mi <span>Mensaje </span>es:</label><textarea name="mensaje" col="50" rows="5"></textarea></p>
	<input type="hidden" name="userid" value="<?=$userid?>" />
	<input type="hidden" name="ip" value="<?=$ip?>" />
			<div style="position:relative;margin:15px 0;">
		<input type="submit" name="enviar" value="ENVIAR" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
	</div>
	</form>
	<?php
	}
	?>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>
