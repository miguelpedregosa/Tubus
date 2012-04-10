<?php
require_once '../system.php';
require_once '../libs/functions.php';
require_once '../version.php';
require_once '../libs/geoip.php';

$ciudad_code = tubus_ip2ciudad_local(obtener_real_ip());
//echo $ciudad_code; die;
switch($ciudad_code)
{
	case 'madrid':
		$selects['madrid'] = 'selected="selected"';
	break;
	
	case 'b':
		$selects['b'] = 'selected="selected"';
	break;
	
	case 'se':
		$selects['se'] = 'selected="selected"';
	break;
	
	case 'v':
		$selects['v'] = 'selected="selected"';
	break;
	
	case 'gr':
		$selects['gr'] = 'selected="selected"';
	break;
	
	case 'z':
		$selects['z'] = 'selected="selected"';
	break;
	
	case 'do':
		$selects['do'] = 'selected="selected"';
	break;
	
	case 'bi':
		$selects['bi'] = 'selected="selected"';
	break;
	
	case 'ma':
		$selects['ma'] = 'selected="selected"';
	break;
	
	case 'sa':
		$selects['sa'] = 'selected="selected"';
	break;
	
	case 'gijon':
		$selects['gijon'] = 'selected="selected"';
	break;
	
	case 'co':
		$selects['co'] = 'selected="selected"';
	break;
	
	case 'elche':
		$selects['elche'] = 'selected="selected"';
	break;
	
	case 'guipuzcoa':
		$selects['guipuzcoa'] = 'selected="selected"';
	break;
	
	case 'leon':
		$selects['leon'] = 'selected="selected"';
	break;
	
	case 'valladolid':
		$selects['valladolid'] = 'selected="selected"';
	break;
	
	
	case 'albacete':
		$selects['albacete'] = 'selected="selected"';
	break;	
	
	case 'vigo':
		$selects['vigo'] = 'selected="selected"';
	break;
	
	
	
	default:
		$selects['madrid'] = 'selected="selected"';
	break;
	
}

echo '	<div id="ajax90">
			
			<span id="barra-cabecera"></span>
			<div id="sub-cont" style="width:85%;">
				<p class="info_general" style="margin:20px 0;">
					Bienvenido a <strong>Tubus</strong>. Para ofrecerte información en tiempo real sobre los autobuses urbanos de tu ciudad necesitamos saber dónde te encuentras. 
				</p>
				<p class="info_general" style="margin:20px 0;">
				<small>¿Necesita ayuda? Consulte nuestra sección de <a href="'.$configuracion['home_url'].'/faq.php" title="Preguntas frecuentes y ayuda de Tubus">preguntas frecuentes</a> o <a href="'.$configuracion['home_url'].'/contacto.php" title="Formulario de contacto">póngase en contacto</a> con Tubus.</small>
				</p>
				<h2 class="geo-h2" style="margin-bottom:25px;">Selecciona tu ciudad</h2>
				<form method="get" action="'.$configuracion['home_url']."/ciudad.php".'">
					<select class="citizen" id="ciudad" name="ciudad">
						<option '.$selects['madrid'].' value="MADRID">Madrid</option>
						<option '.$selects['b'].' value="BARCELONA">Barcelona</option>
						<option '.$selects['se'].' value="SEVILLA">Sevilla</option>
						<option '.$selects['v'].' value="VALENCIA">Valencia</option>
						<option '.$selects['gr'].' value="GRANADA">Granada</option>
						<option '.$selects['z'].' value="ZARAGOZA">Zaragoza</option>
						<option '.$selects['do'].' value="DONOSTIA">Donostia</option>
						<option '.$selects['leon'].' value="LEON">León</option>
						<option '.$selects['valladolid'].' value="VALLADOLID">Valladolid</option>
						<option '.$selects['bi'].' value="BILBAO">Bilbao</option>
						<option '.$selects['ma'].' value="MALAGA">Málaga</option>
						<option '.$selects['sa'].' value="SANTANDER">Santander</option>
						<option '.$selects['gijon'].' value="GIJON">Gijón</option>
						<option '.$selects['co'].' value="CORDOBA">Córdoba</option>
						<option '.$selects['elche'].' value="ELCHE">Elche</option>
						<option '.$selects['albacete'].' value="ALBACETE">Albacete</option>
						<option '.$selects['vigo'].' value="VIGO">Vigo</option>
						<option '.$selects['guipuzcoa'].' value="GUIPUZCOA">Guipúzcoa (provincia)</option>
						
					</select>
					<input type="submit" id="continue" value=""/>
				</form>
			</div>
		</div>';
