<?php
require_once "dbconnect.php";
require_once "functions.php";

function obtener_paradas_lineas($id_linea, $sentido = 1){
	global $link;
	$paradas = array();
	
	//Lo primero es obtener los identificadores de los recorridos de la linea
	$sql = "SELECT * FROM lineas WHERE nombre = '".$id_linea."' LIMIT 1";
	$res = mysql_query($sql);
	
	if(mysql_num_rows($res) != 1)
		return false;
	$datos = mysql_fetch_array($res);
	
	
	$sql_trayectos = "SELECT * FROM trayectos WHERE id_linea = '".$datos['id_linea']."'";
	
	$res2 = mysql_query($sql_trayectos);
	$num_t = mysql_num_rows($res2);
	if($num_t == 0)
		return false;
		
	if($sentido >$num_t)
		$sentido = 1;
	
	$fila_index = $sentido -1 ;
	mysql_data_seek($res2, $fila_index);
	
	$fila = mysql_fetch_array($res2);
	
	$id_sentido = $fila['id_trayecto'];
	
	$sql_t = "SELECT * FROM trayectos_a_paradas WHERE id_trayecto = '".$id_sentido."' ORDER BY posicion ASC ;";
	$res_t = mysql_query($sql_t);
	if(!$res_t)
		return false;
		
	while($row = mysql_fetch_array($res_t)){
		$parada=array();
		$parada['id'] = $row['id_parada'];
		$sqlp = "SELECT * FROM paradas WHERE id_parada = '".$row['id_parada']."' LIMIT 1;"; 
		$resp = mysql_query($sqlp);
		if($resp){
			$filap = mysql_fetch_array($resp);
			$parada['nombre'] = $filap['nombre'];
			$parada['label'] = utf8_encode($filap['label']);
			$lineas_p = obtener_lineas_parada($filap['nombre']);
			$parada['lineas'] = $lineas_p;
		}
        //print_r($filap);
        if($filap['virtual'] == 0){
            $paradas[] = $parada;
		}
	}
	return $paradas;
}

function obtener_info_linea($id_linea, $sentido = 1){
	global $link;
	$info = array();
	$sql = "SELECT * FROM lineas WHERE nombre = '".$id_linea."' LIMIT 1";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) != 1)
		return false;
	$datos = mysql_fetch_array($res);
	
	$linea = array();
			
	$linea['nombre'] = $datos['nombre'];
	$linea['color'] = $datos['color'];
	$linea['descripcion'] = $datos['descripcion'];
	
	if($datos['descripcion'] == '')
	{
		$sql2 = "SELECT * FROM trayectos t WHERE id_linea = '".$datos['id_linea']."' ORDER BY id_trayecto ASC LIMIT 1";

		$res2 = mysql_query($sql2);
		$trayect = mysql_fetch_assoc($res2);
		
		$linea['trayecto'] = utf8_encode($trayect['salida']).' - '.utf8_encode($trayect['llegada']);
		
	}
	else
	{
		$linea['trayecto'] = $datos['descripcion'];
	}
	
	$info['linea'] = $linea;
	$info['trayectos'] = array();
	//Ahora todos los trayectos al saco
	
	$sql3 = "SELECT * FROM trayectos t WHERE id_linea = '".$datos['id_linea']."' ORDER BY id_trayecto ASC";
	$res3 = mysql_query($sql3);

	$contador_trayecto = 1;
	while($fila_tra = mysql_fetch_assoc($res3))
	{
		if($contador_trayecto == $sentido)
		{
			$info['actual']['numero_trayecto'] = $sentido;
			
			$info['actual']['salida'] = $fila_tra['salida'];
			$info['actual']['llegada'] = $fila_tra['llegada'];
			
		}
		
		$data = array();
		$data['numero_trayecto'] = $contador_trayecto;
		$data['salida'] = $fila_tra['salida'];
		$data['llegada'] = $fila_tra['llegada'];
		$data['parada_salida'] = $fila_tra['id_parada_salida'];
		$data['parada_llegada'] = $fila_tra['id_parada_llegada'];
		
		array_push($info['trayectos'], $data);
		$contador_trayecto++;
		
	}


	/*
	if($sentido == 'b'){
		$id_actual = $datos['id_vuelta'];
		$id_contrario= $datos['id_ida'];
	}
	else{
		$id_actual = $datos['id_ida'];
		$id_contrario= $datos['id_vuelta'];
	}
	//Empiezo por el sentido dado
	$sql_a  = "SELECT * FROM trayectos WHERE id_trayecto =  '".$id_actual."' LIMIT 1;";
	$res_a = mysql_query($sql_a);
	if($res_a){
		$datos_a = mysql_fetch_array($res_a);
		$info['actual']['linea'] = $id_linea;
		$info['actual']['sentido'] = $sentido;
		$info['actual']['salida'] = utf8_encode($datos_a['salida']);
		$info['actual']['llegada'] = utf8_encode($datos_a['llegada']);
	}
	
	//Ahora por el sentido contrario
	$sql_c  = "SELECT * FROM trayectos WHERE id_trayecto =  '".$id_contrario."' LIMIT 1;";
	$res_c = mysql_query($sql_c);
	if($res_c){
		$datos_c = mysql_fetch_array($res_c);
		$info['contrario']['linea'] = $id_linea;
		if($sentido == 'a')
			$info['contrario']['sentido'] = 'b';
		else if($sentido == 'b')
			$info['contrario']['sentido'] = 'a';
			
		$info['contrario']['salida'] = utf8_encode($datos_c['salida']);
		$info['contrario']['llegada'] = utf8_encode($datos_c['llegada']);
	}
	*/
	return $info;
}

