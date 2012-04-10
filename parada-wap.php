<?php
$cache_active = $configuracion['cache_active'];  
$cache_folder = $configuracion['cache_dir']; 
$data_cache_id = $configuracion['cache_prefix'].'_'.'info_parada_'.$parada_id;
$random = mt_rand(0,150);
$error_datos = false;
$refresh_time = 65;
$logged_u =  is_logged();
//$parada_id=304;
$nombre_parada = obtener_nombre_parada($parada_id);
if($nombre_parada != false){ //La parada está en la base de datos, por tanto uso los valores estáticos desde aquí
    $coordenadas = get_coordenadas($parada_id);
    $paradas_cercanas = obtener_paradas_cercanas($parada_id,300,3);
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
    $trasbordos_parada = obtener_lineas_parada($parada_id);
    //Puede que tenga los datos de la parada, pero no los datos de sus trasbordos, en ese caso los cojo de la matriz de La Rober
    if($trasbordos_parada == false){
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
    contar_parada($parada_id);
    registrar_historial($parada_id);
}
else{ //La parada no está en la base de datos
    $datos_serializados = acmeCache::fetch($data_cache_id, $configuracion['cache_expiration']); 
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
        contar_parada($parada_id, $nombre_parada['label']); //Registro la parada en la base de datos para futuros usos
        registrar_historial($parada_id);
        
    }
}

echo'
<?xml version="1.0"?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN"
"http://www.wapforum.org/DTD/wml_1.1.xml">

<wml>

<card id="no1" title="Parada '.$nombre_parada['nombre'].' - Tubus '.utf8_decode($configuracion['ciudad']).'">
<big>Tubus - '.utf8_decode($configuracion['ciudad']).'</big>
  <p>'.utf8_decode($nombre_parada['label']).' ('.$nombre_parada['nombre'].')</p>
<p>
<table columns="3">
<tr>
    <td><b>L&#237;nea</b></td>
    <td><b>Destino</b></td>
    <td><b>Est.</b></td>
  </tr>
';
if(count($matriz_datos['proximos']['linea']) > 0) {
for($i=0; $i < count($matriz_datos['proximos']['linea']); $i++) {
	$destino_str = utf8_decode(corregir_titulo($matriz_datos['proximos']['destino'][$i]));
	echo '
	<tr>
		<td>'.$matriz_datos['proximos']['linea'][$i].'</td>
		<td>'.$destino_str.'</td>
		';
		if($matriz_datos['proximos']['minutos'][$i]==0||$matriz_datos['proximos']['minutos'][$i]=='0'){
            echo '<td><img src="'.$configuracion['home_url'].'/style/images/llegada.wbmp" alt="Autobus llegando" /></td>';
         }
        else{
			echo '<td>'.$matriz_datos['proximos']['minutos'][$i].'</td>
		';
		}
		echo '
	</tr>';
}
}
else
{
	echo '<tr>
			<td>&#45;</td>
			<td>&#45;</td>
			<td>&#45;</td>
		  </tr>';
}
echo '
</table>
</p>
<p>
<b>Act.</b> '.date('j/n/Y H:i:s').'
</p>
<p>
<a href="'.$configuracion['home_url'].'/'.$parada_id.'/wap/'.'">Actualizar datos</a>
</p>
<br />
<p>
<b>Parada</b>
<br/>
<input name="myParada"/><br/>

<anchor>
        <go method="get" href="'.$configuracion['home_url'].'/'.'wap-buscador.php">
          <postfield name="parada" value="$(myParada)"/>
        </go>
        Consultar
</anchor>

</p>


</card>

</wml>
';
