<?
function asciihtml($cadena){
	$cadena = str_replace('&#225;','á',$cadena);	
	$cadena = str_replace('&#233;','é',$cadena);	
	$cadena = str_replace('&#237;','í',$cadena);	
	$cadena = str_replace('&#243;','ó',$cadena);	
	$cadena = str_replace('&#250;','ú',$cadena);	
	$cadena = str_replace('&#193;','Á',$cadena);	
	$cadena = str_replace('&#201;','É',$cadena);	
	$cadena = str_replace('&#205;','Í',$cadena);	
	$cadena = str_replace('&#211;','Ó',$cadena);	
	$cadena = str_replace('&#218;','Ú',$cadena);	
	$cadena = str_replace('&#209;','Ñ',$cadena);	
	$cadena = str_replace('&#241;','ñ',$cadena);	
	return $cadena;
}


function bubbleSort($arr) {
	$N = count($arr['minutos'])-1;
	for($i=1; $i <= $N; $i++)
		for($j=$N;$j>=$i;$j--)
			if($arr['minutos'][$j-1]>$arr['minutos'][$j]){
				$aux = $arr['minutos'][$j-1];
				$arr['minutos'][$j-1] = $arr['minutos'][$j];
				$arr['minutos'][$j] = $aux;
                  
				$aux = $arr['destino'][$j-1];
				$arr['destino'][$j-1] = $arr['destino'][$j];
				$arr['destino'][$j] = $aux;
                  
				$aux = $arr['linea'][$j-1];
				$arr['linea'][$j-1] = $arr['linea'][$j];
				$arr['linea'][$j] = $aux;
			}
               
	return $arr;
}



function infoParada($idparada){
global $link;

if(function_exists('curl_init')) // Comprobamos si hay soporte para cURL
{
	$url_info = "http://88.2.60.97:81/tiemposauvasa/parada.aspx?parada=".$idparada;	
	$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_URL, $url_info);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$resultado = (curl_exec($ch));
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	$error = curl_error($ch);
	curl_close($ch);
	
	if ($httpCode >= 400){
		return -1; //lo siento, pero por aki no hay mucho que rascar. El portal puede estar caido.
	}
	
	$info_parada = array();
	$proximos_autobuses = array();
	$error_datos = false;
	
	/* Cojo el nombre de la parada*/
	$info_parada['nombre'] = $id_parada;
	
	$lineas = array();
	$recorrido = array();
	$restantes = array();

	if(substr_count($resultado, 'No hay info') >= 1){
		return -1;
	}
	else{
		//lineas
		$patron = '/<td style="font-family:Arial;font-size:X-Small;width:50px;">[\w]+<\/td>/';
		if(preg_match_all($patron,$resultado,$cadena)){
			$line=($cadena[0]);
			$lineas = array();
			foreach($line as $l){
				$lineas[]=(trim(strip_tags($l)));
			}
			$proximos_autobuses['linea']=$lineas;
		}
		else{
			//mail('info@huruk.net', 'Tubus '.$_COOKIE['userciudad'].': error parada '.$idparada, 'Proximos linea parada '.$idparada.'. '.date('d-m-Y G:i:s')."\nhttp://80.25.252.168:8080/websae/Transportes/parada.aspx?idparada=".$idparada. "\n". $proximos['html']);
			$proximos_autobuses['linea']=array();
		}
		
		//recorridos
		//$patron = '/<td class="tabla_campo_valor" align=center>[[:alpha:][:space:][:digit:]-\.\,\_\:\;\ç\ÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ(-->)\+\*\º\ª\!\"\·\$\%\&\/\(\)\=\'\?\¡\¿\\\|\@\#\€\¬\[\]\{\}]+<\/td>/';
		$patron = '/<td style="font-family:Arial;font-size:X-Small;width:95px;">[\w\s\.ñÑ\&\#\;\-]+<\/td>/';
		if(preg_match_all($patron,$resultado,$cadena)){
			$recor=($cadena[0]);
			$recorrido = array();
			foreach($recor as $r){
				$recorrido[]=asciihtml(trim(strip_tags(($r))));
			}
			$proximos_autobuses['destino'] = $recorrido;
		}
		else{
			//mail('info@huruk.net', 'Tubus '.$_COOKIE['userciudad'].': error parada '.$idparada, 'Proximos destinos parada '.$idparada.' '.date('d-m-Y G:i:s')."\nhttp://80.25.252.168:8080/websae/Transportes/parada.aspx?idparada=".$idparada. "\n". $proximos['html']);
			$proximos_autobuses['destino'] = array();
		}
		
		//<td style="font-family:Arial;font-size:X-Small;width:40px;">12</td>
		$patron = '/<td style="font-family:Arial;font-size:X-Small;width:40px;">[[:digit:]\+]+<\/td>/';
		if(preg_match_all($patron,$resultado,$cadena)){
			$restan=($cadena[0]);
			$restantes = array();
			foreach($restan as $r){
				$restantes[]=(trim(strip_tags($r)));
			}
			$proximos_autobuses['minutos'] = $restantes;
		}
		else{
			//mail('info@huruk.net', 'Tubus '.$_COOKIE['userciudad'].': error parada '.$idparada, 'Proximos minutos parada '.$idparada.' '.date('d-m-Y G:i:s')."\nhttp://80.25.252.168:8080/websae/Transportes/parada.aspx?idparada=".$idparada. "\n". $proximos['html']);
			$proximos_autobuses['minutos']=array();
		}
		
		if(empty($proximos_autobuses['linea']) || empty($proximos_autobuses['destino']) || empty($proximos_autobuses['minutos'])){
			return -1;
		}
		
		$info_parada['proximos'] = $proximos_autobuses;
		$info_parada['proximos'] = bubbleSort($info_parada['proximos']);
		$posibles_transbordos = array();
		$info_parada['transbordos'] = $posibles_transbordos;		
		$horarios=array();
		$info_parada['horarios'] = $horarios;
		
		return $info_parada;
	}
}
else return -1;
}
?>
