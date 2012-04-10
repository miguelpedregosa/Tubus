<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "system.php";
//Borro las cookies y redirijo al home
$logged_u =  is_logged();
if($logged_u['logged'] == true){
	setcookie("userkey", '', time() - 1296000, "/", ".tubus.es"); //15 días de cookie
	setcookie("userid", '', time() - 1296000, "/", ".tubus.es");
}

if(isset($_GET['r']) && $_GET['r'] != "")
        $url = $_GET['r'];
    else
        $url = null;
        
$url_redirect = strip_tags($_GET['r']);

if($url_redirect == ''){
            header ("Location: ".$configuracion['home_url']."/"); 
            exit();
        }
        else{
            header ("Location: ".$configuracion['home_url']."/".$url_redirect); 
        exit();
}
        
exit();
