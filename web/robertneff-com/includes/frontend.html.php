<?php
/**
* @version $Id: frontend.html.php 983 2005-11-11 15:08:46Z rhuk $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* @package Joomla
*/
class modules_html {

	function module( &$module, &$params, $Itemid, $style=0 ) {
		// custom module params
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );
		$rssurl 			= $params->get( 'rssurl' );
		
		if ( $rssurl ) {
			// feed output
			modules_html::modoutput_feed( $module, $params, $moduleclass_sfx );
		}

		switch ( $style ) {
			case -3:
			// allows for rounded corners
				modules_html::modoutput_rounded( $module, $params, $Itemid, $moduleclass_sfx, 1 );
				break;

			case -2:
			// xhtml (divs and font headder tags)
				modules_html::modoutput_xhtml( $module, $params, $Itemid, $moduleclass_sfx, 1 );
				break;

			case -1:
			// show a naked module - no wrapper and no title
				modules_html::modoutput_naked( $module, $params, $Itemid, $moduleclass_sfx, 1 );
				break;

			default:
			// standard tabled output
				modules_html::modoutput_table( $module, $params, $Itemid, $moduleclass_sfx, 1 );
				break;
		}

		
	}

	/**
	* @param object
	* @param object
	* @param int The menu item ID
	* @param int -1=show without wrapper and title, -2=xhtml style
	*/
	function module2( &$module, &$params, $Itemid, $style=0, $count=0 ) {
		global $mosConfig_lang, $mosConfig_absolute_path;

		$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

		// check for custom language file
		$path = $mosConfig_absolute_path . '/modules/' . $module->module . $mosConfig_lang .'.php';
		if (file_exists( $path )) {
			include( $path );
		} else {
			$path = $mosConfig_absolute_path .'/modules/'. $module->module .'.eng.php';
			if (file_exists( $path )) {
				include( $path );
			}
		}

		$number = '';
		if ($count > 0) {
			$number = '<span>' . $count . '</span> ';
		}

		switch ( $style ) {
			case -3:
			// allows for rounded corners
				modules_html::modoutput_rounded( $module, $params, $Itemid, $moduleclass_sfx );
				break;

			case -2:
			// xhtml (divs and font headder tags)
				modules_html::modoutput_xhtml( $module, $params, $Itemid, $moduleclass_sfx );
				break;

			case -1:
			// show a naked module - no wrapper and no title
				modules_html::modoutput_naked( $module, $params, $Itemid, $moduleclass_sfx );
				break;

			default:
			// standard tabled output
				modules_html::modoutput_table( $module, $params, $Itemid, $moduleclass_sfx );
				break;
		}
	}

	// feed output
	function modoutput_feed( &$module, &$params, $moduleclass_sfx ) {
		global $mosConfig_absolute_path, $rssfeed_content;

		$rssurl 			= $params->get( 'rssurl' );
		$rssitems 			= $params->get( 'rssitems', 5 );
		$rssdesc 			= $params->get( 'rssdesc', 1 );
		$rssimage 			= $params->get( 'rssimage', 1 );
		$rssitemdesc		= $params->get( 'rssitemdesc', 1 );
		$words 				= $params->def( 'word_count', 0 );
		$rsstitle			= $params->get( 'rsstitle', 1 );

		$contentBuffer	= '';
		$cacheDir 		= $mosConfig_absolute_path .'/cache/';
		$LitePath 		= $mosConfig_absolute_path .'/includes/Cache/Lite.php';
		require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_rss.php' );
		$rssDoc = new xml_domit_rss_document();
		$rssDoc->useCacheLite(true, $LitePath, $cacheDir, 3600);
		$rssDoc->loadRSS( $rssurl );
		$totalChannels 	= $rssDoc->getChannelCount();

		for ( $i = 0; $i < $totalChannels; $i++ ) {
			$currChannel =& $rssDoc->getChannel($i);
			$elements 	= $currChannel->getElementList();
			$iUrl		= 0;
			foreach ( $elements as $element ) {
				//image handling
				if ( $element == 'image' ) {
					$image =& $currChannel->getElement( DOMIT_RSS_ELEMENT_IMAGE );
					$iUrl	= $image->getUrl();
					$iTitle	= $image->getTitle();
				}
			}

			// feed title
			$content_buffer .= '';
			$content_buffer .= '<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">' . "\n";
						
			if ( $currChannel->getTitle() && $rsstitle ) {
				
				$content_buffer .= "<tr>\n";
				$content_buffer .= "	<td>\n";
				$content_buffer .= "		<strong>\n";
				$content_buffer .= "		<a href=\"" . ampReplace( $currChannel->getLink() )  . "\" target=\"_blank\">\n";
				$content_buffer .= 		$currChannel->getTitle() . "</a>\n";
				$content_buffer .= "		</strong>\n";
				$content_buffer .= "	</td>\n";
				$content_buffer .= "</tr>\n";

			}

			// feed description
			if ( $rssdesc ) {
				$content_buffer .= "<tr>\n";
				$content_buffer .= "	<td>\n";
				$content_buffer .= $currChannel->getDescription();
				$content_buffer .= "	</td>\n";
				$content_buffer .= "</tr>\n";
			}

			// feed image
			if ( $rssimage && $iUrl ) {
				$content_buffer .= "<tr>\n";
				$content_buffer .= "	<td align=\"center\">\n";
				$content_buffer .= "		<image src=\"" . $iUrl . "\" alt=\"" . @$iTitle . "\"/>\n";
				$content_buffer .= "	</td>\n";
				$content_buffer .= "</tr>\n";
			}

			$actualItems = $currChannel->getItemCount();
			$setItems = $rssitems;

			if ($setItems > $actualItems) {
				$totalItems = $actualItems;
			} else {
				$totalItems = $setItems;
			}


			$content_buffer .= "<tr>\n";
			$content_buffer .= "	<td>\n";
			$content_buffer .= "		<ul class=\"newsfeed" . $moduleclass_sfx . "\">\n";

					for ($j = 0; $j < $totalItems; $j++) {
						$currItem =& $currChannel->getItem($j);
						// item title

						$content_buffer .= "<li class=\"newsfeed" . $moduleclass_sfx . "\">\n";
						$content_buffer .= "	<strong>\n";
						$content_buffer .= "      " . str_replace('&apos;', "'", html_entity_decode( $currItem->getTitle() ) ) . "</a>\n";
						$content_buffer .= "	</strong>\n";
							// item description
							if ( $rssitemdesc ) {
								// item description
								$text = html_entity_decode( $currItem->getDescription() );
								$text = str_replace('&apos;', "'", $text);
                                
								// word limit check
								if ( $words ) {
									$texts = explode( ' ', $text );
									$count = count( $texts );
									if ( $count > $words ) {
										$text = '';
										for( $i=0; $i < $words; $i++ ) {
											$text .= ' '. $texts[$i];
										}
										$text .= '...';
									}
								}

								$content_buffer .= "     <div>\n";
								$content_buffer .= "        " . $text;
								$content_buffer .= "		</div>\n";

							}
						$content_buffer .= "</li>\n";
					}
			$content_buffer .= "    </ul>\n";
			$content_buffer .= "	</td>\n";
			$content_buffer .= "</tr>\n";
			$content_buffer .= "</table>\n";
		}
		$module->content = $content_buffer;
	}

	/*
	* standard tabled output
	*/
	function modoutput_table( $module, $params, $Itemid, $moduleclass_sfx, $type=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;
		?>
		<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
		<?php
		if ( $module->showtitle != 0 ) {
			?>
			<tr>
				<th valign="top">
					<?php echo $module->title; ?>
				</th>
			</tr>
			<?php
		}
		?>
		<tr>
			<td>
				<?php
				if ( $type ) {
					echo $module->content;
				} else {
					include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
					
					if (isset( $content)) {
						echo $content;
					}
				}
				?>
			</td>
		</tr>
		</table>
		<?php
	}

	/*
	* show a naked module - no wrapper and no title
	*/
	function modoutput_naked( $module, $params, $Itemid, $moduleclass_sfx, $type=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;

		if ( $type ) {
			echo $module->content;
		} else {
			include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
			
			if (isset( $content)) {
				echo $content;
			}
		}
	}

	/*
	* xhtml (divs and font headder tags)
	*/
	function modoutput_xhtml( $module, $params, $Itemid, $moduleclass_sfx, $type=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;
		?>
		<div class="moduletable<?php echo $moduleclass_sfx; ?>">
			<?php
			if ($module->showtitle != 0) {
				//echo $number;
				?>
				<h3>
					<?php echo $module->title; ?>
				</h3>
				<?php
			}

			if ( $type ) {
				echo $module->content;
			} else {
				include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
				
				if (isset( $content)) {
					echo $content;
				}
			}
			?>
		</div>
		<?php
	}

	/*
	* allows for rounded corners
	*/
	function modoutput_rounded( $module, $params, $Itemid, $moduleclass_sfx, $type=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;
		?>
		<div class="module<?php echo $moduleclass_sfx; ?>">
			<div>
				<div>
					<div>
						<?php //START HACK BY ERIK
						if ($module->title == "Cart Welcome Message"){
							if ( $type ) {
								echo $module->content;
							} else {
								include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
								
								if (isset( $content)) {
									echo $content;
								}
							}
						} // END HACK BY ERIK
						else {
							if ($module->showtitle != 0) {
								echo "<h3>$module->title</h3>";
							}
	
							if ( $type ) {
								echo $module->content;
							} else {
								include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
								
								if (isset( $content)) {
									echo $content;
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
?>