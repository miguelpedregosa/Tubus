<?php
require_once "dbconnect.php";
function cambiar_db(){
    global $link;
    global $configuracion;
    
    $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus!: ' . mysql_error());
            }
}


 
function validar_usuario($username, $password1, $password2, $email){
    global $link;
    
    $valido = true;
    $mensajes = array();
    $salida = array();
    
    //Empiezo por el nombre de usuario
    if($username == ""){
        $valido = false;
        $mensajes[] = "El <strong>nombre de usario no puede estar vacío</strong>";
    }
    
    if(strlen($username)<4){
        $valido = false;
        $mensajes[] = "El <strong>nombre de usario debe tener entre 4 y 12 caracteres alfanuméricos</strong>";
    }
    
    if(strlen($username)>12){
        $valido = false;
        $mensajes[] = "El <strong>nombre de usario debe tener entre 4 y 12 caracteres alfanuméricos</strong>";
    }
    
    $sql = "SELECT * FROM usuarios WHERE username = '".$username."' LIMIT 1";
    $res = mysql_query($sql);
    $num = mysql_num_rows($res);
    
    if($num >= 1){
        $valido = false;
        $mensajes[] = "<strong>Nombre de usuario no disponible</strong>";
    }
    
    if(!preg_match( "/^[a-z0-9]+$/i" , $username )){
        $valido = false;
        $mensajes[] = "El <strong>nombre de usuario solo puede contener valores alfanúmericos</strong>";
    }
    
    if($password1 != $password2){
        $valido = false;
        $mensajes[] = "Las <strong>contraseñas no coinciden</strong>";
    }
    
    if(strlen($password1)<4){
        $valido = false;
        $mensajes[] = "La <strong>contraseña debe tener entre 4 y 16 caracteres alfanuméricos</strong>";
    }
    
    if(strlen($password1)>16){
        $valido = false;
        $mensajes[] = "La <strong>contraseña debe tener entre 4 y 16 caracteres alfanuméricos</strong>";
    }
     
    if(!preg_match( "/^[a-z0-9]+$/i" , $password1 )){
        $valido = false;
        $mensajes[] = "La <strong>contraseña solo puede contener valores alfanúmericos</strong>";
    }    
    
    if( !preg_match( "/^[a-z0-9_.-]+@([a-z0-9]+([-]+[a-z0-9]+)*.)+[a-z]{2,7}$/i " , $email ) ){
        $valido = false;
        $mensajes[] = "El <strong>email no parece válido</strong>";
    }
    
    $sqle = "SELECT * FROM usuarios WHERE email = '".$email."' LIMIT 1";
    $rese = mysql_query($sqle);
    $nume = mysql_num_rows($rese);
    
    if($nume >= 1){
        $valido = false;
        $mensajes[] = "<strong>Email en uso por otro usuario</strong>";
    }
    
    $salida['resultado'] = $valido;
    $salida['mensajes'] = $mensajes;
    return $salida;
}

function validar_passwords($password1, $password2){
    global $link;
    
    $valido = true;
    $mensajes = array();
    $salida = array();
    
    
    if($password1 != $password2){
        $valido = false;
        $mensajes[] = "Las <strong>contraseñas no coinciden</strong>";
    }
    
    if(strlen($password1)<4){
        $valido = false;
        $mensajes[] = "La <strong>contraseña debe tener entre 4 y 16 caracteres alfanuméricos</strong>";
    }
    
    if(strlen($password1)>16){
        $valido = false;
        $mensajes[] = "La <strong>contraseña debe tener entre 4 y 16 caracteres alfanuméricos</strong>";
    }
     
    if(!preg_match( "/^[a-z0-9]+$/i" , $password1 )){
        $valido = false;
        $mensajes[] = "La <strong>contraseña solo puede contener valores alfanúmericos</strong>";
    }    
    
    
    $salida['resultado'] = $valido;
    $salida['mensajes'] = $mensajes;
    return $salida;
}



function logout(){
    setcookie("userid", "", time() - 3600); 
    setcookie("userkey", "", time() - 3600); 
}

function is_logged(){
    global $link;
    
    $key = '';
    $salida = array();
    $salida['logged'] = false;
    
    
    if(isset($_SESSION['userkey']) && $_SESSION['userkey']!= '')
        $key = $_SESSION['userkey'];
    else if (isset($_COOKIE['userkey']) && $_COOKIE['userkey']!= '')
        $key = $_COOKIE['userkey'];
    if($key == ''){
        $salida['logged'] = false;
        return $salida;
    }
    
    //Ahora veamos con que nos encontramos
    $des = base64_decode($key);
    $partes = explode(':',$des);
    $usuario_bdid = $partes[0];
    $userid = $partes[1];
    $userkey = $partes[2]; 
    //Empiezo a hacer comprobaciones
    
    if($_COOKIE['userid'] != $userid){
        $salida['logged'] = false;
        return $salida;
    }
         
    //Cambio la base de datos por la que contiene los datos del login
        $db_selected = mysql_select_db('tubus_usuarios', $link);
            if (!$db_selected) {
                die ('No se puede usar tubus!!: ' . mysql_error());
            }   
    //Fin de cambio de base de datos
        
    //Ahora con la base de datos
    $sql = "SELECT * FROM usuarios WHERE id_usuario = '".$usuario_bdid."' AND userid = '".$userid."' AND userkey = '".$userkey."' LIMIT 1;";
    $res = mysql_query($sql);
    
    if(mysql_num_rows($res) == 1){
        $datos = mysql_fetch_array($res);
        $salida['id_usuario'] = $datos['id_usuario'];
        $salida['username'] = $datos['username'];
        $salida['tipo'] = 'web';
        $salida['logged'] = true;
        cambiar_db();
        return $salida;
    }
    else{
        //Miro a ver si es un usuario de Twitter
        $sqlo = "SELECT * FROM oauth WHERE id_usuario = '".$usuario_bdid."' AND userid = '".$userid."' AND userkey = '".$userkey."' LIMIT 1;";
        $reso = mysql_query($sqlo);
        
         if(mysql_num_rows($reso) == 1){
                $datos = mysql_fetch_array($reso);
                $salida['id_usuario'] = $datos['id_usuario'];
                $salida['username'] = $datos['username'];
                $salida['tipo'] = 'oauth';
                $salida['logged'] = true;
                cambiar_db();
                return $salida;
        }
        else
        {
            $salida['logged'] = false;
             cambiar_db();
            return $salida;
        }
    }
    cambiar_db();
    return $salida;    
}
function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
{
	$source = 'abcdefghijklmnopqrstuvwxyz';
	if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if($n==1) $source .= '1234567890';
	if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
	if($length>0){
		$rstr = "";
		$source = str_split($source,1);
		for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,count($source));
			$rstr .= $source[$num-1];
		}

	}
	return $rstr;
}
function convert_datetime($str) {

list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);

$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

return $timestamp;
}

//funciones de gestión de favoritos
function save_favorite($id_usuario, $tipo_usuario, $id_parada, $nombre_parada = null){
    global $link;
    global $configuracion;

    $fecha = date('Y-m-d H:i:s');
    //Compruebo que el usuario es vaĺido 
    
    //Cambio la base de datos por la que contiene los datos del login
        $db_selected = mysql_select_db('tubus_usuarios', $link);
            if (!$db_selected) {
                die ('No se puede usar tubus!!: ' . mysql_error());
            }   
    //Fin de cambio de base de datos
    
    switch($tipo_usuario){
        
        case 'web':
            $sql = "SELECT id_usuario FROM usuarios WHERE id_usuario = '".$id_usuario."' LIMIT 1;";
        break;
        
        case 'oauth':
            $sql = "SELECT id_usuario FROM oauth WHERE id_usuario = '".$id_usuario."' LIMIT 1;";
        break;
        
        
    }
     
    $res = mysql_query($sql);
    
     $db_selected = mysql_select_db($configuracion['bd_basedatos'], $link);
            if (!$db_selected) {
            die ('No se puede usar tubus!: ' . mysql_error());
    }
    
    
    if($res && mysql_num_rows($res) == 1){
        //Tengo el usuario confirmado, ahora sigo con la parada
        $sqlp = "SELECT * FROM paradas WHERE id_parada = '".$id_parada."' LIMIT 1;";
        $res2 = mysql_query($sqlp);
        
        if($res2 && mysql_num_rows($res2) == 1){
            $row = mysql_fetch_array($res2);
            
            if($nombre_parada == null)
                $nombre_parada = $row['label'];
                
            //Ahora compruebo si la parada ya se encuentra en favoritos para este usuario, actualizo o inserto segun
            $sqlf = "SELECT * FROM favoritos WHERE id_usuario = '".$id_usuario."' AND tipo_usuario = '".$tipo_usuario."' AND id_parada = '".$id_parada."' LIMIT 1;";
            $resf = mysql_query($sqlf);
            
            if(mysql_num_rows($resf) == 0){
                //Inserto nuevo
                $sqli = "INSERT INTO favoritos (id_usuario, tipo_usuario, id_parada, nombre_parada, fecha) VALUES ('".$id_usuario."', '".$tipo_usuario."', '".$id_parada."', '".$nombre_parada."', '".$fecha."' );";
                $resi = mysql_query($sqli);
                if($resi)
                    return true;
                else 
                    return false;
            }
            else if(mysql_num_rows($resf) == 1){
                $datos = mysql_fetch_array($resf);
                //Actualizo
                $sqlu = "UPDATE favoritos SET nombre_parada = '".$nombre_parada."', fecha = '".$fecha."'  WHERE id = '".$datos['id']."' LIMIT 1";
                $resu = mysql_query($sqlu);
                if($resu)
                    return true;
                else 
                    return false;
            }
             
        }
        
        else
            return false;

    }
    else
        return false;
    
    
}

function delete_favorite($id_usuario, $tipo_usuario, $id_parada){
    global $sql;
    $sql = "DELETE FROM favoritos WHERE id_usuario = '".$id_usuario."' AND tipo_usuario = '".$tipo_usuario."' AND id_parada = '".$id_parada."' LIMIT 1;";
    $res = mysql_query($sql);
    if($res)
        return true;
    else
        return false;
}
function check_favorite($id_usuario, $tipo_usuario, $id_parada){
    global $link;
    $sql = "SELECT * FROM favoritos WHERE id_usuario = '".$id_usuario."' AND tipo_usuario = '".$tipo_usuario."' AND id_parada = '".$id_parada."' LIMIT 1;";
    $res = mysql_query($sql);
    if($res && mysql_num_rows($res) == 1)
        return true;
    else
        return false;
}
function have_favorites($id_usuario, $tipo_usuario){
    global $link;
    $sql = "SELECT COUNT(*) FROM favoritos WHERE id_usuario = '".$id_usuario."' AND tipo_usuario = '".$tipo_usuario."' ;";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);
    
    if((int)$row[0] > 0) return true; else return false;
}
