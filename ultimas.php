<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";

$logged_u=is_logged();

if($logged_u['logged'] == false){
	 header ("Location: ".$configuracion['home_url']."/"); 
     exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
	<head>
	<title><?=html_title("Últimas paradas consultadas")?></title>
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
			<h1><span>Historial de paradas consultadas</span></h1>
			<span class="liine"></span>

<?php

//Limito la busqueda 
$resultados = 5; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pag"]; 
if (!$pagina) { 
   	 $inicio = 0; 
   	 $pagina=1; 
} 
else { 
   	$inicio = ($pagina - 1) * $resultados; 
} 

if($logged_u['logged'] == true){

			$userid = read_userid();
			if($userid != null){
				$pag_sql  = "SELECT parada_id FROM historial WHERE userid = '".$userid."'";
				$res_pag = mysql_query($pag_sql);
				$num_total_resultados = mysql_num_rows($res_pag); 
				//calculo el total de páginas 
				$total_paginas = ceil($num_total_resultados / $resultados);
				
				
				$sql = "SELECT parada_id FROM historial WHERE userid = '".$userid."' ORDER BY time DESC LIMIT " . $inicio . "," . $resultados;
				$res = mysql_query($sql);
				$num = mysql_num_rows($res);
				if($num != 0){
					//Muestro los datos
					?>
		<div style="overflow:hidden;">
        <?php
        echo "<p style=\"margin-top:10px;float:right;\">" . $num_total_resultados . ($num_total_resultados > 1?" paradas consultadas":" parada consultada").". Página " . $pagina . " de " . $total_paginas . "<p>";
        ?>
        </div>
		<div class="resultados-buqueda">	
		<?php
					while($data = mysql_fetch_array($res)){
						$id_parada = $data['parada_id'];
						$sql2 = "SELECT nombre, label FROM paradas WHERE id_parada = '".$id_parada."' LIMIT 1";
						$res2 = mysql_query($sql2);
						$parada = mysql_fetch_array($res2);
                        $lineas_parada = obtener_lineas_parada($parada['nombre']);
                        $sal = '';
						?>
<span class="liine2"></span>						
		<a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" class="caja-buscada">
			<div class="parada-ult" id="parada-<?=$parada['nombre']?>">
				<span class="ir-parada"></span>
			<h2>Parada nº <?=$parada['nombre']?></h2>
			<h3><?php echo utf8_encode($parada['label'])?></h3>
            <?php if($lineas_parada != false) { ?>
			<p>Líneas: <?php foreach($lineas_parada as $linea_p){$sal .= $linea_p['nombre'].',&nbsp;';}; $sal = rtrim($sal,',&nbsp;'); echo $sal;?></p>
            <?php } ?>
            </div>
		</a>
			<?php				
					} //Fin de cada parada
					
			?> <span class="liine2"></span></div> <?php		
				}// Fin de si hay resultados para este usario
				else{ //No hay resultados para este usuario, mostrando las paradas mas visitadas
				?>
				<div id="datos_parada">
					<h1> </h1>
				<h2>Paradas más consultadas</h2>
				</div>
		<div class="resultados-buqueda">
			<?php	
				$sql2 = "SELECT nombre, label FROM paradas ORDER BY views DESC LIMIT ".$resultados." ";
				$res2 = mysql_query($sql2);
				while($parada = mysql_fetch_array($res2)){
                        $lineas_parada = obtener_lineas_parada($parada['nombre']);
                        $sal = '';
				?>
				<a href="<?=$configuracion['home_url']?>/<?=$parada['nombre']?>/" class="caja-buscada" rel="parada">
			<div class="parada-num" id="parada-<?=$parada['nombre']?>">
				<span class="ir-parada"></span>
			<h2>Parada nº <?=$parada['nombre']?></h2>
			<h3><?php echo utf8_encode($parada['label'])?></h3>
            <?php if($lineas_parada != false) { ?>
			<p>Líneas: <?php foreach($lineas_parada as $linea_p){$sal .= $linea_p['nombre'].',&nbsp;';}; $sal = rtrim($sal,',&nbsp;'); echo $sal;?></p>
            <?php } ?>
            </div>
		</a>
			<?php	
			}
					
			?> </div> <?php		
			}	
		?>	
			<div id="paginacion">
        <?php
        
        //muestro los distintos índices de las páginas, si es que hay varias páginas 
		if ($total_paginas > 1){
			echo "<p>Página ";
			for ($i=1;$i<=$total_paginas;$i++){ 
				 if ($pagina == $i) 
					 //si muestro el índice de la página actual, no coloco enlace 
					 echo '<span id="seleccionada">'.$pagina . '</span> '; 
				 else 
					 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
					 echo "<span><a href='ultimas.php?pag=" . $i . "'>" . $i . "</a></span> "; 
			}
			echo "</p>"; 
		} 
        ?>
		<p class="ver-resto vuelta"><a href="<?=$configuracion['home_url']?>/user">Volver a la cuenta</a></p>
        </div>
		<?php		
			}
		
}

?>
</div>
<?php include 'footer.php'; ?>
