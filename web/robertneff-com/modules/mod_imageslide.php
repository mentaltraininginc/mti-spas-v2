<?php

/**

* @version $Id: mod_imageslide php 07 2005-10-30 13:00:00Z rabencor $

* @package Joomla

* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.

* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php

* Joomla! is free software. This version may have been modified pursuant

* to the GNU General Public License, and as distributed it includes or

* is derivative of works licensed under the GNU General Public License or

* other free or open source software licenses.

* See COPYRIGHT.php for copyright notices and details.

*

*

* This module is based on a DHTML / Javascript piece from DynamicDrivers

*

*

*/



// no direct access

defined( '_VALID_MOS' ) or die( 'Restricted access' );



global $mosConfig_live_site;





$imagefolder	= $params->get( 'imgfolder' );



$image01		= $params->get( 'img1' );

$image01_URL	= 'http://'.$params->get( 'link1' );

$image02		= $params->get( 'img2' );

$image02_URL	= 'http://'.$params->get( 'link2' );

$image03		= $params->get( 'img3' );

$image03_URL	= 'http://'.$params->get( 'link3' );

$image04		= $params->get( 'img4' );

$image04_URL	= 'http://'.$params->get( 'link4' );

$image05		= $params->get( 'img5' );

$image05_URL	= 'http://'.$params->get( 'link5' );



$imagewidth		= $params->get( 'imgw' );

$imageheight	= $params->get( 'imgh' );



$frameimg		= $params->get( 'frameimg' );

$framewidth		= $params->get( 'framewidth' );

$frameborder	= $params->get( 'frameborder' );

$framebcolor	= $params->get( 'framebcolor' );



$ss_speed		= $params->get( 'ss_speed' );



$link_open		= $params->get( 'link_open' );



$imagepath		= $mosConfig_live_site.$imagefolder;



if (!$frameimg) {

	$framewidth = 0;

	$frameborder = 'none';

}



echo '



<script language="JavaScript1.1">



	//specify interval between slide (in mili seconds)

	var slidespeed = '.$ss_speed.'



	//specify images

	var slideimages = new Array("'.$imagepath.$image01.'","'.$imagepath.$image02.'","'.$imagepath.$image03.'","'.$imagepath.$image04.'","'.$imagepath.$image01.'")



	//specify corresponding links

	var slidelinks = new Array("'.$image01_URL.'","'.$image02_URL.'","'.$image03_URL.'","'.$image04_URL.'","'.$image05_URL.'")



	var newwindow='.$link_open.' //open links in new window? 1=yes, 0=no



	var imageholder = new Array()

	var ie = document.all

	

	for ( i = 0 ; i < slideimages . length ; i++ ){

		imageholder[i] = new Image()

		imageholder[i].src = slideimages[i]

	}



	function goandshowme() {

		if (newwindow)

			window.open(slidelinks[whichlink])

		else

			window.location=slidelinks[whichlink]

		}

		

</script>

	<div align="center">
		<div style="display:block; width:'.( $imagewidth + ( $framewidth * 2 ) ).'px; height:'.( $imageheight + ( $framewidth * 2 ) ).'px; border:'.$frameborder.'px solid '.$framebcolor.';">
			<a href="javascript:goandshowme()"><img src="'.$imagepath.$image01.'" name="slide" style="filter:blendTrans(duration=2); margin-top:'.$framewidth.'px;" border="0" width="'.$imagewidth.'" height="'.$imageheight.'"></a>
		</div>
	</div>

<script>



	var whichlink=0

	var whichimage=0

	var blenddelay=(ie)? document.images.slide.filters[0].duration*500 : 0

	

	function slideit(){

		if (!document.images) return

			if (ie) document.images.slide.filters[0].apply()

				document.images.slide.src=imageholder[whichimage].src

			if (ie) document.images.slide.filters[0].play()

				whichlink=whichimage

				whichimage=(whichimage<slideimages.length-1)? whichimage+1 : 0

				setTimeout("slideit()",slidespeed+blenddelay)

		}

	

	slideit()



</script> ';





?>