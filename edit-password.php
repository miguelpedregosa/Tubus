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
	<style type="text/css">
	.password_strength {
		padding: 0 5px;
		display: inline-block;
		}
	.password_strength_1 {
		background-color: #fcb6b1;
		}
	.password_strength_2 {
		background-color: #fccab1;
		}
	.password_strength_3 {
		background-color: #fcfbb1;
		}
	.password_strength_4 {
		background-color: #dafcb1;
		}
	.password_strength_5 {
		background-color: #bcfcb1;
		}
	</style>
	
	
	<script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
	<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>
	<script src="<?=$configuracion['home_url']?>/js/jquery.password_strength.js"></script>
	
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
			<h1><span>Modificar Contraseña<span></h1>
			<span class="liine"></span>
		<?php
		if(isset($_POST['cambiarpass'])){
			$error = '';
			if(($_POST['actual']=='') OR ($_POST['nueva']=='') OR ($_POST['confirma']=='') OR (strlen($_POST['nueva'])<4) OR (strlen($_POST['nueva'])>16))
				echo '<p class="error">Seamos serios por favor</p>';
			else{
				//Cambio la base de datos por la que contiene los datos del login
				$db_selected = mysql_select_db('tubus_usuarios', $link);
				if (!$db_selected) {
					die ('No se puede usar tubus: ' . mysql_error());
				}	
				$sql = "SELECT * FROM usuarios WHERE username = '".$logged_u['username']."' AND id_usuario = '".$logged_u['id_usuario']."' LIMIT 1;";
				$res = mysql_query($sql,$link);
				if($res){
					$row = mysql_fetch_assoc($res);
		
					//primero compruebo que la clave que quiere cambiar coincide con la que ya tenía
					$actual_pass = sha1($_POST['actual']);
					$new_pass = sha1(mysql_real_escape_string($_POST['nueva']));
					$confirm_pass = sha1(mysql_real_escape_string($_POST['confirma']));
					$actual_saved = $row['password'];
					
					if($actual_pass!=$actual_saved){
						$error .= '<p class="error">La contraseña actual no coincide</p>';
					}
		
					//despues compruebo que la nueva y la de confirmación coinciden
					if($new_pass!=$confirm_pass){
						$error .= '<p class="error">La nueva contraseña no coincide con la confirmación</p>';
					}
					//Si todo está ok, paso a cambiar la clave
					if($error!='')
						echo $error;
					else{
						$sql = "update usuarios set password = '".$new_pass."' WHERE username = '".$logged_u['username']."' AND id_usuario = '".$logged_u['id_usuario']."'";
						$updt = mysql_query($sql,$link);
						if($updt)
							echo "<p>La contraseña se ha modificado</p>";
						else echo '<p class="error">No se ha podido modificar la contraseña</p>';
					}					
				}
				else{
					echo '<p class="error">No se ha podido cambiar la contraseña</p>';
				}
			}
		}
		?>


		<form id="register" name="register" method="post" action="" >
			<label for="actual">Contraseña <span>Actual</span></label><br />
			<input type="password" name="actual" id="actual" maxlength="16"  /><br /><br />
			
			<label for="nueva"><span>Nueva</span> Contraseña (mínimo 4 car.)</label><br />
			<input type="password" name="nueva" id="nueva" maxlength="16" /><br /><br />
			
			<label for="confirma"><span>Confirmar</span> Contraseña</label><br />
			<input type="password" name="confirma" id="confirma" maxlength="16"  /><br /><br />
			
			
			<div style="position:relative;margin:15px 0;">
			<input type="submit" name="cambiarpass" id="cambiarpass" value="Cambiar" />
			<span class="btn-der"></span>
			<span class="btn-izq"></span>
			</div>
		</form>
		
		<script type="text/javascript">
		$('form').attr('autocomplete', 'off');
		$('#nueva').password_strength();
		</script>
		</div>
		<?php include 'caja-busqueda.php' ?>		
			
<?php include 'footer.php'; ?>

