<? 
/**
* @package COToolKit.php
* @Copyright Chanh Ong 10/29/2005
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/
// Test code of my tool kit
/*
$tm=time();
co_prt($tm);
co_prt(co_dte($tm));
co_prt(co_t2days($tm));
co_prt(co_t2days($tm)-1);
co_prt(co_t2days($tm)+1);
$test=co_t2days($tm)-10;
$ttime=co_d2t($test);
co_prt(co_diffdays($tm,$ttime));
co_prt(co_diffdaysindate($tm,-10));
*/
// function that use low level function from low level
function co_diffdaysindate($tm,$days) { 
$diff = co_d2t(co_t2days($tm)+$days);
return co_dte($diff);
}
function co_diffdays($tm,$dte) { 
if ($dte>$tm) { $diff=$dite-$tm; } else { $diff=$tm-$dte;} 
return co_t2days($diff);
}
// low level function w/o dependency
function co_mk_imgsrc($img) { if ($img <> "") { return "<img src=".$img." Border=0>"; } }
function co_d2t($dte) { return ($dte*60*60*24); }
function co_t2days($tm) { return round($tm/60/60/24); }
function co_dte($tm) { return date( "Y-m-d H:i:s",$tm); }
function co_prt($il) { echo $il."\n<br />"; }
?>