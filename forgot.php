<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';
$ip = get_real_ip();
//$userid = get_userid();

$logged_u =  is_logged();
if($logged_u['logged'] == true){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}

?>

<?php if(!isset($_POST['key'])) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Recuperar contraseña")?></title>
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
    
    <script type="text/javascript"> 
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
	<div id="sub-cont">
	<h1><span>Recuperar contraseña</span></h1>
	<span class="liine"></span>
    <!--<p>Si ha olvidado su contraseña introduce tu nombre de usuario o el email con que te registraste en Tubus y te enviaremos un correo electrónico para poder establecer una nueva contraseña.</p>-->
    <form method="post" action="forgot.php" id="register" name="contact" autocomplete="off" >
	<label>Mi <span>nombre de usuario </span>o<span> email</span> con el que me registre es:</label><input type="text" name="username"/>
	<p class="error-p">Introduce aquí tu nombre de usuario o la dirección de correo electrónico con la que te registraste. En breves momentos recibirás un correo electrónico paras poder restablecer tú contraseña.</p>
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="key" value="<?=$key?>" />
	<div style="position:relative;margin:15px 0;">
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		<input type="submit" name="submit" value="RECUPERAR" />
		</div>
	</form>
	</div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>


<?php } else{
    
    $fec = date('mY');
    $clave2 = $configuracion['reg_key'].':'.$fec;
    $key2 = base64_encode($clave2);
    
    if($key2 != $_POST['key']){
        header ("Location: ".$configuracion['home_url']."/forgot.php"); 
        exit();
    }
    //print_r($_POST);
    //Ahora compruebo si existe el usuario o email
    $dato= addslashes(trim(strip_tags($_POST['username'])));
    $sql = "SELECT * FROM usuarios WHERE username = '".$dato."' OR email = '".$dato."' LIMIT 1;";
    
    //Cambio la base de datos por la que contiene los datos del login
     $db_selected = mysql_select_db('tubus_usuarios', $link);
        if (!$db_selected) {
        die ('No se puede usar tubus: ' . mysql_error());
    }   
    //Fin de cambio de base de datos
    
    $res = mysql_query($sql);
    if(mysql_num_rows($res) == 1){
        $usuario = mysql_fetch_array($res);
        //print_r($usuario);
        //Una vez que tengo el usuario creo su clave unica de restauración de contraseña
         $fecha_rea = date('Y-m-d H:i:s');
         $clave_rea = $usuario['id_usuario'].':'.$usuario['userid'].':';
         $leng = strlen($clave_rea);
         $segunda_parte = RandomString((48-$leng));
         $clave_rea .= $segunda_parte; //La clave generada será de 64 caracteres y aleatoria
         $clave_rea = base64_encode($clave_rea);

         $enlace_rec = $configuracion['home_url'].'/reset.php?rkey='.$clave_rea;
         //La guardo en la base de datos
         $sql_i = "UPDATE usuarios SET recover_key = '".$segunda_parte."', recover_time = '".$fecha_rea."', recover_ip = '".$ip."' WHERE id_usuario = '".$usuario['id_usuario']."' LIMIT 1;";
         $res2 = mysql_query($sql_i);
         if($res2){
             //Ahora mando el correo al usuario
            $destinatario = $usuario['email'];
            $asunto = "Recuperar tu contraseña de Tubus";
            $cuerpo = '
                        <html>
                        <head>
                        <title>Recuperar tu contraseña de Tubus</title>
                        </head>
                        <body>
                        <h1>Tubus</h1>
                        <p>
                        Alguien (probablemente tu mismo), ha solicitado restablecer la contraseña de tu cuenta de usuario en Tubus. Si nos ha sido tu, simplemene ignora este mensaje.
                        </p>
                        <p>
                        Para elegir una nueva contraseña asociada a tu cuenta, haz clic en el siguiente enlace, si no funciona prueba a copiar y pegar en el navegador la url:
                        <a href="'.$enlace_rec.'" >'.$enlace_rec.'</a>
                        </p>
                        <p>En elace anterior será válido durante las seis próximas horas.</p><p>Muchas gracias por confiar en Tubus</p>
                        </body>
                        </html>
                ';

        //para el envío en formato HTML
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        //dirección del remitente
        $headers .= "From: Tubus <no-reply@tubus.es>\r\n";

        //dirección de respuesta, si queremos que sea distinta que la del remitente
        $headers .= "Reply-To: contacto@tubus.es\r\n";

        //ruta del mensaje desde origen a destino
        $headers .= "Return-path: contacto@tubus.es\r\n";

        //direcciones que recibián copia
        //$headers .= "Cc: maria@desarrolloweb.com\r\n";

        //direcciones que recibirán copia oculta
        //$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n";

        mail($destinatario,$asunto,$cuerpo,$headers);
        //Una vez enviado el correo muestro un mensaje al visitante.  
        
        //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
        
           
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Recuperar contraseña")?></title>
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
    
    <script type="text/javascript"> 
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
	<div id="sub-cont">
	<h1><span>Recuperar contraseña</span></h1>
	<span class="liine"></span>
    <p class="error-p">Se ha enviado un correo electrónico a la dirección que utilizó para registrar su cuenta en Tubus</p>
    <p><a href="" style="font:normal normal 14px arial,sans-serif;color:#9F3D00;">Ir a la portada</a></p>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>
        <?php     
         }
         else{
             //Ha ocurrido un error a la hora de 
             ?>
             <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Recuperar contraseña")?></title>
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
    
    <script type="text/javascript"> 
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
	<div id="sub-cont">
		<h1><span>Recuperar contraseña</span></h1>
		<span class="liine"></span>
		<p class="error-p">Ha ocurrido un error a la hora de procesar su solicitu, vuelva a intentarlo por favor.</p>
    <form method="post" action="forgot.php" id="register" name="contact" autocomplete="off" >
	<label>Mi <span>nombre de usuarios </span>o<span> email</span> con el que me registre es:</label><input type="text" name="username"/>
	<p class="error-p">Introduce aquí tu nombre de usuario o la dirección de correo electrónico con la que te registraste. En breves momentos recibirás un correo electrónico paras poder restablecer tú contraseña.</p>
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="key" value="<?=$key?>" />
    <input type="submit" name="submit" value="Recuperar" />
	<div style="position:relative;margin:15px 0;">
		<input type="submit" value="RECUPERAR" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
	</form>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>
<?php
         }
         
         
        
        
    }
    else{
        //No es un usuario valido
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Recuperar contraseña")?></title>
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
    
    <script type="text/javascript"> 
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
	<div id="sub-cont">
	<h1><span>Recuperar contraseña</span></h1>
	<span class="liine"></span>
    <p class="error-p">No se ha encontrado el usuario o email que nos ha especificado.</p>
    <form method="post" action="forgot.php" id="register" name="contact" autocomplete="off" >
	<label>Mi <span>nombre de usuarios </span>o<span> email</span> con el que me registre es:</label><input type="text" name="username"/>
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="key" value="<?=$key?>" />
	<p class="error-p">Introduce aquí tu nombre de usuario o la dirección de correo electrónico con la que te registraste. En breves momentos recibirás un correo electrónico paras poder restablecer tú contraseña.</p>
		<div style="position:relative;margin:15px 0;">
		<input type="submit" value="RECUPERAR" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
	</div>
	</form>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>


<?php   
    }
    
}
?>
