<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/'.$configuracion['conector'];
//require_once '../libs/rober.php';
require_once '../libs/text.php';
require_once '../libs/functions.php';
//require_once 'libs/movil.php';

$parada_id = (int)$_GET['parada'];

$cache_active = $configuracion['cache_active'];  
$cache_folder = $configuracion['cache_dir']; 
//echo $cache_folder;

//$data_cache_id = 'info_parada_'.$parada_id;
$data_cache_id = $configuracion['cache_prefix'].'_'.'info_parada_'.$parada_id;
$datos_serializados = acmeCache::fetch($data_cache_id, $configuracion['cache_expiration']); 


if(!$datos_serializados || $datos_serializados == 'i:-1;' || $_GET['a'] == 'r'){ 
	$datos = infoParada($parada_id);
	if($datos == '-1'){
		//header('Location: '.$configuracion['home_url'].'/error.php?error=1&parada='.$parada_id);
		echo mostrar_error_parada(true);
		exit();
	}
	$datos_serializados = serialize($datos);
    acmeCache::save($data_cache_id, $datos_serializados); 
} 

$tiempo_modificacion =  acmeCache::modified_time($data_cache_id);

$matriz_datos = unserialize($datos_serializados);
?>
<h4>Próximos autobuses en llegar<span id="mini-ajax" style="position:relative; display:none"><img src ="<?=$configuracion['home_url']?>/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h4><span class="liine2"></span>
<?php for($i=0; $i < count($matriz_datos['proximos']['linea']); $i++) { ?>
		<div class="apartado-bus">
			<div class="apartado-contenido">
			<table style="width: 100%;">
			<tr>
			<td class="numero2"><a href="#linea_<?=$matriz_datos['proximos']['linea'][$i]?>"><?=$matriz_datos['proximos']['linea'][$i]?></a></td>
			<td class="destino3"><strong>Hacia:</strong> <?= corregir_titulo($matriz_datos['proximos']['destino'][$i]) ?></td>
			<td class="time"><?php 
			/* Para mostrar imagen */
			if($matriz_datos['proximos']['minutos'][$i]==0||$matriz_datos['proximos']['minutos'][$i]=='0'){
					echo '<img src="'.$configuracion['home_url'].'/style/images/llegada.gif" alt="Autobus llegando" />';
			}
			else echo $matriz_datos['proximos']['minutos'][$i]." min";?></td> 
			</tr>
			</table>
			</div>	
			</div>
            <span class="liine2"></span>
		<?php }?>
