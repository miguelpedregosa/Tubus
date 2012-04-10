<?php
//print_r($_SERVER);
require_once $_SERVER['DOCUMENT_ROOT'].'/system.php';
$link = mysql_connect($configuracion['bd_servidor'], $configuracion['bd_usuario'], $configuracion['bd_password']);
if (!$link) {
    die('No conectado: ' . mysql_error());
}

$db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
if (!$db_selected) {
    die ('No se puede usar tubus: ' . mysql_error());
}

//vacio la base de datos para empezar de nuevo a meter datos.
//mysql_query("TRUNCATE TABLE horarios", $link); 
?>
