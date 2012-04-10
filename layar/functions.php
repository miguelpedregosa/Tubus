<?php

function AddParada( $codigo, $ciudad, $paradas ){
	if(empty($paradas)) return;
	
	$dbhost = "localhost";
	$dbdata = "tubus_layar";
	$dbuser = ""; //Usuario
	$dbpass = ""; //Contraseña
	
	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	if (!$link) {
		return false;
	}

	$db_selected = mysql_select_db($dbdata, $link);
	if (!$db_selected) {
		return false;
	}
	
	foreach($paradas as $parada):
		//tengo que comprobar que no esté ya en BD
		$sql = "SELECT id FROM POI_Table WHERE attribution = '".$ciudad.". Parada ".$parada->parada->info->numero."' LIMIT 1";
		$res = mysql_query($sql,$link);
		
		if(mysql_num_rows($res)==0){	
			echo "\t\tInsertando la parada ".$parada->parada->info->numero." de ".$ciudad."\n";		
			$sql_insert = "INSERT INTO POI_Table (attribution, title, lat, lon, imageURL, line4, line3, line2, type, dimension, alt, relativeAlt, distance, inFocus, doNotIndex, showSmallBiw, showBiwOnClick) 
			VALUES ('".$codigo.". Parada ".$parada->parada->info->numero."', '".utf8_decode($parada->parada->info->nombre)."', '".$parada->parada->location->latitud."', '".$parada->parada->location->longitud."', 'http://beta.tubus.es/layar/images/tubus64.png', '".utf8_decode($parada->parada->info->direccion)."', 'Distancia:%distance%', '', 1, 1, NULL, NULL, '0.0000000000', 0,0, 1, 1)";
			$res_insert = mysql_query($sql_insert, $link);	
			$id = mysql_insert_id($link);
			
			echo "\t\tInsertando las acciones en la parada ".$parada->parada->info->numero." de ".$ciudad."\n";		
			$sql_insert_action = "INSERT INTO ACTION_Table 
			(poiID, label, uri, autoTriggerRange, autoTriggerOnly, contentType, method, activityType, params, closeBiw, showActivity) 
			VALUES 
			('".$id."','".utf8_decode('Próximos autobuses')."', 'http://".$codigo.".tubus.es/".$parada->parada->info->numero."#datos_parada', '0', '0', 'text/html', 'GET', '1', 'lat,lon', '0', '0')";
			$res_insert_action = mysql_query($sql_insert_action, $link);
		}
		/*else{
			echo "\t\tActualizando la parada ".$parada->parada->info->numero." de la linea ".$nombre_linea." de ".$ciudad."\n";		
			$sql = "Update POI_Table set attribution='".$ciudad.". Parada ".$parada->parada->info->numero."', title='".$parada->parada->info->nombre."', lat='".$parada->parada->location->latitud."', lon='".$parada->parada->location->longitud."', imageURL='http://beta.tubus.es/layar/images/tubus64.png', line4='<a href=\"".$parada->parada->info->url."\>".$parada->parada->info->direccion."</a>', line3='Distancia:%distance%', line2='', type=1, dimension=1, alt=NULL, relativeAlt=NULL, distance='250.0000000000', inFocus=0, doNotIndex=0, showSmallBiw=1, showBiwOnClick=1 WHERE id = '".$pois[0]['id']."'";
		}*/
		endforeach;
		
		mysql_close($link);
 
}

// Change a string value to float
//
// Arguments:
//   string ; A string value.
//
// Returns:
//   float ; If the string is empty, return NULL.
//
function ChangetoFloat( $string ) {

  if ( strlen( trim( $string ) ) != 0 ) {
 
    return (float)$string;
  }
  else
      return NULL;
}//ChangetoFloat

// Change a string value to integer.
//
// Arguments:
//   string ; A string value.
//
// Returns:
//   Int ; If the string is empty, return NULL.
//
function ChangetoInt( $string ) {

  if ( strlen( trim( $string ) ) != 0 ) {
 
    return (int)$string;
  }
  else
      return NULL;
}//ChangetoInt

// Convert a decimal GPS latitude or longitude value to an integer by multiplying by 1000000.
//
// Arguments:
//   value_Dec ; The decimal latitude or longitude GPS value.
//
// Returns:
//   int ; The integer value of the latitude or longitude.
//
function ChangetoIntLoc( $value_Dec ) {

  return $value_Dec * 1000000;
 
}//ChangetoIntLoc

//Convert a TinyInt value to a boolean value TRUE or FALSE
//
// Arguments:
//   value_Tinyint ; The Tinyint value (0 or 1) of a key in the database.
//
// Returns:
//     value_Bool ; The boolean value, return 'TRUE' when Tinyint is 1. Return 'FALSE' when Tinyint is 0.
//
function ChangetoBool( $value_Tinyint ) {
 
  if ( $value_Tinyint == 1 )
      $value_Bool = TRUE;
  else
      $value_Bool = FALSE;
    
  return $value_Bool;
 
}//ChangetoBool

// Put fetched actions for each POI into an associative array. The returned values are assigned to $poi[actions].
//
// Arguments:
//   poi ; The POI handler.
//   $db ; The database connection handler.
//
// Returns:
//   array ; An array of received actions for this POI.
//
function Getactions( $poi, $db ) {
 
  // A new table called "ACTION_Table" is created to store actions, each action has a field called
  // "poiID" which shows the POI id that this action belongs to.
  // The SQL statement returns actions which have the same poiID as the id of $poi ($poi['id']).
  $sql_actions = $db->prepare( " SELECT label,
                                                                 uri,
                                                                 autoTriggerRange,
                                                                 autoTriggerOnly,
                                                                 contentType,
                                                                 method,
                                                                 activityType,
                                                                 params,
                                                                 closeBiw,
                                                                 showActivity,
                                                                 activityMessage
                                                    FROM ACTION_Table
                                                    WHERE poiID = :id " );
                                 
  // Binds the named parameter markers ":id" to the specified parameter values "$poi['id']".                               
  $sql_actions->bindParam( ':id', $poi['id'], PDO::PARAM_INT );
    
  // Use PDO::execute() to execute the prepared statement $sql_actions.
  $sql_actions->execute();
 
  // Iterator for the $poi["actions"] array.
  $count = 0;
    
  // Fetch all the poi actions.
  $actions = $sql_actions->fetchAll( PDO::FETCH_ASSOC );
 
  /* Process the $actions result */
 
  // if $actions array is empty, return empty array.
  if ( empty( $actions ) ) {
 
      $poi["actions"] = array();
      
  }//if
  else {
      
      // Put each action information into $poi["actions"] array.
      foreach ( $actions as $action ) {
        
        // Assign each action to $poi["actions"] array.
        $poi["actions"][$count] = $action;
      
      // put 'params' into an array of strings
      $paramsArray = array();


      if ( substr_count( $action['params'],',' ) ) {
          $paramsArray = explode( ",", $action['params'] );
      }//if
      else if( strlen( $action['params'] ) ) {
          $paramsArray[0] = $action['params'];
      }


      $poi["actions"][$count]['params'] = $paramsArray;
      
      // Change 'activityType' to Integer.
      $poi["actions"][$count]['activityType'] = ChangetoInt( $poi["actions"][$count]['activityType'] );
      
      // Change the values of "closeBiw" into boolean value.
      $poi["actions"][$count]['closeBiw'] = ChangetoBool( $poi["actions"][$count]['closeBiw'] );
      
      // Change the values of "showActivity" into boolean value.
      $poi["actions"][$count]['showActivity'] = ChangetoBool( $poi["actions"][$count]['showActivity'] );
      
      // Change 'autoTriggerRange' to Integer, if the value is NULL, return NULL.
      $poi["actions"][$count]['autoTriggerRange'] = ChangetoInt( $poi["actions"][$count]['autoTriggerRange'] );
      
      // Change the values of "autoTriggerOnly" into boolean value,if the value is NULL, return NULL.
      $poi["actions"][$count]['autoTriggerOnly'] = ChangetoBool( $poi["actions"][$count]['autoTriggerOnly'] );
      
      $count++;
        
    }// foreach
   
   }//else
   
   return $poi["actions"];

}//Getactions

function Gethotspots( $db, $value ) {

/* Create the SQL query to retrieve POIs within the "radius" returned from GetPOI request.
       Returned POIs are sorted by distance and the first 50 POIs are selected.
       The distance is caculated based on the Haversine formula.
       Note: this way of calculation is not scalable for querying large database.
*/
    
  // Use PDO::prepare() to prepare SQL statement.
  // This statement is used due to security reasons and will help prevent general SQL injection attacks.
  // ":lat1", ":lat2", ":long" and ":radius" are named parameter markers for which real values
  // will be substituted when the statement is executed.
  // $sql is returned as a PDO statement object.
  $sql = $db->prepare( "
              SELECT id,
                     attribution,
                     title,
                     lat,
                     lon,
                     imageURL,
                     line4,
                     line3,
                     line2,
                     type,
                     dimension,
                     (((acos(sin((:lat1 * pi() / 180)) * sin((lat * pi() / 180)) +
                         cos((:lat2 * pi() / 180)) * cos((lat * pi() / 180)) *
                       cos((:long  - lon) * pi() / 180))
                      ) * 180 / pi()) * 60 * 1.1515 * 1.609344 * 1000) as distance
            FROM POI_Table
            HAVING distance < :radius
            ORDER BY distance ASC
            LIMIT 0, 50 " );

  // PDOStatement::bindParam() binds the named parameter markers to the specified parameter values.
  $sql->bindParam( ':lat1', $value['lat'], PDO::PARAM_STR );
  $sql->bindParam( ':lat2', $value['lat'], PDO::PARAM_STR );
  $sql->bindParam( ':long', $value['lon'], PDO::PARAM_STR );
  $sql->bindParam( ':radius', $value['radius'], PDO::PARAM_INT );
    
  // Use PDO::execute() to execute the prepared statement $sql.
  $sql->execute();
    
  // Iterator for the response array.
  $i = 0;
 
  // Use fetchAll to return an array containing all of the remaining rows in the result set.
  // Use PDO::FETCH_ASSOC to fetch $sql query results and return each row as an array indexed by column name.
  $pois = $sql->fetchAll(PDO::FETCH_ASSOC);
 
  /* Process the $pois result */
 
  // if $pois array is empty, return empty array.
  if ( empty($pois) ) {
      
      $response["hotspots"] = array ();
    
  }//if
  else {
      
      // Put each POI information into $response["hotspots"] array.
     foreach ( $pois as $poi ) {
        
        // If not used, return an empty actions array.
        //$poi["actions"] = array();
        $poi["actions"] = Getactions ( $poi, $db );
        
        // Store the integer value of "lat" and "lon" using predefined function ChangetoIntLoc.
        $poi["lat"] = ChangetoIntLoc( $poi["lat"] );
        $poi["lon"] = ChangetoIntLoc( $poi["lon"] );
    
         // Change to Int with function ChangetoInt.
        $poi["type"] = ChangetoInt( $poi["type"] );
        $poi["dimension"] = ChangetoInt( $poi["dimension"] );
    
        // Change to demical value with function ChangetoFloat
        $poi["distance"] = ChangetoFloat( $poi["distance"] );
    
        // Put the poi into the response array.
        $response["hotspots"][$i] = $poi;
        $i++;
      }//foreach
 
  }//else
 
  return $response["hotspots"];
}//Gethotspots
