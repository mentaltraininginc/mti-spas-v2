<?php

// Hungarian Language Module for v2.3 (translated by Jozsef Tamas Herczeg)

$GLOBALS["charset"] = "iso-8859-2";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y.m.d. H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "HIB�(K)",
	"back"			=> "Vissza",
	
	// root
	"home"			=> "Nem l�tezik a kiindul�si k�nyvt�r, ellen�rizd a be�ll�t�sokat.",
	"abovehome"		=> "A jelenlegi k�nyvt�r nem lehet f�ljebb a kiindul�s mapp�n�l.",
	"targetabovehome"	=> "A c�lk�nyvt�r nem lehet f�ljebb a kiindul�si mapp�n�l.",
	
	// exist
	"direxist"		=> "Ez a k�nyvt�r nem l�tezik.",
	//"filedoesexist"	=> "Ez a f�jl m�r l�tezik.",
	"fileexist"		=> "Ez a f�jl nem l�tezik.",
	"itemdoesexist"		=> "Ez az elem m�r l�tezik.",
	"itemexist"		=> "Ez az elem nem l�tezik.",
	"targetexist"		=> "A c�lk�nyvt�r nem l�tezik.",
	"targetdoesexist"	=> "A c�lelem m�r l�tezik.",
	
	// open
	"opendir"		=> "Nem nyithat� meg a k�nyvt�r.",
	"readdir"		=> "Nem olvashat� a k�nyvt�r.",
	
	// access
	"accessdir"		=> "Nem enged�lyezett a sz�modra az ehhez a k�nyvt�rhoz val� hozz�f�r�s.",
	"accessfile"		=> "Nem enged�lyezett a sz�modra az ehhez a f�jlhoz val� hozz�f�r�s.",
	"accessitem"		=> "Nem enged�lyezett a sz�modra az ehhez az elemhez val� hozz�f�r�s.",
	"accessfunc"		=> "Ennek a funkci�nak a haszn�lata nem enged�lyezett a sz�modra.",
	"accesstarget"		=> "Nem enged�lyezett a c�lk�nyvt�rhoz val� hozz�f�r�s.",
	
	// actions
	"permread"		=> "Az enged�lyek lek�r�se nem siker�lt.",
	"permchange"		=> "Az enged�lym�dos�t�s nem siker�lt.",
	"openfile"		=> "Nem lehet megnyitni a f�jlt.",
	"savefile"		=> "Nem lehet menteni a f�jlt.",
	"createfile"		=> "Nem lehet l�trehozni a f�jlt.",
	"createdir"		=> "Nem lehet l�trehozni a k�nyvt�rt.",
	"uploadfile"		=> "A f�jl felt�lt�se nem siker�lt.",
	"copyitem"		=> "A m�sol�s nem siker�lt.",
	"moveitem"		=> "Az �thelyez�s nem siker�lt.",
	"delitem"		=> "A t�rl�s nem siker�lt.",
	"chpass"		=> "Nem siker�lt megv�ltoztatni a jelsz�t.",
	"deluser"		=> "A felhaszn�l� elt�vol�t�sa nem siker�lt.",
	"adduser"		=> "A felhaszn�l� hozz�ad�sa nem siker�lt.",
	"saveuser"		=> "A felhaszn�l� ment�se nem siker�lt.",
	"searchnothing"		=> "Meg kell adnod a keresend� kulcssz�t.",
	
	// misc
	"miscnofunc"		=> "Nem m�k�dik ez a funkci�.",
	"miscfilesize"		=> "A f�jl m�rete nagyobb a megengedettn�l.",
	"miscfilepart"		=> "Csak r�szben siker�lt felt�lteni a f�jlt.",
	"miscnoname"		=> "Meg kell adnod egy nevet.",
	"miscselitems"		=> "Nem v�lasztott�l ki egy elemet sem.",
	"miscdelitems"		=> "Biztosan t�r�lni akarod ezt a(z) \"+num+\" elemet?",
	"miscdeluser"		=> "Biztosan t�r�lni akarod a k�vetkez� felhaszn�l�t: '\"+user+\"'?",
	"miscnopassdiff"	=> "Az �j jelsz� ugyanaz, mint a jelenlegi.",
	"miscnopassmatch"	=> "Elt�r�ek a jelszavak.",
	"miscfieldmissed"	=> "Kihagyt�l egy fontos mez�t.",
	"miscnouserpass"	=> "�rv�nytelen a felhaszn�l�n�v vagy a jelsz�.",
	"miscselfremove"	=> "Saj�t magadat nem t�vol�thatod el.",
	"miscuserexist"		=> "A felhaszn�l� m�r l�tezik.",
	"miscnofinduser"	=> "Nem tal�lhat� a felhaszn�l�.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "ENGED�LYEK M�DOS�T�SA",
	"editlink"		=> "SZERKESZT�S",
	"downlink"		=> "LET�LT�S",
	"uplink"		=> "FEL",
	"homelink"		=> "KIINDUL�SI K�NYVT�R",
	"reloadlink"		=> "FRISS�T�S",
	"copylink"		=> "M�SOL�S",
	"movelink"		=> "�THELYEZ�S",
	"dellink"		=> "T�RL�S",
	"comprlink"		=> "ARCHIV�L�S",
	"adminlink"		=> "ADMIN",
	"logoutlink"		=> "KIL�P�S",
	"uploadlink"		=> "FELT�LT�S",
	"searchlink"		=> "KERES�S",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "N�v",
	"sizeheader"		=> "M�ret",
	"typeheader"		=> "T�pus",
	"modifheader"		=> "M�dos�tva",
	"permheader"		=> "Enged�lyek",
	"actionheader"		=> "M�veletek",
	"pathheader"		=> "�tvonal",
	
	// buttons
	"btncancel"		=> "M�gse",
	"btnsave"		=> "Ment�s",
	"btnchange"		=> "M�dos�t�s",
	"btnreset"		=> "Alaphelyzet",
	"btnclose"		=> "Bez�r�s",
	"btncreate"		=> "L�trehoz�s",
	"btnsearch"		=> "Keres�s",
	"btnupload"		=> "Felt�lt�s",
	"btncopy"		=> "M�sol�s",
	"btnmove"		=> "�thelyez�s",
	"btnlogin"		=> "Bejelentkez�s",
	"btnlogout"		=> "Kijelentkez�s",
	"btnadd"		=> "Hozz�ad�s",
	"btnedit"		=> "Szerkeszt�s",
	"btnremove"		=> "�thelyez�s",
	
	// actions
	"actdir"		=> "K�nyvt�r",
	"actperms"		=> "Enged�lyek m�dos�t�sa",
	"actedit"		=> "F�jl szerkeszt�se",
	"actsearchresults"	=> "A keres�s eredm�nye",
	"actcopyitems"		=> "Elem(ek) m�sol�sa",
	"actcopyfrom"		=> "M�sol�s a(z) /%s mapp�b�l a(z) /%s mapp�ba ",
	"actmoveitems"		=> "Elem(ek) �thelyez�se",
	"actmovefrom"		=> "�thelyez�s a(z) /%s mapp�b�l a(z) /%s mapp�ba ",
	"actlogin"		=> "Bejelentkez�s",
	"actloginheader"	=> "Bejelentkez�s a QuiXplorer haszn�lat�ra",
	"actadmin"		=> "Adminisztr�l�s",
	"actchpwd"		=> "A jelsz� megv�ltoztat�sa",
	"actusers"		=> "Felhaszn�l�k",
	"actarchive"		=> "Elem(ek) archiv�l�sa",
	"actupload"		=> "F�jl(ok) felt�lt�se",
	
	// misc
	"miscitems"		=> "elem",
	"miscfree"		=> "Szabad ter�let",
	"miscusername"		=> "Felhaszn�l�n�v",
	"miscpassword"		=> "Jelsz�",
	"miscoldpass"		=> "A r�gi jelsz�",
	"miscnewpass"		=> "Az �j jelsz�",
	"miscconfpass"		=> "A jelsz� meger�s�t�se",
	"miscconfnewpass"	=> "Az �j jelsz� meger�s�t�se",
	"miscchpass"		=> "Jelsz�csere",
	"mischomedir"		=> "Kiindul�si k�nyvt�r",
	"mischomeurl"		=> "Kezd� URL",
	"miscshowhidden"	=> "A rejtett elemek l�that�k",
	"mischidepattern"	=> "Minta elrejt�se",
	"miscperms"		=> "Enged�lyek",
	"miscuseritems"		=> "(n�v, kiindul�si k�nyvt�r, rejtett elemek megjelen�t�se, enged�lyek, akt�v)",
	"miscadduser"		=> "�j felhaszn�l�",
	"miscedituser"		=> "'%s' felhaszn�l� m�dos�t�sa",
	"miscactive"		=> "Akt�v",
	"misclang"		=> "Nyelv",
	"miscnoresult"		=> "A keres�s eredm�nytelen.",
	"miscsubdirs"		=> "Keres�s az alk�nyvt�rakban",
	"miscpermnames"		=> array("Csak n�zet","M�dos�t�s","Jelsz�csere","M�dos�t�s �s jelsz�csere",
					"Adminisztr�tor"),
	"miscyesno"		=> array("Igen","Nem","I","N"),
	"miscchmod"		=> array("Tulajdonos", "Csoport", "K�z�ns�g"),
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
