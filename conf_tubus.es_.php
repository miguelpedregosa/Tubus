<?php

//Algunos parametros de configuración generales que se repiten para todas las ciudades
require_once 'version.php';
require_once 'libs/geoip.php';

$configuracion['master'] = true;
$configuracion['dcookie'] = '.tubus.es';


if(!isset($_COOKIE['userciudad'])){
   
   /*
    * Si el usuario no ha establecido ninguna ciudad a mano, se busca por ip a ver si se encuentra 
    * en alguna de las ciudades que tenemos cubiertas.
    */ 
   
   $ciudad_code = tubus_ip2ciudad(obtener_real_ip());
   require_once 'conf_'.$ciudad_code.'.tubus.es_.php';

}
else{
	
	$ciudad = $_COOKIE['userciudad'];
	/*
	if(file_exists('conf_'.$ciudad .'.tubus.es_.php'))
		require_once 'conf_'.$ciudad .'.tubus.es_.php';
	else
		require_once 'conf_madrid.tubus.es_.php';
	*/
	
	switch($ciudad){
		case 'gr':
			require_once 'conf_gr.tubus.es_.php';
		break;
		
		case 'z':
			require_once 'conf_z.tubus.es_.php';
		break;
		
		case 'v':
			require_once 'conf_v.tubus.es_.php';
		break;
        
        case 'b':
			require_once 'conf_b.tubus.es_.php';
		break;
        
        case 'ma':
			require_once 'conf_ma.tubus.es_.php';
		break;
        
        case 'do':
			require_once 'conf_do.tubus.es_.php';
		break;
        
		case 'se':
			require_once 'conf_se.tubus.es_.php';
		break;
        
		case 'co':
			require_once 'conf_co.tubus.es_.php';
		break;
        
        case 'madrid':
			require_once 'conf_madrid.tubus.es_.php';
		break;
		
		 case 'bi':
			require_once 'conf_bi.tubus.es_.php';
		break;
	
		 case 'elche':
			require_once 'conf_elche.tubus.es_.php';
		break;
		
		case 'sa':
			require_once 'conf_sa.tubus.es_.php';
		break;
		
		case 'gijon':
			require_once 'conf_gijon.tubus.es_.php';
		break;
		
		case 'guipuzcoa':
			require_once 'conf_guipuzcoa.tubus.es_.php';
		break;
		
		case 'leon':
			require_once 'conf_leon.tubus.es_.php';
		break;
		
		case 'valladolid':
			require_once 'conf_valladolid.tubus.es_.php';
		break;
		
		case 'albacete':
			require_once 'conf_albacete.tubus.es_.php';
		break;		
		
		case 'vigo':
			require_once 'conf_vigo.tubus.es_.php';
		break;
		
				
		default:
		
		if(file_exists("conf_".$ciudad.".tubus.es_.php"))
		{
			require_once "conf_".$ciudad.".tubus.es_.php" ;
		}
		
		else
			require_once 'conf_madrid.tubus.es_.php';
		break;
	}
	
}

