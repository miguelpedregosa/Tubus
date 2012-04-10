<?php
require_once 'system.php';
require_once 'libs/cache_kit.php';
require_once 'libs/url.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/text.php';
require_once 'libs/usuarios.php';
require_once 'libs/helpers.php';
require_once 'libs/functions.php';
require_once 'libs/movil.php';
//Delete the characters beginning by ?, those characters are the GET parameters included in the URI called	
$server_uri = preg_replace('/\?(.)*/','',$_SERVER['REQUEST_URI'] );
$url_args = preg_split('/\/+/', $server_uri);
array_shift($url_args); // The first element is always a "/"	
//The bus stop id will be in the first element of the array

$gmaps_ready = is_gmaps_capable();
$geolocation_ready = is_geolocation_capable();


if(is_numeric($url_args[0])){
		//return (int)$url_args[0];
        $parada_id = (int)$url_args[0];
        $accion = $url_args[1];
        $parametro1 = $url_args[2];
        $parametro2 = $url_args[3];
        //print_r($url_args);
        
        if($accion == 'mobile')
        {
           require_once 'parada-noajax.php';
           exit; 
        }
        
        if($accion == 'wap')
        {
           require_once 'parada-wap.php';
           exit; 
        }
        
        if($accion == 'smartphone')
        {
           require_once 'parada-ajax.php';
           exit; 
        }
        
       if($accion == 'qr')
        {
           //require_once 'parada-ajax.php';
           //exit;
           registrar_entrada_qr($parada_id);
           header ("Location: ".$configuracion['home_url']."/".$parada_id."/"); 
           exit();
        }
        
        
        if($gmaps_ready){
			require_once 'parada-ajax.php';
		}
		else{
			require_once 'parada-noajax.php';
		}
		exit;
    }
else {
        
     switch($url_args[0]){
		 
		case 'linea':
		$num_linea = $url_args[1];
		if(!isset($url_args[2]) || $url_args[2] == "" || $url_args[2] == '' )
		{
			$sentido_linea = 1;
		}
		else
		{
			$sentido_linea = (int) $url_args[2];
		}
		
		require_once 'linea.php';
		
		break;
        
        case 'user':
        if($geolocation_ready)
            require_once 'usuario-geo.php';
        else
            require_once 'usuario-nogeo.php';
            
        break;
			
        default:
			header ("Location: ".$configuracion['home_url']."/"); 
			//echo 'K0';
			exit;
		break;
	}
}
