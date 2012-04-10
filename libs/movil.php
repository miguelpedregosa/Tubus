<?php
require_once 'mobile_device_detect.php';
require_once 'browser.php';

function is_gmaps_capable(){
	$mobile = mobile_device_detect();
	if (!$mobile)
		return true;
	else{
		if(is_array($mobile)){
			$mobile_browser = $mobile[0];
			$status = $mobile[1];
			//echo $_SERVER['HTTP_USER_AGENT'];
			//echo $status;
			//die;
			if($mobile_browser == 0)
				return true;
			else{
				switch($status){
					case 'Apple iPad':
					case 'Apple':
					case 'Android':
					case 'Opera Mobile':
					case 'Windows Phone':
					case 'Blackberry':
					case 'webOS':
					case 'Symbian':
					case 'Bada':
						return true;
					break;
					
					default:
					return false;
					break;
				}	
			}	
		}
		else
			return true;
		
	}	
}
function is_windows_phone_7()
{
	$mobile = mobile_device_detect();
	if(!$mobile)
		return false;
		
	$status = $mobile[1];
	
	if($status == 'Windows Phone')
		return true;
	else
		return false;
	
}
function is_browser_geocapable(){
	$browser = getBrowser(null, true);
	$navegador = $browser['browser'];
	$version = $browser['version'];
	$majorver = $browser['majorver'];
	//print_r($browser);
    //die;
    //echo $_SERVER['HTTP_USER_AGENT'];
	switch($navegador){
		
		case 'Chrome':
		if( (float) $version >= 5 )
			return true;
		else 
			return false;
		break;
		
		case 'IE':
		if( (float) $version >= 9 )
			return true;
		else 
			return false;
		break;	
		
		
		case 'Safari':
		if( (float) $version >= 5 )
			return true;
		else 
			return false;
		break;
		
		case 'Firefox':
		if( (float) $version >= 3.5 )
			return true;
		else 
			return false;
		break;
		
		case 'Opera':
		if( (float) $version >= 10.6 )
			return true;
		else 
			return false;
		break;
		
		
		default:
            $navegador_agent =  $_SERVER['HTTP_USER_AGENT'];
            //Primero con Chrome 6
        //$patron_chrome = 'showStopPointDiv\(\'[[:digit:]]*\',\'[[:space:]]*[[:alpha:][:digit:][:punct:][:space:]áéíóúñÁÉÍÓÚÑàèìòùÀÈÌÒÙäëïöüÄËÏÖÜ\'çÇâêîôûÂÊÎÔÛ·\(\)\{\}\$%&-_\?¿¡!\*\^]*\',\'[[:digit:]]*\.[[:digit:]]*\',\'[[:digit:]]*\.[[:digit:]]*\'\);" >';
            $patron_chrome = 'Chrome\/[[:digit:]\.]*[[:space:]]?';
        if (eregi($patron_chrome, $navegador_agent, $segmentos_chrome)) {
            $version_chrome = explode('/', $segmentos_chrome[0]);
            $mayor_v = explode('.', $version_chrome[1]);
            $chrome_mayor = (int)$mayor_v[0];
            if($chrome_mayor >= 6)
                return true;
        }
        
        $patron_opera = 'Opera(.)*Version\/[[:digit:]\.]*';
        
        if (eregi($patron_opera, $navegador_agent, $segmentos_opera)) {
            //print_r($segmentos_opera);
            $patron_opera_v = 'Version\/[[:digit:]\.]*';
            if (eregi($patron_opera_v, $segmentos_opera[0], $segmentos_opera_v)) {
                 //print_r($segmentos_opera_v);
                 $version_opera = explode('/', $segmentos_opera_v[0]);
                 $opera_mayor = (float)$version_opera[1];
                  if($opera_mayor >= 10.6)
                        return true;
            }
            
            
            
        }
        
        //Ahora con Safari 5+
        //Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES) AppleWebKit/533.17.8 (KHTML, like Gecko) Version/5.0.1 Safari/533.17.8
        
        $patron_safari = 'Version(.)*Safari\/[[:digit:]\.]*';
        
        if (eregi($patron_safari, $navegador_agent, $segmentos_safari)) {
            //print_r($segmentos_safari);
            //die;
            $patron_safari_v = 'Version\/[[:digit:]\.]*';
            if (eregi($patron_safari_v, $segmentos_safari[0], $segmentos_safari_v)) {
                 //print_r($segmentos_safari_v);
                 $version_safari = explode('/', trim($segmentos_safari_v[0]));
                 //print_r($version_safari); 
                 $safari_mayor = $version_safari[1];
                 $safari_mayor = (int)$safari_mayor[0];
                 //echo $safari_mayor; die;
                  if($safari_mayor >= 5 )
                        return true;
            }
            
            
            
        }
       
		//Ahora con Firefox 4 y superior
		//Firefox/4.0
		$patron_firefox = 'Firefox\/[[:digit:]\.]*';
		
		if (eregi($patron_firefox, $navegador_agent, $segmentos_firefox)) {            
			$version_firefox = explode('/', trim($segmentos_firefox[0]));             
			$version_firefox_mayor = explode(',', $version_firefox[1]);
			
             $firefox_mayor = (int)$version_firefox_mayor[0];
             
				if($firefox_mayor >= 4 )
                     return true;
		}        



		//die($navegador_agent);
        
		return false;
		break;
		
	}
		
}

function is_geolocation_capable(){
	$mobile = mobile_device_detect();
	if (!$mobile)
		return is_browser_geocapable();
	else{
		if(is_array($mobile)){
			$mobile_browser = $mobile[0];
			$status = $mobile[1];
			
			if($mobile_browser == 0)
				return is_browser_geocapable();
			else{
				switch($status){
					case 'Apple iPad':
					case 'Apple':
					case 'Android':
					case 'Blackberry':
					case 'Bada':
						return true;
					break;
					
					default:
					return false;
					break;
				}	
			}	
		}
		else
			return is_browser_geocapable();
		
	}	
}
?>
