<?php

/*
// The "AllVideos" Plugin for Joomla 1.0.x - Version 2.1
// License: http://www.gnu.org/copyleft/gpl.html
// Authors: Fotis Evangelou - George Chouliaras
// Copyright (c) 2006 JoomlaWorks.gr - http://www.joomlaworks.gr
// Project page at http://www.joomlaworks.gr - Demos at http://demo.joomlaworks.gr
// ***Last update: October 6th, 2006***
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

// Group One (flash based)
$_MAMBOTS->registerFunction( 'onPrepareContent', 'AllVideos_group_one' );

function AllVideos_group_one( $published, &$row, &$params, $page=0 ) {

// add parameters
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe, $database;
  $query = "SELECT id FROM #__mambots WHERE element = 'plugin_jw_allvideos' AND folder = 'content'";
  $database->setQuery( $query );
  $id = $database->loadResult();
  $mambot = new mosMambot( $database );
  $mambot->load( $id );
  $param =& new mosParameters( $mambot->params );  
  $allvideos_css = $param->get('allvideos_css', 'allvideos');
  $width = 'width:'.$param->get('width', 400).'px;';
  $height = 'height:'.$param->get('height', 323).'px;';
  $top_margin = 'margin-top:'.$param->get('top_margin', 8).'px;';
  $bottom_margin = 'margin-bottom:'.$param->get('bottom_margin', 8).'px;';
  $video_align = 'text-align:'.$param->get('video_align', 'center').';';
  $video_folder = $param->get('video_folder', 'images/stories/videos/');
  $video_image = $param->get('video_image', '');
  $video_clicktext = $param->get('video_clicktext', 'Click to watch the video!');
  $video_transparency = $param->get('video_transparency', 'transparent');
  $video_bg = $param->get('video_bg', '');
  $audio_folder = $param->get('audio_folder', 'images/stories/audio/');
  // iFilm - Metacafe only
  $ifilmwidth = 'width:'.$param->get('ifilmwidth', 400).'px;';
  $ifilmheight = 'height:'.$param->get('ifilmheight', 323).'px;';
  $metacafewidth = 'width:'.$param->get('metacafewidth', 400).'px;';
  $metacafeheight = 'height:'.$param->get('metacafeheight', 323).'px;'; 
  // for audio only
  $awidth = 'width:'.$param->get('awidth', 300).'px;';
  $aheight = 'height:'.$param->get('aheight', 60).'px;';    
// end parameters

$regex = array(

"flv" => array("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" style=\"".$width." ".$height."\" title=\"AllVideos Player\">
  <param name=\"movie\" value=\"$mosConfig_live_site/mambots/content/plugin_jw_allvideos/jw_allvideos_player.swf?file=$mosConfig_live_site/".$video_folder."***code***.flv&image=images/stories/".$video_image."&clicktext=".$video_clicktext."\" />
  <param name=\"quality\" value=\"high\" />
  <param name=\"wmode\" value=\"".$video_transparency."\" />
  <param name=\"bgcolor\" value=\"".$video_bg."\">
  <embed src=\"$mosConfig_live_site/mambots/content/plugin_jw_allvideos/jw_allvideos_player.swf?file=$mosConfig_live_site/".$video_folder."***code***.flv&image=images/stories/".$video_image."&clicktext=".$video_clicktext."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" wmode=\"".$video_transparency."\" bgcolor=\"".$video_bg."\" style=\"".$width." ".$height."\"></embed>
</object>", "#{flv}(.*?){/flv}#s") ,

"swf" => array("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" style=\"".$width." ".$height."\" title=\"AllVideos Player\">
  <param name=\"movie\" value=\"$mosConfig_live_site/".$video_folder."***code***.swf\" />
  <param name=\"quality\" value=\"high\" />
  <param name=\"wmode\" value=\"".$video_transparency."\" />
  <param name=\"bgcolor\" value=\"".$video_bg."\">
  <embed src=\"$mosConfig_live_site/".$video_folder."***code***.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" wmode=\"".$video_transparency."\" bgcolor=\"".$video_bg."\" style=\"".$width." ".$height."\"></embed>
</object>", "#{swf}(.*?){/swf}#s") ,

"mp3" => array("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" style=\"".$awidth." ".$aheight."\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" >
<param name=\"movie\" value=\"$mosConfig_live_site/mambots/content/plugin_jw_allvideos/jw_allvideos_aplayer.swf?file=$mosConfig_live_site/".$audio_folder."***code***.mp3\" />
<embed src=\"$mosConfig_live_site/mambots/content/plugin_jw_allvideos/jw_allvideos_aplayer.swf?file=$mosConfig_live_site/".$audio_folder."***code***.mp3\" style=\"".$awidth." ".$aheight."\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
</object>", "#{mp3}(.*?){/mp3}#s") ,

"google" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=en\"></embed>", "#{google}(.*?){/google}#s") ,

"google.co.uk" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=en-GB\"></embed>", "#{google.co.uk}(.*?){/google.co.uk}#s") ,

"google.de" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=de\"></embed>", "#{google.de}(.*?){/google.de}#s") ,

"google.es" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=es\"></embed>", "#{google.es}(.*?){/google.es}#s") ,

"google.fr" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=fr\"></embed>", "#{google.fr}(.*?){/google.fr}#s") ,

"google.it" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=it\"></embed>", "#{google.it}(.*?){/google.it}#s") ,

"google.nl" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=nl\"></embed>", "#{google.nl}(.*?){/google.nl}#s") ,

"google.pl" => array("<embed style=\"".$width." ".$height."\" id=\"VideoPlayback\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=***code***&hl=pl\"></embed>", "#{google.pl}(.*?){/google.pl}#s") ,

"ifilm" => array("<embed style=\"".$ifilmwidth." ".$ifilmheight."\" src=\"http://www.ifilm.com/efp\" quality=\"high\" wmode=\"transparent\" name=\"efp\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" flashvars=\"flvBaseClip=***code***\" />", "#{ifilm}(.*?){/ifilm}#s") ,

"youtube" => array("<object style=\"".$width." ".$height."\"><param name=\"movie\" value=\"http://www.youtube.com/v/***code***\" /><param name=\"wmode\" value=\"transparent\" /><embed src=\"http://www.youtube.com/v/***code***\"  wmode=\"transparent\" type=\"application/x-shockwave-flash\" style=\"".$width." ".$height."\"></embed></object>", "#{youtube}(.*?){/youtube}#s") ,

"vimeo" => array("<embed src=\"http://www.vimeo.com/moogaloop.swf?clip_id=***code***\" wmode=\"transparent\" quality=\"high\" style=\"".$width." ".$height."\" type=\"application/x-shockwave-flash\"></embed>", "#{vimeo}(.*?){/vimeo}#s") ,

"metacafe" => array("<embed src=\"http://www.metacafe.com/fplayer/***code***.swf\" style=\"".$metacafewidth." ".$metacafeheight."\" wmode=\"transparent\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed>", "#{metacafe}(.*?){/metacafe}#s") ,

"boltaudio" => array("<embed src=\"http://www.bolt.com/audio/audio_player_mp3_branded.swf?contentId=***code***&contentType=3\" loop=\"false\" quality=\"high\" style=\"".$width." ".$height."\" name=\"audio_player_mp3\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />", "#{boltaudio}(.*?){/boltaudio}#s") ,

"boltvideo" => array("<embed src=\"http://www.bolt.com/audio/audio_player_flv_branded.swf?contentId=***code***&contentType=2\" loop=\"false\" quality=\"high\" style=\"".$width." ".$height."\" name=\"audio_player_flv\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />", "#{boltvideo}(.*?){/boltvideo}#s") ,

"jumpcut" => array("<object style=\"".$width." ".$height."\">
<param name=\"movie\" value=\"http://www.jumpcut.com/media/flash/jump.swf\" />
<param name=\"flashvars\" value=\"asset_type=movie&asset_id=***code***&eb=1\" />
<embed src=\"http://www.jumpcut.com/media/flash/jump.swf\" style=\"".$width." ".$height."\" flashvars=\"asset_type=movie&asset_id=***code***&eb=1\" type=\"application/x-shockwave-flash\" />
</object>", "#{jumpcut}(.*?){/jumpcut}#s") ,

"currenttv" => array("<embed src=\"http://www.current.tv/studio/vm2/vm2.swf?type=vcc&id=***code***\" quality=\"high\" flashvars=\"videoType=vcc&videoID=***code***\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" style=\"".$width." ".$height."\" />", "#{currenttv}(.*?){/currenttv}#s") ,

"freevideoblog" => array("<embed src=\"http://video.freevideoblog.com/vidiac.swf\" FlashVars=\"video=***code***\" quality=\"high\" style=\"".$width." ".$height."\" name=\"ePlayer\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />", "#{freevideoblog}(.*?){/freevideoblog}#s") ,

"streetfire" => array("<embed src=\"http://videos.streetfire.net/vidiac.swf\" FlashVars=\"video=***code***\" quality=\"high\" style=\"".$width." ".$height."\" name=\"ePlayer\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />", "#{streetfire}(.*?){/streetfire}#s") ,

"crossroad" => array("<embed src=\"http://www.crossroadvideos.com/vidiac.swf\" FlashVars=\"video=***code***\" quality=\"high\" style=\"".$width." ".$height."\" name=\"ePlayer\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />", "#{crossroad}(.*?){/crossroad}#s") ,

"stickam" => array("<embed src=\"http://www.stickam.com/flashVarMediaPlayer/***code***\" type=\"application/x-shockwave-flash\" scale=\"noscale\" wmode=\"transparent\" style=\"".$width." ".$height."\"></embed>", "#{stickam}(.*?){/stickam}#s") ,

"myvideo" => array("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" style=\"".$width." ".$height."\"><param name=\"movie\" value=\"http://www.myvideo.de/movie/***code***\"></param><embed src=\"http://www.myvideo.de/movie/***code***\" style=\"".$width." ".$height."\" type=\"application/x-shockwave-flash\"></embed></object>", "#{myvideo}(.*?){/myvideo}#s") ,

"sevenload" => array("<object style=\"".$width." ".$height."\"><param name=\"movie\" value=\"http://sevenload.de/pl/***code***/500x403/swf\" /><embed src=\"http://sevenload.de/pl/***code***/500x403/swf\" type=\"application/x-shockwave-flash\" style=\"".$width." ".$height."\"></embed></object>", "#{sevenload}(.*?){/sevenload}#s") ,

"krazyshow" => array("<embed src=\"http://www.krazyshow.com/media/flvplayer2.swf?autoStart=0&popup=1&video=http%3a%2f%2fwww.krazyshow.com%2fmedia%2fgetflashvideo.ashx%3fcid%3d***code***\" type=\"application/x-shockwave-flash\" quality=\"high\" style=\"".$width." ".$height."\"></embed>", "#{krazyshow}(.*?){/krazyshow}#s") ,

"uume" => array("<object style=\"".$width." ".$height."\"><param name='movie' value='http://www.uume.com/v/***code***_UUME'></param><embed src='http://www.uume.com/v/***code***_UUME' type='application/x-shockwave-flash' style=\"".$width." ".$height."\"></embed></object>", "#{uume}(.*?){/uume}#s") ,

"tudou" => array("<object style=\"".$width." ".$height."\"><param name=\"movie\" value=\"http://www.tudou.com/v/***code***\"></param><embed src=\"http://www.tudou.com/v/***code***\" type=\"application/x-shockwave-flash\" style=\"".$width." ".$height."\"></embed></object>", "#{tudou}(.*?){/tudou}#s") ,

"seehaha" => array("<object><embed src=\"http://www.seehaha.com/flash/playvid2.swf?vidID=***code***\" quality=\"high\" style=\"".$width." ".$height."\"></embed></object>", "#{seehaha}(.*?){/seehaha}#s") ,

"quxiu" => array("<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' style=\"".$width." ".$height."\"><param name='movie' value='http://www.quxiu.com/photo/swf/swfobj.swf?id=***code***'><param name='quality' value='high'><param name='menu' value='false'></object>", "#{quxiu}(.*?){/quxiu}#s") ,

"wangyou" => array("<object style=\"".$width." ".$height."\"><param name=\"movie\" value=\"http://v.wangyou.com/images/x_player.swf?id=***code***\"></param><embed src=\"http://v.wangyou.com/images/x_player.swf?id=***code***\" quality=\"high\" wmode=\"transparent\" style=\"".$width." ".$height."\" allowScriptAccess=\"sameDomain\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed></object>", "#{wangyou}(.*?){/wangyou}#s") ,

"mofile" => array("<object style=\"".$width." ".$height."\" id='moxtv' name='moxtv'><param name='FlashVars' value='v=***code***&autoplay=0' /><param name='movie' value='http://tv.mofile.com/cn/xplayer.swf'><param name='allowScriptAccess' value='sameDomain' /><param name='wmode' value='transparent'><param name='bgcolor' value='#000000'><embed FlashVars='v=***code***&autoplay=0' src='http://tv.mofile.com/cn/xplayer.swf' wmode='transparent' quality='high' style=\"".$width." ".$height."\" allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' /></object>", "#{mofile}(.*?){/mofile}#s") ,

);
	  
// prepend and append code
$startcode = "\n\n<!-- JW AllVideos Plugin (v2.1) starts here -->\n<div style=\"clear:both;".$video_align.$top_margin.$bottom_margin."\" class=\"".$allvideos_css."\">\n";
$endcode = "\n</div>\n<!-- JW AllVideos Plugin (v2.1) ends here -->\n\n";
	    if ( !$published ) {		
		    foreach ($regex as $key => $value) {
		      $row->text = preg_replace( $regex[$key][1], '', $row->text );
		    }
		    return;
	    }		
	    foreach ($regex as $key => $value) {  // searching for marks     	    		    	
	    	if (preg_match_all($regex[$key][1], $row->text, $matches, PREG_PATTERN_ORDER) > 0) {      			 
	    		foreach ($matches[0] as $match) {	
				$match = preg_replace("/{.+?}/", "", $match); 
				$code = str_replace("***code***", $match, $regex[$key][0] );

				$row->text = preg_replace( "#{".$key."}".$match."{/".$key."}#s", $startcode.$code.$endcode , $row->text );
	    		}
	    	}	    	
	    }  
}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

// Group Two (windows media, mpg, mpeg, avi based)
$_MAMBOTS->registerFunction( 'onPrepareContent', 'AllVideos_group_two' );

function AllVideos_group_two( $published, &$row, &$params, $page=0 ) {

// add parameters
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe, $database;
  $query = "SELECT id FROM #__mambots WHERE element = 'plugin_jw_allvideos' AND folder = 'content'";
  $database->setQuery( $query );
  $id = $database->loadResult();
  $mambot = new mosMambot( $database );
  $mambot->load( $id );
  $param =& new mosParameters( $mambot->params );  
  $allvideos_css = $param->get('allvideos_css', 'allvideos');
  $width = 'width:'.$param->get('width', 400).'px;';
  $height = 'height:'.$param->get('height', 323).'px;';
  $top_margin = 'margin-top:'.$param->get('top_margin', 8).'px;';
  $bottom_margin = 'margin-bottom:'.$param->get('bottom_margin', 8).'px;';
  $video_align = 'text-align:'.$param->get('video_align', 'center').';';
  $video_folder = $param->get('video_folder', 'images/stories/videos/');
  $video_clicktext = $param->get('video_clicktext', 'Click to watch the video!');
  $video_transparency = $param->get('video_transparency', 'transparent');
  $video_bg = $param->get('video_bg', '');
  $audio_folder = $param->get('audio_folder', 'images/stories/audio/');
  // for audio only
  $awidth = 'width:'.$param->get('awidth', 300).'px;';
  $aheight = 'height:'.$param->get('aheight', 60).'px;';   
// end parameters

$regex = array(

"wmv" => array("<object classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" type=\"application/x-oleobject\" style=\"".$width." ".$height."\">
	<param name=\"URL\" value=\"$mosConfig_live_site/".$video_folder."***code***.wmv\" />
	<param name=\"ShowControls\" value=\"1\">
	<param name=\"autoStart\" value=\"0\">
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.wmv\" style=\"".$width." ".$height."\" autoStart=\"0\" type=\"application/x-mplayer2\"/></embed>
</object>", "#{wmv}(.*?){/wmv}#s") ,

"wma" => array("<object classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" type=\"application/x-oleobject\" style=\"".$awidth." ".$aheight."\">
	<param name=\"URL\" value=\"$mosConfig_live_site/".$audio_folder."***code***.wma\" />
	<param name=\"ShowControls\" value=\"1\">
	<param name=\"autoStart\" value=\"0\">
<embed src=\"$mosConfig_live_site/".$audio_folder."***code***.wma\" style=\"".$awidth." ".$aheight."\" autoStart=\"0\" type=\"application/x-mplayer2\"/></embed>
</object>", "#{wma}(.*?){/wma}#s") ,

"avi" => array("<object classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" type=\"application/x-oleobject\" style=\"".$width." ".$height."\">
	<param name=\"URL\" value=\"$mosConfig_live_site/".$video_folder."***code***.avi\" />
	<param name=\"ShowControls\" value=\"1\">
	<param name=\"autoStart\" value=\"0\">
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.avi\" style=\"".$width." ".$height."\" autoStart=\"0\" type=\"application/x-mplayer2\"/></embed>
</object>", "#{avi}(.*?){/avi}#s") ,

"mpg" => array("<object classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" type=\"application/x-oleobject\" style=\"".$width." ".$height."\">
	<param name=\"URL\" value=\"$mosConfig_live_site/".$video_folder."***code***.mpg\" />
	<param name=\"ShowControls\" value=\"1\">
	<param name=\"autoStart\" value=\"0\">
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.mpg\" style=\"".$width." ".$height."\" autoStart=\"0\" type=\"application/x-mplayer2\"/></embed>
</object>", "#{mpg}(.*?){/mpg}#s") ,

"mpeg" => array("<object classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" type=\"application/x-oleobject\" style=\"".$width." ".$height."\">
	<param name=\"URL\" value=\"$mosConfig_live_site/".$video_folder."***code***.mpeg\" />
	<param name=\"ShowControls\" value=\"1\">
	<param name=\"autoStart\" value=\"0\">
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.mpeg\" style=\"".$width." ".$height."\" autoStart=\"0\" type=\"application/x-mplayer2\"/></embed>
</object>", "#{mpeg}(.*?){/mpeg}#s") ,

"bofunk" => array("<embed name=\"RAOCXplayer\" src=\"http://www.bofunk.com/myspace/***code***.asx\" type=\"application/x-mplayer2\" style=\"".$width." ".$height."\" ShowControls=\"1\" ShowStatusBar=\"0\" loop=\"false\" EnableContextMenu=\"0\" DisplaySize=\"0\" pluginspage=\"http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/\" />", "#{bofunk}(.*?){/bofunk}#s") ,

"break" => array("<embed src=\"http://clip.break.com/dnet/media/content/***code***.wmv\" style=\"".$width." ".$height."\" autoplay=\"false\" />", "#{break}(.*?){/break}#s") ,

"myspacevideocode" => array("<embed type=\"application/x-mplayer2\" src=\"http://www.myspacevideocode.com/code.php?id=***code***\" name=\"MediaPlayer\" style=\"".$width." ".$height."\" ShowControls=\"1\" ShowStatusBar=\"0\" ShowDisplay=\"0\" autostart=\"0\" />", "#{myspacevideocode}(.*?){/myspacevideocode}#s")

);
	  
// prepend and append code
$startcode = "\n\n<!-- JW AllVideos Plugin (v2.1) starts here -->\n<div style=\"clear:both;".$video_align.$top_margin.$bottom_margin."\" class=\"".$allvideos_css."\">\n";
$endcode = "\n</div>\n<!-- JW AllVideos Plugin (v2.1) ends here -->\n\n";
	    if ( !$published ) {		
		    foreach ($regex as $key => $value) {
		      $row->text = preg_replace( $regex[$key][1], '', $row->text );
		    }
		    return;
	    }		
	    foreach ($regex as $key => $value) {  // searching for marks     	    		    	
	    	if (preg_match_all($regex[$key][1], $row->text, $matches, PREG_PATTERN_ORDER) > 0) {      			 
	    		foreach ($matches[0] as $match) {	
				$match = preg_replace("/{.+?}/", "", $match); 
				$code = str_replace("***code***", $match, $regex[$key][0] );

				$row->text = preg_replace( "#{".$key."}".$match."{/".$key."}#s", $startcode.$code.$endcode , $row->text );
	    		}
	    	}	    	
	    }  
}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

// Group Three (quicktime -mov and mp4- based)
$_MAMBOTS->registerFunction( 'onPrepareContent', 'AllVideos_group_three' );

function AllVideos_group_three( $published, &$row, &$params, $page=0 ) {

// add parameters
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe, $database;
  $query = "SELECT id FROM #__mambots WHERE element = 'plugin_jw_allvideos' AND folder = 'content'";
  $database->setQuery( $query );
  $id = $database->loadResult();
  $mambot = new mosMambot( $database );
  $mambot->load( $id );
  $param =& new mosParameters( $mambot->params );  
  $allvideos_css = $param->get('allvideos_css', 'allvideos');
  $width = 'width:'.$param->get('width', 400).'px;';
  $height = 'height:'.$param->get('height', 323).'px;';
  $top_margin = 'margin-top:'.$param->get('top_margin', 8).'px;';
  $bottom_margin = 'margin-bottom:'.$param->get('bottom_margin', 8).'px;';
  $video_align = 'text-align:'.$param->get('video_align', 'center').';';
  $video_folder = $param->get('video_folder', 'images/stories/videos/');
  $video_clicktext = $param->get('video_clicktext', 'Click to watch the video!');
  $video_transparency = $param->get('video_transparency', 'transparent');
  $video_bg = $param->get('video_bg', '');
  $audio_folder = $param->get('audio_folder', 'images/stories/audio/');
// end parameters

$regex = array(

"mov" => array("<object codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" style=\"".$width." ".$height."\">
<param name=\"src\" value=\"$mosConfig_live_site/".$video_folder."***code***.mov\" />
<param name=\"controller\" value=\"True\" />
<param name=\"cache\" value=\"False\" />
<param name=\"autoplay\" value=\"False\" />
<param name=\"kioskmode\" value=\"False\" />
<param name=\"scale\" value=\"tofit\" />
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.mov\" pluginspage=\"http://www.apple.com/quicktime/download/\" scale=\"tofit\" kioskmode=\"False\" qtsrc=\"$mosConfig_live_site/".$video_folder."***code***.mov\" cache=\"False\" style=\"".$width." ".$height."\" controller=\"True\" type=\"video/quicktime\" autoplay=\"False\" /></object>", "#{mov}(.*?){/mov}#s"),

"mp4" => array("<object codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" style=\"".$width." ".$height."\">
<param name=\"src\" value=\"$mosConfig_live_site/".$video_folder."***code***.mp4\" />
<param name=\"controller\" value=\"True\" />
<param name=\"cache\" value=\"False\" />
<param name=\"autoplay\" value=\"False\" />
<param name=\"kioskmode\" value=\"False\" />
<param name=\"scale\" value=\"tofit\" />
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.mp4\" pluginspage=\"http://www.apple.com/quicktime/download/\" scale=\"tofit\" kioskmode=\"False\" qtsrc=\"$mosConfig_live_site/".$video_folder."***code***.mov\" cache=\"False\" style=\"".$width." ".$height."\" controller=\"True\" type=\"video/quicktime\" autoplay=\"False\" /></object>", "#{mp4}(.*?){/mp4}#s"),

"revver" => array("<object codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" style=\"".$width." ".$height."\">
<param name=\"src\" value=\"http://media.revver.com/broadcast/***code***/video.mov\" />
<param name=\"controller\" value=\"True\" />
<param name=\"cache\" value=\"False\" />
<param name=\"autoplay\" value=\"False\" />
<param name=\"kioskmode\" value=\"False\" />
<param name=\"scale\" value=\"tofit\" />
<embed src=\"http://media.revver.com/broadcast/***code***/video.mov\" pluginspage=\"http://www.apple.com/quicktime/download/\" scale=\"tofit\" kioskmode=\"False\" qtsrc=\"http://media.revver.com/broadcast/***code***/video.mov\" cache=\"False\" style=\"".$width." ".$height."\" controller=\"True\" type=\"video/quicktime\" autoplay=\"False\" /></object>", "#{revver}(.*?){/revver}#s")

);
	  
// prepend and append code
$startcode = "\n\n<!-- JW AllVideos Plugin (v2.1) starts here -->\n<div style=\"clear:both;".$video_align.$top_margin.$bottom_margin."\" class=\"".$allvideos_css."\">\n";
$endcode = "\n</div>\n<!-- JW AllVideos Plugin (v2.1) ends here -->\n\n";
	    if ( !$published ) {		
		    foreach ($regex as $key => $value) {
		      $row->text = preg_replace( $regex[$key][1], '', $row->text );
		    }
		    return;
	    }		
	    foreach ($regex as $key => $value) {  // searching for marks     	    		    	
	    	if (preg_match_all($regex[$key][1], $row->text, $matches, PREG_PATTERN_ORDER) > 0) {      			 
	    		foreach ($matches[0] as $match) {	
				$match = preg_replace("/{.+?}/", "", $match); 
				$code = str_replace("***code***", $match, $regex[$key][0] );

				$row->text = preg_replace( "#{".$key."}".$match."{/".$key."}#s", $startcode.$code.$endcode , $row->text );
	    		}
	    	}	    	
	    }  
}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

// Group Four (Real Media .rm based)
$_MAMBOTS->registerFunction( 'onPrepareContent', 'AllVideos_group_four' );

function AllVideos_group_four( $published, &$row, &$params, $page=0 ) {

// add parameters
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe, $database;
  $query = "SELECT id FROM #__mambots WHERE element = 'plugin_jw_allvideos' AND folder = 'content'";
  $database->setQuery( $query );
  $id = $database->loadResult();
  $mambot = new mosMambot( $database );
  $mambot->load( $id );
  $param =& new mosParameters( $mambot->params );  
  $allvideos_css = $param->get('allvideos_css', 'allvideos');
  $width = 'width:'.$param->get('width', 400).'px;';
  $height = 'height:'.$param->get('height', 323).'px;';
  $top_margin = 'margin-top:'.$param->get('top_margin', 8).'px;';
  $bottom_margin = 'margin-bottom:'.$param->get('bottom_margin', 8).'px;';
  $video_align = 'text-align:'.$param->get('video_align', 'center').';';
  $video_folder = $param->get('video_folder', 'images/stories/videos/');
  $video_clicktext = $param->get('video_clicktext', 'Click to watch the video!');
  $video_transparency = $param->get('video_transparency', 'transparent');
  $video_bg = $param->get('video_bg', '');
  $audio_folder = $param->get('audio_folder', 'images/stories/audio/');
// end parameters

$regex = array(

"rm" => array("<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" style=\"".$width." ".$height."\">
	<param name=\"controls\" value=\"ControlPanel\" />
	<param name=\"autostart\" value=\"0\" />
	<param name=\"src\" value=\"$mosConfig_live_site/".$video_folder."***code***.rm\" />
<embed src=\"$mosConfig_live_site/".$video_folder."***code***.rm\" type=\"audio/x-pn-realaudio-plugin\" style=\"".$width." ".$height."\" controls=\"ControlPanel\" autostart=\"0\" />
</object>", "#{rm}(.*?){/rm}#s")

);
	  
// prepend and append code
$startcode = "\n\n<!-- JW AllVideos Plugin (v2.1) starts here -->\n<div style=\"clear:both;".$video_align.$top_margin.$bottom_margin."\" class=\"".$allvideos_css."\">\n";
$endcode = "\n</div>\n<!-- JW AllVideos Plugin (v2.1) ends here -->\n\n";
	    if ( !$published ) {		
		    foreach ($regex as $key => $value) {
		      $row->text = preg_replace( $regex[$key][1], '', $row->text );
		    }
		    return;
	    }		
	    foreach ($regex as $key => $value) {  // searching for marks     	    		    	
	    	if (preg_match_all($regex[$key][1], $row->text, $matches, PREG_PATTERN_ORDER) > 0) {      			 
	    		foreach ($matches[0] as $match) {	
				$match = preg_replace("/{.+?}/", "", $match); 
				$code = str_replace("***code***", $match, $regex[$key][0] );

				$row->text = preg_replace( "#{".$key."}".$match."{/".$key."}#s", $startcode.$code.$endcode , $row->text );
	    		}
	    	}	    	
	    }  
}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////
// Special - Video providers that do not fit the above groups for some reason. //
/////////////////////////////////////////////////////////////////////////////////

// **************************** http://www.dropshots.com/ **************************** //
$_MAMBOTS->registerFunction( 'onPrepareContent', 'DropShots' );
function DropShots( $published, &$row, &$params, $page=0 ) {
	global $mosConfig_absolute_path;
	$regex = "#{dropshots}(.*?){/dropshots}#s";
	if ( !$published ) {
		$row->text = preg_replace( $regex, '', $row->text );
		return;
	}
	$row->text = preg_replace_callback( $regex, 'DropShots_replacer', $row->text );
	return true;
}

function DropShots_replacer ( &$matches ) {

// add parameters
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe, $database;
  $query = "SELECT id FROM #__mambots WHERE element = 'plugin_jw_allvideos' AND folder = 'content'";
  $database->setQuery( $query );
  $id = $database->loadResult();
  $mambot = new mosMambot( $database );
  $mambot->load( $id );
  $param =& new mosParameters( $mambot->params );  
  $allvideos_css = $param->get('allvideos_css', 'allvideos');
  $width = 'width:'.$param->get('width', 400).'px;';
  $height = 'height:'.$param->get('height', 323).'px;';
  $top_margin = 'margin-top:'.$param->get('top_margin', 8).'px;';
  $bottom_margin = 'margin-bottom:'.$param->get('bottom_margin', 8).'px;';
  $video_align = 'text-align:'.$param->get('video_align', 'center').';';
  $video_folder = $param->get('video_folder', 'images/stories/videos/');
  $video_clicktext = $param->get('video_clicktext', 'Click to watch the video!');
  $video_transparency = $param->get('video_transparency', 'transparent');
  $video_bg = $param->get('video_bg', '');
  $audio_folder = $param->get('audio_folder', 'images/stories/audio/');
// end parameters

$dropshots = $matches[1];
$tmp = explode("?", $dropshots);
$params = $tmp[1];
$tmp2 = explode("&", $params);
$i=0;
$mystring = array();
while ( $i < count ( $tmp2 ) ) {
      $tmp3 = split ( "=", $tmp2[$i]);
      $mystring[] = $tmp3[1];
      $i++;
}
$dropshotsclean = implode ( "/", $mystring );

$res = '<!-- JW AllVideos Plugin (v2.1) starts here -->

<div style="clear:both;'.$video_align.''.$top_margin.''.$bottom_margin.'" class="'.$allvideos_css.'">
<embed src="http://www.dropshots.com/dropshotsplayer.swf" Flashvars="url=http://www.dropshots.com/photos/'.$dropshotsclean.'.flv&post=1" style="'.$width.' '.$height.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</div>

<!-- JW AllVideos Plugin (v2.1) ends here -->';
	return $res;
}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

// This is the excellent "EOLAS - no click to activate" fix/patch
// from Gero Zahn, for IE and Opera browsers, which is already
// implemented for Joomla as a seperate plugin.

/*
* @version v 1.0
* @author: Gero Zahn, gero@gerozahn.de www.gerozahn.de/bot_gznoclicktoactivate
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botgznoclicktoactivate' );

function botgznoclicktoactivate( $published, &$row, $mask=0, $page=0 ) {
	global $mosConfig_absolute_path, $mosConfig_live_site;
	if (!$published) { # not published?
		return;
	} else { # Work just if published
	  # All tag areas or tags to be processed. Important: Start with <object ...>...</object> areas
	  # as it could contain an <embed ...>..</embed> area or (perhaps) an unclosed <embed ...> tags
	  $tags=array('`<object[^>]*>(.*)</object>`isU', # <object ...>...</object> areas
	              '`<applet[^>]*>(.*)</applet>`isU', # <applet ...>...</applet> areas
	              '`<embed[^>]*>(.*)</embed>`isU',   # <embed ...>..</embed> areas
	              '`<embed[^>]*>`isU');              # single, unclosed <embed ...> tags outsite object areas
	  $replacements=array(); # Storage for the elements found to be processed
	  foreach(array_keys($tags) as $idx) { # Handle all kings of tag areas and tags, one by one
	    $tmptags=array(); # Storage for the found occurrences
	    preg_match_all($tags[$idx],$row->text,$tmptags); # And here they are
	    if ($tmptags) { # Found some?
	      foreach(array_keys($tmptags[0]) as $secidx) { # Deal with them, one by one
	        # We have to move them apart -- especially <object ...>...</object> areas with an internal
	        # <embed ...>..</embed> area or an unclosed <embed ...> tag -- otherwise they'd be found again.
	        $tagval=$tmptags[0][$secidx]; # This is the current occurrence to be processed later on
	        $tagkey="replacetag_".$idx."_".$secidx; # Temporarily replace it by "replacetag_x_y"
	        # ... where x is 0..3 (object/applet/embed/s.embed) and y is the corresponding number.
	        $replacements[$tagkey]=$tagval; # Store the occurrence beside it's unique key ...
	        $row->text=str_replace($tagval,$tagkey,$row->text); # ... and actually replace the occurrence with the key
	      }
	    }
	    unset($tmptags); # A bit of dirty work
	  }
	  foreach($replacements as $tagkey => $tagval) { # Handle all occurrences, one by one
	    $jsval=addslashes($tagval); # Handle special characters properly
	    $jsval=str_replace(chr(13),"",$jsval); # remove CRs - all in one line
	    $jsval=str_replace(chr(10),"",$jsval); # remove LFs - all in one line
	    # 1. Embed that tiny little external JS to work as actual embedder.
	    # 2. Embed the original occurrence inside a JS variable -- 
	    # 3. Call the tiny little embedder to dynamically output the variable
	    # 4. Embed the original, unchanged occurrence in a <noscript>...</noscript> area as fall-back
$jsval= "<script src=\"$mosConfig_live_site/mambots/content/plugin_jw_allvideos/gz_eolas_fix.js\" type=\"text/javascript\"></script>\n".
		"<script language=\"JavaScript\">\n".
		"<!--\n".
		"var jsval = '$jsval';\n".
		# "//document.write(jsval);". # This doesn't work as it's an internal document.write(...)
		"writethis(jsval);". # So: Use the external one-liner function to perform the trick
		"//-->\n".
		"</script>\n".
		"<noscript>$tagval</noscript>";
	    # The original occurrence has been replaced with its unique "key" beforehanded,
		# now replace this stored key with is JS wrapper and noscript fallback.
	    $row->text=str_replace($tagkey,$jsval,$row->text);
	  }
	  unset($replacements); # A bit of dirty work
		return true; # Done!
	}
}

// END

?>