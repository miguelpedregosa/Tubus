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
	$url_info = "http://www.amialbacete.com:89/estimacionbus/default.aspx";	
	$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_URL, $url_info);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,30);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$resultado = (curl_exec($ch));
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	$httpConnect = curl_getinfo($ch, CURLOPT_CONNECTTIMEOUT);
	$error = curl_error($ch);
	curl_close($ch);
	
	if ($httpCode >= 400){
		return -1; //lo siento, pero por aki no hay mucho que rascar. El portal puede estar caido.
	}
	
	$info_parada = array();
	$proximos_autobuses = array();
	$error_datos = false;	
	
	//datos que hay que enviar por POST
	$__EVENTTARGET = '';
	$__EVENTARGUMENT = '';
	$__LASTFOCUS = '';
	$DropDownList1 = '';
	$DropDownList2 = '';
	$btnConsulta = '';
	
	$patron = '/<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.)+" \/>/';
	if(preg_match($patron, $resultado, $cadena))
	{
		$texto = $cadena[0];
		$patron = '/value="(.)*"/';
		if(preg_match($patron, $texto, $value))
		{
			$__VIEWSTATE = str_replace('value="', '', $value[0]);
			$__VIEWSTATE = str_replace('"', '', $__VIEWSTATE);
		}
	}
	
	$patron = '/<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.)+" \/>/';
	if(preg_match($patron, $resultado, $cadena))
	{
		$texto = $cadena[0];
		$patron = '/value="(.)*"/';
		if(preg_match($patron, $texto, $value))
		{
			$__EVENTVALIDATION = str_replace('value="', '', $value[0]);
			$__EVENTVALIDATION = str_replace('"', '', $__EVENTVALIDATION);
		}
	}
	
	//Busco en la base de datos los trayectos asociados a la parada
	$sql = "Select p.id_parada, p.nombre, tap.id_trayecto, taD.DropDownList1 from paradas p 
	join trayectos_a_paradas tap on p.id_parada = tap.id_parada
	join trayectos_a_DropDownList1 taD on tap.id_trayecto = taD.trayecto_id
	where nombre = '".$idparada."'";
	$res = mysql_query($sql,$link);
	if(mysql_num_rows($res)==0) return -1; //no hay paradas.
	$lineas = array();
	$recorrido = array();
	$restantes = array();
	while($row = mysql_fetch_assoc($res)){

		//Completo los datos para la petición post
		$DropDownList1 = $row['DropDownList1'];
		$DropDownList2 = $idparada;
		$__EVENTARGUMENT = '';
		$__EVENTTARGET = '';	
		$__EVENTVALIDATION;
		$__LASTFOCUS = '';
		$__VIEWSTATE;
		$btnConsulta='Actualizar Tiempo Espera';
		
		$parametros_post = 'DropDownList1='.urlencode($DropDownList1).'&DropDownList2='.urlencode($DropDownList2).'&__EVENTARGUMENT='.urlencode($__EVENTARGUMENT).'&__EVENTTARGET='.urlencode($__EVENTTARGET).'&__EVENTVALIDATION='.urlencode($__EVENTVALIDATION).'&__LASTFOCUS='.urlencode($__LASTFOCUS).'&__VIEWSTATE='.urlencode($__VIEWSTATE).'&btnConsulta='.urlencode($btnConsulta);  

		$sesion = curl_init($url_info);  
		curl_setopt($sesion,CURLOPT_CONNECTTIMEOUT,30);
		// definir tipo de petición a realizar: POST  
		curl_setopt ($sesion, CURLOPT_POST, true);   
		// Le pasamos los parámetros definidos anteriormente  
		curl_setopt ($sesion, CURLOPT_POSTFIELDS, $parametros_post);   
		// sólo queremos que nos devuelva la respuesta  
		curl_setopt($sesion, CURLOPT_HEADER, false);   
		curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);  
		// ejecutamos la petición  
		$respuesta = curl_exec($sesion);  
		// cabeceras de error
		$httpCode = curl_getinfo($sesion, CURLINFO_HTTP_CODE); 
		// cerramos conexión  
		curl_close($sesion);
		
		if ($httpCode >= 400){
			return -1; //lo siento, pero por aki no hay mucho que rascar. El portal puede estar caido.
		}
		
		if(substr_count($respuesta, 'Error en tiempo') == 0  AND substr_count($respuesta, 'Error de servidor') == 0){
			//busco la linea en bd
			$query_line = mysql_query("Select nombre, descripcion from trayectos t
									   join lineas l on t.id_linea = l.id_linea 
									   where id_trayecto = '".$row['id_trayecto']."'", $link);
			$row_line = mysql_fetch_assoc($query_line);
			
			//desentraño el hacia ...
			$patron = '/<option selected="selected" value="(.){1}">[\w\s\.ñÑ\&\#\;\:\-]+<\/option>/';
			if(preg_match($patron, $respuesta, $cadena)){
				$hacia = (trim(strip_tags($cadena[0])));
				$hacia = preg_replace('/LINEA [[:alnum:]]{1,2}:/','',$hacia);
			}
			else $hacia = $row_line['descripcion'];
			
			$opciones_hacia = explode('-',$hacia);
			$opciones=$opciones_hacia;
			
			//Pelea con el tiempo restante
			
			$patron = '/Primer autobús en [[:digit:]]+ minutos/';
			if(preg_match($patron, $respuesta, $cadena)){
				$faltan = (trim(strip_tags($cadena[0])));
				$faltan = preg_replace('/[[:alpha:]áéíóú\s]/','',$faltan);
			}else{
				$patron = '/Primer autobús en menos de un minuto/';
				if(preg_match($patron, $respuesta, $cadena)){
					$faltan = 0;
				}
				else{
					$faltan = null;
				}			
			}
			
			if($faltan!=null){
				$lineas[]=$row_line['nombre'];
				$recorrido[]= trim(array_pop($opciones_hacia));
				$restantes[]= trim($faltan);
			}
			
			//Segundo autobús en 10 minutos
			$patron = '/Segundo autobús en [[:digit:]]+ minutos/';
			if(preg_match($patron, $respuesta, $cadena)){
				$faltan = (trim(strip_tags($cadena[0])));
				$faltan = preg_replace('/[[:alpha:]áéíóú\s]/','',$faltan);
				//añadiendo los datos
				$lineas[]=$row_line['nombre'];
				$recorrido[]= trim(array_pop($opciones));
				$restantes[]= trim($faltan);
			}
		}
	}

	$proximos_autobuses['linea']=$lineas;
	$proximos_autobuses['destino'] = $recorrido;
	$proximos_autobuses['minutos'] = $restantes;	
	
	$info_parada['proximos'] = $proximos_autobuses;
	$info_parada['proximos'] = bubbleSort($info_parada['proximos']);
	$posibles_transbordos = array();
	$info_parada['transbordos'] = $posibles_transbordos;		
	$horarios=array();
	$info_parada['horarios'] = $horarios;
		
	return $info_parada;
}
else return -1;
}
?>
