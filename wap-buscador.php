<?php
require_once "libs/functions.php";
require_once "libs/usuarios.php";
require_once "libs/helpers.php";
require_once "libs/movil.php";
require_once "system.php";

if (isset($_GET['parada'])&&is_numeric($_GET['parada'])){
		header ("Location: ".$configuracion['home_url']."/".$_GET['parada']."/wap/"); 
}
else{
	echo '
<?xml version="1.0"?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN"
"http://www.wapforum.org/DTD/wml_1.1.xml">

<wml>
<card id="no1" title="Tubus '.$configuracion['ciudad'].'">
<big>Tubus - '.$configuracion['ciudad'].'</big>
<p>
Introduzca el n&#250;mero de parada que desea consultar.
</p>
<p>
<b>Parada</b>
<br/>
<input name="myParada"/><br/>

<anchor>
        <go method="get" href="'.$configuracion['home_url'].'/'.'wap-buscador.php">
          <postfield name="parada" value="$(myParada)"/>
        </go>
        Consultar
</anchor>
</p>

</card>

</wml
';
}
