<?php
/**
 * Libreria de funciones basicas para el control y correcto tratamiento de los datos que entran en nuestra aplicacion.
 * Dichas funciones se encargan de limpiar y validar tipos de datos asi como las variables proporcionadas por GET o POST
 * @package Input
 */ 
class Input
{
/**
 * Devuelve la variable GET cuyo nombre se especifica como parametro. Antes de devolver la variable
 * se realiza la sanitizacion de la misma para evitar que el usuario introduzca dato malintencionados
 * @param string Nombre de la variable GET a devolver
 * @param string tipo de sanitizacion que se le realiza a la variable antes de devolverla
 * @return string varibale GET solicitada y sanitizada o false en caso de que no exista
 */ 	
public static function get_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_GET[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
	}
/**
 * Devuelve la variable POST cuyo nombre se especifica como parametro. Antes de devolver la variable
 * se realiza la sanitizacion de la misma para evitar que el usuario introduzca dato malintencionados
 * @param string Nombre de la variable POST a devolver
 * @param string tipo de sanitizacion que se le realiza a la variable antes de devolverla
 * @return string varibale POST solicitada y sanitizada o false en caso de que no exista
 */ 		
public static function post_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_POST[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
/**
 * Devuelve la variable COOKIE cuyo nombre se especifica como parametro. Antes de devolver la variable
 * se realiza la sanitizacion de la misma
 * @param string Nombre de la variable COOKIE a devolver
 * @param string tipo de sanitizacion que se le realiza a la variable antes de devolverla
 * @return string varibale COOKIE solicitada y sanitizada o false en caso de que no exista
 */ 
public static function cookie_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_COOKIE[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
/**
 * Devuelve la variable SERVER cuyo nombre se especifica como parametro. Antes de devolver la variable
 * se realiza la sanitizacion de la misma
 * @param string Nombre de la variable SERVER a devolver
 * @param string tipo de sanitizacion que se le realiza a la variable antes de devolverla
 * @return string varibale SERVER solicitada y sanitizada o false en caso de que no exista
 */ 
public static function server_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_SERVER[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
/**
 * Devuelve la variable ENV cuyo nombre se especifica como parametro. Antes de devolver la variable
 * se realiza la sanitizacion de la misma
 * @param string Nombre de la variable ENV a devolver
 * @param string tipo de sanitizacion que se le realiza a la variable antes de devolverla
 * @return string varibale ENV solicitada y sanitizada o false en caso de que no exista
 */ 
public static function env_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_ENV[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
/**
 * Devuelve la variable REQUEST cuyo nombre se especifica como parametro. Antes de devolver la variable
 * se realiza la sanitizacion de la misma
 * @param string Nombre de la variable REQUEST a devolver
 * @param string tipo de sanitizacion que se le realiza a la variable antes de devolverla
 * @return string varibale REQUEST solicitada y sanitizada o false en caso de que no exista
 */ 
public static function request_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_REQUEST[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
/**
 * Funcion que sanitiza todas las variables enviadas mediante GET por el usuario
 * @param string Si se especifica el nombre de una variable GET solo devuelve dicha variable sanitizada o false en caso de que no exista.
 * @return mixed Devuelve un array con las variables GET o una sola variable (string) o false
 */ 	
public static function _GET($var_name = null)
{
	if($var_name != null){
		return Input::get_var($var_name);
	}
		$get_data = array();
		$keys = array_keys($_GET);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}

/**
 * Funcion que sanitiza todas las variables enviadas mediante POST por el usuario
 * @param string Si se especifica el nombre de una variable POST solo devuelve dicha variable sanitizada o false en caso de que no exista.
 * @return mixed Devuelve un array con las variables POST o una sola variable (string) o false
 */ 
public static function _POST($var_name = null)
{
	if($var_name != null){
		return Input::post_var($var_name);
	}
		$get_data = array();
		$keys = array_keys($_POST);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_POST[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}
/**
 * Funcion que sanitiza todas las variables SERVER
 * @param string Si se especifica el nombre de una variable SERVER solo devuelve dicha variable sanitizada o false en caso de que no exista.
 * @return mixed Devuelve un array con las variables SERVER o una sola variable (string) o false
 */ 
public static function _SERVER($var_name = null)
{
	if($var_name != null){
		return Input::server_var($var_name);
	}
		$get_data = array();
		$keys = array_keys($_SERVER);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_SERVER[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}
/**
 * Funcion que sanitiza todas las variables ENV
 * @param string Si se especifica el nombre de una variable ENV solo devuelve dicha variable sanitizada o false en caso de que no exista.
 * @return mixed Devuelve un array con las variables ENV o una sola variable (string) o false
 */ 
public static function _ENV($var_name = null)
{
	if($var_name != null){
		return Input::env_var($var_name);
	}
	
		$get_data = array();
		$keys = array_keys($_ENV);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_ENV[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}
/**
 * Funcion que sanitiza todas las variables REQUEST
 * @param string Si se especifica el nombre de una variable REQUEST solo devuelve dicha variable sanitizada o false en caso de que no exista.
 * @return mixed Devuelve un array con las variables REQUEST o una sola variable (string) o false
 */ 
public static function _REQUEST($var_name = null)
{
	if($var_name != null){
		return Input::request_var($var_name);
	}
	
		$get_data = array();
		$keys = array_keys($_REQUEST);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_REQUEST[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}
/**
 * Funcion que valida una cadena como una direccion de correo electronico.
 * @param string Cadena que se quiere validad como correo electrónico.
 * @return string Devuelve la direccion de correo electronico sanitizada o false en caso de que no sea valida.
 */ 	
public static function validate_email($email)
{
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
			if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
				return $sanitized_email;
			}
			else
			{
				return false;
			}

}
/**
 * Funcion que valida una variable como un numero flotante.
 * @param float Numero que se quiere validar como flotante.
 * @return float Devuelve el numero flotante sanitizado o false en caso de que no sea valido.
 */ 	
public static function validate_float($float)
{
		$sanitized_float = filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			if (filter_var($sanitized_float, FILTER_VALIDATE_FLOAT)) {
				return (float) $sanitized_float;
			}
			else
			{
				return false;
			}

}

/**
 * Funcion que valida una variable como un numero entero.
 * @param int Numero que se quiere validar como entero.
 * @return int Devuelve el numero entero sanitizado o false en caso de que no sea valido.
 */ 
public static function validate_int($int)
{
		$sanitized_int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
			if (filter_var($sanitized_int, FILTER_VALIDATE_INT)) {
				return (int) $sanitized_int;
			}
			else
			{
				return false;
			}

}	
/**
 * Funcion que valida una cadena como una direccion URI.
 * @param string Cadena que se quiere validad como URI.
 * @return string Devuelve la direccion URI sanitizada o false en caso de que no sea valida.
 */ 
public static function validate_url($url)
{
		$sanitized_url = filter_var($url, FILTER_SANITIZE_URL);
			if (filter_var($sanitized_url, FILTER_VALIDATE_URL)) {
				return (string) $sanitized_url;
			}
			else
			{
				return false;
			}

}	
/**
 * Funcion que valida una cadena como una direccion IP.
 * @param string Cadena que se quiere validad como IP.
 * @return string Devuelve la direccion IP sanitizada o false en caso de que no sea valida.
 */ 	
public static function validate_ip($ip)
{
		
			if (filter_var($ip, FILTER_VALIDATE_IP)) {
				return $ip;
			}
			else
			{
				return false;
			}

}
/**
 * Funcion que valida una variable como un boleano.
 * @param boolean Variable que se quiere validar como boleana.
 * @return boolean Devuelve la variable boleana o false en caso de que no sea valido.
 */ 
public static function validate_boolean($boolean)
{
			return filter_var($boolean, FILTER_VALIDATE_BOOLEAN);
}
/**
 * Funcion que sanitiza una URL realizando un urlencode de los caracteres
 * @param string Cadena a la que vamos a realizar un urlencode
 * @return string Cadena con urlencode realizado
 */ 
public static function url_encode($string)
{
		return filter_var($string, FILTER_SANITIZE_ENCODED);
}
/**
 * Funcion que sanitiza una cadena de caracteres
 * @param string Cadena a la que vamos a realizar el sanitizado
 * @return string Cadena con sanitizado realizado
 */ 
public static function validate_string($string)
{
		return filter_var($string, FILTER_SANITIZE_STRING);
}
/**
 * Funcion que valida una variable como array
 * @param mixed Variable que queremos validar como array
 * @return boolean true si es un un array y false en caso contrario
 */ 	
public static function validate_array($var, $type = null)
{
		return is_array($var);
}
/**
 * Funcion que sanitza una cadena para ser guardada en una base de datos, escapando sus caracteres especiales
 * @param string Cadena a sanitizar
 * @return string Cadena sanitizada
 */ 	
public static function magic_quotes($string)
{
		return filter_var($string, FILTER_SANITIZE_MAGIC_QUOTES);
}


}
