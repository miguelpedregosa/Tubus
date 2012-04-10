<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";
require_once "system.php";

$hostname = 'http://'.$_SERVER['HTTP_HOST'];
//Solo se puede cambiar de ciudad desde la app master. No desde los subdominios
if($configuracion['beta'] == false)
{
if($hostname != $configuracion['master_url'] )
{
	header ("Location: ".$configuracion['master_url']."/ciudad.php"); 
	exit();
}
}
$logged_u =  is_logged();
?>
<?php
if(isset($_GET['ciudad'])){
    $ciudad = $_GET['ciudad'];
    
    switch($ciudad){
        
        case 'GRANADA':
            setcookie("userciudad", 'gr', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'gr' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'gr' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        
        case 'VALENCIA':
            setcookie("userciudad", 'v', time() + 157680000, "/", $configuracion['dcookie']);
        if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'v' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'v' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        
        
        
        case 'ZARAGOZA':
            setcookie("userciudad", 'z', time() + 157680000, "/", $configuracion['dcookie']);
        if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'z' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'z' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        case 'BARCELONA':
            setcookie("userciudad", 'b', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'b' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'b' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
         case 'MALAGA':
            setcookie("userciudad", 'ma', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'ma' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'ma' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        case 'DONOSTIA':
            setcookie("userciudad", 'do', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'do' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'do' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        
        case 'BILBAO':
            setcookie("userciudad", 'bi', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'bi' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'bi' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
         case 'SEVILLA':
            setcookie("userciudad", 'se', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'se' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'se' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        case 'MADRID':
            setcookie("userciudad", 'madrid', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'madrid' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'madrid' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        
        case 'ELCHE':
            setcookie("userciudad", 'elche', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'elche' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'elche' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
        
         case 'CORDOBA':
            setcookie("userciudad", 'co', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'co' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'co' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;


		case 'SANTANDER':
            setcookie("userciudad", 'sa', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'sa' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'sa' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;


		case 'GIJON':
            setcookie("userciudad", 'gijon', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'gijon' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'gijon' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        


		case 'GUIPUZCOA':
            setcookie("userciudad", 'guipuzcoa', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'guipuzcoa' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'guipuzcoa' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
		case 'LEON':
            setcookie("userciudad", 'leon', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'leon' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'leon' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
       case 'VALLADOLID':
            setcookie("userciudad", 'valladolid', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'valladolid' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'valladolid' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
      case 'ALBACETE':
            setcookie("userciudad", 'albacete', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'albacete' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'albacete' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
        
		case 'VIGO':
            setcookie("userciudad", 'vigo', time() + 157680000, "/", $configuracion['dcookie']);
            if($logged_u['logged'] == true){
                
               //Cambio la base de datos por la que contiene los datos del login
                $db_selected = mysql_select_db('tubus_usuarios', $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                }   
                //Fin de cambio de base de datos
                if($logged_u['tipo'] == 'oauth')
                    $sql = "UPDATE oauth SET ciudad = 'vigo' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                else if($logged_u['tipo'] == 'web')
                    $sql = "UPDATE usuarios SET ciudad = 'vigo' WHERE id_usuario = '".$logged_u['id_usuario']."' LIMIT 1 ";
                
                $res = mysql_query($sql);
                
                //Vuelvo a cambiar a la otra base de datos
                $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
                    if (!$db_selected) {
                        die ('No se puede usar tubus: ' . mysql_error());
                    }
                //Fin de cambio de base de datos
                
                    
            }
        break;
	    
                
        
        default:
            setcookie("userciudad", 'madrid', time() + 157680000, "/", $configuracion['dcookie']);
        break;
        
    }
    
    //Una vez hecha la selección de ciudad, redirijo a la portada del sitio
   if(isset($_GET['r']))
   {
	   header ("Location: ".$configuracion['home_url']."/".$_GET['r']);
   }
   else{
		header ("Location: ".$configuracion['home_url']."/"); 
	}
   
   exit();
}
else{
	if(isset($_GET['r']))
   {
	   $r = '&r='.$_GET['r'];
   }
   else
   {
	$r = '';	
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title('Seleccione la ciudad donde se encuentra')?></title>
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
		<?php if($configuracion['beta']) $subdominio_activo = 'http://beta.tubus.es'; else $subdominio_activo = 'http://tubus.es'; ?>
		<div id="sub-cont">
				<h1><span>Seleccione su ciudad</span></h1>
				<span class="liine"></span>
				<!--Selecion de ciudad-->
				<div id="register">
				<!--Nueva Construcción-->
				<div id="seleccion-boton2">
				<a href="ciudad.php?ciudad=MADRID<?=$r?>" title="Acceder a la información de Madrid"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-madrid.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=BARCELONA<?=$r?>" title="Acceder a la información de Barcelona"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-b.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=SEVILLA<?=$r?>" title="Acceder a la información de Sevilla"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-se.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=VALENCIA<?=$r?>" title="Acceder a la información de Valencia"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-v.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=GRANADA<?=$r?>" title="Acceder a la información de Granada"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-gr.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=ZARAGOZA<?=$r?>" title="Acceder a la información de Zaragoza"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-z.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=DONOSTIA<?=$r?>" title="Acceder a la información de Donostia - San Sebastián"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-do.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=LEON<?=$r?>" title="Acceder a la información de León"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-leon.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=VALLADOLID<?=$r?>" title="Acceder a la información de Valladolid"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-valladolid.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=BILBAO<?=$r?>" title="Acceder a la información de Bilbao"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-bi.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=MALAGA<?=$r?>" title="Acceder a la información de Málaga"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-ma.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=SANTANDER<?=$r?>" title="Acceder a la información de Santander"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-sa.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=GIJON<?=$r?>" title="Acceder a la información de Gijón"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-gijon.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=CORDOBA<?=$r?>" title="Acceder a la información de Córdoba"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-co.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=ELCHE<?=$r?>" title="Acceder a la información de Elche"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-elche.tubus.png) no-repeat 50%;"></span></a>
				
				<a href="ciudad.php?ciudad=GUIPUZCOA<?=$r?>" title="Acceder a la información de la provincia de Guipuzcoa"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-guipuzcoa.tubus.png) no-repeat 50%;"></span></a>				
				
				<a href="ciudad.php?ciudad=ALBACETE<?=$r?>" title="Acceder a la información de Albacete"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-albacete.tubus.png) no-repeat 50%;"></span></a>				
				
				<a href="ciudad.php?ciudad=VIGO<?=$r?>" title="Acceder a la información de Vigo"><span class="btn-usr tipo2" style="background:url(<?=$configuracion['home_url']?>/style/images/invert-logo-vigo.tubus.png) no-repeat 50%;"></span></a>				
				
				
				</div>
				<!--Fin de nueva Construcción-->
				
				</div>
				<!--Fin de selecion de ciudad-->
                
        </div>
			
<?php include 'footer.php'; ?>
    
    
    
    
<?php    
}
