<?php
require_once 'ipinfodb.class.php';

function save_ip_ciudad($ip, $ciudad)
{
	$tmp_l = mysql_connect('localhost', 'tubus', '#Clave de la BD Tubus');
    if($tmp_l)
    {
		mysql_select_db('tubus_usuarios',$tmp_l);
		//Compruebo si existe la IP ya en la base de datos
		$sql = "SELECT * FROM ciudades_ip WHERE ip = '".$ip."' LIMIT 1";
		$res = mysql_query($sql);
		if(!$res)
			return false;
			
		if(mysql_num_rows($res) == 0)
		{
			//Nuevo registro
			mysql_query("INSERT INTO ciudades_ip (ip, ciudad) VALUES ('".$ip."','".$ciudad."') ");
		}
		else
		{
			//Actualizo registro
			mysql_query("UPDATE ciudades_ip SET ciudad = '".$ciudad."' WHERE ip = '".$ip."' LIMIT 1 ");
		}
			
	mysql_close($tmp_l);
	return true;		
	}
}

function recorded_ciudad($ip)
{
	$ciudad = '';
	$tmp_l = mysql_connect('localhost', 'tubus', '#Clave de la BD Tubus');
    if($tmp_l)
    {
		mysql_select_db('tubus_usuarios',$tmp_l);
		
		
		$sql = "SELECT * FROM ciudades_ip WHERE ip = '".$ip."' LIMIT 1";
		$res = mysql_query($sql, $tmp_l);
		
		if(!$res || mysql_num_rows($res) != 1)
			return $ciudad;
			
		$datos = mysql_fetch_array($res);
		$ciudad = $datos['ciudad'];
		mysql_close($tmp_l);
		return $ciudad;		
	}
	
}


function obtener_real_ip()
{

   if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
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


function ip_to_ciudad_ipinfodb($ip)
{
	$ciudad_local = recorded_ciudad($ip);
	if($ciudad_local != '')
		return $ciudad_local;
	
	$ipinfodb = new ipinfodb;
	$ipinfodb->setKey('@@@@@@@@@@@@@@@@@@@@@@@@@@@@2'); #Key para el servicio ipinfodb.com
	
	//Se usan los datos de http://ipinfodb.com/
	$locations = $ipinfodb->getGeoLocation($ip);
	//$errors = $ipinfodb->getError();
	
	if (!empty($locations) && is_array($locations)) {
		
	if($locations['CountryCode'] == 'ES')
	{
		//Ahora miro la ciudad
		switch($locations['City'])
		{
			case 'Granada':
			$ciudad_sel = 'gr';
			break;
			
			case 'San Sebastian':
			$ciudad_sel = 'do';
			break;
			
			case 'Zaragoza':
			$ciudad_sel = 'z';
			break;
			
			case 'Valencia':
			$ciudad_sel = 'v';
			break;
			
			case 'Barcelona':
			$ciudad_sel = 'b';
			break;
			
			case 'Málaga':
			$ciudad_sel = 'ma';
			break;
			
			case 'Sevilla':
			$ciudad_sel = 'se';
			break;
			
			case 'Córdoba':
			$ciudad_sel = 'co';
			break;
			
			case 'Madrid':
			$ciudad_sel = 'madrid';
			break;

			case 'Bilbao':
			$ciudad_sel = 'bi';
			break;

			case 'Elche':
			$ciudad_sel = 'elche';
			break;
			
			case 'Santander':
			$ciudad_sel = 'sa';
			break;
			
			case 'Valladolid':
			$ciudad_sel = 'valladolid';
			break;
			
			case 'Albacete':
			$ciudad_sel = 'albacete';
			break;	
			
			case 'Vigo':
			$ciudad_sel = 'vigo';
			break;
			
			
			case 'Gijón':
			case 'Gijon':
			$ciudad_sel = 'gijon';
			break;
			
			case 'León':
			case 'Leon':
			$ciudad_sel = 'leon';
			break;
			
			default:
			return '';
			break;
		}
		
		
	}
	else // Si no es España no me Interesa
	{
		return '';
	}
	if($ciudad_sel != '')
		save_ip_ciudad($ip, $ciudad_sel);
	return $ciudad_sel;
	}
	else
	{
			return '';
	}
	
	
}

function ip_to_ciudad_local($ip)
{
	        $ciudad_sel = '';
	        $ip_cachos = explode('.',$ip);
            $ipnum = ($ip_cachos[0] * (256*256*256)) + ($ip_cachos[1] * (256*256)) + ($ip_cachos[2] * (256)) + $ip_cachos[3];
            $sql = "SELECT * from ipl where nip2 >= '".$ipnum."' and nip1 <= '".$ipnum."' limit 1";
    $tmp_l = mysql_connect('localhost', 'tubus', '#Contraseña de la BD');
    if($tmp_l)
        {
            mysql_select_db('tubus',$tmp_l);
        }
        else{
            return $ciudad_sel;
        }
    
    $res_l = mysql_query($sql, $tmp_l);
    if(mysql_num_rows($res_l) == 1){
        $row = mysql_fetch_array($res_l);
        //print_r($row);
        $ciudad = $row['scit'];
        $region = $row['sreg'];
        
        switch($ciudad){
            case 'GRANADA':
                if($region == 'ANDALUCIA'){
					$ciudad_sel = 'gr';
				}
            break;
            
            case 'ZARAGOZA':
                if($region == 'ARAGON'){
					$ciudad_sel = 'z';
				}
            break;
            
            case 'VALENCIA':
                if($region == 'VALENCIA'){
					$ciudad_sel = 'v';
				}
            break;
            
            case 'BARCELONA':
                if($region == 'CATALUñA'){
					$ciudad_sel = 'b';
				}
            break;
            
            case 'BILBAO':
                if($region == 'PAIS VASCO'){
					$ciudad_sel = 'bi';
				}
            break;
            
            case 'MADRID':
                if($region == 'MADRID'){
					$ciudad_sel = 'madrid';
				}
            break;
            
            case 'MALAGA':
                if($region == 'ANDALUCIA'){
					$ciudad_sel = 'ma';
				}
            break;
            
            
            case 'SEVILLA':
                if($region == 'ANDALUCIA'){
					$ciudad_sel = 'se';
				}
            break;
            
            
            case 'CóRDOBA':
                if($region == 'ANDALUCIA'){
					$ciudad_sel = 'co';
				}
            break;
            
            case 'SAN SEBASTIAN':
                if($region == 'PAIS VASCO'){
					$ciudad_sel = 'do';
				}
            break;
            
			case 'ALBACETE':
                if($region == 'CASTILLA-LA MANCHA'){
					$ciudad_sel = 'albacete';
				}
            break;

			case 'VALLADOLID':
                if($region == 'CASTILLA Y LEON'){
					$ciudad_sel = 'valladolid';
				}
            break;			
         
		 	case 'LEON':
                if($region == 'CASTILLA Y LEON'){
					$ciudad_sel = 'leon';
				}
            break;	
			
			
			case 'GIJON':
                if($region == 'ASTURIAS'){
					$ciudad_sel = 'gijon';
				}
            break;	
			
			case 'SANTANDER':
                if($region == 'CANTABRIA'){
					$ciudad_sel = 'sa';
				}
            break;	
			
			case 'VIGO':
                if($region == 'GALICIA'){
					$ciudad_sel = 'vigo';
				}
            break;
		 
		    
            default:
            	$ciudad_sel = 'madrid';
            break;
            
        }
        
        
    }
    else{
		$ciudad_sel = 'madrid';
    }
    mysql_close($tmp_l);
	return $ciudad_sel;

}

function tubus_ip2ciudad($ip)
{
	$ciudad = ip_to_ciudad_ipinfodb($ip);
	
	if($ciudad == '')
		$ciudad = ip_to_ciudad_local($ip);
		
	if($ciudad == '')
		$ciudad = 'madrid';
		
	return $ciudad;
}

function tubus_ip2ciudad_local($ip)
{
	$ciudad = recorded_ciudad($ip);
	if($ciudad == '')
		$ciudad = ip_to_ciudad_local($ip);
		
	if($ciudad == '')
		$ciudad = 'madrid';
		
	return $ciudad;
		
}

