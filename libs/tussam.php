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
	$sql = "SELECT * FROM `paradas` WHERE `label` LIKE '%".(utf8_decode($calle))."%'";
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
	require_once 'nusoap/nusoap.php';	
	
	try{
		$info_parada = array();
		$proximos_autobuses = array();
		$error_datos = false;
		
		$client = new nusoap_client('http://www.infobustussam.com:9001/services/dinamica.asmx?WSDL',true);
		$data = array(
			"status"=>0,
			"parada"=>$idparada,
			"linea"=>"*"
			);
			
		$client->setHeaders($headers);
		$client->setCurlOption(CURLOPT_POSTFIELDS,$data);
		
		$info=($client->call("GetPasoParada", $data, $headers));
		
		$parada = array(
			'nombre'=>$info['GetPasoParadaResult']['PasoParada'][0]['parada'],		//label
			'numero'=>$idparada				//numero
		);
		
		$info_parada['nombre'] = $info['GetPasoParadaResult']['PasoParada'][0]['parada'];
		
		//registrar_parada($parada);
		
		$lineas = array();
		$recorrido = array();
		$restantes = array();
		
		if($info['GetPasoParadaResult']['PasoParada'][0]){
			foreach($info['GetPasoParadaResult']['PasoParada'] as $lineabus){
				
				switch($lineabus['linea'])
				{
					case '01':
					$linea_nomre = '1';
					break;
					
					case '02':
					$linea_nomre = '2';
					break;
					
					case '03':
					$linea_nomre = '3';
					break;		

					case '04':
					$linea_nomre = '4';
					break;
					
					case '05':
					$linea_nomre = '5';
					break;
					
					case '06':
					$linea_nomre = '6';
					break;
					
					case '07':
					$linea_nomre = '7';
					break;
					
					case '08':
					$linea_nomre = '8';
					break;
					
					case '09':
					$linea_nomre = '9';
					break;		
					
					default:
					$linea_nomre = $lineabus['linea'];
					break;	
				}
				
				$lineas[]=$linea_nomre;
				$recorrido[]=$lineabus['ruta'];
				if(intval($lineabus['e1']['minutos'])<1){
					$restantes[]=0;
				}
				else{
					$restantes[]=intval($lineabus['e1']['minutos']);
				}
			}
		}
		else if($info['GetPasoParadaResult']['PasoParada']['e1']){
			switch($info['GetPasoParadaResult']['PasoParada']['linea'])
			{
				case '01':
				$linea_nomre = '1';
				break;
				
				case '02':
				$linea_nomre = '2';
				break;
				
				case '03':
				$linea_nomre = '3';
				break;		

				case '04':
				$linea_nomre = '4';
				break;
				
				case '05':
				$linea_nomre = '5';
				break;
				
				case '06':
				$linea_nomre = '6';
				break;
				
				case '07':
				$linea_nomre = '7';
				break;
				
				case '08':
				$linea_nomre = '8';
				break;
			
				case '09':
				$linea_nomre = '9';
				break;		
				
				default:
				$linea_nomre = $info['GetPasoParadaResult']['PasoParada']['linea'];
				break;	
			}
			$lineas[]=$linea_nomre;
			$recorrido[]=$info['GetPasoParadaResult']['PasoParada']['ruta'];
			if(intval($info['GetPasoParadaResult']['PasoParada']['e1']['minutos'])<1){
					$restantes[]=0;
				}
				else{
					$restantes[]=intval($info['GetPasoParadaResult']['PasoParada']['e1']['minutos']);
				}
		}
		else return -1;

		$proximos_autobuses['linea'] = $lineas;
		$proximos_autobuses['destino'] = $recorrido;
		$proximos_autobuses['minutos'] = $restantes;
		
		//ordenar según proximidad a parada
		$proximos_autobuses = bubbleSort($proximos_autobuses);
		
		$info_parada['proximos'] = $proximos_autobuses;
		$info_parada['transbordos'] = array();
		$info_parada['horarios'] = array();
		
		return $info_parada;
	}
	catch (Exception $ex){
		$mensaje= ($ex->getMessage());
		$codigo= ($ex->getCode());
		$fichero= ($ex->getFile());
		$linea= ($ex->getLine());
		$log_mensaje= date("H:i d-m-Y")." Error:: $codigo en $fichero en la linea $linea. Error $mensaje"; 
		return $log_mensaje;
	}
}
?>
