<div id="cabecera">
			<a href="<?=$configuracion['home_url']?>/" style="width:105px;display:block;">
            <?php $ciudad_br = $configuracion['home_url']. '/style/images/logo-'.$configuracion['cache_prefix'].'.png';?>
            <div id="logos" style="background:url(<?=$ciudad_br?>) no-repeat 0 10px;">
			</div>
            </a>
			<div id="localidad">
			</div>
            <?php include_once 'barra-login.php'; ?>
            
            <?php if(($configuracion['ciudad'] == 'Granada') && $configuracion['mostrar_aviso']){?>
            
            <div id="error" style="padding:5px;background:#fff79b;margin-top:10px;">
				<div id="banner" style="padding:5px;border:1px dashed #ada43b;">
					<div id="banner2" style="color:#000;background:#fff79b;font-family:arial,sans-serif;font-size:12px;">
					Actualmente la información en tiempo real para Granada está fuera de servicio debido a que <strong>Transportes Rober</strong> no permite el acceso de Tubus a los datos. Podeis quejaros por ello al email de: <a href="mailto:atencionalcliente@transportesrober.com">Transportes Rober</a> o al <a href="mailto:cgim@movilidadgranada.com">CGI Movilidad del Ayuntamiento de Granada</a>
					</div>
				</div>
			</div>
			
			<?php };?>
</div>
