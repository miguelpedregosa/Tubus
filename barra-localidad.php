<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "system.php";

$logged_us =  is_logged();
if(!isset($url_r_login) || $url_r_login == '')
    $url_r= '';
else
    $url_r= '?r='.$url_r_login;
?>
<h1><a href="<?=$configuracion['home_url']?>/ciudad.php" title="Cambiar la ciudad seleccionada" >[<?=$configuracion['ciudad']?>]</a></h1>
<?php
	if($logged_us['logged'] == true){
        echo '<!--<div id="loggin"><ul><li>'.anchor('user/', $logged_us['username'], 'Mi cuenta').'</li> | <li>'.anchor('logout.php'.$url_r, 'salir', 'Cerrar sesión en Tubus').'</li></ul></div>-->';
	}
	else{
        echo '<!--<div id="loggin"><ul><li>'.anchor('login.php'.$url_r, 'Acceder', 'Iniciar sesión en Tubus').' </li>| <li>'.anchor('registro.php', 'Registrarse', 'Crear una cuenta nueva en Tubus').'</li></ul></div>-->';
    }
