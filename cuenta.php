<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";
require_once "system.php";
$logged_u =  is_logged();

if($logged_u['logged'] == false){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}
    
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title("Mi cuenta de usuario")?></title>
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
				<h1><span>Mis Datos<span></h1>
				<span class="liine"></span>
              <?php
              
              switch($logged_u['tipo']){
                  case 'oauth':
                  $tipo = 'Logueado con Twitter';
                    $sql = "SELECT * FROM oauth WHERE username = '".$logged_u['username']."' AND id_usuario = '".$logged_u['id_usuario']."' LIMIT 1;";
                  break;
                  
                  case 'web':
                  default:
                  $tipo = 'Usuario registrado';
                    $sql = "SELECT * FROM usuarios WHERE username = '".$logged_u['username']."' AND id_usuario = '".$logged_u['id_usuario']."' LIMIT 1;";
                  break;
              }
              
              //Cambio la base de datos por la que contiene los datos del login
     $db_selected = mysql_select_db('tubus_usuarios', $link);
        if (!$db_selected) {
        die ('No se puede usar tubus: ' . mysql_error());
    }   
    //Fin de cambio de base de datos
    
    $res = mysql_query($sql);
    if($res){
        $row = mysql_fetch_array($res);
    }
        
        //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
        
               
            $ciudad_sel = $configuracion['ciudad'];
              
             if($row['tipo'] == "" )
				$tipo_acc = "Twitter";
			else
				$tipo_acc = $row['tipo'];
				              
              
              ?>  
			<div class="cuentaca">
			<dl>
			<dt>Usuario</dt>
			<dd><?=utf8_encode($logged_u['username'])?></dd>
			<?php if ($logged_u['tipo'] == 'web') { ?>
            <dt>Correo Electronico</dt>
			<dd><?= $row['email'] ?></dd>
            <?php } ?>
            <dt>Ciudad seleccionada</dt>
			<dd><?= $ciudad_sel ?></dd>
			<dt>Tipo</dt>
			<dd>Acceso vía <?=$tipo_acc ?></dd>
			</dl>
			</div>
			<div class="imagen-cuenta">
			<img src="<?=$configuracion['home_url']?>/style/images/user.jpg" />
			</div>
			<span style="width:100%;display:block;clear:both;"></span>
			<?php if ($logged_u['tipo'] == 'web') { ?>
            <p class="ver-resto fav-edit"><a href="<?=$configuracion['home_url']?>/edit-password.php">Cambiar contraseña</a></p>
			<?php } ?>
            <!-- Aquí acaba el sistema de lineas -->
			<p class="ver-resto vuelta"><a href="<?=$configuracion['home_url']?>/user">Volver a la cuenta</a></p>
		</div>
		<?php include 'caja-busqueda.php' ?>		
			
<?php include 'footer.php'; ?>
