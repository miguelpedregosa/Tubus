<?
//require("dbconnect.php");

function acentuadas($cadena){
	$cadena = str_replace('Á','á',$cadena);
	$cadena = str_replace('É','é',$cadena);
	$cadena = str_replace('Í','í',$cadena);
	$cadena = str_replace('Ó','ó',$cadena);
	$cadena = str_replace('Ú','ú',$cadena);
	$cadena = str_replace('Ñ','ñ',$cadena);
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

function registrar_parada($parada_a){
	global $link;
	$parada = $parada_a['numero'];
	$label =  utf8_decode($parada_a['nombre']);
	
	$sql = "SELECT * FROM paradas WHERE nombre = '".$parada."' LIMIT 1";
	$res = mysql_query($sql);
	if(!$res)
		return false;
	//$tiempo = time();
	$fecha = date('Y-m-d H:i:s');
	if(mysql_num_rows($res) == 0){
		//No existe la parada, por tanto tengo que crearla
		$sql_i = "INSERT into paradas (nombre, creada, views, last_view, label)  VALUES ('".$parada."','".$fecha."','0','".$fecha."', '".$label."')";
		if(mysql_query($sql_i))
			return true;
		else 
			return false;
	}
	else{
		return true;
		
	}	
	
}

function buscaParadas($calle){

	global $link;

	$paradas = array();
	$sql = "SELECT * FROM `paradas` WHERE `label` LIKE '%".htmlentities(utf8_decode($calle))."%'";
	$res = mysql_query($sql);
	while($row = mysql_fetch_assoc($res)){
		$paradas[] = array(
			'nombre'=>utf8_encode($row['label']),
			'numero'=>$row['nombre']);
	}
	$tiempo = date('Y-m-d G:i:s');
	//La guardo en caché
	/*foreach($paradas as $bus_stop){
		registrar_parada($bus_stop);
	}*/
	$paradas_serialized = serialize($paradas);
	$sql_insert = "INSERT INTO cache_buscador (querystring, results, time) VALUES ('".htmlentities(utf8_decode($calle))."', '".$paradas_serialized."', '".$tiempo."')";
	mysql_query($sql_insert);
	return $paradas_serialized;
}

function getHorarios($h){
	$hora_actual=date('H').':'.date('i');
	$url_franja_horaria = "http://80.25.252.168:8080/websae/Transportes/parada_horariospop2.aspx?hora=".$h;
	$chh = curl_init();
	curl_setopt($chh, CURLOPT_USERAGENT, $useragent);
	curl_setopt($chh, CURLOPT_URL, $url_franja_horaria);
	curl_setopt($chh, CURLOPT_HEADER, true);
	curl_setopt ($chh, CURLOPT_RETURNTRANSFER, true);
	$resultado_horas = curl_exec($chh);
	$error_horas = curl_error($chh);
	
	$horarios=array();
	$iterador = 0; //utilizo esta variable para saber desde que punto tengo de extraer las horas
	$dif=0;//esta es para conocer la longitud del subarray de horas
	$saltar = true;//esta es para saber si he encontrado una hora en el array de horas menor que la hora actual
	$indice = 0;//pra recorrer el array de horas
	$error = 0;//para saber si ha fallado la lectura de datos de la web de la rober
	
	$patron = '/<td class="tabla_campo_valor" width="60" align="center">[[:digit:]]{2}:[[:digit:]]{2}<\/td>/';
	if(preg_match_all($patron,$resultado_horas,$cadena)){
		$horas = array();
		foreach($cadena[0] as $hora){
				$horas[] = addslashes(ucfirst(trim(strip_tags($hora))));
				if((strtotime($hora_actual)<=strtotime(addslashes(trim(strip_tags($hora)))))&&($saltar)){
					$saltar=false;
					$iterador=$indice;
				}
				$indice ++;
		}
		$horarios['horas']=$horas;
	}
	else $error = -1;
	
	$patron = '/<td class="tabla_campo_valor" width="50" align="center">[[:digit:][:alpha:]]+<\/td>/';
	if(preg_match_all($patron,$resultado_horas,$cadena)){
		$lineas_h = array();
		foreach($cadena[0] as $linea_h){
				$linea_h = addslashes(ucfirst(trim(strip_tags($linea_h))));
				switch($linea_h){
					case '2':
						$lineas_h[] = '20D';
						break;
					
					case '15':
						$lineas_h[] = 'C';
						break;
					case '16':
						$lineas_h[] = 'U';
						break;
					case '14':
						$lineas_h[] = 'F';
						break;
					default:
						$lineas_h[] = $linea_h;
						break;
				}
		}
		$horarios['lineas']=$lineas_h;
	}
	else $error = -1;
	
	$patron = '/<td class="tabla_campo_valor" width="270" align="center">[[:alnum:][:space:]\.\-ñÑºªáéíóúÁÉÍÓÚ\(\)]+<\/td>/';
	if(preg_match_all($patron,$resultado_horas,$cadena)){
		$trayectos = array();
		foreach($cadena[0] as $trayecto){
				$trayectos[] = addslashes(acentuadas(ucfirst(trim(strip_tags($trayecto)))));
		}
		$horarios['trayecto']=$trayectos;
	}
	else $error = -1; //devuelvo el valor -1 si ha fallado la lectura de datos desde la web de la rober
	
	curl_close($chh);
	
	if($error == -1) return -1;

	//filtro los horarios
	$ext_horas=array();
	$total=count($horas);
	$dif=(int)$total-(int)$iterador;
	if($saltar==true) return array(); //la franja horaria actual no tiene ninguna hora con autobusese
	else{
		$ext_horas['horas'] = array_slice($horarios['horas'],$iterador,$dif);
		$ext_horas['lineas'] = array_slice($horarios['lineas'],$iterador,$dif);
		$ext_horas['trayecto'] = array_slice($horarios['trayecto'],$iterador,$dif);
		return $ext_horas;
	}
}

function infoParada($idparada){

if(function_exists('curl_init')) // Comprobamos si hay soporte para cURL
{
	//$url_info = "http://213.98.155.162/BilbobusMovil/tiemposwap_es.php?id=".$idparada;
	$url_info = "http://213.98.155.162/Bilbobus/tiempos.php?id=".$idparada;
	//$url_info = "http://api.batura.mobi/bilbus/esperawap?stop=".$idparada;
	$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_URL, $url_info);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$resultado = utf8_encode(curl_exec($ch));
	$error = curl_error($ch);
	
	$info_parada = array();
	$proximos_autobuses = array();
	$error_datos = false;
	
	/* Cojo el nombre de la parada*/
	$patron = '/<strong>PARADA [\w\sçÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ\-\.\,\:\;\º\ª\!\"\'\\\&\/\(\)\?\¡\¿]+<br>/';
	if(preg_match($patron,$resultado,$cadena)){
		$nombre = trim(ucwords(strtolower(strip_tags($cadena[0]))));
		$info_parada['nombre'] = $nombre;
	}
	else{
		return -1; //no he encontrado ni siquiera el nombre.
	}
	
	$lineas = array();
	$recorrido = array();
	$restantes = array();
	
	/* obtengo el nº de la linea del proximo autobus en llegar */	
	$patron = "/nea: [\w]+/";
	if(preg_match_all($patron,$resultado,$cadena)){
		$line=($cadena[0]);
		$lineas = array();
		foreach($line as $l){
			$linea = trim(strip_tags(preg_replace('/nea/','',str_replace(':','',$l))));
			$lineas[]=ltrim($linea,'0');
		}
		$proximos_autobuses['linea']=$lineas;
	}
	else{
		return -1;
	}
	
	$patron = '/nea: [\w\sçÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ\-\.\,\:\;\º\ª\!\"\'\\\&\/\(\)\?\¡\¿]+<\/a>/';
	if(preg_match_all($patron,$resultado,$cadena)){
		$recor=($cadena[0]);
		$recorrido = array();
		foreach($recor as $r){
			$r = trim(preg_replace('/nea: [\w\s]+/', '', $r),'-');
			$array_recorrido = explode('-',$r);
			$recorrido[]=trim(array_pop($array_recorrido));
		}
		$proximos_autobuses['destino'] = $recorrido;
	}
	else{
		return -1;
	}
	
	$patron = '/<br>>>[\w\sçÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ\-\.\,\:\;]+<br>/';
	if(preg_match_all($patron,$resultado,$cadena)){
		$restan=($cadena[0]);
		$restantes = array();
		foreach($restan as $r){
			if(substr_count($r,'Autobús llegando')>=1){
				$restantes[]=(trim(strip_tags(0)));
			}
			else{
				$raux=(trim(strip_tags(str_replace('Llegará en:','',$r))));
				$raux=(trim(strip_tags(str_replace('>>Tiempo restante:','',$raux))));
				$restantes[]=(trim(strip_tags(str_replace('minutos','',$raux))));
			}
		}
		$proximos_autobuses['minutos'] = $restantes;
	}
	else{
		return -1;
	}
	
	$proximos_autobuses = bubbleSort($proximos_autobuses);
	
	$info_parada['proximos'] = $proximos_autobuses;
	$info_parada['transbordos'] = array();
	$info_parada['horarios'] = array();	
		
	return $info_parada;
}
else
	return -1; //No hay soporte para cURL
}
?>
