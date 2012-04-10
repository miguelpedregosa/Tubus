<?php
ob_start();
ob_implicit_flush(0);

function comprobarCompresion(){
	//global $HTTP_ACCEPT_ENCODING;
	$codificacion_aceptada = ($_SERVER['HTTP_ACCEPT_ENCODING']);
	if (headers_sent() || connection_status() || connection_aborted()){
		return 0;
	}
	if (strpos($codificacion_aceptada, 'x-gzip') !== false) return "x-gzip";
	if (strpos($codificacion_aceptada,'gzip') !== false) return "gzip";
	return 0;
}

function comprimirDocumento($nivel=6,$debug=0){
	$ENCODING = comprobarCompresion();
	if ($ENCODING){
		$Contents = ob_get_contents();
		ob_end_clean();
		if ($debug){
			$s = "<p>Tamaño de pagina no comprimida: ".strlen($Contents);
			$s .= "<br>Tamaño de pagina comprimida: ".strlen(gzcompress($Contents,$nivel));
			$Contents .= $s;
		}
		header("Content-Encoding: $ENCODING");
		print "\x1f\x8b\x08\x00\x00\x00\x00\x00";
		$Size = strlen($Contents);
		$Crc = crc32($Contents);
		$Contents = gzcompress($Contents,$nivel);
		$Contents = substr($Contents, 0, strlen($Contents) - 4);
		print $Contents;
		print pack('V',$Crc);
		print pack('V',$Size);
		exit;
	}else{
		ob_end_flush();
		exit;
	}
}
?>
