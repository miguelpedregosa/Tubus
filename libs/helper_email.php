<?php

/**
 * Helper de funciones básicas para el envío de correo electrónico mediante el framework.
 * @package Email
 */ 
require_once 'lib_input.php';

class Email
{
	public static function autoload()
	{
		/*
		if((Helper::load_settings(__CLASS__)) === false)
		{	
			$settings = array(
				'nombre_var' => 'comentario',
				'nombre_var2' => 'comentario'
			);
			Helper::create_file_settings(__CLASS__, $settings );
			Helper::load_settings(__CLASS__);
		}
		*/
	}
	
    
    public static function validate_email($email)
	{
		if(Input::validate_email($email) != false)
			return true;
		else
			return false;
	}
	public static function sanitize_email($email)
	{
		return Input::validate_email($email);
	}
    
    
    
    public static function send_text_email($data)
    {
		if(!is_array($data))
		{
			return false;
		}
		
		if(!isset($data['to']) || !isset($data['subject']) || !isset($data['text']))
			return false;
		
		$to = '';
		
		if(is_array($data['to']))
		{
			$to = '';
			foreach($data['to'] as $email_d)
			{
				$em = Input::validate_email($email_d);
				if($em != false)
				{
					$to .= $em.',';
				}
				
			}
			$to = rtrim($to, ',');
		}
		else
		{
			$to = Input::validate_email($data['to']);
			if($to == false)
			{
				return false;
			}
		}
		if($to == '')
		{
				return false;
		}
		
		
		return @mail( $to, $data['subject'], $data['text'] );
		
			
		
	}
    
    
    public static function send_html_email($data)
	{
		
		if(!is_array($data))
		{
			return false;
		}
		
		if(!isset($data['to']) || !isset($data['from']) || !isset($data['subject']) || !isset($data['html']))
			return false;
	
		$from = Input::validate_email($data['from']);
		if($from == false)
		{
				return false;
		}
		
		if(is_array($data['to']))
		{
			$to = '';
			foreach($data['to'] as $email_d)
			{
				$em = Input::validate_email($email_d);
				if($em != false)
				{
					$to .= $em.',';
				}
				
			}
			$to = rtrim($to, ',');
		}
		else
		{
			$to = Input::validate_email($data['to']);
			if($to == false)
			{
				return false;
			}
		}
		if($to == '')
		{
				return false;
		}
				
		
		if(isset($data['cc']))
		{
			
			if(is_array($data['cc']))
			{
				$cc = '';
					foreach($data['cc'] as $email_d)
					{
						$em = Input::validate_email($email_d);
						if($em != false)
						{
							$cc .= $em.',';
						}
				
					}
					$cc = rtrim($cc, ',');
			}
			else
			{
				$cc = Input::validate_email($data['cc']);
			}
		
		if($cc == '' || $cc == false)
		{
			unset($cc);
		}
		
		
		}
		
		
		
		if(isset($data['bcc']))
		{
			
			if(is_array($data['bcc']))
			{
				$bcc = '';
					foreach($data['bcc'] as $email_d)
					{
						$em = Input::validate_email($email_d);
						if($em != false)
						{
							$bcc .= $em.',';
						}
				
					}
					$bcc = rtrim($bcc, ',');
			}
			else
			{
				$bcc = Input::validate_email($data['bcc']);
			}
		
		if($bcc == '' || $bcc == false)
		{
			unset($bcc);
		}
		
		
		}
		
		if(isset($data['bcc']))
			$bcc = Input::validate_email($data['bcc']);
		
		if(isset($data['replyto']))
			$replyto = Input::validate_email($data['replyto']);
			
		$subject = $data['subject'];
		$html_content = $data['html'];
		
		
			
		$mime_boundary = "----Tubus Mail----".md5(time());
		 
		
		if(isset($data['fromname']))
		{
			$headers = "From: ".$data['fromname']." <".$from.">\n";
		}
		else
		{
			$headers = "From: ".$from."\r\n";
		}
		
		if(isset($replyto))
		{
			if(isset($data['replytoname']))
			{
				$headers .= "Reply-To: ".$data['replytoname']." <".$replyto.">\n";
			}
			else
			{
				$headers.= 'Reply-To: '.$replyto.'' . "\r\n" ;
			}
		}
		else
		{
			if(isset($data['fromname']))
			{
				$headers .= "Reply-To: ".$data['fromname']." <".$from.">\n";
			}
			else
			{
				$headers .= "Reply-To: ".$from."\r\n";
			}
		}
		
		if(isset($cc))
		{
			$headers.= 'Cc: '.$cc.'' . "\r\n";
		}
		
		if(isset($bcc))
		{
			$headers.= 'Bcc: '.$bcc.'' . "\r\n";
		}
		
		if(isset($data['alttext']))
		{
			$alt_text = $data['alttext'];
		}
		else
		{
			$alt_text = '';
		}
		
		
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";	
		
		$message = '';
		
		$message .= "--$mime_boundary\n";
		$message .= "Content-Type: text/html; charset=UTF-8\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $html_content;
		$message .= "\n\n";
		$message .= "--$mime_boundary--\n\n";
		return @mail( $to, $subject, $message, $headers );
		
			
	}
    
    
   /* 
    
    public static function load_template($template_name, $vars = null)
    {
		global $configuracion, $runtime;
		
		$template_dir = TEMPLATE_ROOT.'email'.DS;
		$template_name = $template_dir.$template_name;
		
		if(!file_exists($template_name))
		{
			return false;
		}
		$template_cache_dir = CACHE_ROOT.'email'.DS;
		
		$options = array(
			'cache' => 'file',	
			'cache_dir'=> $template_cache_dir,		
		);
		
		$h20 = new h2o($template_name, $options);
		
		if(is_array($vars))
		{
			return $h20->render($vars);
		}
		else
		{
			return $h20->render();
		}
		
	}
	
	public static function send_email_from_template($data)
	{
		
		if(!is_array($data))
		{
			return false;
		}
		
		if(!isset($data['to']) || !isset($data['from']) || !isset($data['subject']) || !isset($data['template']))
			return false;
	
		$from = Input::validate_email($data['from']);
		if($from == false)
		{
				return false;
		}
		
		if(is_array($data['to']))
		{
			$to = '';
			foreach($data['to'] as $email_d)
			{
				$em = Input::validate_email($email_d);
				if($em != false)
				{
					$to .= $em.',';
				}
				
			}
			$to = rtrim($to, ',');
		}
		else
		{
			$to = Input::validate_email($data['to']);
			if($to == false)
			{
				return false;
			}
		}
		if($to == '')
		{
				return false;
		}
				
		
		if(isset($data['cc']))
		{
			
			if(is_array($data['cc']))
			{
				$cc = '';
					foreach($data['cc'] as $email_d)
					{
						$em = Input::validate_email($email_d);
						if($em != false)
						{
							$cc .= $em.',';
						}
				
					}
					$cc = rtrim($cc, ',');
			}
			else
			{
				$cc = Input::validate_email($data['cc']);
			}
		
		if($cc == '' || $cc == false)
		{
			unset($cc);
		}
		
		
		}
		
		
		
		if(isset($data['bcc']))
		{
			
			if(is_array($data['bcc']))
			{
				$bcc = '';
					foreach($data['bcc'] as $email_d)
					{
						$em = Input::validate_email($email_d);
						if($em != false)
						{
							$bcc .= $em.',';
						}
				
					}
					$bcc = rtrim($bcc, ',');
			}
			else
			{
				$bcc = Input::validate_email($data['bcc']);
			}
		
		if($bcc == '' || $bcc == false)
		{
			unset($bcc);
		}
		
		
		}
		
		if(isset($data['bcc']))
			$bcc = Input::validate_email($data['bcc']);
		
		if(isset($data['replyto']))
			$replyto = Input::validate_email($data['replyto']);
			
		$subject = $data['subject'];
		$html_content = Email::load_template($data['template'],$data['template_vars']);
		
		if($html_content == false)
			return false;
		
			
		$mime_boundary = "----Pantoflo Mail----".md5(time());
		 
		
		if(isset($data['fromname']))
		{
			$headers = "From: ".$data['fromname']." <".$from.">\n";
		}
		else
		{
			$headers = "From: ".$from."\r\n";
		}
		
		if(isset($replyto))
		{
			if(isset($data['replytoname']))
			{
				$headers .= "Reply-To: ".$data['replytoname']." <".$replyto.">\n";
			}
			else
			{
				$headers.= 'Reply-To: '.$replyto.'' . "\r\n" ;
			}
		}
		else
		{
			if(isset($data['fromname']))
			{
				$headers .= "Reply-To: ".$data['fromname']." <".$from.">\n";
			}
			else
			{
				$headers .= "Reply-To: ".$from."\r\n";
			}
		}
		
		if(isset($cc))
		{
			$headers.= 'Cc: '.$cc.'' . "\r\n";
		}
		
		if(isset($bcc))
		{
			$headers.= 'Bcc: '.$bcc.'' . "\r\n";
		}
		
		if(isset($data['alttext']))
		{
			$alt_text = $data['alttext'];
		}
		else
		{
			$alt_text = '';
		}
		
		
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";	
		
		$message = '';
		
		$message .= "--$mime_boundary\n";
		$message .= "Content-Type: text/html; charset=UTF-8\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $html_content;
		$message .= "\n\n";
		$message .= "--$mime_boundary--\n\n";
		
		return @mail( $to, $subject, $message, $headers );
		
			
	}
	*/
	public static function send_email($data)
	{
		if(!is_array($data))
		{
			return false;
		}
		
		if(isset($data['template']))
		{
			return  Email::send_email_from_template($data);
		}
		else
		{
			if(isset($data['html']))
			{
				return Email::send_html_email($data);
			}
			else
			{
				return Email::send_text_email($data);
			}
			
		}
		
	}
	
	public static function send($data)
	{
		return Email::send_email($data);
	}
	
}

function enviar_email_registro($to, $nombre='')
{
	$email_cuerpo = 
	'
	<html>

<head>

<title>Muchas gracias por registrarte en Tubus</title>

</head>

<body>

<!--This style Should be in body to appear it correctly in email clients-->

<style type="text/css">

body { background-color: #f7f4f2; margin: 0 0 0 0; padding: 0 0 0 0; } table { color:#000000; font-family: Verdana, Geneva, sans-serif; font-size:12px; line-height:20px; } a { color: #000000; text-decoration:none;} a img { border: none; } ul.list li {font-family:Verdana, Geneva, sans-serif; font-size:12px; line-height:12px; } .options{ color:#000000; font-family: Verdana, Geneva, sans-serif; font-size:10px; line-height:12px; } .options a{ color:#94391c; text-decoration:none; }

</style>

<!--wraper table-->

	<table border="0" width="100%" style="border-width: 0px" cellspacing="0" cellpadding="0" bgcolor="#f7f4f2">
	
		<tr>
	    
			<td style="border-style: none; border-width: 0px" align="center">
			
			
			
			<!--Start Top Options-->
			
			<table border="0" width="600" cellspacing="0" cellpadding="0" style="border-width: 0px; height: 38px;">
				<tr>
	            
					<td class="options" align="center">
					
					
					</td>
				</tr>
			</table>
			<!--End Top Options-->
			


			
			<!--Start Header Image with logo-->
			
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="bottom">
					
					<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/top.gif" width="600" height="68">
					
					</td>
				</tr>
			</table>
			<!--End Header Image with logo-->
	


	
	
			<!--Start Infocus Module-->
			
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="12" bgcolor="#FFFFFF">
				<tr>
					<td style="border-style: none; border-width: 0px">
	                
					<table border="0" width="100%" style="border-width: 0px" cellspacing="0" cellpadding="8">
						<tr>
							<td class="infocus" style="border-style: none; border-width: 0px" bgcolor="#94391c" align="left" valign="top">
	                        
							<b><font size="3" color="#FFFFFF">Bienvenido a Tubus</font></b>
							
							<hr style="color: #DC7C65; background-color: #DC7C65; height: 1px;" size="1">
										
							<font color="#FFFFFF">
							
							Tubus te permite conocer en tiempo real las llegadas de los autobuses urbanos de tu ciudad. Gestiona tu tiempo y evita esperas innecesarias.
							<br />Descubre todas las características que nos convierten en tu mejor opción.
							</font><br>
							
							<a href="http://blog.tubus.es/"><img alt="Ir al blog de Tubus" border="0" src="http://email.tubus.es/registro/infocus_readmore.jpg"></a>
							<a href="http://tubus.es"><img alt="Ir a Tubus" border="0" src="http://email.tubus.es/registro/infocus_buynow.jpg"></a>
							
							</td>
	                        
							<td style="border-style: none; border-width:0px" width="235" bgcolor="#94391c" align="left" valign="top">
	                        
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/infocus_image.jpg" width="336" height="257"></td>
						</tr>
					</table>
	                
					</td>
				</tr>
			</table>
			<!--End Infocus Module-->
			
				
			
			<!--Start Full Length News Module-->
			
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px">
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
					
							<b><font size="3" color="#94391c">¡Muchas gracias por registrarte en Tubus!</font></b><br/><br/>
							
				
							<p><strong>'.$nombre.'</strong> gracias al registro podrás disfrutar de innumerables ventajas como:</p>
	                  </td>
				</tr>
			</table>
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px" >
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
	
	
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/knewstuff-128.png" width="128" height="128" align="right" hspace="16" vspace="8">
							
							<b><font size="3" color="#94391c">Paradas Favoritas</font></b><br/>
														
							Marca tus paradas más habituales como favoritas y podrás consultarlas facilmente desde cualquier sitio en cualquier momento. 
							Ahorra así mucho tiempo al gestionarlar desde casa, la universidad o el trabajo; no pierdas más tiempo esperando a que llegue
							el bus.
							
							<br>
							
					</td>
				</tr>
			</table>
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px" >
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
	
	
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/bus.jpg" width="128" height="128" align="right" hspace="16" vspace="8">
							
							<b><font size="3" color="#94391c">Últimas Paradas Visitadas</font></b><br/>
														
							Revisa tu historial de paradas y podrás conocer los números de las paradas y los lugares que visitaste.
							
							<br>
							
					</td>
				</tr>
			</table>
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px" >
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
	
	
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/Safari-World-128.png" width="128" height="128" align="right" hspace="16" vspace="8">
							
							<b><font size="3" color="#94391c">Paradas Cercanas</font></b><br/>
														
							Gracias al posicionamiento GPS de los móviles actuales descubre cuales son las paradas que tienes alrededor y cuales son las líneas de autobus que pasan por ellas. Podrás saber si te interesa coger el autobus o ir andando. Gestiona y optimiza tu tiempo de la manera más eficaz posible.
							
							<br>
							
					</td>
				</tr>
			</table>
			<table border="0" width="600" cellspacing="0" cellpadding="20" style="border-width: 0px" >
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top" bgcolor="#FFFFFF">
	
	
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/Wooden-Map-128.png" width="128" height="128" align="right" hspace="16" vspace="8">
							
							<b><font size="3" color="#94391c">Trayectoria hasta la parada</font></b><br/>
														
							<strong>Tubus</strong> te ayuda para que llegues a cualquier parada sin contratiempos. 
							Utiliza el sistema de rutas para averiguar el camino a seguir para llegar a las diferentes paradas y no pierdas el tiempo dando vueltas por la ciudad.
							
							<br>
							
					</td>
				</tr>
			</table>

			<!--End Full Length News Module-->
		
			
			<!--Start Line Seperator-->			
			
			<table border="0" width="600" cellspacing="0" cellpadding="0" style="border-width: 0px">
				<tr>
					<td style="border-style: none; border-width: 0px" align="center" bgcolor="#FFFFFF">
					
							<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/seperator.jpg" width="402" height="7"></td>
				</tr>
			</table>
			<!--End Line Seperator-->			
			
			
			
			
			
			
	
	
			<!--Start News Module with left Side bar-->
	
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="20">
				<tr>
	            	
	                <!-- left side bar with links --> 
	                
					<td style="border-style: none; border-width: medium" align="center" valign="top" bgcolor="#FFFFFF">
								<a href="http://tubus.es/ciudad.php?ciudad=GUIPUZCOA">
								<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/guip.jpg" width="125" height="125"></a><p>
								<a href="http://tubus.es/ciudad.php?ciudad=SANTANDER">
								<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/sant.jpg" width="125" height="125"></a></p>
								<p>
								<a href="http://tubus.es/ciudad.php?ciudad=GIJON">
								<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/gijon.jpg" width="125" height="125"></a></p>
					</td>
	                
	                
					<td style="border-style: none; border-width: medium" align="left" valign="top" width="400" bgcolor="#FFFFFF">
						
							<b><font size="3" color="#94391c">¿Dónde está disponible Tubus?</font></b><br/><br/>
							Actualmente Tubus está presente en 15 ciudades españolas, incluyendo las 5 ciudades con mayor número de habitantes de España:
							
							<ul style="list-style-position:inside;padding:0;">
							<li>Madrid</li>
							<li>Barcelona</li>
							<li>Sevilla</li>
							<li>Valencia</li>
							<li>Zaragoza</li>
							<li>Málaga</li>
							<li>San Sebastián</li>
							<li>Bilbao</li>
							<li>Granada</li>
							<li>Córdoba</li>
							<li>Santander</li>
							<li>Gijón</li>
							<li>Elche</li>
							<li>Jaén</li>
							<li>Guipuzcoa</li>
							</ul>
	                        Seguimos creciendo y llegando a nuevas ciudades de forma regular, aumentando el número de personas a las que ofrecemos nuestros servicios de forma totalmente gratuita.
	                        <br/>
	
					</td>
				</tr>
			</table>
			<!--End News Module with left Side bar -->
			
			<!-- Start footer Image -->
			
			<table border="0" width="600" style="border-width: 0px" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border-style: none; border-width: 0px" align="left" valign="top">
	                
						<img alt="" style="display:block;" border="0" src="http://email.tubus.es/registro/bot.gif" width="600" height="45">
	                    
	                </td>
				</tr>
			</table>
			<!-- End  footer Image -->
			
			
			
	
	
			<!-- Start Bottom Options -->
			
			<table border="0" width="600" cellspacing="0" cellpadding="0" style="border-width: 0px; padding: 10px;">
				<tr>
	            
					<td class="options" align="center">
					
						Entra en <a href="http://tubus.es">tubus.es</a>, o en nuestro <a href="http://blog.tubus.es">blog</a>. 
						También nos puedes seguir en <a href="http://twitter.com/tubus_es">Twitter</a>. <br>
	                    
					
					</td>
				</tr>
			</table>
			<!-- End Bottom Options -->
			
			
			
			
			
			</td>
		</tr>
	</table>

</body>

</html>

	';
	$data['to'] = $to;
	$data['from'] = 'registro@tubus.es';
	$data['fromname'] = 'Registro Tubus';
	$data['replyto'] = 'info@tubus.es';
	$data['replytoname'] = 'Tubus';
	
	$data['subject'] = 'Bienvenido a Tubus '.$nombre;
	$data['html'] = $email_cuerpo;
	//if(!isset($data['to']) || !isset($data['from']) || !isset($data['subject']) || !isset($data['html']))
	Email::send_html_email($data);
	
}
