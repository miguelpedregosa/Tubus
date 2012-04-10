<!-- Inicio caja de búsqueda -->
<div id="otraparada">
	<h1>Paradas de autobús urbano</h1>
	<form action="<?=$configuracion['home_url']?>/buscador.php" method="post" name="tubusform" id="tubusform">
		<input x-webkit-speech="x-webkit-speech" class="caja-datos" type="text" value="" name="querystring" id="querystring" />
		<input class="datos-enviar" type="submit" value="" name="enviar" id="enviar" />
	</form>
	<div class="contador">Puedes buscar por dirección o directamente por el número de parada.</div>
</div>
<!-- Hasta aquí -->
