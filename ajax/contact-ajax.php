<?php
require_once '../system.php';
//require_once '../libs/rober.php';
require_once '../libs/'.$configuracion['conector'];
require_once '../libs/functions.php';
require_once '../libs/dbconnect.php';


$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$comentario = $_POST['mensaje'];
$user = $_POST['userid'];
$ip = $_POST['ip'];
$date_added = date('Y-m-d G:i:s');
$cabeceras = 'From: contacto@tubus.es' . "\r\n" .
    'Reply-To: '. $correo . "\r\n";

$mensaje = '';
$error = 0;

//Verifico que los datos llegan correctamente
if(strlen($nombre)<3||is_numeric($nombre)){
	$mensaje.='El nombre utilizado no es válido.<br />';
	$error = 1;
}

if(!preg_match('/(^[0-9a-zA-Z]+(?:[._][0-9a-zA-Z]+)*)@([0-9a-zA-Z]+(?:[._-][0-9a-zA-Z]+)*\.[0-9a-zA-Z]{2,3})$/',$correo)){
	$mensaje.='La dirección de e-mail utilizada parece no ser válida.<br />';
	$error = 1;
}

if(strlen($comentario)<3){
	$mensaje.='Por favor, utilice una descripción más detallada del mensaje que quiere hacernos llegar.<br />';
	$error = 1;
}



if($error==1)
	echo $mensaje.'Por favor, vuelva a intentarlo';
else{
	$sql = "INSERT INTO mensajes(nombre, mail, mensaje, date_added, ip, userid) VALUES ('$nombre','$correo','$comentario','$date_added','$ip','$user')";
	mysql_query($sql);
	mail('contacto@tubus.es','Tubus.es: Ha recibido una nueva consulta',
	"El usuario $nombre ha enviado una consulta desde Tubus.es\n\nSus datos de contacto son:\n - Nombre: $nombre \n - Correo: $correo \n - Mensaje: $comentario \n\nPor favor, contestar con la mayor brevedad posible.", $cabeceras);
	echo "$nombre, tu consulta ha sido enviada correctamente. Muchas gracias";
	//echo "$sql";
}
?>
