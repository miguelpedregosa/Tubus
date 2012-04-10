<?php
$geolocation_ready_2 = is_geolocation_capable();
$logged_um =  is_logged();
if($configuracion['master'] == true){
	$url_cambio = $configuracion['home_url'].'/ciudad.php';
}
else
{
	$url_cambio = $configuracion['master_url'].'/ciudad.php';
}
?>
<div id="menu" style="display:none; position:absolute; z-index:100" >
<span class="esquinita"></span>
<?php
   if($geolocation_ready_2 && $configuracion['mapa'])
        {
?>
<form id="geomenu" name="geomenu" action="<?=$configuracion['home_url']?>/geo.php" method="post">
        <input type="hidden" id="menulat" name="menulat" value="" />
        <input type="hidden" id="menulong" name="menulong" value="" />
        <input type="hidden" id="radio" name="radio" value="1800" />
</form>
<?php
        } 
 ?>        
		<!--<span class="puntita"></span>-->
		<ul>
		
		<?php
            if($geolocation_ready_2 && $configuracion['mapa'])
        {
        ?>
            <li><a id="geomenubtn" href="<?=$configuracion['home_url']?>/geo.php">Paradas cercanas</a></li>
        <?php
        } 
        ?>
            <li><a href="<?=$configuracion['home_url']?>/buscador.php">Buscar</a></li>
        
        
        <li><a href="<?=$url_cambio?>">Cambiar ciudad</a></li>
        <?php
			if($logged_um['logged'] == true){
				 if(have_favorites($logged_um['id_usuario'], $logged_um['tipo'])){
					 ?>
						<li><a href="<?=$configuracion['home_url']?>/favoritos.php">Mis Favoritas</a></li>
					 <?php
				 }
				 ?>
				 <li><a href="<?=$configuracion['home_url']?>/logout.php">Cerrar sesión</a></li>
				 <?php
		}else
		{
			?>
			<li><a href="<?=$configuracion['home_url']?>/login.php">Iniciar sesión</a></li>
			<li><a href="<?=$configuracion['home_url']?>/registro.php">Registrarse</a></li>
			<?php
		}
		?>
        
        
        </ul>
</div>
