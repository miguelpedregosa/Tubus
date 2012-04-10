<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//Asignación de variables
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/'.$configuracion['conector'];
require_once '../libs/text.php';
require_once '../libs/functions.php';


$parada_id = (int)$_GET['parada'];


//$geolocation_ready = is_geolocation_capable();
$cache_active = $configuracion['cache_active'];  
$cache_folder = $configuracion['cache_dir']; 
$data_cache_id = $configuracion['cache_prefix'].'_'.'info_parada_'.$parada_id;
$random = mt_rand(0,150);
$error_datos = false;
$refresh_time = 45;
$nombre_parada = obtener_nombre_parada($parada_id);


if($nombre_parada != false){ //La parada está en la base de datos, por tanto uso los valores estáticos desde aquí
    $coordenadas = get_coordenadas($parada_id);
    $paradas_cercanas = obtener_paradas_cercanas($parada_id);
    $trasbordos_parada = obtener_lineas_parada($parada_id);
   
    $geobloqueada = is_blocked($parada_id);
    //Puede que tenga los datos de la parada, pero no los datos de sus trasbordos, en ese caso los cojo de la matriz de La Rober
    if($trasbordos_parada == false){
        $datos_serializados = acmeCache::fetch($data_cache_id, $configuracion['cache_expiration']); 
            if(!$datos_serializados || $accion == 'r'){ 
                $datos = infoParada($parada_id);
            if($datos == '-1'){
                $error_datos = true;
            }
        $datos_serializados = serialize($datos);
        acmeCache::save($data_cache_id, $datos_serializados); 
        } 

        $tiempo_modificacion =  acmeCache::modified_time($data_cache_id);
        $matriz_datos = unserialize($datos_serializados);
        
        $trasbordos_parada = array();
        $numdatos = count($matriz_datos['transbordos']['linea']);
         for($i=0; $i<$numdatos; $i++){
             $tmp = array();
             $tmp['id_linea'] = null;
             $tmp['nombre'] = $matriz_datos['transbordos']['linea'][$i];
             $destinos = explode('-',$matriz_datos['transbordos']['destinos'][$i]);
             $tmp['salida'] = $destinos[1];
             $tmp['llegada'] = $destinos[0];
            
            $trasbordos_parada[] = $tmp;
         }
    }
    //contar_parada($parada_id);
    //registrar_historial($parada_id);
    
}
else{
    //La parada no está en la base de datos
    $datos_serializados = acmeCache::fetch($data_cache_id, $configuracion['cache_expiration']); 
    $geobloqueada = false;
        if(!$datos_serializados || $accion == 'r'){ 
            $datos = infoParada($parada_id);
            if($datos == '-1'){
                $error_datos = true;
                $trasbordos_parada = false;
                $coordenadas = false;
                $paradas_cercanas = false;
            }
            else{
                $datos_serializados = serialize($datos);
                acmeCache::save($data_cache_id, $datos_serializados); 
            }
            
        }
    if(!$error_datos){ //Tenemos los datos traidos desde caché o desde La Rober
         $tiempo_modificacion =  acmeCache::modified_time($data_cache_id);
         $matriz_datos = unserialize($datos_serializados);
         //Tengo que realizar la conversión de la matriz de datos que recibo en las matrices que uso en el resto del programa
         $nombre_parada = array();
         $trasbordos_parada = array();
         
         $nombre_parada['id_parada'] = null;
         $nombre_parada['nombre'] = $parada_id;
         $nombre_parada['label'] = $matriz_datos['nombre'];
         $nombre_parada['direccion'] = null;
         $nombre_parada['zona'] = null;
         $nombre_parada['zona'] = 0;
         $nombre_parada['visitas'] = 1;
         //Ahora hago lo mismo con la matriz de transbordos
         $numdatos = count($matriz_datos['transbordos']['linea']);
         for($i=0; $i<$numdatos; $i++){
             $tmp = array();
             $tmp['id_linea'] = null;
             $tmp['nombre'] = $matriz_datos['transbordos']['linea'][$i];
             $destinos = explode('-',$matriz_datos['transbordos']['destinos'][$i]);
             $tmp['salida'] = $destinos[1];
             $tmp['llegada'] = $destinos[0];
            
            $trasbordos_parada[] = $tmp;
         }

        $coordenadas = false; //No hay coordenadas porque la parada no está en la base de datos
        $paradas_cercanas = false; //No hay paradas cercanas
        //contar_parada($parada_id, $nombre_parada['label']); //Registro la parada en la base de datos para futuros usos
        //registrar_historial($parada_id);
        
    }
}
?>
<span class="liine2"></span>
<?php 
if($trasbordos_parada != false)
         foreach($trasbordos_parada as $linea){ 
					if($linea['numero_trayecto'] != "")
					{
						$append_to = '/'.$linea['numero_trayecto'].'/';
					}
					else
					{
						$append_to = '/';
					}
					
					if($linea['color'] == '000000')
						$linea_color = '892E11';
					else 
						$linea_color = $linea['color'];
					$url_imag_l = $configuracion['home_url'].'/imagenes/lineas/imagen_linea.php?radio=15&borde='.$linea_color.'&linea='.$linea['nombre'];
					?>
		<a href="<?=$configuracion['home_url']?>/linea/<?=$linea['nombre']?><?=$append_to?>" title="Ver detalles de la línea <?=$linea['nombre']?>: <?= $linea['salida'].' - '.$linea['llegada'] ?>"><div class="apartado-bus-trasbordos">
			<table style="width:100%;" id="linea_<?= $linea['nombre']?>">
			<a href="<?=$configuracion['home_url']?>/linea/<?=$linea['nombre']?><?=$append_to?>"><tr>
			<td class="numero"><img class="imaglinea" src="<?=$url_imag_l?>" title="Línea <?=$linea['nombre']?>: <?= $linea['salida'].' - '.$linea['llegada'] ?>" alt="Línea <?=$linea['nombre']?>: <?= $linea['salida'].' - '.$linea['llegada'] ?>" /></td>
			<td class="destino2"><strong>Trayecto:</strong> <?= $linea['salida'].' - '.$linea['llegada'] ?></td>
			</tr>
			</table>
			</div></a>
            <span class="liine2"></span>
<?php }
  else {
        ?>
    <p class="info_general">No hay información disponible actualmente.</p>
 <?php } ?>
