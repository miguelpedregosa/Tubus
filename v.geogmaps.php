<?php

require_once '/home/tubus/httpdocs/m.tubus.es/conf_v.tubus.es_.php';
require_once '/home/tubus/httpdocs/m.tubus.es/libs/text.php';

$link = mysql_connect($configuracion['bd_servidor'], $configuracion['bd_usuario'], $configuracion['bd_password']);
if (!$link) {
    die('No conectado: ' . mysql_error());
}

$db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
if (!$db_selected) {
    die ('No se puede usar tubus: ' . mysql_error());
}


if(!isset($_REQUEST['parada'])){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geolocalización de paradas usando Google Maps</title>
<script src="http://tubus.es/js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
var geocoder;
var map;
var markersArray = [];

  
function initialize() {
    geocoder = new google.maps.Geocoder(); 
    var latlng = new google.maps.LatLng(39.4753, -0.3789);
    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeControl: false,
      streetViewControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map"), myOptions);
    
  
  google.maps.event.addListener(map, 'dblclick', function(event) {
    //Borrar todos los marcadores que haya en el mapa
    if (markersArray) {
        for (i in markersArray) {
        markersArray[i].setMap(null);
        }
        markersArray.length = 0;
  }
    //Añado el nuevo
    var marker = new google.maps.Marker({
      position: event.latLng, 
      map: map
    });
    //Lo guardo en la matriz
    markersArray.push(marker);
    //map.setCenter(event.latLng);
    //alert(event.latLng);
    document.gdatos.latitud.value = event.latLng.lat();
    document.gdatos.longitud.value = event.latLng.lng();
  });
    google.maps.event.addListener(map, 'pov_changed', function() {
      alert('hola');
  });
  }
  
function codeAddress() {
    var address = document.getElementById("address").value;
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //Borrar todos los marcadores que haya en el mapa
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
                    markersArray.length = 0;
            }
            
            
          map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
              map: map, 
              position: results[0].geometry.location
          });
            markersArray.push(marker);
            document.gdatos.latitud.value = results[0].geometry.location.lat();
            document.gdatos.longitud.value = results[0].geometry.location.lng();
          
        } else {
          alert("Geocode was not successful for the following reason: " + status);
        }
      });
    }
  }
  

</script>

</head>

<body onload="initialize()">


<h1>Geolocalización de paradas usando Google Maps</h1>
<!--
<h2>Geolocalizar usando un enlace</h2>
<p>Intrucciones de uso:</p>
<ol>
  <li>Abrir Google Maps y buscar la localización de la parada con la mayor exactitud posible, usar el mayor nivel de zoom y la vista Street View si es necesario.</li>
  <li>Centrar el mapa en la posición que queremos usar como coordenadas.</li>
  <li>Hacer clic en <em>Enlazar</em> y copiar el enlace que aparece en la primera página.</li>
  <li>Seleccionar la parada que se desea geolocalizar en el seleccionable. Solo aparecerán las paradas no bloquedas en el sistema.</li>
  <li>Pegar el enlace copiado en el paso 3.</li>
  
  <li>Marcamos si queremos bloquear la parada al guardar la localización.</li>
  <li>Hacemos clic en <strong>Enviar datos</strong>.</li>
</ol>
<p>&nbsp;</p>

<form id="form1" name="form1" method="post" action="v.geogmaps.php">
<table width="100%" border="0">
  <tr>
    <th width="21%" scope="row"><div align="justify">Parada</div></th>
    <td width="79%"><div align="justify">
       <?php
        $sql = "SELECT id_parada, nombre, label FROM paradas WHERE blocked <> 1 ORDER BY nombre ASC";
        $res = mysql_query($sql);
        if(mysql_num_rows($res) > 0){
        ?>
      <select name="parada" id="parada">
       <?php while ($datos = mysql_fetch_array($res)) { ?>
        <option value="<?=$datos['id_parada']?>"><?=$datos['nombre']?> - <?php echo utf8_encode($datos['label'])?></option>
        <?php } ?>
        
      </select>
      <?php } ?>
      
      </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">URL de Google Maps </div></th>
    <td><div align="justify">
      <input name="url" type="text" id="url" size="100" />
    </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify"></div></th>
    <td><div align="justify"></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Bloquear parada </div></th>
    <td><div align="justify">
      <input name="bloquear" type="checkbox" id="bloquear" value="true" />
    </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify"></div></th>
    <td><div align="justify">
      <input type="submit" name="Submit" value="Enviar datos" />
    </div></td>
  </tr>
</table>
</form>
-->
<h2>Geolocalizar usando <em>lat, long</em></h2>
<p>Intrucciones de uso:</p>
<ol>
  <li>Buscar la latitud y longitud del punto exacto donde queremos ubicar la parada y copiar el formato latitud, longitud</li>
  <li>Seleccionar la parada que queremos ubicar</li>
  <li>Marcamos si queremos bloquear la parada al guardar la localización.</li>
  <li>Hacemos clic en <strong>Enviar datos</strong>.</li>
</ol>
<form id="form1" name="form1" method="post" action="v.geogmaps.php">
<table width="100%" border="0">
  <tr>
    <th width="21%" scope="row"><div align="justify">Parada</div></th>
    <td width="79%"><div align="justify">
       <?php
        $sql = "SELECT id_parada, nombre, label FROM paradas WHERE blocked <> 1 ORDER BY nombre ASC";
        $res = mysql_query($sql);
        if(mysql_num_rows($res) > 0){
        ?>
      <select name="parada" id="parada">
       <?php while ($datos = mysql_fetch_array($res)) { ?>
        <option value="<?=$datos['id_parada']?>"><?=$datos['nombre']?> - <?php echo utf8_encode($datos['label'])?></option>
        <?php } ?>
        
      </select>
      <?php } ?>
      
      </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Coordenadas decimales (lat,long) </div></th>
    <td><div align="justify">
      <input name="coordenadas" type="text" id="coordenadas" size="100" />
    </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify"></div></th>
    <td><div align="justify"></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Bloquear parada </div></th>
    <td><div align="justify">
      <input name="bloquear" type="checkbox" id="bloquear" value="true" />
    </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify"></div></th>
    <td><div align="justify">
      <input type="submit" name="Submit" value="Enviar datos" />
    </div></td>
  </tr>
</table>
</form>


<h2>Geolocalizar usando el mapa</h2>
<p>Intrucciones de uso:</p>
<ol>
  <li>Buscar en el mapa siguiente, bien a ojo o usando la caja de búsqueda la localización que deseamos usar</li>
  <li>Con doble clic establecemos el punto exacto del mapa que queremos usar, aparecerá una marca (No funciona el doble clic en Street View)</li>
  <li>Para cambiar la marca (si es necesario) hacer doble clic en cualquier otro punto del mapa. Las coordenadas deben cambiar</li>
  <li>Seleccionar la parada que se desea geolocalizar en el seleccionable. Solo aparecerán las paradas no bloquedas en el sistema.</li>
  <li>Marcamos si queremos bloquear la parada al guardar la localización.</li>
  <li>Hacemos clic en <strong>Enviar datos</strong>.</li>
</ol>
 <div>
 Buscar en el mapa: 
    <input id="address" type="textbox" value="">
    <input type="button" value="Buscar" onclick="codeAddress()">
  </div>
  <p>&nbsp;</p>
<div align="center" id="map" style="width: 65%; height: 400px; text-align:center;"></div>
<div>
<form id="gdatos" name="gdatos" method="post" action="v.geogmaps.php">
<table width="100%" border="0">
  <tr>
    <th width="21%" scope="row"><div align="justify">Parada</div></th>
    <td width="79%"><div align="justify">
       <?php
        $sql = "SELECT id_parada, nombre, label FROM paradas WHERE blocked <> 1 ORDER BY nombre ASC";
        $res = mysql_query($sql);
        if(mysql_num_rows($res) > 0){
        ?>
      <select name="parada" id="parada">
      <option value="-1">Selecciona una parada de la lista ...</option>
       <?php while ($datos = mysql_fetch_array($res)) { ?>
        <option value="<?=$datos['id_parada']?>"><?=$datos['nombre']?> - <?php echo utf8_encode($datos['label'])?></option>
        <?php } ?>
        
      </select>
      <?php } ?>
      
      </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Latitud</div></th>
    <td><div align="justify">
      <input name="latitud" type="text" id="latitud" size="20" />
    </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Longitud</div></th>
    <td><div align="justify">
      <input name="longitud" type="text" id="longitud" size="20" />
    </div></td>
  </tr>
    <th scope="row"><div align="justify">Bloquear parada </div></th>
    <td><div align="justify">
      <input name="bloquear" type="checkbox" id="bloquear" value="true" />
    </div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify"></div></th>
    <td><div align="justify">
      <input type="submit" name="Submit" value="Enviar datos" />
    </div></td>
  </tr>
</table>
</form>
</div>


</body>
</html>





<?php    
}
else{
    //print_r($_REQUEST);
    //die;
    $id_parada = $_REQUEST['parada'];
   if(isset($_REQUEST['latitud']) && isset($_REQUEST['longitud'])){
    $lat = (float)$_REQUEST['latitud'];
    $long = (float)$_REQUEST['longitud'];
    $bloquear = $_REQUEST['bloquear'];
    }
    else if(isset($_REQUEST['coordenadas']))
    {
        //Me han pasado las coordenadas en formato lat, lang
        $bloquear = $_REQUEST['bloquear'];
        $dat = explode(',', trim($_REQUEST['coordenadas']));
        $lat = (float)trim($dat[0]);
        $long = (float)trim($dat[1]);
    }
    else{
    $url_google = $_REQUEST['url'];
    $bloquear = $_REQUEST['bloquear'];
    $lat = 0;
    $long = 0;
    
    //http://maps.google.es/?ie=UTF8&hq=&hnear=Granada,+Andaluc%C3%ADa&ll=37.176487,-3.597929&spn=0.166046,0.330276&z=12
    //$patron = '<div class="texto">[[:space:]]*[[:alpha:][:digit:][:punct:][:space:]áéíóúñÁÉÍÓÚÑàèìòùÀÈÌÒÙäëïöüÄËÏÖÜ\'çÇâêîôûÂÊÎÔÛ·\(\)\{\}\$%&-_\?¿¡!\*\^]*</p>(<p>|[[:space:]]*<div class="oferta_especial">)';
    $patron = '&cbll=([0-9\.-]*,[0-9\.-]*)';
   //echo $url_google;
	if (eregi($patron, $url_google, $segmentos)) {
		$coordenadas = $segmentos[1];
        $datos = explode(',',$coordenadas);
        $lat = (float)$datos[0];
        $long = (float)$datos[1];
        
    }
    else{
       $patron = '&ll=([0-9\.-]*,[0-9\.-]*)';
        if (eregi($patron, $url_google, $segmentos)) {
            $coordenadas = $segmentos[1];
            $datos = explode(',',$coordenadas);
            $lat = (float)$datos[0];
            $long = (float)$datos[1];
        
    }
        
    }
    
    
    
    
    
    //echo $lat.'<hr />'.$long;
    //die;
}
   if($lat != 0 && $long != 0){
       //Guardo los datos en la base de datos
       if($bloquear == "true")
            $sql = "UPDATE paradas SET latitud = '".$lat."', longitud = '".$long."', blocked = 1 WHERE id_parada = '".$id_parada."' AND blocked = 0 LIMIT 1";
        else
            $sql = "UPDATE paradas SET latitud = '".$lat."', longitud = '".$long."' WHERE id_parada = '".$id_parada."' AND blocked = 0 LIMIT 1";

        $res = mysql_query($sql);
        
        if($res){
            $sql2 = "SELECT id_parada, nombre, label FROM paradas WHERE id_parada = '".$id_parada."' LIMIT 1";
        $res2 = mysql_query($sql2);
        $datos = mysql_fetch_array($res2);
 ?>           
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geolocalización de paradas usando Google Maps</title>
</head>

<body>
<h1>Geolocalización de paradas usando Google Maps</h1>
<p>Se ha almacenado con éxito la siguiente parada en la base datos</p>
<table width="100%" border="0">
  <tr>
    <th width="21%" scope="row"><div align="justify">Parada</div></th>
    <td width="79%"><div align="justify"><?=$datos['nombre']?> - <?php echo utf8_encode($datos['label'])?></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Latitud</div></th>
    <td><div align="justify"><?=$lat?></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">Longitud</div></th>
    <td><div align="justify"><?=$long?></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify">URL </div></th>
    <td><div align="justify"><a target="_blank" href="http://v.tubus.es/<?=$datos['nombre']?>">http://v.tubus.es/<?=$datos['nombre']?></a></div></td>
  </tr>
  <tr>
    <th scope="row"><div align="justify"></div></th>
    <td><div align="justify"><a href="v.geogmaps.php">[[Localizar otra parada]] </a></div></td>
  </tr>
</table>
</body>
</html>
<?php
            
        }
        else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geolocalización de paradas usando Google Maps</title>
</head>

<body>
<h1>Geolocalización de paradas usando Google Maps</h1>
<p>Ha ocurrido un error al localizar la parada. <a href="v.geogmaps.php">[[Volver a intentar]] </a></p>
</body>
</html>
<?php                   
        }    
        
       
       
   }
   
   
    
}    
