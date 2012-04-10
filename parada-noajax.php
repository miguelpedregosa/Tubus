<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
$cache_active = $configuracion['cache_active'];  
$cache_folder = $configuracion['cache_dir']; 
$data_cache_id = $configuracion['cache_prefix'].'_'.'info_parada_'.$parada_id;
$random = mt_rand(0,150);
$error_datos = false;
$refresh_time = 65;
$logged_u =  is_logged();
$canonical_url = 'http://'.$configuracion['cache_prefix'].'.es/'.$parada_id.'/';

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title($nombre_parada['nombre']." ".$nombre_parada['label'])?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Parada: <?=$nombre_parada['label']?>  Tubus facilita el acceso a toda la información relativa al sistema de transporte urbano granadino. Gracias a TuBus es muy sencillo conocer el tiempo estimado de llegada de cada autobús en cada parada, desde cualquier lugar y en cualquier momento." /> 
<meta name="keywords" content="bus urbano, rober, granada, tubus, autobus, urbano, granadino, tiempo real, paradas, linea 4, línea 3, estación de autobuses, metro ligero, ave, estación de trenes, fuente las batallas, marquesinas, paneles" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
<meta name="generator" content="Huruk Soluciones" />

<!-- <meta http-equiv="refresh" content="<?=$refresh_time?>" /> -->

<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<link rel="stylesheet" type="text/css" media="handheld" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<!--[if IEMobile 7]> 
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/wp7_style_<?=$configuracion['version']?>.css" />
<![endif]-->
<link rel="search" type="application/opensearchdescription+xml" title="Buscar en Tubus" href="<?=$configuracion['home_url']?>/opensearch.xml"/>
<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>
<link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>

<link rel="canonical" href="<?=$canonical_url?>" />


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
	<div id="sub-cont" class="zona-paradas">
		<h1><span><?=$nombre_parada['label']?></span></h1>
		<span class="liine"></span>
		<div id="datos_parada">
			<h2>Parada Nº <?=$nombre_parada['nombre']?></h2>
			<h3>Fecha: <?=date('j/n/Y H:i:s')?></h3>
			<!-- <h3><strong>Actualizado:</strong> hace <?=$tiempo_modificacion?> s</h3> -->
			<a title="Actualizar datos" href="<?php echo $configuracion['home_url'].'/'.$parada_id.'/r/'.$random?>/"><img src="<?=$configuracion['home_url']?>/style/images/boton.gif" id="boton-refrescar" alt="Transportes Rober" /></a>
			<h3 id="actualizador"><a id="enlace-refrescar" title="Actualizar datos" href="<?php echo $configuracion['home_url'].'/'.$parada_id.'/r/'.$random?>/">Actualizar datos</a></h3>
		
		<?php
             if($coordenadas != false)
             { 
					 $gps_button = '<a title="Indicaciones paso a paso para llegar a esta parada" href="'.$configuracion['home_url'].'/nroute.php?id_parada='.$nombre_parada['nombre'].'"><img src="'.$configuracion['home_url'].'/style/images/ruta-mini.png" class="latwitt" alt="Indicaciones paso a paso para llegar a esta parada"></a>'; 
			 }
			 else
			 {
				 	$gps_button = '<a href="#" title="No hay indicaciones paso a paso hacia esta parada :("><img src="'.$configuracion['home_url'].'/style/images/ruta2-mini.png" class="latwitt" alt="No hay indicaciones paso a paso hacia esta parada :("></a>';
			 }
            
            ?>
		
				
		
        <?php
            if($logged_u['logged'] == false){
            ?>

               <!-- Nueva botonera que es que lo flipas fijo-->
			<div id="socials">
			<a id="favorito-no" title="Necesita registrarse o iniciar sesión para guardar estar parada" href="<?=$configuracion['home_url']?>/login.php?r=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/fav-inactivo-mini.png" alt="Necesita registrarse o iniciar sesión para guardar estar parada"></a>
			<?=$gps_button?>
			<a title="Compartir parada" href="<?=$configuracion['home_url']?>/share.php?id_parada=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/share-mini.png" alt="Compartir parada" class="lafour"></a>
			</div>
			<!-- Fin de la Nueva botonera así que puedes dejar de fliparlo -->
            
            
            <?php
            }
            else{
            //Ahora compruebo si la parada ya está guardada en favoritos
            if(check_favorite($logged_u['id_usuario'], $logged_u['tipo'], $nombre_parada['id_parada']))
            {
            ?>
   
            <div id="socials">
			<a id="favorito" title="Eliminar parada de 'Mis Favoritas'" href="<?=$configuracion['home_url']?>/favorite.php?accion=remove&parada=<?=$nombre_parada['id_parada']?>&r=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/fav-mini.png" alt="Eliminar parada de 'Mis Favoritas'" /></a>
			<?=$gps_button?>
			<a title="Compartir parada" href="<?=$configuracion['home_url']?>/share.php?id_parada=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/share-mini.png" alt="Compartir parada" class="lafour"></a>
			</div>
            
            
            <?php
            }
            else{
            ?>

             <div id="socials">
			<a id="favorito" title="Guardar en m 'Mis Favoritas'" href="<?=$configuracion['home_url']?>/favorite.php?accion=add&parada=<?=$nombre_parada['id_parada']?>&r=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/fav-inactivo-mini.png" alt="Guardar en m 'Mis Favoritas'"></a>
			<?=$gps_button?>
			<a title="Compartir parada" href="<?=$configuracion['home_url']?>/share.php?id_parada=<?=$nombre_parada['nombre']?>"><img src="<?=$configuracion['home_url']?>/style/images/share-mini.png" alt="Compartir parada" class="lafour"></a>
			</div>
            
            <?php
            }
        }
            
            ?>
        
        
        </div>
		<div id="content">
		<div id="llegada">
        <?php if(!$error_datos) { ?>
            <h4>Próximos autobuses en llegar</h4>
			<span class="liine2"></span>
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
                    <!--  <img src="images/llegada.gif" alt="Autobus llegando" />  -->
                    </tr>
                </table>
                </div>	
			</div>
			<span class="liine2"></span>
		<?php }?>
        <?php }
        else {
          echo mostrar_error_parada(false);
         } ?>
        </div>
		<div id="trasbordos">
		<h4 class="lineas-par">Líneas en esta parada</h4>
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
				
				?>
		<a href="<?=$configuracion['home_url']?>/linea/<?=$linea['nombre']?><?=$append_to?>" title="linea <?=$linea['nombre']?>"><div class="apartado-bus-trasbordos">
			<table style="width:100%;" id="linea_<?= $linea['nombre']?>">
			<tr>
			<td class="numero"><?=$linea['nombre']?></td>
			<td class="destino2"><strong>Trayecto:</strong> <?=$linea['salida'].' - '.$linea['llegada']?></td>
			</tr>
			</table>
			</div></a>
			<span class="liine2"></span>
		<?php } 
        else {
        ?>
        <p class="info_general">No hay información disponible actualmente.</p>
        <?php } ?>
		</div>
	</div>
	</div>
	<?php
	 if($coordenadas != false) {
	?>
	<div id="ubicacion">
	<h1>Ubicación aproximada de la parada</h1>  
	<?php 
	$imagen_url =  get_static_map($coordenadas['latitud'], $coordenadas['longitud']);
			?>
			<div id="map" style="width: 200px; height: 350px" >
			<img src ="<?=$imagen_url?>" height="350" width="200" alt="Ubicación aproximada de la parada" />
			</div>
			<p id="res_reporte">
		<a href="<?=$configuracion['home_url']?>/report_error.php?parada=<?=$parada_id?>" id="reportar">Reportar fallo</a>
	</p>
	</div>
	<?php } ?>
<?php include 'caja-busqueda.php' ?>		
<?php

if($paradas_cercanas != false){
?>
<div id="datos_parada">
<h1 class="ultimas-paradas">Paradas cercanas (beta)</h1>
</div>
<div class="resultados-buqueda">	
<?php
foreach($paradas_cercanas as $datos_p){
    $lineas_parada = obtener_lineas_parada($datos_p['nombre']);
    $sal = '';
     ?>	
			<a href="<?=$configuracion['home_url']?>/<?=$datos_p['nombre']?>/" class="caja-buscada">
			<div class="parada-num" id="parada-<?=$datos_p['nombre']?>">
				<span class="ir-parada"></span>
			<h2>Parada nº <?=$datos_p['nombre']?> <span class="metros">(<?php echo str_replace('.',',',round($datos_p['distancia'],1))?> metros aprox.)</span></h2>
			<h3><?=$datos_p['label']?></h3>
			<?php if($lineas_parada != false) { ?>
            <p>Líneas: <?php foreach($lineas_parada as $linea_p){$sal .= $linea_p['nombre'].',&nbsp;';}; $sal = rtrim($sal,',&nbsp;'); echo $sal;?></p>
			<?php } ?>
            </div>
		</a>

<?php } ?>	
<p class="a-cerca"><a href="<?=$configuracion['home_url']?>/geo.php?lat=<?=$coordenadas['latitud']?>&long=<?=$coordenadas['longitud']?>&radio=500">Ver más paradas cercanas</a></p>
</div>	
<?php	
}
?>
</div>

<?php include 'footer.php'; ?>
