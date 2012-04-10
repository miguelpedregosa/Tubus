<?php require_once "libs/helpers.php"; ?>
<div class="contador">
			<p><small><?=$configuracion['texto_pie']?>
			Al utilizar Tubus usted está de acuerdo con nuestros <?php echo anchor("legal.php",'"Terminos y condiciones"', 'Aviso legal y política de privacidad');?> | <?php echo anchor("faq.php",'"Preguntas frecuentes sobre Tubus"', 'Preguntas frecuentes sobre Tubus');?>
            </small>
            </p>
			</div>
		<div id="pie">
		<div id="a-izquierda">
        <h3> | <?php echo anchor("contacto.php",'Contacto', 'Contactar con Tubus');?></h3>
		<h3> | <?php echo anchor("legal.php",'Privacidad', 'Aviso legal y política de privacidad');?></h3>
		<h3>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo anchor("http://blog.tubus.es/",'Blog', 'Blog oficial de Tubus');?></h3>
		</div>
		<h3><?php echo anchor("http://huruk.net/",'Huruk');?></h3>
		</div>
	</div>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11509350-1']);
  _gaq.push(['_setDomainName', '.tubus.es']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>
