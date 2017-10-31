<?php
/*
BSQ_Sitestats is written by Brent Stolle (c) 2005
Brent can be contacted at dev@bs-squared.com or at http://www.bs-squared.com/

This software is FREE. Please distribute it under the terms of the GNU/GPL License
See http://www.gnu.org/copyleft/gpl.html GNU/GPL for details.

If you fork this to create your own project, please make a reference to BSQ_Sitestats
someplace in your code and provide a link to http://www.bs-squared.com

BSQ_Sitestats is based on and made to operate along side of Shaun Inman's ShortStat
http://www.shauninman.com/
*/

/**
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Shaun Inman <http://www.shauninman.com>
* @author Brent Stolle <dev@bs-squared.com>
*
*/

/* Use this to map pseudo-foreign keys for browsers and back again */
$bsq_browserLookup = array(
	0 => "Indeterminable",
	"Indeterminable" => 0,
	
	1 => "Crawler/Search Engine",
	"Crawler/Search Engine" => 1,
	
	2 => "Safari",
	"Safari" => 2,
	
	3 => "Firefox",
	"Firefox" => 3,
	
	4 => "Internet Explorer",
	"Internet Explorer" => 4,
	
	5 => "Konqueror",
	"Konqueror" => 5,
	
	6 => "Opera",
	"Opera" => 6,
	
	7 => "Netscape",
	"Netscape" => 7,
	
	8 => "Mozilla",
	"Mozilla" => 8,
	
	9 => "Lynx",
	"Lynx" => 9
	);

/* HTTP language abbreviation to language/country */
$bsq_languageLookup = array(
	"af" => "Afrikaans",
	"ar" => "Argentina",
	"ar-sa" => "Argentina",
	"sq" => "Albanian",
	"eu" => "Basque",
	"bg" => "Bulgarian",
	"be" => "Byelorussian",
	"ca" => "Catalan",
	"zh" => "Chinese",
	"zh-cn" => "Chinese/China",
	"zh-tw" => "Chinese/Taiwan",
	"zh-hk" => "Chinese/Hong Kong",
	"zh-sg" => "Chinese/singapore",
	"hr" => "Croatian",
	"cs" => "Czech",
	"da" => "Danish",
	"nl" => "Dutch",
	"nl-nl" => "Dutch/Netherlands",
	"nl-NL" => "Dutch/Netherlands",
	"nl-be" => "Dutch/Belgium",
	"en" => "English",
	"en-gb" => "English/United Kingdom",
	"en-us" => "English/United States",
	"en-au" => "English/Australian",
	"en-ca" => "English/Canada",
	"en-nz" => "English/New Zealand",
	"en-ie" => "English/Ireland",
	"en-za" => "English/South Africa",
	"en-jm" => "English/Jamaica",
	"en-bz" => "English/Belize",
	"en-tt" => "English/Trinidad",
	"et" => "Estonian",
	"fo" => "Faeroese",
	"fa" => "Farsi",
	"fi" => "Finnish",
	"fr" => "French",
	"fr-be" => "French/Belgium",
	"fr-fr" => "French/France",
	"fr-ch" => "French/Switzerland",
	"fr-ca" => "French/Canada",
	"fr-lu" => "French/Luxembourg",
	"gd" => "Gaelic",
	"gl" => "Galician",
	"de" => "German",
	"de-at" => "German/Austria",
	"de-de" => "German/Germany",
	"de-ch" => "German/Switzerland",
	"de-lu" => "German/Luxembourg",
	"de-li" => "German/Liechtenstein",
	"el" => "Greek",
	"he" => "Hebrew",
	"he-il" => "Hebrew/Israel",
	"hi" => "Hindi",
	"hu" => "Hungarian",
	"hu-hu" => "Hungarian/Hungary",
	"ie-ee" => "Internet Explorer/Easter Egg",
	"is" => "Icelandic",
	"id" => "Indonesian",
	"in" => "Indonesian",
	"ga" => "Irish",
	"it" => "Italian",
	"it-it" => "Italian-Italy",
	"it-ch" => "Italian/ Switzerland",
	"ja" => "Japanese",
	"ko" => "Korean",
	"lv" => "Latvian",
	"lt" => "Lithuanian",
	"mk" => "Macedonian",
	"ms" => "Malaysian",
	"mt" => "Maltese",
	"no" => "Norwegian",
	"pl" => "Polish",
	"pt" => "Portuguese",
	"pt-br" => "Portuguese/Brazil",
	"rm" => "Rhaeto-Romanic",
	"ro" => "Romanian",
	"ro-mo" => "Romanian/Moldavia",
	"ru" => "Russian",
	"ru-mo" => "Russian/Moldavia",
	"ru-ru" => "Russian/Russia",
	"gd" => "Scots Gaelic",
	"sr" => "Serbian",
	"sk" => "Slovack",
	"sl" => "Slovenian",
	"sb" => "Sorbian",
	"es" => "Spanish",
	"es-do" => "Spanish",
	"es-ar" => "Spanish/Argentina",
	"es-co" => "Spanish/Colombia",
	"es-mx" => "Spanish/Mexico",
	"es-es" => "Spanish/Spain",
	"es-gt" => "Spanish/Guatemala",
	"es-cr" => "Spanish/Costa Rica",
	"es-pa" => "Spanish/Panama",
	"es-ve" => "Spanish/Venezuela",
	"es-pe" => "Spanish/Peru",
	"es-ec" => "Spanish/Ecuador",
	"es-cl" => "Spanish/Chile",
	"es-uy" => "Spanish/Uruguay",
	"es-py" => "Spanish/Paraguay",
	"es-bo" => "Spanish/Bolivia",
	"es-sv" => "Spanish/El salvador",
	"es-hn" => "Spanish/Honduras",
	"es-ni" => "Spanish/Nicaragua",
	"es-pr" => "Spanish/Puerto Rico",
	"es-us" => "Spanish/United States",
	"sx" => "Sutu",
	"sv" => "Swedish",
	"sv-se" => "Swedish/Sweden",
	"sv-fi" => "Swedish/Finland",
	"ts" => "Thai",
	"th" => "Thailand",
	"tn" => "Tswana",
	"tr" => "Turkish",
	"uk" => "Ukrainian",
	"ur" => "Urdu",
	"vi" => "Vietnamese",
	"xh" => "Xshosa",
	"ji" => "Yiddish",
	"zu" => "Zulu"
	);
	
/**
 * Look up a browser string for its ID
 * 
 * @param string $browser
 *
 * @return integer Browser ID to use
 */
function bsq_lookupBrowserStr($browser)
{
	global $bsq_browserLookup;
	
	if (isset($bsq_browserLookup[$browser])) {
		return $bsq_browserLookup[$browser];
	}
	else {
		return 0;
	}
}

/**
 * Look up a browser string given its ID
 * 
 * @param integer $browserID
 *
 * @return string Browser name
 */
function bsq_lookupBrowserID($browserID)
{
	global $bsq_browserLookup;
	
	if (isset($bsq_browserLookup[$browserID])) {
		return $bsq_browserLookup[$browserID];
	}
	else {
		return $bsq_browserLookup[0];
	}
}

?>



