<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/mailchimp.php';
require_once 'libs/CURL.php';
require_once 'libs/usuarios.php';
require_once 'libs/twitteroauth/twitteroauth.php';
require_once 'libs/helper_email.php';
$ip = get_real_ip();
$userid = get_userid();

session_start();

if(isset($_GET['r']) && $_GET['r'] != ""){
	
        $url = $_GET['r'];
        $fb_retorno = $configuracion['home_url']."/facebook.php?r=".$url;
    }
    else{
        $url = null;
        $fb_retorno = $configuracion['home_url']."/facebook.php";
	}
        
if (!isset($_REQUEST['code'])) {
  header ("Location: ".$configuracion['home_url']."/login.php"); 
  exit();
}

$codigo = $_GET['code'];


$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $configuracion['FACEBOOK_ID'] . "&redirect_uri=" . urlencode($fb_retorno) . "&client_secret="
        . $configuracion['FACEBOOK_SECRET'] . "&code=" . $codigo;


$access_token = file_get_contents($token_url);

if (!isset($access_token) || $access_token == "") {
  header ("Location: ".$configuracion['home_url']."/login.php"); 
  exit();
}

$graph_url = "https://graph.facebook.com/me?" . $access_token;
$user = json_decode(file_get_contents($graph_url));

//print_r($user);



 //Cambio la base de datos por la que contiene los datos del login
        $db_selected = mysql_select_db('tubus_usuarios', $link);
            if (!$db_selected) {
                die ('No se puede usar tubus: ' . mysql_error());
    }   
//Fin de cambio de base de datos


$id_usuario = "fb".$user->id;
$username = utf8_decode($user->name);
$fecha_crea = date('Y-m-d H:i:s');
$url_redirect = strip_tags($_GET['r']);
$sql = "SELECT * FROM oauth WHERE id_usuario = '".$id_usuario."' AND username = '".$username."' LIMIT 1";

$res = mysql_query($sql);
if(mysql_num_rows($res) == 0){
    //No está el usuario en la base de datos, procedemos a crearlo con su clave y user id
     $userkey = RandomString(64);
     
     $sqli = "INSERT INTO oauth (id_usuario, username, email, userid, userkey, created, register_ip, last_login, last_ip, tipo)  VALUES('".$id_usuario."', '".$username."', '".$user->email."', '".$userid."', '".$userkey."', '".$fecha_crea."', '".$ip."', '".$fecha_crea."', '".$ip."', 'Facebook' );";
     $resi = mysql_query($sqli); 
     //Guardo su email en la lista de mailchimp
     
     suscribir_email($user->email);
     
     //Email de bienvenida al usuario
     enviar_email_registro($user->email, $username);
     
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
