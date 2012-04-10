<?php

	require_once 'functions.php';

	$url_info = "http://api.tubus.es/v1/json/-/ciudades/";
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
	
	$ciudades = $json->ciudades;
	curl_close($ch);
	
	foreach ($ciudades as $ciudad):
		$codigo = $ciudad->ciudad->codigo;
		$nombre = $ciudad->ciudad->nombre;
		
		echo "Obteniendo las lineas de ".$nombre."\n";
		
		//obtengo el listado de lineas de autobuses de una ciudad
		$url_info = "http://api.tubus.es/v1/json/".$codigo."/linea";
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
		
		$lineas = $json->linea;
		
		foreach($lineas as $linea):
			$nombre_linea = $linea->info->nombre;
			
			echo "\tObteniendo las paradas de la linea ".$nombre_linea." de ".$nombre."\n";
			
			//obtengo el listado de paradas de una linea de autobuses de una ciudad
			$url_info = "http://api.tubus.es/v1/json/".$codigo."/linea/".$nombre_linea."";
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
			
			$info_linea = $json->linea;
			
			$paradas_trayecto_ida = $info_linea->ida->trayecto;
			AddParada( $codigo, $nombre, $paradas_trayecto_ida );
			
			//si es circular, hago tambien la vuelta
			if($info_linea->info->circular==0){
				$paradas_trayecto_vuelta = $info_linea->vuelta->trayecto;
				AddParada( $codigo, $nombre, $paradas_trayecto_vuelta );
			}
			
		endforeach;		

	endforeach;
	
