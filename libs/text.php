<?php
function pasar_a_minusculas($cadena){
	$cadena = str_replace('Á', 'á', $cadena);
	$cadena = str_replace('É', 'é', $cadena);
	$cadena = str_replace('Í', 'í', $cadena);
	$cadena = str_replace('Ó', 'ó', $cadena);
	$cadena = str_replace('Ú', 'ú', $cadena);
	$cadena = str_replace('Ñ', 'ñ', $cadena);
	$cadena = str_replace('Ç', 'ç', $cadena);
	$cadena = str_replace('Ä', 'ä', $cadena);
	$cadena = str_replace('Ë', 'ë', $cadena);
	$cadena = str_replace('Ï', 'ï', $cadena);
	$cadena = str_replace('Ö', 'ö', $cadena);
	$cadena = str_replace('Ü', 'ü', $cadena);
	$cadena = str_replace('À', 'à', $cadena);
	$cadena = str_replace('È', 'è', $cadena);
	$cadena = str_replace('Ì', 'ì', $cadena);
	$cadena = str_replace('Ò', 'ò', $cadena);
	$cadena = str_replace('Ù', 'ù', $cadena);

	return strtolower($cadena);
}

function Makecamelcase($str){
    $str=pasar_a_minusculas(trim($str));
    $partes = explode(" ", $str);
    $cadena = '';
    for ($i = 0; $i < count($partes); $i++) {
        $txt = $partes[$i];
        if(strlen($txt) > 3)
            $txt = ucfirst($txt);
        $cadena .= $txt . " ";
    }
    
    return trim(ucfirst($cadena));
}
function corregir_titulo($nombre){
	
	$nombre = strtolower($nombre);
	$nombre = str_replace('Ñ','ñ',$nombre);
	$nombre = ucwords($nombre);
	$nombre = str_replace('Zaidin', 'Zaidín', $nombre);
	
	return $nombre;
}
?>
