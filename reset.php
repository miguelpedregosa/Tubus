<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';

$logged_u =  is_logged();
if($logged_u['logged'] == true){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}
if(!isset($_POST['key'])) {
    if(!isset($_GET['rkey']) || $_GET['rkey'] == "" || strlen($_GET['rkey'])!= 64){
        //Clave no valida
        header ("Location: ".$configuracion['home_url']."/"); 
        exit();
    }
$rkey = $_GET['rkey'];

//Una vez que tengo la key procedo a presentar el formulario de reseteo de contraseña
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Restablecer la contraseña de usuario")?></title>
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
	<h1><span>Restablecer contraseña</span></h1> 
	<span class="liine"></span>
    <p class="error-p">Ingrese una nueva contraseña para su cuenta</p>
	<form method="post" action="reset.php" id="register" name="contact" autocomplete="off" >
	<label>Mi nueva <span>contraseña</span> es:</label><input type="password" maxlength="8" name="password1" />
	<label><span>contraseña</span> de nuevo:</label><input type="password" maxlength="8" name="password2" />
	
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="key" value="<?=$key?>" />
    <input type="hidden" name="rkey" value="<?=$rkey?>" />
    <div style="position:relative;margin:15px 0;">
		<input type="submit" id="loong" value="CAMBIAR CONTRASEÑA" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
	</form>
	</div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>


<?
} else{
    //print_r($_POST);
    
    $fec = date('mY');
    $clave2 = $configuracion['reg_key'].':'.$fec;
    $key2 = base64_encode($clave2);
    
    if($key2 != $_POST['key']){
        header ("Location: ".$configuracion['home_url']."/"); 
        exit();
    }
    $datos_rkey = base64_decode($_POST['rkey']);
    $partes_datos = explode(':',$datos_rkey);
    $ruseridusuario = $partes_datos[0];
    $ruserid = $partes_datos[1];
    $ruserclave = $partes_datos[2];
    
$validacion = validar_passwords($_POST['password1'], $_POST['password2']);
if($validacion['resultado'] == false){
    //Las contraseñas nuevas no son válidas
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Restablecer la contraseña de usuario")?></title>
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
	<h1><span>Restablecer contraseña</span></h1> 
	<span class="liine"></span>
    <p class="error-p">Se han producido los siguientes errores a la hora de realizar el cambio de contraseña:</p>
    <ul class="error-p">
    <?php
    foreach($validacion['mensajes'] as $mensaje_e){
        echo '<li>'.$mensaje_e.'</li>';
    }
    ?>
    </ul>
	<form method="post" action="reset.php" id="register" name="contact" autocomplete="off" >
	<label>Mi nueva <span>contraseña</span> es:</label><input type="password" maxlength="8" name="password1" />
	<label><span>contraseña</span> de nuevo:</label><input type="password" maxlength="8" name="password2" />
	<?php
    //Ahora genero una clave de comprobación para evitar los registros automáticos
    $fec = date('mY');
    $clave = $configuracion['reg_key'].':'.$fec;
    $key = base64_encode($clave);
    ?>
    <input type="hidden" name="key" value="<?=$key?>" />
    <input type="hidden" name="rkey" value="<?=$_POST['rkey']?>" />
    <div style="position:relative;margin:15px 0;">
		<input type="submit" id="loong" value="CAMBIAR CONTRASEÑA" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
	</form>
	</div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>
<?php
}
else{
    //Las contraseñas cumplen los requisitos
    
        //Cambio la base de datos por la que contiene los datos del login
     $db_selected = mysql_select_db('tubus_usuarios', $link);
        if (!$db_selected) {
        die ('No se puede usar tubus: ' . mysql_error());
    }   
    //Fin de cambio de base de datos
    
    
    
    //Vamos a mirar en la base de datos 
    $sql = "SELECT * FROM usuarios WHERE id_usuario = '". $ruseridusuario."' AND userid = '".$ruserid."' AND recover_key = '".$ruserclave."' LIMIT 1;";
    $res = mysql_query($sql);
    
    //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
    
    if(mysql_num_rows($res) != 1){
        //Algo no ha ido bien, no hay usuario que verifique los datos
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Restablecer la contraseña de usuario")?></title>
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
	<h1><span>Restablecer contraseña</span></h1> 
	<span class="liine"></span>
    <p class="error-p">Se ha producido un error al tratar de restablecer su contraseña de usuario. Por favor vuelva a repetir el procedimiento. Puede ponerse en contacto con nosotros en <a href="mailto:contacto@tubus.es">contacto@tubus.es</a></p>
    </div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>  
<?php     
        
    }
    else{
        $usuario = mysql_fetch_array($res);
        $fecha_recu = $usuario['recover_time'];
        $time_r = convert_datetime($fecha_recu);
        $time_n = time();
        //print_r($usuario);
        if(($time_n - $time_r) > 21600){
            //La clave ha caducado
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Restablecer la contraseña de usuario")?></title>
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
	<h1><span>Restablecer contraseña</span></h1> 
	<span class="liine"></span>
    <p class="error-p">Se ha producido un error al tratar de restablecer su contraseña de usuario. Por favor vuelva a repetir el procedimiento. Puede ponerse en contacto con nosotros en <a href="mailto:contacto@tubus.es">contacto@tubus.es</a></p>
    </div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>  
<?php            
        }
        else{
            //Si se ha llegado hasta aquí, todo está correcto y podemos almacenar la nueva contraseña del usuario en la bd
            $nueva_clave = sha1($_POST['password1']);
            //Genero una nueva clave para que se deslogue de cualquier sitio donde esté
            $userkey = RandomString(64);
            
            
                    //Cambio la base de datos por la que contiene los datos del login
                        $db_selected = mysql_select_db('tubus_usuarios', $link);
                        if (!$db_selected) {
                            die ('No se puede usar tubus: ' . mysql_error());
                        }   
                    //Fin de cambio de base de datos
            
            
            
            $sql_i = "UPDATE usuarios SET password = '".$nueva_clave."', userkey = '".$userkey."', recover_key = NULL WHERE id_usuario = '".$usuario['id_usuario']."' LIMIT 1 ";
            $res_i = mysql_query($sql_i);
            
            //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
                die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
            
            
            if(!$res){
                //Ha ocurrido un error
                ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Restablecer la contraseña de usuario")?></title>
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
	<h1><span>Restablecer contraseña</span></h1> 
	<span class="liine"></span>
    <p class="error-p">Se ha producido un error al tratar de restablecer su contraseña de usuario. Por favor vuelva a repetir el procedimiento. Puede ponerse en contacto con nosotros en <a href="mailto:contacto@tubus.es">contacto@tubus.es</a></p>
    </div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>  
<?php 
            }
            else{
                //Toda ha ido bien
                ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Restablecer la contraseña de usuario")?></title>
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
	<h1><span>Restablecer contraseña</span></h1> 
	<span class="liine"></span>
    <p class="error-p">Se ha cambiado correctamente su clave de acceso a Tubus</p>
    <p><a href="" style="font:normal normal 14px arial,sans-serif; color:#9F3D00;">Iniciar sesión</a> | <a href="" style="font:normal normal 14px arial,sans-serif; color:#9F3D00;">Ir a la portada</a></p>
	</div>
	<div id="result"></div>
	</div>
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php'; ?>  
                
                
                
                <?php
            }

        }
 
    }

  }
    
}
?>
