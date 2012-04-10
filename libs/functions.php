<?php
require_once "dbconnect.php";
require_once "google_config.php";
require_once "geografia.php";

function visitas($pagina){
	global $link;

	$ip =  $_SERVER['REMOTE_ADDR'];   
	$fecha = date("j \d\e\l n \d\e Y");   
	$hora = date("h:i:s");   
	$horau = date("h");   
	$diau = date("z");   
	$aniou = date("Y");   
	//se asignan la variables   
	$sql = "SELECT page, aniou, diau, horau, ip ";   
	$sql.= "FROM contador WHERE page = '$pagina' AND aniou = '$aniou' AND diau = '$diau' AND horau = '$horau' AND ip LIKE '$ip' ";   
	$es = mysql_query($sql, $link) or die("Error al leer base de datos: ".mysql_error);   
	//se buscan los registros que coincidan con la hora,dia,año e ip    
	if(mysql_num_rows($es)>0)   
	{//no se cuenta la visita   
	}   
	else   
	{   
	$sql = "INSERT INTO contador (id, page, ip, explorador, version, fecha, hora, horau, diau, aniou) ";   
	$sql.= "VALUES ('','$pagina','$ip', '', '', '$fecha','$hora','$horau','$diau','$aniou')";   
	$es = mysql_query($sql, $link) or die("Error al grabar un mensaje: ".mysql_error);   
	}   
	//creamos el condicionamiendo para logearlo o no.   
	$sql = "SELECT * ";   
	$sql.= "FROM contador WHERE page='$pagina'";   
	$es = mysql_query($sql, $link) or die("Error al leer base de datos: ".mysql_error);   
	$visitas = mysql_num_rows($es);   
	$men=$visitas; 
	return $men;
}

function get_horario($parada, $hora){
	global $link;
	
	$sql = "SELECT distinct linea ";   
	$sql.= "FROM horarios WHERE id_parada='$parada' AND f_horaria='$hora'";   
	$es = mysql_query($sql, $link) or die("Error al leer base de datos: ".mysql_error);
	$horarios = array();
	while($row = mysql_fetch_assoc($es)){
		$linea = $row['linea'];
		$sql2 = "SELECT hora ";   
		$sql2.= "FROM horarios WHERE id_parada='$parada' AND f_horaria='$hora' AND linea = '$linea' ";   
		$sql2.= "ORDER BY hora ASC";   
		$es2 = mysql_query($sql2, $link) or die("Error al leer base de datos: ".mysql_error);
		$hora = '';
		while($row2 = mysql_fetch_assoc($es2)){
			$hora .= $row2['hora'].' ';
		}
		//print_r($linea.' '.$hora."\n");
		echo '<div class="apartado-bus">
			<span class="sup-izq"></span>
			<span class="sup-der"></span>
			<span class="inf-izq"></span>
			<span class="inf-der"></span>
			<table>
			<tr>
			<td class="numero4">'.$linea.'</td>
			<td class="destino4">'.$hora.'</td>
			</tr>
			</table>
			</div>';
	}
	return($horarios);
}

function get_coordenadas($parada)
{
	global $link;
	
	//compruebo que como parada no se está pasando cualquier cosa
	if(!is_int($parada)) return false;
	
	$sql = "SELECT * FROM paradas WHERE nombre = '".$parada."'";
	$res = mysql_query($sql, $link);
	$reg_seleccionados = mysql_num_rows($res);
	if ($reg_seleccionados == 1) // existe la parada
	{
		$datos_parada = mysql_fetch_assoc($res);
		
		if($datos_parada['latitud'] == null or $datos_parada['longitud'] == null)
			return false;
		
		$geolocalizacion=array(
			'latitud' => $datos_parada['latitud'],
			'longitud' => $datos_parada['longitud']
		);
		
		return $geolocalizacion;
	}
	else return false; // no existe la parada o hay más de un resultado, lo cual no es lógico.
}

function is_blocked($parada)
{
	global $link;
	
	//compruebo que como parada no se está pasando cualquier cosa
	if(!is_int($parada)) return false;
	
	$sql = "SELECT * FROM paradas WHERE nombre = '".$parada."'";
	$res = mysql_query($sql, $link);
	if(!res) return false;
	$reg_seleccionados = mysql_num_rows($res);
	if ($reg_seleccionados == 1) // existe la parada
	{
		$datos_parada = mysql_fetch_assoc($res);
		$blocked = $datos_parada['blocked'];
		
		if($blocked == 1) return true;
		else return false;
	}
	else return false; // no existe la parada o hay más de un resultado, lo cual no es lógico.
}

function get_static_map($latitud, $longitud)
{
	$url_map = 'http://maps.google.com/staticmap?center='.$latitud.','.$longitud.'&zoom='.STATIC_MAPS_ZOOM.'&size='.STATIC_MAPS_WIDHT.'x'.STATIC_MAPS_HEIGHT.'&maptype=mobile&markers='.$latitud.','.$longitud.',redb&key='.GOOGLE_API_KEY.'&sensor='.SENSOR_AVAILABLE.'';
	return($url_map);
}

function get_real_ip()
{

   if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != ''  )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );

      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR

      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\\./',
                  '/^127\\.0\\.0\\.1/',
                  '/^192\\.168\\..*/',
                  '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                  '/^10\\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   return $client_ip;

}

function get_userid(){
	if(isset($_COOKIE['userid']))
		return $_COOKIE['userid'];
	else{
		$userid = uniqid (rand (),true);
		setcookie("userid", $userid, time() + 31536000, "/", ".tubus.es");
		return $userid;
	}
}

function read_userid(){
	if(isset($_COOKIE['userid']))
		return $_COOKIE['userid'];
	else{
		return null;
	}
}

function registrar_busqueda($querystring){
	global $link;
	$userid = read_userid();
	$fecha = date('Y-m-d H:i:s');
	$ip = get_real_ip();
	
	$sql = "INSERT INTO historial_buscador (userid, querystring, ip, time) VALUES ('".$userid."','".utf8_decode($querystring)."','".$ip."','".$fecha."')";
	$res = mysql_query($sql);
	if($res)
		return true;
	else
		return false;
	
}


function registrar_historial($parada, $id_zona = null){
	global $link;
	//Lo primero que necesito es el user id, en caso de no tenerlo necesito crear uno nuevo
	$userid = get_userid();
	//Ahora transformo el nombre de la parada en su id
	$sql = "SELECT id_parada FROM paradas WHERE nombre = '".$parada."' LIMIT 1";
	//echo $sql;
	$res = mysql_query($sql);
	$cantidad = mysql_num_rows($res);
	if($cantidad == 0){
		return false; //No existe la parada en la base de datos
	}
	else if($cantidad == 1){
		$datos = mysql_fetch_array($res);
		$parada_id = $datos['id_parada'];
		$fecha = date('Y-m-d H:i:s');
		$ip = get_real_ip();
		//Ahora tengo que mirar si el usuario tiene esta parada en su historial en cuyo caso se actualizan los valores, en caso contrario se inserta en la bd
		$sql = "SELECT * FROM historial WHERE userid = '".$userid."' AND parada_id = '".$parada_id."' LIMIT 1 "; 
		$res2 = mysql_query($sql);
		if(!$res2)
			return false;
		$data = mysql_fetch_array($res2);
		$contador = $data['count'];
		$numero = mysql_num_rows($res2);
		
		if($numero == 0){ //No existe en el historial la relacion
			$sql = "INSERT INTO historial (userid, parada_id, ip, time, count, nombre) VALUES ('".$userid."','".$parada_id."','".$ip."','".$fecha."',1,'".$parada."')";
			$res = mysql_query($sql);
			if($res)
				return true;
			else
				return false;
		}
		else if($numero == 1){
			$contador++;
			$sql = "UPDATE historial SET ip = '".$ip."', time='".$fecha."', nombre = '".$parada."', count = '".$contador."' WHERE userid = '".$userid."' AND parada_id = '".$parada_id."' LIMIT 1";
			$res = mysql_query($sql);
			if($res)
				return true;
			else
				return false;
		}
	}
}
	
function contar_parada($parada, $label = null){
	global $link;
	if($label != null)
		$label = utf8_decode($label);
	
	$sql = "SELECT * FROM paradas WHERE nombre = '".$parada."' LIMIT 1";
	$res = mysql_query($sql);
	if(!$res)
		return false;
	//$tiempo = time();
	$fecha = date('Y-m-d H:i:s');
	if(mysql_num_rows($res) == 0){
		//No existe la parada, por tanto tengo que crearla
		if($label != null)
            $sql_i = "INSERT into paradas (nombre, creada, views, last_view, label)  VALUES ('".$parada."','".$fecha."','1','".$fecha."', '".$label."')";
		else
            $sql_i = "INSERT into paradas (nombre, creada, views, last_view)  VALUES ('".$parada."','".$fecha."','1','".$fecha."')";
        
        if(mysql_query($sql_i))
			return true;
		else 
			return false;
	}
	else{
		$datos = mysql_fetch_array($res);
		$contador = (int)$datos['views'];
		$contador++;
		$fecha = date('Y-m-d H:i:s');
		if($label != null)
            $sql_u = "UPDATE paradas set views = '".$contador."',last_view = '".$fecha."', label = '".$label."' WHERE nombre = '".$parada."' LIMIT 1";
		else
            $sql_u = "UPDATE paradas set views = '".$contador."',last_view = '".$fecha."' WHERE nombre = '".$parada."' LIMIT 1";

        
        if(mysql_query($sql_u))
			return true;
		else 
			return false;
		
	}	
		
	
}

function obtener_paradas_cercanas($parada, $maxdist = 300, $numero = 5){
	$salida = array();
	$sql = "SELECT id_parada FROM paradas WHERE nombre = '".$parada."' LIMIT 1";
	$res = mysql_query($sql);
	
	if(mysql_num_rows($res) == 1){
		$datos = mysql_fetch_array($res);
		$id1 = $datos['id_parada'];
		
		$sql2 = "SELECT DISTINCT * FROM distancia_entre_paradas WHERE (id_parada1 = '".$id1."' OR id_parada2 = '".$id1."') AND distancia <= ".$maxdist." ORDER BY distancia ASC LIMIT ".$numero."";
		//echo "Parada solicitada $parada con ID: $id1 \n";
		$res2 = mysql_query($sql2);
		
		if(mysql_num_rows($res2) <= 0)
			return false;
		
		while($datos_parada = mysql_fetch_array($res2)){
			//print_r($datos_parada);
			if($datos_parada['id_parada1'] == $id1)
				$id2 = $datos_parada['id_parada2'];
			else
				$id2 = $datos_parada['id_parada1'];
				
			//echo "La otra parada tiene ID: $id2 \n";
			$distancia = $datos_parada['distancia'];
			$sql3 = "SELECT nombre, label FROM paradas WHERE id_parada = '".$id2."' LIMIT 1";
			$res3 = mysql_query($sql3);
			if(mysql_num_rows($res3) == 1){
				$info = mysql_fetch_array($res3);
				$info_parada['nombre'] = utf8_encode($info['nombre']);
				//echo "La otra parada tiene Nombre: ".$info_parada['nombre']." \n";
				$info_parada['label'] = utf8_encode($info['label']);
				$info_parada['distancia'] = $distancia;
				
				$salida[] = $info_parada;
				
			}
			
			
		}
		
		return $salida;
		
	}
	else return false;
	
	return false;
	
	
}

function ordenar_vector_distancias($vector){
    $size = count($vector);
    
    for($i=0; $i < $size; $i++){
        for($j = $size-1; $j > $i; $j--){
            
            if($vector[$j]['distancia'] < $vector[$j-1]['distancia']){
                $temp = $vector[$j];
                $vector[$j] = $vector[$j-1];
                
					$vector[$j-1] = $temp;
                
            }
            
            
        }
    }
    
    return $vector;
}

function obtener_paradas_proximas($lat1, $long1, $maxdist = 300, $pmax = 10){
    global $link;
    $distancias = array();
    $distancias_op = array();
    $salida = array();
    
        if($lat1 == 0) return false;
        if($long1 == 0) return false;
    
    $sql = "SELECT * FROM paradas WHERE latitud <> 0 AND longitud <> 0";
    $res = mysql_query($sql);
    
    if(mysql_num_rows($res) > 0){
        while($datos = mysql_fetch_array($res)){
            $lat2 = $datos['latitud'];
            $long2 = $datos['longitud'];
            $idparada = $datos['id_parada'];
            
            $distancia = distancia_haversin($lat1, $lat2, $long1, $long2);
            
            if($distancia <= $maxdist){
            
				$resultado['id'] = $idparada;
				$resultado['distancia'] = $distancia;
           
				$distancias[] = $resultado;
			}
            
        }
        
    }
    else return false;
    
    //Una vez que tengo la distancia calculada de todas las paradas con respecto a la posicion solicitada, 
    //elimino aquellas que está fuera de rango para acelerar los calculos.
    /*
    foreach($distancias as $parada){
        if($parada['distancia'] <= $maxdist){
            $distancias_op[] = $parada;
            
        }
        
    }  
    */
    //print_r($distancias); 
    $do = ordenar_vector_distancias($distancias); //Ordeno las paradas por cercanía
    //Ahora compongo la matriz de salida, con el numero de la parada
    $contador = 0;
    foreach($do as $item){
       if($contador < $pmax){
        $sql3 = "SELECT nombre, label FROM paradas WHERE id_parada = '".$item['id']."' LIMIT 1";
			$res3 = mysql_query($sql3);
			if(mysql_num_rows($res3) == 1){
				$info = mysql_fetch_array($res3);
				$info_parada['nombre'] = utf8_encode($info['nombre']);
				$info_parada['label'] = utf8_encode($info['label']);
				$info_parada['distancia'] = $item['distancia'];
				
				$salida[] = $info_parada;
				
			}
        $contador++;
	}
        
    }
    
    return $salida;
    
}

function obtener_num_trayecto($linea_id, $trayecto_id)
{
	global $link;
	$sql = "SELECT * FROM trayectos WHERE id_linea = '".$linea_id."' ORDER BY id_trayecto ASC";
	$res = mysql_query($sql);
	$contador = 1;
	$indice = 1;
	while($fila = mysql_fetch_assoc($res))
	{
		if($fila['id_trayecto'] == $trayecto_id)
		{
			$indice = $contador;
		}
		$contador++;
	}
	
	return $indice;
	
}

function array_elimina_duplicados($array, $campo) 
    { 
        $new = array();  
        $exclude = array("");  
        for ($i = 0; $i<=count($array)-1; $i++) {  
            if (!in_array(trim($array[$i][$campo]) ,$exclude)) { $new[] = $array[$i]; $exclude[] = trim($array[$i][$campo]); }  
        } 
         
        return $new; 
    }
    

function obtener_lineas_parada($parada){
	global $link;
	$lineas = array();
	//Compruebo que el nombre de la parada existe en BD
	
	$sql = "SELECT id_parada ";   
	$sql.= "FROM paradas WHERE nombre='$parada'";  
	$res = mysql_query($sql);
	if(mysql_num_rows($res)==1)//La parada existe en Base de datos
	{
		//obtengo la id de la parada
		$row = mysql_fetch_assoc($res);
		$id_parada = $row['id_parada'];
		
		//Una vez que tengo el identificador de la parada, voy a consultar en base de datos los trayectos que la contienen.
		$sql_tp = "SELECT * FROM trayectos_a_paradas WHERE id_parada='$id_parada'";
		$res_tp = mysql_query($sql_tp);
		
		if(mysql_num_rows($res_tp)==0) return false;
		
		$trayectos = array();
		$trayecto_num = 1;
		while($row = mysql_fetch_assoc($res_tp)){
			$trayectos[] = ($row['id_trayecto']);
		}
		foreach($trayectos as $trayecto){
			$sql_t = "SELECT id_linea, salida, llegada FROM trayectos WHERE id_trayecto = '$trayecto'"; 
			$res_t = mysql_query($sql_t);
			
			$row_l = mysql_fetch_assoc($res_t);
			
			//me traigo el nombre de la linea
			$sql_l = "SELECT nombre, color, especial FROM lineas WHERE id_linea = '".$row_l['id_linea']."'"; 
			$res_l = mysql_query($sql_l);
			
			$row_dl = mysql_fetch_assoc($res_l);
			if($row_dl['especial'] != 1)
			{
			$lineas[] = array(
			'id_linea' => $row_l['id_linea'],
			'nombre' => utf8_encode($row_dl['nombre']),
			'color' => utf8_encode($row_dl['color']),
			'salida' => utf8_encode($row_l['salida']),
			'llegada' => utf8_encode($row_l['llegada']),
			'numero_trayecto' => obtener_num_trayecto($row_l['id_linea'], $trayecto)
			);
		
		$trayecto_num++;
		}
		}
		return $lineas;
	}
	else//la parada no existe en Base de datos.
	{
		return false;
	}
}

function obtener_nombre_parada($parada){
	global $link;
	$lineas = array();
	//Compruebo que el nombre de la parada existe en BD
	
	$sql = "SELECT * ";   
	$sql.= "FROM paradas WHERE nombre='$parada'";   
	$res = mysql_query($sql, $link);
	if(mysql_num_rows($res)==1)//La parada existe en Base de datos
	{
		$row = mysql_fetch_assoc($res);
		$datos = array(
			'id_parada'=>$row['id_parada'],
			'nombre'=>utf8_encode($row['nombre']),
			'label'=>utf8_encode($row['label']),
			'direccion'=>utf8_encode($row['direccion']),
			'zona' =>$row['zona'],
			'visitas' => $row['views']
		);
		return $datos;
	}
	else{
	return false;
	}
}

function obtener_porcentaje_paradas_geolocalizadas(){
	
	global $link;	
	$sql_total = "SELECT COUNT(*) AS \"total_paradas\" FROM paradas WHERE virtual = 0";
	$res = mysql_query($sql_total);
	$row = mysql_fetch_assoc($res);
	$total_paradas = (float)$row['total_paradas'];
	
	$sql_total_geo = "SELECT COUNT(*) AS \"total_paradas\" FROM paradas WHERE latitud <> 'NULL' AND longitud <> 'NULL'";
	$res_geo = mysql_query($sql_total_geo);
	$row_geo = mysql_fetch_assoc($res_geo);
	$total_paradas_geo = (float)$row_geo['total_paradas'];
	
	$porcentaje = (float)(($total_paradas_geo*100)/$total_paradas);
	return (round($porcentaje,0));
	
}

function mostrar_error_parada($ajax_code = true){
	$error = '<h4>Próximos autobuses en llegar<span id="mini-ajax" style="position:relative; display:none"><img src ="'.$configuracion['home_url'].'/style/images/ajax-loader.gif" style="position:absolute;top:0px;left:6px;"/></span></h4><span class="liine2"></span>';
	$error .= '
    <div class="resultados-buqueda">	
    <p class="info_general"><strong>Se ha producido un error al obtener las llegadas a esta parada.</strong><br /><br />
     Por favor vuelva a intentarlo pasados unos instantes.<br /><br /> Email de contacto: <a href="mailto:contacto@tubus.es">contacto@tubus.es</a></p>
     </div>
      ';
return $error;	
}

function registrar_entrada_qr($parada, $id_zona = null){
    global $link;
	//Lo primero que necesito es el user id, en caso de no tenerlo necesito crear uno nuevo
	$userid = get_userid();
	//Ahora transformo el nombre de la parada en su id
	$sql = "SELECT id_parada FROM paradas WHERE nombre = '".$parada."' LIMIT 1";
	//echo $sql;
	$res = mysql_query($sql);
	$cantidad = mysql_num_rows($res);
	if($cantidad == 0){
		return false; //No existe la parada en la base de datos
	}
	else if($cantidad == 1){
		$datos = mysql_fetch_array($res);
		$parada_id = $datos['id_parada'];
		$fecha = date('Y-m-d H:i:s');
		$ip = get_real_ip();
		//Ahora tengo que mirar si el usuario tiene esta parada en su historial en cuyo caso se actualizan los valores, en caso contrario se inserta en la bd
		$sql = "SELECT * FROM historial_qr WHERE userid = '".$userid."' AND parada_id = '".$parada_id."' LIMIT 1 "; 
		$res2 = mysql_query($sql);
		$data = mysql_fetch_array($res2);
		$contador = $data['count'];
		$numero = mysql_num_rows($res2);
		
		if($numero == 0){ //No existe en el historial la relacion
			$sql = "INSERT INTO historial_qr (userid, parada_id, ip, time, count, nombre) VALUES ('".$userid."','".$parada_id."','".$ip."','".$fecha."',1,'".$parada."')";
			$res = mysql_query($sql);
			if($res)
				return true;
			else
				return false;
		}
		else if($numero == 1){
			$contador++;
			$sql = "UPDATE historial_qr SET ip = '".$ip."', time='".$fecha."', nombre = '".$parada."', count = '".$contador."' WHERE userid = '".$userid."' AND parada_id = '".$parada_id."' LIMIT 1";
			$res = mysql_query($sql);
			if($res)
				return true;
			else
				return false;
		}
	}
    
}

//$test = obtener_paradas_cercanas('304');
//print_r($test);

function lineas($limit = true, $resultados = 3){
 global $link;
 
 if($limit)
 $sql = "SELECT * FROM lineas l WHERE especial <> 1 ORDER BY l.id_linea +0 ASC LIMIT $resultados";	
 else
 $sql = "SELECT * FROM lineas l WHERE especial <> 1 ORDER BY l.id_linea +0 ASC";	
 
 $res = mysql_query($sql);
 $lineas = array();
 while($row = mysql_fetch_assoc($res)){
	 
	$sql2 = "SELECT * FROM trayectos t WHERE id_linea = '".$row['id_linea']."' ORDER BY id_trayecto ASC LIMIT 1";	
	 $res2 = mysql_query($sql2);
	 $trayect = mysql_fetch_assoc($res2);
	 $lineas[]=array(
		'nombre'=>$row['nombre'],
		'descripcion'=>$row['descripcion'],
		'salida'=>utf8_encode($trayect['salida']),
		'llegada'=>utf8_encode($trayect['llegada'])
	 );
 }
 return $lineas;
}


function SearchByName($calle, $pagina = null){

	global $link;

	if (!$pagina) {
		$inicio = 0;
		$pagina=1;
		}
   else {
    $inicio = ($pagina - 1) * 10;
   } 
	
	
	$paradas = array();
	$sql = "SELECT * FROM `paradas` WHERE `label` LIKE '%".htmlentities(utf8_decode($calle))."%' AND virtual = 0 ORDER BY id_parada ASC LIMIT $inicio,10";
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
	//$sql_insert = "INSERT INTO cache_buscador (querystring, results, time) VALUES ('".htmlentities(utf8_decode($calle))."', '".$paradas_serialized."', '".$tiempo."')";
	//mysql_query($sql_insert);
	return $paradas_serialized;
}

function SearchByNameCount($calle){

	global $link;
	$sql = "SELECT * FROM `paradas` WHERE `label` LIKE '%".htmlentities(utf8_decode($calle))."%' AND virtual = 0 ORDER BY id_parada ASC";
	$res = mysql_query($sql);
	return mysql_num_rows($res);
	
}


?>
