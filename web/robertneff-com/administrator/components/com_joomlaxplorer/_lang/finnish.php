<?php

// English Language Module for v2.3 (translated by Jarmo Ker�nen)

$GLOBALS["charset"] = "iso-8859-1";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "VIRHE(ET)",
	"back"			=> "Palaa",
	
	// root
	"home"			=> "Koti hakemistoa ei ole, tarkista asetuksesi.",
	"abovehome"		=> "Nykyinen hakemisto ei saa olla kotihakemiston yl�puolella.",
	"targetabovehome"	=> "Kohdehakemisto ei saa olla kotihakemiston yl�puolella.",
	
	// exist
	"direxist"		=> "T�m� hakemisto ei ole olemassa.",
	//"filedoesexist"	=> "This file already exists.",
	"fileexist"		=> "T�m� tiedosto ei ole olemassa.",
	"itemdoesexist"		=> "T�m� nimike on jo olemassa.",
	"itemexist"		=> "T�m� nimike ei ole olemassa.",
	"targetexist"		=> "Kohdehakemisto ei ole olemassa.",
	"targetdoesexist"	=> "Kohdenimike on jo olemassa.",
	
	// open
	"opendir"		=> "Hakemistoa ei voida avata.",
	"readdir"		=> "Hakemistoa ei voida lukea.",
	
	// access
	"accessdir"		=> "Sinulla ei ole valtuuksia t�h�n hakemistoon.",
	"accessfile"		=> "Sinulla ei ole valtuuksia t�h�n tiedostoon.",
	"accessitem"		=> "Sinulla ei ole valtuuksia t�h�n nimikkeeseen.",
	"accessfunc"		=> "Sinulla ei ole valtuuksia t�h�n toimintoon.",
	"accesstarget"		=> "Sinulla ei ole valtuuksia kohdehakemistoon.",
	
	// actions
	"permread"		=> "Oikeuksien saanti ep�onnistui.",
	"permchange"		=> "Oikeuksien muutos ep�onnistui.",
	"openfile"		=> "Tiedoston avaaminen ep�onnistui.",
	"savefile"		=> "Tiedoston tallennus ep�onnistui.",
	"createfile"		=> "Tiedoston luonti ep�onnistui.",
	"createdir"		=> "Hakemiston luonti ep�onnistui.",
	"uploadfile"		=> "Tiedoston uploadaus ep�onnistui.",
	"copyitem"		=> "Kopionti ep�onnistui.",
	"moveitem"		=> "Siirto ep�onnistui.",
	"delitem"		=> "Poisto ep�onnistui.",
	"chpass"		=> "Salasanan vaihto ep�onnistui.",
	"deluser"		=> "K�ytt�j�n poisto ep�onnistui.",
	"adduser"		=> "K�ytt�j�n lis�ys ep�onnistui.",
	"saveuser"		=> "K�ytt�j�n tallennus ep�onnistui.",
	"searchnothing"		=> "Sinun pit�� antaa jotain etsitt�v��.",
	
	// misc
	"miscnofunc"		=> "Toiminto ei ole saatavilla.",
	"miscfilesize"		=> "Tiedosto ylitt�� maksimikoon.",
	"miscfilepart"		=> "Tiedosto uploadautui vain osittain.",
	"miscnoname"		=> "Anna nimi.",
	"miscselitems"		=> "Et ole valinnut yht��n nimikett�.",
	"miscdelitems"		=> "Oletko varma ett� haluat poistaa n�m� \"+num+\" nimikett�?",
	"miscdeluser"		=> "Oletko varma ett� haluat poistaa k�ytt�j�n '\"+user+\"'?",
	"miscnopassdiff"	=> "Uusi salasanasi ei eroa nykyisest�.",
	"miscnopassmatch"	=> "Salasanat eiv�t t�sm��.",
	"miscfieldmissed"	=> "Ohitit t�rke�n kent�n.",
	"miscnouserpass"	=> "K�ytt�j�nimi tai salasana on v��r�.",
	"miscselfremove"	=> "Et voi poistaa itse�si.",
	"miscuserexist"		=> "K�ytt�j� on jo olemassa.",
	"miscnofinduser"	=> "K�ytt�j�� ei l�ydy.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "MUUTA OIKEUKSIA",
	"editlink"		=> "MUOKKAA",
	"downlink"		=> "DOWNLOAD",
	"uplink"		=> "YL�S",
	"homelink"		=> "KOTI",
	"reloadlink"		=> "RELOAD",
	"copylink"		=> "KOPIOI",
	"movelink"		=> "SIIRR�",
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
	"btnmove"		=> "Siirr�",
	"btnlogin"		=> "Kirjaudu",
	"btnlogout"		=> "Poistu",
	"btnadd"		=> "Lis��",
	"btnedit"		=> "Muokka",
	"btnremove"		=> "Poista",
	
	// actions
	"actdir"		=> "Hakemisto",
	"actperms"		=> "Muuta oikeuksia",
	"actedit"		=> "Muokkaa tiedostoa",
	"actsearchresults"	=> "Etsinn�n tulokset",
	"actcopyitems"		=> "Kopioi nimikkeet",
	"actcopyfrom"		=> "Kopioi t��lt� /%s t�nne /%s ",
	"actmoveitems"		=> "Siirr� nimikkeet",
	"actmovefrom"		=> "Siirr� t��lt� /%s t�nne /%s ",
	"actlogin"		=> "Kirjaudu",
	"actloginheader"	=> "Kirjaudu k�ytt��ksesi joomlaXploreria",
	"actadmin"		=> "Hallinta",
	"actchpwd"		=> "Muuta salasanaa",
	"actusers"		=> "K�ytt�j�t",
	"actarchive"		=> "Arkistoi nimikkeet",
	"actupload"		=> "Upload tiedostot",
	
	// misc
	"miscitems"		=> "Nimikkeet",
	"miscfree"		=> "Vapaa",
	"miscusername"		=> "K�ytt�j�nimi",
	"miscpassword"		=> "Salasana",
	"miscoldpass"		=> "Vanha salasana",
	"miscnewpass"		=> "Uusi salasana",
	"miscconfpass"		=> "Vahvista salasana",
	"miscconfnewpass"	=> "Vahvista uusi salasana",
	"miscchpass"		=> "Muuta salasana",
	"mischomedir"		=> "Kotihakemisto",
	"mischomeurl"		=> "Koti URL",
	"miscshowhidden"	=> "N�yt� piilotetut nimikkeet",
	"mischidepattern"	=> "Piilota kuvio",
	"miscperms"		=> "Oikeudet",
	"miscuseritems"		=> "(nimi, kotihakemisto, n�yt� piilotetut nimikkeet, oikeudet, aktiivi)",
	"miscadduser"		=> "lis�� k�ytt�j�",
	"miscedituser"		=> "muokkaa k�ytt�j�� '%s'",
	"miscactive"		=> "Aktiivi",
	"misclang"		=> "Kieli",
	"miscnoresult"		=> "Ei saatavia tuloksia.",
	"miscsubdirs"		=> "Etsi alahakemistoistaS",
	"miscpermnames"		=> array("Vain katselu","Muokkaa","Muuta salasana","Muokkaa & Muuta salasana",
					"Hallinta"),
	"miscyesno"		=> array("Kyll�","Ei","Y","N"),
	"miscchmod"		=> array("Omistaja", "Ryhm�", "Julkinen"),
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
