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
		$url_info_book = "http://www.tuzsa.es/tuzsa_frm_esquemaparadatime.php?poste=".$idparada;
		$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_URL, $url_info_book);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$resultado = utf8_encode(curl_exec($ch));
		$error = curl_error($ch);
		
		$info_parada = array();
		$proximos_autobuses = array();
		$error_datos = false;
		
		/* Cojo el nombre de la parada*/
		
		$patron = '/<table width="300px" cellpadding="2" cellspacing="0" border="0" style="border:1pt solid #cccccc">.+<\/table>/';
		if(preg_match($patron,$resultado,$cadena)){
			$proximos['html']=($cadena[0]);
			$proximos['html'] = trim(str_replace('Próximos autobuses en llegar:','',$proximos['html']));
			$proximos['html'] = trim(str_replace('Panel de Información:','',$proximos['html']));		
		}
		
		$info_proximos = array();
		$patron = '/<td class="digital">[[:alpha:][:space:][:digit:]-\.\,\_\:\;\ç\ÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ\+\*\º\ª\!\"\·\$\%\&\/\(\)\=\'\?\¡\¿\\\|\@\#\€\¬\[\]\{\}]+<\/td>/';
		if(preg_match_all($patron,$proximos['html'],$cadena)){
			$recor=($cadena[0]);
			$datos = array();
			foreach($recor as $r){
				$datos[]=(trim(ucwords(strtolower(strip_tags($r)))));
			}
			$info_proximos = $datos;
		}
		
		if(count($info_proximos)%3!=0)
			return -6; //no es divisible por 3, por lo tanto estimo que pueden faltar datos...
		
		for($i=0; $i<count($info_proximos); $i=$i+3){
			$lineas[]=(trim(strip_tags($info_proximos[$i])));
		}
		
		for($i=1; $i<count($info_proximos); $i=$i+3){
			$recorrido[]=htmlentities(utf8_decode(trim(ucwords(strtolower(strip_tags($info_proximos[$i]))))));
		}
		
		for($i=2; $i<count($info_proximos); $i=$i+3){
			if(substr_count($info_proximos[$i],'En La Parada')>=1){
				$restantes[]=(trim(strip_tags(0)));
			}
			
			else if(substr_count($info_proximos[$i],'Sin estimacion')>=1||substr_count($info_proximos[$i],'Sin Estimacion')>=1){
				$restantes[]=(trim(strip_tags(20)));
			}
			
			else
				$restantes[]=(trim(strip_tags(str_replace('Minutos.','',$info_proximos[$i]))));
		}
		
		
		$proximos_autobuses['linea']=$lineas;
		$proximos_autobuses['destino'] = $recorrido;
		$proximos_autobuses['minutos'] = $restantes;
		
		//ordenar según proximidad a parada
		$proximos_autobuses = bubbleSort($proximos_autobuses);
		
		$info_parada['proximos'] = $proximos_autobuses;
		
		/* aqui empieza el tema de los transbordos */
	
		$posibles_transbordos = array();
		
		$transbordos = array();
		
		$patron = '/<td align[[:space:]]*="left" class="tablasubtitulo">&nbsp;Posibles Transbordos en esta Parada:<\/td>[[:alpha:][:space:][:digit:]\<\>\-\.\,\_\:\;\ç\ÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ\+\*\º\ª\!\"\·\$\%\&\/\(\)\=\'\?\¡\¿\\\|\@\#\€\¬\[\]\{\}]+<td class="tablasubtitulo">Horarios:<\/td>/';
		if(preg_match($patron,$resultado,$cadena)){
			$transbordos['html'] = ($cadena[0]);
			$transbordos['html'] = trim(str_replace('Posibles Transbordos en esta Parada:','',$transbordos['html']));
			$transbordos['html'] = trim(str_replace('Horarios:','',$transbordos['html']));
			
			$patron = '/<a href="linea.aspx\?idlinea=[[:digit:]]+" class="lista">[[:digit:][:alpha:]]+<\/a>/';
			if(preg_match_all($patron,$transbordos['html'],$cadena)){
				$trnsb=($cadena[0]);
				$lineas=array();
				foreach($trnsb as $t){
					$lineas[]=(trim(strip_tags($t)));
				}
				$posibles_transbordos['linea']=$lineas;
			}
			
			$patron = '/<a href="linea.aspx\?idlinea=[[:digit:]]+" class="texto">[[:alpha:][:space:][:digit:]-\.\,\_\:\;\ç\ÇáéúíóüñÑaàèùìòÁÉÚÍÓÀÈÙÌÒÜ\+\*\º\ª\!\"\·\$\%\&\/\(\)\=\'\?\¡\¿\\\|\@\#\€\¬\[\]\{\}]+<\/a>/';
			if(preg_match_all($patron,$transbordos['html'],$cadena)){
				$trnsb=($cadena[0]);
				$recorrido=array();
				foreach($trnsb as $t){
					$recorrido[]=(trim(ucwords(strtolower(strip_tags($t)))));
				}
				$posibles_transbordos['destinos']=$recorrido;
			}
		}
		
		$info_parada['transbordos'] = $posibles_transbordos;
		
		curl_close($ch);
		
		$horarios=array();
		$h=date('H');
		
		$horarios = getHorarios($h);
		if($horarios == -1) // ha habido un error leyendo los horarios
			$error_datos = -4;
			
		if (empty($horarios)){
			$nexthour  = date('H', mktime(date('H')+1, 0, 0, 0, 0, 0));
			$horarios = getHorarios($nexthour);
			if (empty($horarios)){
				$horarios='';
				$error_datos = -4;
			}
		}
		
		if($error_datos == -4) return $info_parada; //no hay horarios
		
		$info_parada['horarios'] = $horarios;
		
		return $info_parada;

	}
	else
		return -5; //No hay soporte para cURL
}
?>
