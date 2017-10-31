<?php
session_id($_GET['sessid']);
session_start();
header("Content-Type: image/png");
$xx = 60;
$yy = 18;
$im = imagecreate($xx, $yy) or die('Image create error!');
$bgcolor = imagecolorallocate($im, 255, 255, 255);
$bordercolor = imagecolorallocate($im, 0, 0, 0);
$linecolor = imagecolorallocate($im, 200, 110, 255);
$fontcolor = imagecolorallocate($im, 80, 55, 150);
for($x=7; $x < $xx-7; $x+=5) {
    imageline($im, $x+7, 0, $x-7, $yy-1, $linecolor);
    imageline($im, $x-7, 0, $x+7, $yy-1, $linecolor);
} // for
for($y=3; $y < $yy; $y+=3) imageline($im, 0, $y, $xx-1, $y, $linecolor);
imagestring($im, 5, 8, 1, $_SESSION['ff_seccode'], $fontcolor);
imageline($im, 0, 0, 0, $yy-1, $bordercolor);
imageline($im, 0, 0, $xx-1, 0, $bordercolor);
imageline($im, 0, $yy-1, $xx-1, $yy-1, $bordercolor);
imageline($im, $xx-1, 0, $xx-1, $yy-1, $bordercolor);
imagepng($im);
imagedestroy($im);
?>