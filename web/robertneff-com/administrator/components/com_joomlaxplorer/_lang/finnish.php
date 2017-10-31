<?php

// English Language Module for v2.3 (translated by Jarmo Keränen)

$GLOBALS["charset"] = "iso-8859-1";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "VIRHE(ET)",
	"back"			=> "Palaa",
	
	// root
	"home"			=> "Koti hakemistoa ei ole, tarkista asetuksesi.",
	"abovehome"		=> "Nykyinen hakemisto ei saa olla kotihakemiston yläpuolella.",
	"targetabovehome"	=> "Kohdehakemisto ei saa olla kotihakemiston yläpuolella.",
	
	// exist
	"direxist"		=> "Tämä hakemisto ei ole olemassa.",
	//"filedoesexist"	=> "This file already exists.",
	"fileexist"		=> "Tämä tiedosto ei ole olemassa.",
	"itemdoesexist"		=> "Tämä nimike on jo olemassa.",
	"itemexist"		=> "Tämä nimike ei ole olemassa.",
	"targetexist"		=> "Kohdehakemisto ei ole olemassa.",
	"targetdoesexist"	=> "Kohdenimike on jo olemassa.",
	
	// open
	"opendir"		=> "Hakemistoa ei voida avata.",
	"readdir"		=> "Hakemistoa ei voida lukea.",
	
	// access
	"accessdir"		=> "Sinulla ei ole valtuuksia tähän hakemistoon.",
	"accessfile"		=> "Sinulla ei ole valtuuksia tähän tiedostoon.",
	"accessitem"		=> "Sinulla ei ole valtuuksia tähän nimikkeeseen.",
	"accessfunc"		=> "Sinulla ei ole valtuuksia tähän toimintoon.",
	"accesstarget"		=> "Sinulla ei ole valtuuksia kohdehakemistoon.",
	
	// actions
	"permread"		=> "Oikeuksien saanti epäonnistui.",
	"permchange"		=> "Oikeuksien muutos epäonnistui.",
	"openfile"		=> "Tiedoston avaaminen epäonnistui.",
	"savefile"		=> "Tiedoston tallennus epäonnistui.",
	"createfile"		=> "Tiedoston luonti epäonnistui.",
	"createdir"		=> "Hakemiston luonti epäonnistui.",
	"uploadfile"		=> "Tiedoston uploadaus epäonnistui.",
	"copyitem"		=> "Kopionti epäonnistui.",
	"moveitem"		=> "Siirto epäonnistui.",
	"delitem"		=> "Poisto epäonnistui.",
	"chpass"		=> "Salasanan vaihto epäonnistui.",
	"deluser"		=> "Käyttäjän poisto epäonnistui.",
	"adduser"		=> "Käyttäjän lisäys epäonnistui.",
	"saveuser"		=> "Käyttäjän tallennus epäonnistui.",
	"searchnothing"		=> "Sinun pitää antaa jotain etsittävää.",
	
	// misc
	"miscnofunc"		=> "Toiminto ei ole saatavilla.",
	"miscfilesize"		=> "Tiedosto ylittää maksimikoon.",
	"miscfilepart"		=> "Tiedosto uploadautui vain osittain.",
	"miscnoname"		=> "Anna nimi.",
	"miscselitems"		=> "Et ole valinnut yhtään nimikettä.",
	"miscdelitems"		=> "Oletko varma että haluat poistaa nämä \"+num+\" nimikettä?",
	"miscdeluser"		=> "Oletko varma että haluat poistaa käyttäjän '\"+user+\"'?",
	"miscnopassdiff"	=> "Uusi salasanasi ei eroa nykyisestä.",
	"miscnopassmatch"	=> "Salasanat eivät täsmää.",
	"miscfieldmissed"	=> "Ohitit tärkeän kentän.",
	"miscnouserpass"	=> "Käyttäjänimi tai salasana on väärä.",
	"miscselfremove"	=> "Et voi poistaa itseäsi.",
	"miscuserexist"		=> "Käyttäjä on jo olemassa.",
	"miscnofinduser"	=> "Käyttäjää ei löydy.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "MUUTA OIKEUKSIA",
	"editlink"		=> "MUOKKAA",
	"downlink"		=> "DOWNLOAD",
	"uplink"		=> "YLÖS",
	"homelink"		=> "KOTI",
	"reloadlink"		=> "RELOAD",
	"copylink"		=> "KOPIOI",
	"movelink"		=> "SIIRRÄ",
	"dellink"		=> "POISTA",
	"comprlink"		=> "ARKISTOI",
	"adminlink"		=> "HALLINTA",
	"logoutlink"		=> "POISTU",
	"uploadlink"		=> "UPLOAD",
	"searchlink"		=> "ETSI",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Nimi",
	"sizeheader"		=> "Koko",
	"typeheader"		=> "Tyyppi",
	"modifheader"		=> "Muutettu",
	"permheader"		=> "Oikeudet",
	"actionheader"		=> "Toiminnat",
	"pathheader"		=> "Polku",
	
	// buttons
	"btncancel"		=> "Peruuta",
	"btnsave"		=> "Tallenna",
	"btnchange"		=> "Muuta",
	"btnreset"		=> "Nollaa",
	"btnclose"		=> "Sulje",
	"btncreate"		=> "Luo",
	"btnsearch"		=> "Etsi",
	"btnupload"		=> "Upload",
	"btncopy"		=> "Kopioi",
	"btnmove"		=> "Siirrä",
	"btnlogin"		=> "Kirjaudu",
	"btnlogout"		=> "Poistu",
	"btnadd"		=> "Lisää",
	"btnedit"		=> "Muokka",
	"btnremove"		=> "Poista",
	
	// actions
	"actdir"		=> "Hakemisto",
	"actperms"		=> "Muuta oikeuksia",
	"actedit"		=> "Muokkaa tiedostoa",
	"actsearchresults"	=> "Etsinnän tulokset",
	"actcopyitems"		=> "Kopioi nimikkeet",
	"actcopyfrom"		=> "Kopioi täältä /%s tänne /%s ",
	"actmoveitems"		=> "Siirrä nimikkeet",
	"actmovefrom"		=> "Siirrä täältä /%s tänne /%s ",
	"actlogin"		=> "Kirjaudu",
	"actloginheader"	=> "Kirjaudu käyttääksesi joomlaXploreria",
	"actadmin"		=> "Hallinta",
	"actchpwd"		=> "Muuta salasanaa",
	"actusers"		=> "Käyttäjät",
	"actarchive"		=> "Arkistoi nimikkeet",
	"actupload"		=> "Upload tiedostot",
	
	// misc
	"miscitems"		=> "Nimikkeet",
	"miscfree"		=> "Vapaa",
	"miscusername"		=> "Käyttäjänimi",
	"miscpassword"		=> "Salasana",
	"miscoldpass"		=> "Vanha salasana",
	"miscnewpass"		=> "Uusi salasana",
	"miscconfpass"		=> "Vahvista salasana",
	"miscconfnewpass"	=> "Vahvista uusi salasana",
	"miscchpass"		=> "Muuta salasana",
	"mischomedir"		=> "Kotihakemisto",
	"mischomeurl"		=> "Koti URL",
	"miscshowhidden"	=> "Näytä piilotetut nimikkeet",
	"mischidepattern"	=> "Piilota kuvio",
	"miscperms"		=> "Oikeudet",
	"miscuseritems"		=> "(nimi, kotihakemisto, näytä piilotetut nimikkeet, oikeudet, aktiivi)",
	"miscadduser"		=> "lisää käyttäjä",
	"miscedituser"		=> "muokkaa käyttäjää '%s'",
	"miscactive"		=> "Aktiivi",
	"misclang"		=> "Kieli",
	"miscnoresult"		=> "Ei saatavia tuloksia.",
	"miscsubdirs"		=> "Etsi alahakemistoistaS",
	"miscpermnames"		=> array("Vain katselu","Muokkaa","Muuta salasana","Muokkaa & Muuta salasana",
					"Hallinta"),
	"miscyesno"		=> array("Kyllä","Ei","Y","N"),
	"miscchmod"		=> array("Omistaja", "Ryhmä", "Julkinen"),
	// from here all new by mic
	'miscowner'			=> 'Owner',
	'miscownerdesc'		=> '<strong>Description:</strong><br />User (UID) /<br />Group (GID)<br />Current rights:<br /><strong> %s ( %s ) </strong>/<br /><strong> %s ( %s )</strong>',

	// sysinfo (new by mic)
	'simamsysinfo'		=> 'joomla System Info',
	'sisysteminfo'		=> 'System Info',
	'sibuilton'			=> 'Operating System',
	'sidbversion'		=> 'Database Version (MySQL)',
	'siphpversion'		=> 'PHP Version',
	'siphpupdate'		=> 'INFORMATION: <span style="color: red;">The PHP version you use is <strong>not</strong> actual!</span><br />To guarantee all functions and features of joomla and addons,<br />you should use as minimum <strong>PHP.Version 4.3</strong>!',
	'siwebserver'		=> 'Webserver',
	'siwebsphpif'		=> 'WebServer - PHP Interface',
	'sijoomlaversion'	=> 'joomla Version',
	'siuseragent'		=> 'Browser Version',
	'sirelevantsettings' => 'Important PHP Settings',
	'sisafemode'		=> 'Safe Mode',
	'sibasedir'			=> 'Open basedir',
	'sidisplayerrors'	=> 'PHP Errors',
	'sishortopentags'	=> 'Short Open Tags',
	'sifileuploads'		=> 'Datei Uploads',
	'simagicquotes'		=> 'Magic Quotes',
	'siregglobals'		=> 'Register Globals',
	'sioutputbuf'		=> 'Output Buffer',
	'sisesssavepath'	=> 'Session Savepath',
	'sisessautostart'	=> 'Session auto start',
	'sixmlenabled'		=> 'XML enabled',
	'sizlibenabled'		=> 'ZLIB enabled',
	'sidisabledfuncs'	=> 'Non enabled functions',
	'sieditor'			=> 'WYSIWYG Editor',
	'siconfigfile'		=> 'Config file',
	'siphpinfo'			=> 'PHP Info',
	'siphpinformation'	=> 'PHP Information',
	'sipermissions'		=> 'Permissions',
	'sidirperms'		=> 'Directory permissions',
	'sidirpermsmess'	=> 'To be shure that all functions and features of joomla are working correct, following folders should have permission to write [chmod 0777]',
	'sionoff'			=> array( 'On', 'Off' ),
	
	'extract_warning' => "Do you really want to extract this file? Here?\\nThis will overwrite existing files when not used carefully!",
	'extract_success' => "Extraction was successful",
	'extract_failure' => "Extraction failed"
);
?>
