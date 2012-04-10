<?php
function hex2rgb($im,$hex) {
    return imagecolorallocate($im,
        hexdec(substr($hex,0,2)),
        hexdec(substr($hex,2,2)),
        hexdec(substr($hex,4,2))
        );
}


header('Content-type: image/png');
$radio = $_GET['radio'];
$borde_c = $_GET['borde'];
$texto = trim($_GET['linea']);

//$texto = '6';
$font = '/home/turbano/ArialBlack.ttf';

if(!isset($radio) || !is_numeric($radio) || $radio > 250)
{
	$radio = 50;
}

$borde_w = $radio / 3.85;
if(!isset($borde_c) || strlen($borde_c) != 6)
{
	$borde_c = '000000';
}


$fondo_imagen = 'FFFFFF';
$relleno_imagen = 'FFFFFF';


$a = $radio*2;
$b = $a*4;
$c = $b/2;
$d = $b;
$e = $d-($borde_w*8);

$im1 = imagecreatetruecolor($b,$b);
$im2 = imagecreatetruecolor($a,$a);





imagefill($im1,0,0,hex2rgb($im1,$fondo_imagen));
imagefilledellipse($im1,$c,$c,$d,$d,hex2rgb($im1,$borde_c));
imagefilledellipse($im1,$c,$c,$e,$e,hex2rgb($im1,$relleno_imagen));




imagecopyresampled($im2,$im1,0,0,0,0,$a,$a,$b,$b);
//Ahora meto el texto de la linea

if(strlen($texto) > 3)
{
	$texto = $texto[0].$texto[1].'*';
}

switch(strlen($texto))
{
	case 1:
	$fuente_tama = $radio/1.25;
	$fuente_x = $radio/1.625;
	$fuente_y = $radio/0.724637681;
	break;
	
	case 2:
	$fuente_tama = $radio/1.428571429;
	$fuente_x = $radio/2.777777778;
	$fuente_y = $radio/0.724637681;
	break;
	
	case 3:
	$fuente_tama = $radio/2;
	$fuente_x = $radio/2.777777778;
	$fuente_y = $radio/0.806451613;
	break;
	
}


$black = imagecolorallocate($im2, 0, 0, 0);
imagettftext($im2, $fuente_tama, 0, $fuente_x, $fuente_y, $black, $font, $texto);

//Finalmente, muestro la imagen en pantalla
imagepng($im2);
imagedestroy($im);
imagedestroy($im2);

?>
