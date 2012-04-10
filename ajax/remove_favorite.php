<?php
require_once "../libs/functions.php";
require_once "../libs/usuarios.php";
require_once "../libs/helpers.php";
require_once "../system.php";
$logged_u =  is_logged();
//print_r($logged_u);
if($logged_u['logged'] == false){
    echo 'NOLOGIN';
    exit;
}

if(!isset($_GET['parada']) or $_GET['parada'] <= 0){
    echo 'NOPARADA';
    exit;
}
$id_parada = addslashes(trim(strip_tags($_GET['parada'])));

if(delete_favorite($logged_u['id_usuario'], $logged_u['tipo'], $id_parada))
    echo 'OK';
else
    echo 'FAIL';
