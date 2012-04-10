<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "system.php";

function LoginTruncate($login) 
{ 

 $string = substr($login, 0, 9) . '...';
 
 return $string; 
}

$logged_us =  is_logged();
if(!isset($url_r_login) || $url_r_login == '')
    $url_r= '';
else
    $url_r= '?r='.$url_r_login;
?>
<?php
	if($logged_us['logged'] == true){ //anchor('user/', $logged_us['username'], 'Mi cuenta')
        echo '<div id="loggin"><ul><li><a href="#" id="desplegador"><span id="mennu" class="desplegador-no"></span>Menu</a></li><li><a href="'.$configuracion['home_url'].'/user/" title="Mi cuenta"><span class="mugneco"></span>'.LoginTruncate(utf8_encode($logged_us['username'])).'</a></li></ul></div>';
	}
	else{
        echo '<div id="loggin"><ul><li><a href="#" id="desplegador"><span id="mennu" class="desplegador-no"></span>Menu</a></li><li><a href="'.$configuracion['home_url'].'/login.php'.$url_r.'" title="Iniciar sesión en Tubus"><span class="log-in"></span>Login</a></li></ul></div>';
    }
?>

