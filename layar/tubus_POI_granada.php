<?php

require_once 'functions.php';

/* Pre-define connection to the MySQL database.*/

$dbhost = "localhost";
$dbdata = "tubus_layar";
$dbuser = ""; //Usuario
$dbpass = ""; //Contraseña

/* Put parameters from GetPOI request into an associative array named $value */

// Put needed parameter names from GetPOI request in an array called $keys.
$keys = array( "layerName", "lat", "lon", "lang", "radius" );

// Initialize an empty associative array.
$value = array();
 
try {
  // Retrieve parameter values using $_GET and put them in $value array with parameter name as key.
  foreach( $keys as $key ) {
 
    if ( isset($_GET[$key]) )
      $value[$key] = $_GET[$key];
    else
      throw new Exception($key ." parameter is not passed in GetPOI request.");
  }//foreach
}//try
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}//catch

/* Connect to MySQL server. We use PDO which is a PHP extension to formalise database connection.
       For more information regarding PDO, please see http://php.net/manual/en/book.pdo.php.
*/
    
// Connect to predefined MySQl database.  
$db = new PDO( "mysql:host=$dbhost; dbname=$dbdata", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES utf8") );
    
// set the error reporting attribute to Exception.
$db->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );

/* Construct the response into an associative array.*/
    
// Create an empty array named response.
$response = array();

//detect the city calling de layer
/*$url_info = "http://api.tubus.es/v1/json/-/geociudad/".$value['lat']."/".$value['lon']."/";		
$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_URL, $url_info);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
curl_setopt($ch, CURLOPT_USERPWD, "layar:layar"); 
$resultado = utf8_encode(curl_exec($ch));
$error = curl_error($ch);
$json = json_decode($resultado);
curl_close($ch);

$codigo_ciudad = $json->geociudad->ciudad->codigo;
$nombre_ciudad = utf8_decode($json->geociudad->ciudad->nombre);*/

// Assign cooresponding values to mandatory JSON response keys.
$response["layer"] = $value["layerName"];
  
// Use Gethotspots() function to retrieve POIs with in the search range.  
$response["hotspots"] = Gethotspots( $db, $value );

// if there is no POI found, return a custom error message.
if ( empty( $response["hotspots"] ) ) {
     $response["errorCode"] = 20;
     $response["errorString"] = "No POI found. Please adjust the range.";
}//if
else {
      $response["errorCode"] = 0;
      $response["errorString"] = "ok";
}//else

/* All data is in $response, print it into JSON format.*/
for($i = 0; $i<count($response['hotspots']); $i++){
		
		$patron = '/^[[:alpha:]]+/';
		preg_match($patron,$response['hotspots'][$i]['attribution'], $cadena);
		$codigo_ciudad = trim($cadena[0]);
				
		$nombre_de_la_parada = trim(str_replace('Parada','',($response['hotspots'][$i]['attribution'])));//atención a los bucles
		$nombre_de_la_parada = trim(str_replace($codigo_ciudad,'',$nombre_de_la_parada));//atención a los bucles
		$nombre_de_la_parada = trim(preg_replace('/[[:punct:]]+/','',$nombre_de_la_parada));
		$url_info = "http://api.tubus.es/v1/json/".$codigo_ciudad."/lineas/".$nombre_de_la_parada;

		$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_URL, $url_info);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
		curl_setopt($ch, CURLOPT_USERPWD, "layar:layar"); 
		$resultado = utf8_encode(curl_exec($ch));
		$error = curl_error($ch);
		$json = json_decode($resultado);
		
		$info_lineas = ($json->lineas);	
		curl_close($ch);
		$response['hotspots'][$i]['line2'] = 'Líneas: ';
		foreach($info_lineas as $linea):
			$response['hotspots'][$i]['line2'] .= $linea->nombre. ' ';
		endforeach;
		$response['hotspots'][$i]['attribution'] = trim(str_replace($codigo_ciudad.'.','',$response['hotspots'][$i]['attribution']));
}

// Put the JSON representation of $response into $jsonresponse.
$jsonresponse = json_encode( $response );
    
// Declare the correct content type in HTTP response header.
header( "Content-type: application/json; charset=utf-8" );
    
// Print out Json response.
echo $jsonresponse;

/* Close the MySQL connection.*/
    
// Set $db to NULL to close the database connection.
$db=null;
