<?php
require_once 'system.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';

function redirigir($url_redirect){
    if($url_redirect == ''){
            header ("Location: ".$configuracion['home_url']."/"); 
            exit();
        }
        else{
            header ("Location: ".$configuracion['home_url']."/".$url_redirect); 
        exit();
        }
}


if(isset($_GET['r']) && $_GET['r'] != "")
        $url = $_GET['r'];
    else
        $url = null;

$logged_u =  is_logged();
//print_r($logged_u);
if($logged_u['logged'] == false){
    //Redirijo al login si no está el usuario logueado
    //header ("Location: ".$configuracion['home_url']."/login.php");
    //exit;
    $url_redir = 'login.php?r='.$url;
    redirigir($url_redir);
}

$accion = $_GET['accion'];

switch($accion){
    case 'add':
        if(!isset($_GET['parada']) or $_GET['parada'] <= 0){
               redirigir($url);
        }
    $id_parada = addslashes(trim(strip_tags($_GET['parada'])));
    $nombre_parada = addslashes(trim(strip_tags($_GET['nombre'])));
    if($nombre_parada == "" or strlen($nombre_parada) < 4)
        $nombre_parada = null;
    
    if(save_favorite($logged_u['id_usuario'], $logged_u['tipo'], $id_parada, $nombre_parada))
         redirigir($url);
    else
         redirigir($url);
    break;
    
    case 'remove':
    
    if(!isset($_GET['parada']) or $_GET['parada'] <= 0){
                redirigir($url); 
        }
    $id_parada = addslashes(trim(strip_tags($_GET['parada'])));
    
    if(delete_favorite($logged_u['id_usuario'], $logged_u['tipo'], $id_parada))
         redirigir($url);
    else
         redirigir($url);
    
    break;
    
    default:
       redirigir($url);
    break;

}
