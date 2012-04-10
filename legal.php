<?php
require_once 'system.php';
//require_once 'libs/rober.php';
require_once 'libs/'.$configuracion['conector'];
require_once 'libs/functions.php';
require_once 'libs/helpers.php';
require_once 'libs/movil.php';

$ip = get_real_ip();
$userid = get_userid();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title><?=html_title("Aviso legal")?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 

<meta name="description" content="Aviso lega, privacidad y condiciones de uso de Tubus." /> 
<meta name="keywords" content="bus urbano, rober, granada, tubus, autobus, urbano, granadino, tiempo real, paradas, metro ligero, ave, fuente las batallas, marquesinas, paneles" /> 

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
<meta name="generator" content="Huruk Soluciones" />

<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<link rel="stylesheet" type="text/css" media="handheld" href="<?=$configuracion['home_url']?>/style/style_<?=$configuracion['version']?>.css" />
<!--[if IEMobile 7]> 
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$configuracion['home_url']?>/style/wp7_style_<?=$configuracion['version']?>.css" />
<![endif]-->
<link rel="search" type="application/opensearchdescription+xml" title="Buscar en Tubus" href="<?=$configuracion['home_url']?>/opensearch.xml"/>
<link rel="apple-touch-icon" href="<?=$configuracion['home_url']?>/style/images/apple-touch-icon.png"/>
<link rel="shortcut icon" href="<?=$configuracion['home_url']?>/tubus_fav.png" type="image/png"/>
<script src="https://www.google.com/jsapi?key=ABQIAAAA4NrpBT8LijNsshLTHNpmLxR4mkvciC68xVMfDJ-G4kipE2SDyRSXqWnexajRtZVBdCCsD1K3Ntye6Q" type="text/javascript"></script>
	<script language="Javascript" type="text/javascript">
    //<![CDATA[
		google.load("jquery", "1.4.2");
	//]]>
    </script>
	<!-- <script src="<?=$configuracion['home_url']?>/js/jquery-1.4.2.min.js" type="text/javascript"></script> -->
<script src="<?=$configuracion['home_url']?>/js/menuhor.js"></script>

<script language="JavaScript"> 
usuario="contacto" 
dominio="tubus.es" 
conector="@" 


function dame_correo(){ 
   return usuario + conector + dominio 
} 

function escribe_enlace_correo(){ 
   document.write("<a href='mailto:" + dame_correo() + "'>" + dame_correo() + "</a>") 
} 

jQuery(window).ready(function(){
     toggle_menu();
    });  
</script> 

</head>

<body>
<div id="contenedor">
	<?php require_once 'header.php'; ?>
	<div id="cuerpo">
     <?php include_once 'menu-horizontal.php'; ?>
     <?php include_once 'ad.php'; ?>
	<div id="sub-cont">
		<h1><span>Aviso legal y Condiciones de uso de Tubus</span></h1>
		<span class="liine"></span>
	<div id="legal">
	<p style="margin-top:25px;"><strong>IMPORTANTE:</strong> El acceso y navegación por tubus.es implica que el usuario acepta la política de privacidad, el aviso legal y las 
	condiciones de uso de este servicio. En caso de no aceptarlos, no debe usar Tubus.</p>
	
	<h2>Exclusión de garantías y responsabilidad</h2>
	<p>Tubus no garantizan la licitud, fiabilidad, exactitud, exhaustividad, actualidad y utilidad de los contenidos.</p>
	<p>La información sobre las llegadas en tiempo real de cada parada mostrada en Tubus es proporcionada directamente por la empresa de transportes encargada de su gestión en cada una de las ciudades soportadas, de manera pública y abierta a través de 
	su página web. Dicha información puede no ser precisa y verse afectada por factores externos e incontrolables por parte de Tubus o de la empresa prestataria, entre estos factores podemos nombrar: climatología, cortes de calles por diversos motivos, retenciones de tráfico, averias en los vehículos y/o en los mecanismo de medición, ...</p>
	<p>Tubus no se responsabiliza ni de los inconvenientes, molestias o problemas que el uso de los datos ofrecidos en el portal web
	puedan generar en los usuarios/visitantes, siendo exclusivamente la labor de Tubus proporcionar un acceso más universal y accesible a 
	dicha datos.</p>
	
	<h2>Información Legal</h2>
	<p>En conformidad al Art.10 de la Ley 34/2002, de 11 de julio, de servicios de la sociedad de la información y de comercio electrónico se 
	informa:</p>
	<p>Tubus es un proyecto personal y sin ánimo de lucro con el objetivo de incentivar y mejorar el uso del transporte público. El dominio tubus.es es propiedad y está administrado por Huruk Soluciones</p>
	
	<h2>Contacto</h2>
	<p>Correo electrónico: <script>escribe_enlace_correo()</script></p>
	<p><?php echo anchor("contacto.php",'Formulario de contacto', 'Contactar con Tubus');?></p>
	
	<!--//
	<h2>Sobre los datos de los usuarios</h2>
	<p>En conformidad con lo previsto en la Ley Orgánica 15/1999, del 13 de diciembre, de Protección de Datos de Carácter Personal (LOPD), 
	Tubus.es informa de la existencia de un fichero de su titularidad en el cual se incluyen los datos necesarios para 
	mantener informados a los usuarios que así lo requieran o proporcionar los servicios que los usuarios soliciten.</p>
	
	<p>El titular podrá ejercitar los derechos reconocidos en la LOPD sobre este fichero y, en particular, los de acceso, rectificación o 
	cancelación de datos y oposición, si resultara pertinente, así como el de revocación del consentimiento para la cesión de sus datos en los 
	términos previstos en la LOPD. Los usuarios pueden realizar estas acciones enviando una solicitud a contacto@tubus.es</p>
	//-->
	<h2 id="privacidad">Privacidad</h2>
	<p>Tubus.es proporciona el acceso a contenidos en Internet a los que el usuario, con carácter general, puede tener 
	acceso de forma libre.</p>
	<p>Además de este acceso libre, para algunos servicios prestados por Tubus a través de su página web será necesario que el usuario se 
	registre, proporcionando una serie de datos para poder tener acceso a los mencionados servicios, datos que permiten 
	la prestación del servicio por parte de Tubus y la correcta identificación del usuario registrado. Las comunicaciones se 
	realizarán por correo electrónico a la dirección de e-mail facilitada por el usuario, quien presta su consentimiento expreso para dichos 
	envíos a través de correo electrónico.</p>
	<p>Al registrarse, el usuario podría recibir comunicaciones, noticias y eventos sobre Tubus por correo electrónico. El usuario podrá en todo momento 
	ejecutar su derecho a no recibir este tipo de correspondencia, sin tener que renunciar en ningún momento a su condición de usuario registrado.</p>
	<p>Tubus se compromete a cumplir con el deber de secreto de tales datos, así como a tratarlos con confidencialidad, asumiendo las 
	medidas necesarias para evitar su alteración, pérdida, tratamiento o acceso no autorizado, tal y como se recoge en la Ley Orgánica 15/1999, 
	de 13 de diciembre, de Protección de Datos de Carácter Personal, y en el Real Decreto 994/1999, de 11 de junio.</p>
	<p>Asimismo, Tubus se compromete a la no utilización de dichos datos para fines distintos del objeto del servicio que presta 
	a través de su página web, página que ofrece información en tiempo real sobre el transporte público de varias ciudades a través de internet.</p>
	
	<p>El usuario responderá, en cualquier caso, de la veracidad, exactitud, autenticidad y vigencia de los datos facilitados, reservándose 
	Tubus el derecho a excluir de los servicios registrados a todo usuario que haya facilitado datos falsos, sin perjuicio de las demás 
	acciones que procedan en Derecho.</p>
		
	<h2>Condiciones de uso</h2>
	<p>Las páginas e información presentadas son de acceso y visibilidad pública e inmediata sin necesidad de registros, pagos o procedimientos 
	adicionales. </p>

	<p>El usuario se abstendrá de utilizar cualquiera de los servicios ofrecidos en Tubus con fines o efectos ilícitos, lesivos de los 
	derechos e intereses de terceros, o que puedan dañar, inutilizar, sobrecargar, deteriorar o impedir la normal utilización de los servicios, 
	los equipos informáticos o los documentos, archivos y cualquier contenido almacenado en Tubus o servidores externos enlazados desde 
	Tubus.</p>
	
	<p>El incumplimiento de las condiciones de uso podría significar el bloqueo de la cuenta de usuario y/o dominio web, el borrado y/o edición del 
	texto ofensivo, y las medidas y denuncias adecuadas según las leyes españolas y europeas. </p>

	<p>Con el objetivo de mejorar el servicio y minimizar los problemas, Tubus se reserva el derecho a modificar y actualizar las condiciones 
	de uso sin previo aviso.</p>
	
	<div id="result"></div>
	</div>
	</div>
<?php include 'caja-busqueda.php' ?>
</div>
<?php include 'footer.php'; ?>
