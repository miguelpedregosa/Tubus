<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/usuarios.php';
require_once 'libs/twitteroauth/twitteroauth.php';
$ip = get_real_ip();
$userid = get_userid();

session_start();

if(isset($_GET['r']) && $_GET['r'] != "")
        $url = $_GET['r'];
    else
        $url = null;

if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header ("Location: ".$configuracion['home_url']."/login.php"); 
  exit();
}

$connection = new TwitterOAuth($configuracion['CONSUMER_KEY'], $configuracion['CONSUMER_SECRET'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
$_SESSION['access_token'] = $access_token;

$content = $connection->get('account/verify_credentials');
if($content->error != ""){
  header ("Location: ".$configuracion['home_url']."/login.php"); 
  exit();
    
}

 //Cambio la base de datos por la que contiene los datos del login
        $db_selected = mysql_select_db('tubus_usuarios', $link);
            if (!$db_selected) {
                die ('No se puede usar tubus: ' . mysql_error());
    }   
//Fin de cambio de base de datos


$id_usuario = $content->id;
$username = $content->screen_name;
$fecha_crea = date('Y-m-d H:i:s');
$url_redirect = strip_tags($_GET['r']);
$sql = "SELECT * FROM oauth WHERE id_usuario = '".$id_usuario."' AND username = '".$username."' LIMIT 1";
$res = mysql_query($sql);
if(mysql_num_rows($res) == 0){
    //No está el usuario en la base de datos, procedemos a crearlo con su clave y user id
     $userkey = RandomString(64);
     
     $sqli = "INSERT INTO oauth (id_usuario, username, userid, userkey, created, register_ip, last_login, last_ip, tipo)  VALUES('".$id_usuario."', '".$username."', '".$userid."', '".$userkey."', '".$fecha_crea."', '".$ip."', '".$fecha_crea."', '".$ip."', 'Twitter' );";
     $resi = mysql_query($sqli); 
     //Una vez guardado el usuario de Twitter procedo con el login en Tubus
     if($resi){
         $clave_login = $id_usuario.':'.$userid.':'.$userkey;
         $login_cookie = base64_encode($clave_login);
         
         setcookie("userkey", $login_cookie, time() + 604800, "/", ".tubus.es"); //1 semana de cookie
         setcookie("userid", $userid, time() + 604800, "/", ".tubus.es");
         
         //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
         
         
         
         //Por último redirijo al usuario
         if($url_redirect == ''){
            header ("Location: ".$configuracion['home_url']."/user/"); 
            exit();
            }
        else{
            header ("Location: ".$configuracion['home_url']."/".$url_redirect); 
            exit();
        }
         
         
     }
     else{
         header ("Location: ".$configuracion['home_url']."/login.php"); 
         exit();
     }
    
}
else{
    //Si el usuario ya está en la base de datos, cojo esos datos y actualizo
    
    $datos = mysql_fetch_array($res);
    $id_usuario = $datos['id_usuario'];
    $username = $datos['username'];
    $userid = $datos['userid'];
    $userkey = $datos['userkey'];
    $ciudad = $datos['ciudad'];
    
    $sqlu = "UPDATE oauth SET last_login  = '".$fecha_crea."', last_ip = '".$ip."' WHERE id_usuario = '".$id_usuario."' LIMIT 1";
    mysql_query($sqlu);
    //Por ultimo pongo las cookies y redirijo
    
    
         $clave_login = $id_usuario.':'.$userid.':'.$userkey;
         $login_cookie = base64_encode($clave_login);
         
         setcookie("userkey", $login_cookie, time() + 604800, "/", ".tubus.es"); //1 día de cookie
         setcookie("userid", $userid, time() + 604800, "/", ".tubus.es");
         setcookie("userciudad", $ciudad, time() + 157680000, "/", ".tubus.es");
         
         //Vuelvo a cambiar a la otra base de datos
        $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus: ' . mysql_error());
            }
        
        //Fin de cambio de base de datos
         
         
         
         
         //Por último redirijo al usuario
         if($url_redirect == ''){
            header ("Location: ".$configuracion['home_url']."/user/"); 
            exit();
            }
        else{
            header ("Location: ".$configuracion['home_url']."/".$url_redirect); 
            exit();
        }
    
    
    
    
}


exit;
