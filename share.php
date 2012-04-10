<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';
require_once 'libs/lib_input.php';
require_once 'libs/helper_email.php';

$parada_id = (int)$_GET["id_parada"];
if($parada_id == null || !isset($_GET["id_parada"]) || $parada_id == 0)
{
	header('Location: '.$configuracion['home_url'].'/');
	exit();
}
$canonical_url = 'http://'.$configuracion['cache_prefix'].'.es/'.$parada_id.'/';

$text_share = urlencode("Usando #Tubus ".$configuracion['ciudad']." para obtener información de la parada de autobús nº $parada_id $canonical_url vía @tubus_es");
$text_share2 = urlencode("Información y llegadas en tiempo real de la parada de autobús nº $parada_id en ".$configuracion['ciudad']."");

$twitter_href = "http://twitter.com/home?status=$text_share";
$twitter_href = "http://twitter.com/share?url=".urlencode($canonical_url)."&amp;text=$text_share";

/*
<a target="_blank" href="http://twitter.com/share?url=<?php echo urlencode($canonical_url); ?>&amp;text=<?php echo urlencode($texto_twitter); ?>
*/
$facebook_href = "http://www.facebook.com/sharer.php?u=".$canonical_url;
$tuenti_href = "http://www.tuenti.com/share?url=".$canonical_url;
$delicious_href = "http://delicious.com/save?url=".$canonical_url.'&title='.$text_share2;

$posterous_href = "http://posterous.com/share?linkto=".$canonical_url;
$buzz_href = "http://www.google.com/buzz/post?url=".$canonical_url;

$readitlater_href = "https://readitlaterlist.com/save?url=".$canonical_url."&title=".$text_share2;
$blogger_href ="http://www.blogger.com/blog_this.pyra?t&u=".$canonical_url."&n=".$text_share2."&pli=1";

$tumblr_href = "http://www.tumblr.com/share?v=3&u=".str_replace("http://","",$canonical_url)."&t=$text_share2";


function enviar_parada_email($to, $nombrer, $comentario )
{
	global $parada_id, $configuracion, $canonical_url;
	
	$nombre_parada = obtener_nombre_parada($parada_id);
	$trasbordos_parada = obtener_lineas_parada($parada_id);
	$trasbordos_parada = array_elimina_duplicados($trasbordos_parada, 'id_linea');
	$coordenadas = get_coordenadas($parada_id);
	
	$lineas_part = '';
	
	foreach($trasbordos_parada as $linea)
	{
		$lineas_part .= $linea['nombre'].', ';
	}
	$lineas_part = trim($lineas_part);
	$lineas_part = rtrim($lineas_part, ',');
	
	if($nombre_parada['direccion'] != "")
	{
		$direccion_part = '<strong>Dirección:</strong> '.$nombre_parada['direccion'].' <em>'.$configuracion['ciudad'].'</em><br />';
	}
	else
	{
		$direccion_part = '';
	}
	
	if($coordenadas['latitud'] != '' && $coordenadas['latitud'] != 0 && $coordenadas['longitud'] != '' && $coordenadas['longitud'] != 0)
	{
		$coordenadas_part = '<strong><a href="'.$canonical_url.'#ubicacion" title="Ver ubicación de la parada">Ver mapa</a></strong>';
	}
	else
	{
		$coordenadas_part = '';
	}
	//die;
	
	$data['html'] =
	'
	<html>

<head>

<title>'.$nombrer.' te recomienda la parada '.$parada_id.' en Tubus '.$configuracion['ciudad'].'</title>

</head>

<body>

<!--This style Should be in body to appear it correctly in email clients-->

<style type="text/css">

body { background-color: #f7f4f2; margin: 0 0 0 0; padding: 0 0 0 0; } table { color:#000000; font-family: Verdana, Geneva, sans-serif; font-size:12px; line-height:20px; } a { color: #000000; text-decoration:none;} a img { border: none; } ul.list li {font-family:Verdana, Geneva, sans-serif; font-size:12px; line-height:12px; } .options{ color:#000000; font-family: Verdana, Geneva, sans-serif; font-size:10px; line-height:12px; } .options a{ color:#94391c; text-decoration:none; }

</style>

<!--wraper table-->

	<table border="0" width="100%" style="border-width: 0px" cellspacing="0" cellpadding="0" bgcolor="#f7f4f2">
	
		<tr>
	    
			<td style="border-style: none; border-width: 0px" align="center">
			
			
			
			<!--Start Top Options-->
			
			<table border="0" width="600" cellspacing="0" cellpadding="0" style="border-width: 0px; height: 38px;">
				<tr>
	            
					<td class="options" align="center">
					
					
					</td>
				</tr>
			</table>
			<!--End Top Options-->
			


			
			<!--Start Header Image with logo-->
			
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="bottom">
					
					<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/top.gif" width="600" height="68">
					
					</td>
				</tr>
			</table>
			<!--End Header Image with logo-->
	
	
			<!--Start Infocus Module-->
			
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="12" bgcolor="#FFFFFF">
				<tr>
					<td style="border-style: none; border-width: 0px">
	                
					<table border="0" width="100%" style="border-width: 0px" cellspacing="0" cellpadding="8">
						<tr>
							<td class="infocus" style="border-style: none; border-width: 0px" bgcolor="#94391c" align="left" valign="top">
	                        
							<b><font size="3" color="#FFFFFF">Tubus</font></b>
							
							<hr style="color: #DC7C65; background-color: #DC7C65; height: 1px;" size="1">
										
							<font color="#FFFFFF">
							Tubus te permite conocer en tiempo real las llegadas de los autobuses urbanos de tu ciudad. Gestiona tu tiempo y evita esperas innecesarias.
							<br />Descubre todas las características que nos convierten en tu mejor opción.
							</font><br>
							
							<a href="http://blog.tubus.es/"><img alt="Ir al blog de Tubus" border="0" src="http://email.tubus.es/registro/infocus_readmore.jpg"></a>
							<a href="http://tubus.es"><img alt="Ir a Tubus" border="0" src="http://email.tubus.es/registro/infocus_buynow.jpg"></a>
							
							</td>
	                        
							<td style="border-style: none; border-width:0px" width="235" bgcolor="#94391c" align="left" valign="top">
	                        
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/infocus_image.jpg" width="336" height="257"></td>
						</tr>
					</table>
	                
					</td>
				</tr>
			</table>
			<!--End Infocus Module-->
			
				
			
			<!--Start Full Length News Module-->
			
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px">
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
					
							<b><font size="3" color="#94391c">¡'.$nombrer.' te recomienda que visites el siguiente lugar en Tubus '.$configuracion['ciudad'].'!</font></b><br/><br/>
							
				
							<p>Alguien, que probablemente conoces, te invita a que visualices la parada '.$parada_id.' en Tubus '.$configuracion['ciudad'].'. Igualmente te ha dejado el siguiente mensaje:</p>
							<p><em>'.$comentario.'</em></p>
	                  </td>
				</tr>
			</table>
			
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px" >
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
	
	
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/Wooden-Map-128.png" width="128" height="128" align="right" hspace="16" vspace="8">
							
							<b><font size="3" color="#94391c">Parada '.$parada_id.' en '.$configuracion['ciudad'].'</font></b><br/>
														
							Líneas de autobus urbano que paran aquí: 
							<br />
							'.$lineas_part.'
							<br />
							<br />
							'.$direccion_part.'
							'.$coordenadas_part.'
							
					</td>
				</tr>
			</table>
			
			
			
			

			<!--End Full Length News Module-->
		
			
			<!--Start Line Seperator-->			
			
			<table border="0" width="600" cellspacing="0" cellpadding="0" style="border-width: 0px">
				<tr>
					<td style="border-style: none; border-width: 0px" align="center" bgcolor="#FFFFFF">
					
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/seperator.jpg" width="402" height="7"></td>
				</tr>
			</table>
			<!--End Line Seperator-->			
			
			
			
			
			
			
	
	
			<!--Start News Module with left Side bar-->
	
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="20">
				<tr>
	            	
	                <!-- left side bar with links --> 
	                
					<td style="border-style: none; border-width: medium" align="center" valign="top" bgcolor="#FFFFFF">
								<a href="http://tubus.es/ciudad.php?ciudad=GUIPUZCOA">
								<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/guip.jpg" width="125" height="125"></a><p>
								<a href="http://tubus.es/ciudad.php?ciudad=SANTANDER">
								<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/sant.jpg" width="125" height="125"></a></p>
								<p>
								<a href="http://tubus.es/ciudad.php?ciudad=GIJON">
								<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/gijon.jpg" width="125" height="125"></a></p>
					</td>
	                
	                
					<td style="border-style: none; border-width: medium" align="left" valign="top" width="400" bgcolor="#FFFFFF">
						
							<b><font size="3" color="#94391c">¿Dónde está disponible Tubus?</font></b><br/><br/>
							Actualmente Tubus está presente en 15 ciudades españolas, incluyendo las 5 ciudades con mayor número de habitantes de España:
							
							<ul style="list-style-position:inside;padding:0;">
							<li>Madrid</li>
							<li>Barcelona</li>
							<li>Sevilla</li>
							<li>Valencia</li>
							<li>Zaragoza</li>
							<li>Málaga</li>
							<li>San Sebastián</li>
							<li>Bilbao</li>
							<li>Granada</li>
							<li>Córdoba</li>
							<li>Santander</li>
							<li>Gijón</li>
							<li>Elche</li>
							<li>Jaén</li>
							<li>Guipuzcoa</li>
							</ul>
	                        Seguimos creciendo y llegando a nuevas ciudades de forma regular, aumentando el número de personas a las que ofrecemos nuestros servicios de forma totalmente gratuita.
	                        <br/>
	
					</td>
				</tr>
			</table>
			<!--End News Module with left Side bar -->
			
			<!-- Start footer Image -->
			
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top">
	                
						<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/bot.gif" width="600" height="45">
	                    
	                </td>
				</tr>
			</table>
			<!-- End  footer Image -->
			
			
			
	
	
			<!-- Start Bottom Options -->
			
			<table border="0" width="600" cellspacing="0" cellpadding="0" style="border-width: 0px; padding: 10px;">
				<tr>
	            
					<td class="options" align="center">
					
						Entra en <a href="http://tubus.es">tubus.es</a>, o en nuestro <a href="http://blog.tubus.es">blog</a>. 
						También nos puedes seguir en <a href="http://twitter.com/tubus_es">Twitter</a>. <br>
	                    
					
					</td>
				</tr>
			</table>
			<!-- End Bottom Options -->
			
			
			
			
			
			</td>
		</tr>
	</table>

</body>

</html>

	';
	$data['to'] = $to;
	$data['from'] = 'info@tubus.es';
	//$data['fromname'] = $nombrer. ', a través de Tubus '.$configuracion['ciudad'];
	//$data['replyto'] = 'info@tubus.es';
	//$data['replytoname'] = $nombrer;
	
	$data['subject'] = $nombrer.' te recomienda la parada '.$parada_id.' en Tubus '.$configuracion['ciudad'];
	
	//if(!isset($data['to']) || !isset($data['from']) || !isset($data['subject']) || !isset($data['html']))
	return Email::send_html_email($data);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>

<title><?=html_title("Compartir parada $parada_id")?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Buscador de paradas Tubus facilita el acceso a toda la información relativa al sistema de transporte urbano granadino. Gracias a TuBus es muy sencillo conocer el tiempo estimado de llegada de cada autobús en cada parada, desde cualquier lugar y en cualquier momento." /> 
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
<div id="sub-cont" class="zona-paradas">
			<h1><span>Compartir parada <a href="<?=$configuracion['home_url']?>/<?=$parada_id?>" title="Ir a la parada <?=$parada_id?>"><?=$parada_id?></a> (<?=$configuracion['ciudad']?>)</span></h1>
            <span class="liine"></span>
	<!--<div id="datos_parada">-->
		<!-- Hueco 1 -->
		<div id="share-twitter" class="share">
		<a href="<?=$twitter_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-twitter.jpg" alt="Compartir parada en Twitter" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-facebook" class="share">
		<a href="<?=$facebook_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-facebook.jpg" alt="Publicar en tu muro de Facebook" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-tuenti" class="share">
		<a href="<?=$tuenti_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-tuenti.jpg" alt="Publicar en tu perfil de Tuenti" /></a>
		</div>

		<span class="liine"></span>
		<div id="share-tumblr" class="share">
		<a href="<?=$tumblr_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-tumblr.jpg" alt="Compartir infromación usando Tumblr" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-posterous" class="share">
		<a href="<?=$posterous_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-posterus.jpg" alt="Publicar en tu blog Posterous" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-blogger" class="share">
		<a href="<?=$blogger_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-blogger.jpg" alt="Publicar en tu blog Blogger" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-delicious" class="share">
		<a href="<?=$delicious_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-delicious.jpg" alt="Guardar enlace en Delicious" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-googlebuzz" class="share">
		<a href="<?=$buzz_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-google.jpg" alt="Compartir en Google Buzz" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-readitlater" class="share">
		<a href="<?=$readitlater_href?>"><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-read.jpg" alt="Guardar información en Read It Later" /></a>
		</div>
		<span class="liine"></span>
		<div id="share-email" class="share">
		<a href=""><img src="<?=$configuracion['home_url']?>/imagenes/logos/l-mail.jpg" alt="" /></a>
			</div>
			
			<?php
			if(isset($_POST['submit']))
			{
				$validado = true;
				$error_txt = array();
				//echo 'Has enviado el formulario';
				//Empiezo a validar campos del formulario
				
				$nombre = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
				if($nombre == ""){
					$validado = false;
					array_push($error_txt, "Debes introducir un nombre para que sepan quien envía la recomendación");
				}
				
				$sanitized_email = filter_input(INPUT_POST, "destino_email" ,FILTER_SANITIZE_EMAIL);
				
				if($sanitized_email == ""){
					$validado = false;
					array_push($error_txt, "Debes introducir un email para enviar la recomendación");
				}
				else
				{
				
					if (!filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
						$validado = false;
						array_push($error_txt, "Debes introducir un email válido al que enviar la recomendación");
					}
				}
			
				$texto = filter_input(INPUT_POST, "texto", FILTER_SANITIZE_STRING);
			
				if($validado)
				{
					//Envio en el mail
				
				enviar_parada_email($sanitized_email, $nombre, $texto);
				/*
				$datos_email['to'] = $sanitized_email;
				$datos_email['subject'] = $nombre." te recomienda bla bla bla en Tubus";
				$datos_email['text'] = $texto;
				*/
				Email::send_text_email($datos_email);


					//Guardo el email en la base de datos.
						//Cambio la base de datos por la que contiene los datos del login
							$db_selected = mysql_select_db('tubus_usuarios', $link);
								if (!$db_selected) {
									die ('No se puede usar tubus: ' . mysql_error());
							}   
						//Fin de cambio de base de datos	
				
				$ip = get_real_ip();
				$fecha_env = date('Y-m-d H:i:s');
				$sql = "INSERT INTO recomendar_emails (ciudad, parada, sender, toadd, message, ip, date) VALUES ('".addslashes(utf8_decode($configuracion['ciudad']))."', '".addslashes(utf8_decode($parada_id))."','".addslashes(utf8_decode($nombre))."', '".addslashes($sanitized_email)."', '".addslashes(utf8_decode($texto))."', '".$ip."', '".$fecha_env."' ) ";
				
				mysql_query($sql);
				
				
				
				
					//Vuelvo a cambiar a la otra base de datos
						$db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
						if (!$db_selected) {
							die ('No se puede usar tubus: ' . mysql_error());
						}
        
					//Fin de cambio de base de datos
				
					//Limpio las variables POST usadas para que no se muestren de nuevo en el formulario
					$_POST['username'] = '';
					$_POST['destino_email'] = '';
					$_POST['texto'] = '';
			echo '<div class="exito">Se ha enviado el mensaje correctamente</div>';
			
				}
				else
				{
					echo '<ul class="error-p">';
					//Muestro un mensaje de error
					foreach ($error_txt as $error)
					{
						echo '<li>'.$error.'</li>';
					}
					echo '</ul>';
				}
				
			
					
			}
			
			?>
			
			<form id="register" class="forma-mail" action="#share-email" method="post">
			<label><span>Tu nombre*</span></label><input value="<?=$_POST['username']?>" type="text" name="username" id="username" />
			<label><span>Enviar a*</span></label><input value="<?=$_POST['destino_email']?>" type="text" name="destino_email" id="destino_email" />
			<label><span>Comentario:</span></label><textarea name="texto" ><?=$_POST['texto']?></textarea>
			<small>Al pulsar en "Enviar" estás aceptando nuestras <a href="<?=$configuracion['home_url']?>/legal.php" title="Ver condiciones de privacidad (en ventana nueva)" target="_blank">condiciones de privacidad</a></small>
			<div style="position:relative;margin:15px 0;">		
		<input type="submit" name="submit" value="ENVIAR" />
		<span class="btn-der"></span>
		<span class="btn-izq"></span>
		</div>
		</form>
		 
		
	<!--</div>-->

<div class="resultados-buqueda">	
		<!-- Hueco 2 -->
	</div>
</div>


<!-- Por aqui meto mano -->
<div id="otraparada">
	 <h1>Buscar paradas de autobús</h1> 
	<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input class="caja-datos" type="text" value="<?=$direccion?>" name="querystring" id="querystring" />
		<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puedes buscar por dirección o directamente por el número de parada.</div>
</div>
<!-- Hasta aquí -->

<?php include 'footer.php'; ?>	
