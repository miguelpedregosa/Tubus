<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
//require_once 'libs/rober.php';
require_once 'libs/helpers.php';
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';
require_once 'libs/twitteroauth/twitteroauth.php';

$ip = get_real_ip();
$logged_u =  is_logged();
if($logged_u['logged'] == true){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}
?>
<?php if(!isset($_POST['key'])) { 
session_start();    
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

if(isset($_GET['r']) && $_GET['r'] != "")
        $url_callback_fb = $configuracion['home_url']."/facebook.php".'?r='.strip_tags($_GET['r']);
    else
        $url_callback_fb = $configuracion['home_url']."/facebook.php";


$url_facebook = 'https://www.facebook.com/dialog/oauth?client_id='.$configuracion['FACEBOOK_ID'].'&redirect_uri='.$url_callback_fb.'&scope=email&display=touch';
$facebook_button = '<a href="'.$url_facebook.'"><span class="buttons3" />LOGIN CON FACEBOOK</span></a>';
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Iniciar sesión")?></title>
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
     <?php include_once 'ad.php'; ?>
    <?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    if(isset($_GET['r']) && $_GET['r'] != "")
        $url = $_GET['r'];
    else
        $url = null;
    ?>
    
    <div id="sub-cont">
		<h1><span>Iniciar sesión</span></h1>
		<span class="liine"></span>
        <form method="post" action="login.php" id="register" name="register" autocomplete="off" >
		<label><span>Nombre de usuario:</span></label><input type="text" size="16" maxlength="12" name="username" />
		<label><span>Contraseña:</span></label><input type="password" size="16" maxlength="16" value="" name="password1" />
		<input type="checkbox" size="16" maxlength="16" value="1" name="recordar" /><label class="record"><span>Recordarme</span></label>
		<input type="hidden" name="sha1" value="0" />
        <input type="hidden" name="url" value="<?=$url?>" />
        <input type="hidden" name="key" value="<?=$key?>" />
        
		<div style="position:relative;margin:15px 0;">		
		<input type="submit" name="submit" value="INICIAR SESIÓN" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
		<strong class="crear-cuenta">Si aun no tienes cuenta en <span class="negrita">tubus.es</span>:</strong>
		<div style="position:relative;margin:15px 0;">
		<a href="<?=$configuracion['home_url']?>/registro.php" style="zíndex:9;position:relative;"><span class="buttons2" />CREAR CUENTA</span></a></a>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        <div class="twitter" style="position:relative;margin:15px 0;"><?=$twitter_button?>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
		
		<div class="face" style="position:relative;margin:15px 0;"><?=$facebook_button?>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        
         </form>
    <h6><a href="<?=$configuracion['home_url']?>/forgot.php">¿Ha <span>olvidado su contraseña</span>?</a></h6>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>


<?php }
else{
//print_r($_POST);
//Compruebo si la key es correcta
    $fec = date('mY');
    $clave2 = $configuracion['reg_key'].':'.$fec;
    $key2 = base64_encode($clave2);
    
    if($key2 != $_POST['key']){
        header ("Location: ".$configuracion['home_url']."/login.php"); 
        exit();
    }
    
    $username = trim(strip_tags($_POST['username']));
    $password = trim(strip_tags($_POST['password1']));
    $url_redirect = strip_tags($_POST['url']);
    $recordar = $_POST['recordar'];
    $sha1 = $_POST['sha1'];
    
    if($sha1 != '1')
        $password = sha1($password);
        
     //Cambio la base de datos por la que contiene los datos del login
     $db_selected = mysql_select_db('tubus_usuarios', $link);
        if (!$db_selected) {
        die ('No se puede usar tubus: ' . mysql_error());
    }   
    //Fin de cambio de base de datos
        
    //Ahora compruebo si el usuario y la clave son correctas
    $sql = "SELECT * FROM usuarios WHERE username = '".$username."' AND password = '".$password."' LIMIT 1;";
    $res = mysql_query($sql);
    if(mysql_num_rows($res) == 1){
        //Hay un usuario con el mismo nombre y contraseña
        $datos_usuario = mysql_fetch_array($res);
        //Ahora construyo la clave de login
        $clave_login = $datos_usuario['id_usuario'].':'.$datos_usuario['userid'].':'.$datos_usuario['userkey'];
        $login_cookie = base64_encode($clave_login);
        $ciudad = $datos_usuario['ciudad'];
        $fecha_acc = date('Y-m-d H:i:s');
        $sql_act = "UPDATE usuarios SET last_login = '". $fecha_acc."', last_ip = '".$ip."' WHERE id_usuario = '".$datos_usuario['id_usuario']."' LIMIT 1; ";
        mysql_query($sql_act);
        
        //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
        
        
        //Establezco la variable que me permite permanecer logueado durante la sesión al menos
        if($recordar == "1"){
            setcookie("userkey", $login_cookie, time() + 157680000, "/", ".tubus.es"); //15 días de cookie
            setcookie("userid", $datos_usuario['userid'], time() + 157680000, "/", ".tubus.es");
            setcookie("userciudad", $ciudad, time() + 157680000, "/", ".tubus.es");
            //session_start();
            //$_SESSION['userkey'] = $login_cookie;
        }
        else{
            
            setcookie("userid", $datos_usuario['userid'], 0, "/", ".tubus.es");
            setcookie("userkey", $login_cookie, 0, "/", ".tubus.es");
            setcookie("userciudad", $ciudad, time() + 157680000, "/", ".tubus.es");
            //session_start();
            //$_SESSION['userkey'] = $login_cookie;
        }
        
        //Una vez logueado redirijo a la página que sea
        if($url_redirect == ''){
            header ("Location: ".$configuracion['home_url']."/user/"); 
            exit();
        }
        else{
            header ("Location: ".$configuracion['home_url']."/".$url_redirect); 
        exit();
        }
        
        
        //echo "<br />".$clave_login;
    }
    else{ //Error al hacer el login
session_start();    
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Iniciar sesión")?></title>
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
		<h1><span>Iniciar sesión</span></h1>
		<span class="liine"></span>
    <p class="error-p">Se ha producido un error al iniciar sesión, por favor compruebe el <strong>nombre de usuario y contraseña.</strong></p> 
    <form method="post" action="login.php" id="register" name="register" autocomplete="off" >
		<label><span>Nombre de usuario:</span></label><input type="text" size="16" maxlength="12" name="username" />
		<label><span>Contraseña:</span></label><input type="password" size="16" maxlength="16" value="" name="password1" />
		<input type="checkbox" size="16" maxlength="8" value="1" name="recordar" /><label class="record"><span>Recordarme</span></label>
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="sha1" value="0" />
    <input type="hidden" name="key" value="<?=$key?>" />
    <div style="position:relative;margin:15px 0;">
		<input type="submit" name="submit" value="INICIAR SESIÓN" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
		<strong class="crear-cuenta">Si aun no tienes cuenta en <span class="negrita">tubus.es</span>:</strong>
		<div style="position:relative;margin:15px 0;">
		<a href="http://beta.tubus.es/registro.php"><input type="submit" name="submit" value="CREAR CUENTA" /></a>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
        <div class="twitter" style="position:relative;margin:15px 0;"><?=$twitter_button?>
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
		
	</form>
        <h6><a href="<?=$configuracion['home_url']?>/forgot.php">¿Ha <span>olvidado su contraseña</span>?</a></h6>

	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>    
    
    
       
       
    <?php    
    }
    

    
    

}

 ?>
