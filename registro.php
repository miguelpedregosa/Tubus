<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
//require_once 'libs/rober.php';
require_once 'libs/helpers.php';
require_once 'libs/functions.php';
require_once 'libs/mailchimp.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';
require_once 'libs/twitteroauth/twitteroauth.php';
require_once 'libs/helper_email.php';

$ip = get_real_ip();
$userid = get_userid();

$logged_u =  is_logged();
if($logged_u['logged'] == true){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}

?>
<?php if(!isset($_POST['key'])) { 
session_start();
/*    
$connection = new TwitterOAuth($configuracion['CONSUMER_KEY'], $configuracion['CONSUMER_SECRET']);
 if(isset($_GET['r']) && $_GET['r'] != "")
        $url_callback = $configuracion['OAUTH_CALLBACK'].'?r='.strip_tags($_GET['r']);
    else
        $url_callback = $configuracion['OAUTH_CALLBACK'];

$request_token = $connection->getRequestToken($url_callback);
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url_twitter = $connection->getAuthorizeURL($token);

switch ($connection->http_code) {
  case 200:
    $twitter_button = '<a href="'.$url_twitter.'"><span class="buttons" />LOGIN CON TWITTER</span></a>';
    break;
  default:
    $twitter_button ='';
    break;
}
*/

    
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Registro de usuario")?></title>
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
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    
    <div id="sub-cont">
		<h1><span>Registro de Usuario</span></h1>
		<span class="liine"></span>
        <form method="post" action="registro.php" id="register" name="register" autocomplete="off" >
		<label>Mi <span>nombre de usuario</span> es:</label><input maxlength="12" type="text" name="username" />
		<label>Mi <span>correo electronico</span> es:</label><input type="text" name="email" />
		<label>Mi <span>contraseña</span> es:</label><input type="password" size="16" maxlength="16" name="password1" />
		<label>Repetir <span>contraseña:</span></label><input size="16" maxlength="16" type="password" name="password2" />
		<input type="hidden" name="key" value="<?=$key?>" />
        <span class="advert">Al hacer clic en <em>"Registrarse"</em> estas aceptando nuestra <a href="legal.php#privacidad" title="Ver Política de privacidad de Tubus (en ventana nueva)" target="_blank">Política de privacidad</a></span>
		<div style="position:relative;margin:15px 0;">
		<input type="submit" name="submit" value="REGISTRARSE" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        
         </form>
		
        
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>

<?php } else {
    //Aqui es cuando me llega el form
    //print_r($_POST);
    //Compruebo si la key es correcta
    $fec = date('mY');
    $clave2 = $configuracion['reg_key'].':'.$fec;
    $key2 = base64_encode($clave2);
    
    if($key2 != $_POST['key']){
        header ("Location: ".$configuracion['home_url']."/registro.php"); 
        exit();
    }
    //Validamos el formulario
    $validacion = validar_usuario($_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['email']);
    //print_r($validacion);
    if($validacion['resultado'] == false){
    ?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Registro de usuario")?></title>
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
		<h1><span>Registro de Usuario</span></h1>
		<span class="liine"></span>
    <ul class="error-p">
    <?php
    foreach($validacion['mensajes'] as $mensaje_e){
        echo '<li>'.$mensaje_e.'</li>';
    }
    ?>
    </ul>
	<form method="post" action="registro.php" id="register" name="register" autocomplete="off" >
	<label>Mi <span>nombre de usuario</span> es:</label><input maxlength="12" type="text" name="username" />
		<label>Mi <span>correo electronico</span> es:</label><input type="text" name="email" />
		<label>Mi <span>contraseña</span> es:</label><input type="password" size="16" maxlength="16" name="password1" />
		<label>Repetir <span>contraseña:</span></label><input size="16" maxlength="16" type="password" name="password2" />
		
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
   <input type="hidden" name="key" value="<?=$key?>" />
        
		<div style="position:relative;margin:15px 0;">
		<input type="submit" name="submit" value="REGISTRARSE" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        
         </form>
		</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>
    
     <?php   
    }
    else{ //Procedo a introducir el usuario en la base de datos
       //Genero una clave unica por usuario, distinta al userid, la userkey de 40 caracteres
       //$userkey = sha1(uniqid($configuracion['reg_key']));
       $userkey = RandomString(64);
       $username = addslashes(trim(strip_tags($_POST['username'])));
       $password = sha1($_POST['password1']);
       $email = addslashes(trim(strip_tags($_POST['email'])));
       $fecha_crea = date('Y-m-d H:i:s');
       
       //Cambio la base de datos por la que contiene los datos del login
        $db_selected = mysql_select_db('tubus_usuarios', $link);
            if (!$db_selected) {
                die ('No se puede usar tubus: ' . mysql_error());
    }   
    //Fin de cambio de base de datos
       
       
      //Ahora inserto los datos en la base de datos
      $sql = "INSERT INTO usuarios (username, password, email, userid, userkey, created, register_ip)  VALUES('".$username."', '".$password."', '".$email."', '".$userid."', '".$userkey."', '".$fecha_crea."', '".$ip."' );";
      $res = mysql_query($sql); 
      
      suscribir_email($email);
      //Email de bienvenida al usuario
     enviar_email_registro($email, $username);
      
      //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
      
      
      if($res){
        //Se ha creado el usuario con éxito
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Registro de usuario")?></title>
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
	<div id="ubicacion">
	<div id="sub-cont">
		<h1><span>Registro de usuario</span></h1>
		<span class="liine"></span>
		<p class="error-p">Se ha registrado correctamente como usuario de Tubus</p>
		<div id="seleccion-boton">
		<a href="<?=$configuracion['home_url']?>/login.php"><span class="btn-usr usr">Acceder a Mi cuenta</span></a>
		<a href="<?=$configuracion['home_url']?>"><span class="btn-usr ind">Volver al inicio</span></a>
		</div>
		<span class="clear"></span>
		</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>  
        
        <?php
        }    
      else{
          //Ha ocurrido un error al crear el usuario
          ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Registro de usuario")?></title>
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
	<div id="ubicacion">
	<h1>Registro de usuario</h1> 
    <p>Se han producido un error a la hora de realizar su registro de usuario. Pruebe de nuevo</p>
    
	<form method="post" action="registro.php" id="contact" name="contact" autocomplete="off" >
	<p><label>Nombre de usuario:</label><input type="text" maxlength="8" value="<?= $_POST['username'] ?>" name="username" /></p>
	<p><label>Contraseña:</label><input type="password" size="16" maxlength="8" value="" name="password1" /></p>
	<p><label>Contraseña (de nuevo) :</label><input type="password" size="16" maxlength="8" value="" name="password2" /></p>
	<p><label>Email:</label><input type="text" value="<?= $_POST['email'] ?>" name="email" /></p>
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="key" value="<?=$key?>" />
    <input type="submit" name="submit" value="Crear usuario" />
	</div>
	</form>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>          
          
      <?php    
      } 
       
    }
    
}
?>
