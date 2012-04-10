<?php
require_once '../version.php';
if(isset($_GET['r']))
	$r_t = '&r='.rtrim($_GET['r'],'/').'/';
else
	$r_t = '';
function ciudad_google2tubus($ciudad)
{
	//echo $ciudad; die;
	switch($ciudad)
	{
		case 'Granada':
		return 'gr';
		break;
		
		case 'San Sebastian':
		return 'do';
		break;
		
		case 'Saragossa':
		return 'z';
		break;

		case 'Valencia':
		return 'v';
		break;		

		case 'Barcelona':
		return 'b';
		break;
		
		case 'Malaga':
		return 'ma';
		break;		
		
		case 'Seville':
		return 'se';
		break;
			
		case 'Cordova':
		return 'co';
		break;
			
		case 'Madrid':
		return 'madrid';
		break;
		
		case 'Bilbao':
		return 'bi';
		break;
		
		case 'Elche':
		return 'elche';
		break;

		case 'Gijón':
		return 'gijon';
		break;

		case 'Santander':
		return 'sa';
		break;

		default:
		return false;
		break;
	}
	
	return false;
}

function crear_mensaje_url($ciudad)
{
	global $r_t;
	global $configuracion;
	switch($ciudad)
	{
		case 'gr':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=GRANADA'.$r_t.'" title="Mostrar autobuses urbanos de Granada">Tubus Granada</a>';
		break;
		
		case 'do':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=DONOSTIA'.$r_t.'" title="Mostrar autobuses urbanos de Donostia - San Sebastián">Tubus Donostia</a>';
		break;
		
		case 'z':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=ZARAGOZA'.$r_t.'" title="Mostrar autobuses urbanos de Zaraagoza">Tubus Zaragoza</a>';
		break;

		case 'v':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=VALENCIA'.$r_t.'" title="Mostrar autobuses urbanos de Valencia">Tubus Valencia</a>';
		break;		

		case 'b':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=BARCELONA'.$r_t.'" title="Mostrar autobuses urbanos de Barcelona">Tubus Barcelona</a>';
		break;
		
		case 'ma':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=MALAGA'.$r_t.'" title="Mostrar autobuses urbanos de Málaga">Tubus Málaga</a>';
		break;		
		
		case 'se':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=SEVILLA'.$r_t.'" title="Mostrar autobuses urbanos de Sevilla">Tubus Sevilla</a>';
		break;
			
		case 'co':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=CORDOBA'.$r_t.'" title="Mostrar autobuses urbanos de Córdoba">Tubus Córdoba</a>';
		break;
			
		case 'madrid':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=MADRID'.$r_t.'" title="Mostrar autobuses urbanos de Madrid">Tubus Madrid</a>';
		break;
		
		case 'bi':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=BILBAO'.$r_t.'" title="Mostrar autobuses urbanos de Bilbao">Tubus Bilbao</a>';
		break;

		case 'elche':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=ELCHE'.$r_t.'" title="Mostrar autobuses urbanos de Elche">Tubus Elche</a>';
		break;
		
		case 'sa':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=SANTANDER'.$r_t.'" title="Mostrar autobuses urbanos de Santander">Tubus Santander</a>';
		break;
		
		case 'gijon':
		return '<a href="'.$configuracion['master_url'].'/ciudad.php?ciudad=GIJON'.$r_t.'" title="Mostrar autobuses urbanos de Gijón">Tubus Gijón</a>';
		break;
		
		default:
		return false;
		break;
	}
	
	return false;
}


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

if(isset($_GET['lat']) && isset($_GET['long'])){
require_once '../system.php';
require_once '../libs/CURL.php';
require_once '../libs/geoip.php';

$output = array();

//Tengo que ver que ciudad tiene seleccionada el usuario, va a depender de la cookie o de la ip
if(!isset($_COOKIE['userciudad'])){
	$ciudad_code = tubus_ip2ciudad(obtener_real_ip());
}
else
{
	$ciudad_code = $_COOKIE['userciudad'];
}

//Ahora uso el webservice de Google para ver si el usuario está en la misma ciudad que dice su cookie o su ip.
$lat = (float) trim($_GET['lat']);
$long = (float) trim($_GET['long']);
$url_gmaps_s = 'http://maps.google.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&sensor=false';

$cc = new CURL();
$datos = $cc->get($url_gmaps_s);
$datos_json = json_decode($datos);
//print_r($datos_json);
if($datos_json->status == 'OK')
{
	if($datos_json->results[0])
	{
		//print_r($datos_json->results[0]);
		$ciudad_google = $datos_json->results[0]->address_components[2]->short_name;
		//Una vez que tengo la ciudad donde se encuentra el usuario, tengo que ver si es una ciudad de las que están dadas de alta en Tubus
		$google_code = ciudad_google2tubus($ciudad_google);
		
		//Si es una ciudad válida y no es la misma que tengo
		if($google_code != false && $google_code != $ciudad_code )
		{
			
			if(!isset($_COOKIE['autogeoreminder'])) //Si el usuario no quiere el mensaje, no se le muestra
			{
				
				//echo $google_code.":".$ciudad_code;
				$output['mostrar'] = 'si';
				$mensaje = 'Tubus está disponible en su ciudad. Ir a '.crear_mensaje_url($google_code);
				$output['mensaje'] = $mensaje;
				//echo crear_mensaje_url($google_code);
			}
			else
			{
				$output['mostrar'] = 'no';
			}
			
			
			
		}
		else
		{
			$output['mostrar'] = 'no';
		}
		
		
		//echo $ciudad_google;
	}
	
}
else
{
	$output['mostrar'] = 'no';
}




}
else
{
	$output = array();
	$output['mostrar'] = 'no';
	
}
echo json_encode($output);
