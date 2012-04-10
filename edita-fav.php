<?php
require_once 'system.php';
require_once 'libs/cache_kit.php';
require_once 'libs/url.php';
require_once 'libs/helpers.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/text.php';
require_once 'libs/functions.php';
require_once 'libs/dbconnect.php';
require_once 'libs/usuarios.php';
require_once 'libs/movil.php';

$logged_u=is_logged();

if($logged_u['logged'] == false){
    header ("Location: ".$configuracion['home_url']."/"); 
    exit();
}

$nombre = (int)$_GET['parada'];
$fecha = date('Y-m-d H:i:s');	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title("Editar paradas favoritas")?></title>
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
		<div id="datos_parada">
			<?php	
			if(isset($_POST['paso3'])){
				//guardo los datos en BD
				$fav_sql  = "UPDATE favoritos SET nombre_parada = '".utf8_decode($_POST['nuevonombre'])."' WHERE id = '".$_POST['favorito']."'"; 
				$res_fav = mysql_query($fav_sql);
				
				if($res_fav)
				{
					echo '<p>El favorito se ha actualizado correctamente</p>';
				}
				else{
					echo '<p>Se ha producido un error al actualizar. Por favor, vuelva a intentarlo más tarde</p>';
				}			
			}
			if(isset($_POST['paso2']) OR isset($_GET['parada'])){
				$where = '';
				
				if(isset($_POST['paso2'])){
					$ident_favorito = $_POST['favorito'];
					$where = "f.id = '".$ident_favorito."'";
				}
				else{
					$ident_favorito = $_GET['parada'];
					$where = "f.id_parada = '".$ident_favorito."'";
				}
					
				$fav_sql  = "SELECT * FROM favoritos f
				join paradas p on f.id_parada = p.id_parada
				join trayectos_a_paradas tp on f.id_parada = tp.id_parada
				WHERE ".$where." AND f.id_usuario='".$logged_u['id_usuario']."' Limit 1"; 
				$res_fav = mysql_query($fav_sql);
				
				if(mysql_num_rows($res_fav)==1){
				
				$rowf = mysql_fetch_assoc($res_fav);
				
				?>	
				<form name="editaFav2" id="register" action="edita-fav.php" method="POST">		
					<p>Información de la parada</p>
					<p><span>Parada nº <?=$rowf['nombre']?><br /><?=utf8_encode($rowf['label'])?></span></p>
					
					<p>
					  <label for="nuevonombre"><span>Nuevo nombre:</span></label>
					  <input type="text" id="errortype" name="nuevonombre" maxlength="50" />
					</p>
					
					<p><input type="hidden" name="favorito" value="<?=$rowf['id']?>" /></p>

					<div style="position:relative;margin:15px 0;">
						<input type="submit" name="paso3" value="GUARDAR" />
						<span class="btn-der"></span>
						<span class="btn-izq"></span>
					</div>	
					<div style="position:relative;margin:15px 0;">
						<a href="<?=$configuracion['home_url']?>/edita-fav.php" title="Atrás"><input type="button" name="paso3" value="<< ATRÁS" /></a>
						<span class="btn-der"></span>
						<span class="btn-izq"></span>
					</div>		
				</form>
				<?php
				}
			}
				
			if(!isset($_POST['paso2'])&&!isset($_POST['paso3'])&&!isset($_GET['parada'])){
			?>	
				<form name="editaFav" id="register" action="edita-fav.php" method="POST">		
					
					<?php
					if(have_favorites($logged_u['id_usuario'], $logged_u['tipo'])){			
					?><p>
						<label for="favorito"><span>Seleccione favorito:</span></label>
						  <select id="errortype" name="favorito" width="50">
						
							<?php
							$fav_sql  = "SELECT * FROM favoritos WHERE id_usuario = '".$logged_u['id_usuario']."' AND tipo_usuario = '".$logged_u['tipo']."' ORDER by fecha DESC"; 
							$res_fav = mysql_query($fav_sql);
							while($rowf = mysql_fetch_array($res_fav)){
								$id_parada = $rowf['id_parada'];
								$id_favorito = $rowf['id'];
								$nombre = utf8_encode($rowf['nombre_parada']);
								echo '<option value="'.$id_favorito.'" selected>'.$nombre.'</option>';
							}
						?>
						</select>
						</p>
						<div style="position:relative;margin:15px 0;">
						<input type="submit" name="paso2" value="Siguiente >>" />
						<span class="btn-der"></span>
						<span class="btn-izq"></span>
						</div>
						<?php
					}//si tiene favoritos
					else{
						echo "<p>Lo sentimos, pero no tiene seleccionada ninguna parada como favorita</p>";
					}
					?>
					
					
					
				</form>
			<?php
			}
			?>
			<p class="info_general returner">Volver <a href="<?=$configuracion['home_url']?>/favoritos.php" title="Volver a Tubus">a Favoritos</a></p>
		
		
		</div>
	</div>    
    
</div>
    
<!-- Por aqui meto mano -->
<?php include 'caja-busqueda.php' ?>

<?php include 'footer.php';?>
