<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
require_once '../system.php';
require_once '../libs/cache_kit.php';
require_once '../libs/url.php';
//require_once '../libs/rober.php';
require_once '../libs/'.$configuracion['conector'];
require_once '../libs/text.php';
require_once '../libs/functions.php';

$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];
$radio = (int)$_REQUEST['radio'];
if(!isset($radio) or $radio == '' or $radio == 0 or $radio > 5000)
    $radio = 500;

$paradas = obtener_paradas_proximas($lat, $long, $radio);
$texto = '';
$res_paradas = array();
$output = array();
if($paradas != false && count($paradas) > 0){ //Hay resultados que mostrar
     if (count($paradas) > 2)
     $limite = 2;
		else $limite = count($paradas); 
     
     for($i=0; $i< $limite; $i++){
		 $parada = $paradas[$i];
           $lineas_parada = obtener_lineas_parada($parada['nombre']);
			$lineas_parada = array_elimina_duplicados($lineas_parada, 'nombre');
           $coorde = get_coordenadas((int)$parada['nombre']);
        $sal = '';
        $sal_g = '';
		
		$distancia_e = round($parada['distancia'],1);
		if($distancia_e >= 1000){
			$distancia_e = $distancia_e / 1000;
			$distancia_e = round($distancia_e, 1);
		
			$distancia_t = 'a '.str_replace('.',',',$distancia_e).' kms. aprox';
		}
		else{
			$distancia_t = 'a '.str_replace('.',',',$distancia_e).' m. aprox';
		}
			
		
			
		$texto .= '<a href="'.$configuracion['home_url'].'/'.$parada['nombre'].'/" class="caja-buscada">
		<div class="parada-num" style="padding:0;" id="parada-'.$parada['nombre'].'">
			<span class="ir-parada"></span>
			<h2 class="geo-h2">Parada nº '.$parada['nombre'].' <span class="metros">('.$distancia_t.')</span></h2>
			<h3>'.$parada['label'].'</h3>';
            if($lineas_parada != false) {
            $texto .= '<p>Líneas: ';
             foreach($lineas_parada as $linea_p){
                 $sal .= $linea_p['nombre'].',&nbsp;';
                 $sal_g .= "<p class=\"globo-contenido-linea\"><span class=\"linea\" style=\"background-color:#".$linea_p['color'].";\">".$linea_p['nombre']."</span><strong>Dirección:</strong> ".$linea_p['llegada']."</p>";
             };
              
                 $sal = rtrim($sal,',&nbsp;'); 
                 $texto .= $sal;
             $texto .= '</p>';
			 }
			 $texto .= '
             </div>
			 <span class="liine3"></span>
		</a>';
        
        $globohtml = "<h3 class=\"globo-titulo\"><a href=\"".$configuracion['home_url']."/".$parada['nombre']."/\">Parada nº ".$parada['nombre']." </a></h3><p class=\"globo-parrafo\">".$parada['label']."</p><div id=\"globo-lineas\"><p class=\"globo-contenido-linea\"><span class=\"linea globo-persona-image\"></span>Se encuentra aprox. a ".str_replace('.',',',round($parada['distancia'],1))." m de esta parada.</p><p class=\"globo-contenido-linea\"><span class=\"linea globo-bus-image\"></span><strong class=\"smallcaps\">Líneas de esta parada:</strong></p>".$sal_g."</div>";

        
        
		$parada['lineas_html'] = $sal;
        $parada['latitud'] = $coorde['latitud'];
        $parada['longitud'] = $coorde['longitud'];
        $parada['globohtml'] = $globohtml;
		$parada['label'] = $parada['nombre'];
		$res_paradas[] = $parada;
		}
        
		$output['html'] = "<span class=\"liine3\"></span>".$texto;
		$fecha = date('j/n/Y H:i:s');
		$output['fecha'] = 'Última búsqueda: '.$fecha;
		$output['paradas'] = $res_paradas;
		echo json_encode($output);
}
else {
    $output['html'] = '<p class="info_general" style="margin-bottom:10px;margin-left:0;">No se ha encontrado ninguna parada a menos de '.$radio.' m de su posición. Asegúrese que ha seleccionado la ciudad correcta donde se encuentra.</p>';
    $fecha = date('j/n/Y H:i:s');
    $output['fecha'] = 'Última búsqueda: '.$fecha;
    echo json_encode($output);
}
?>
