<?php

// Hungarian Language Module for v2.3 (translated by Jozsef Tamas Herczeg)

$GLOBALS["charset"] = "iso-8859-2";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y.m.d. H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "HIBÁ(K)",
	"back"			=> "Vissza",
	
	// root
	"home"			=> "Nem létezik a kiindulási könyvtár, ellenõrizd a beállításokat.",
	"abovehome"		=> "A jelenlegi könyvtár nem lehet följebb a kiindulás mappánál.",
	"targetabovehome"	=> "A célkönyvtár nem lehet följebb a kiindulási mappánál.",
	
	// exist
	"direxist"		=> "Ez a könyvtár nem létezik.",
	//"filedoesexist"	=> "Ez a fájl már létezik.",
	"fileexist"		=> "Ez a fájl nem létezik.",
	"itemdoesexist"		=> "Ez az elem már létezik.",
	"itemexist"		=> "Ez az elem nem létezik.",
	"targetexist"		=> "A célkönyvtár nem létezik.",
	"targetdoesexist"	=> "A célelem már létezik.",
	
	// open
	"opendir"		=> "Nem nyitható meg a könyvtár.",
	"readdir"		=> "Nem olvasható a könyvtár.",
	
	// access
	"accessdir"		=> "Nem engedélyezett a számodra az ehhez a könyvtárhoz való hozzáférés.",
	"accessfile"		=> "Nem engedélyezett a számodra az ehhez a fájlhoz való hozzáférés.",
	"accessitem"		=> "Nem engedélyezett a számodra az ehhez az elemhez való hozzáférés.",
	"accessfunc"		=> "Ennek a funkciónak a használata nem engedélyezett a számodra.",
	"accesstarget"		=> "Nem engedélyezett a célkönyvtárhoz való hozzáférés.",
	
	// actions
	"permread"		=> "Az engedélyek lekérése nem sikerült.",
	"permchange"		=> "Az engedélymódosítás nem sikerült.",
	"openfile"		=> "Nem lehet megnyitni a fájlt.",
	"savefile"		=> "Nem lehet menteni a fájlt.",
	"createfile"		=> "Nem lehet létrehozni a fájlt.",
	"createdir"		=> "Nem lehet létrehozni a könyvtárt.",
	"uploadfile"		=> "A fájl feltöltése nem sikerült.",
	"copyitem"		=> "A másolás nem sikerült.",
	"moveitem"		=> "Az áthelyezés nem sikerült.",
	"delitem"		=> "A törlés nem sikerült.",
	"chpass"		=> "Nem sikerült megváltoztatni a jelszót.",
	"deluser"		=> "A felhasználó eltávolítása nem sikerült.",
	"adduser"		=> "A felhasználó hozzáadása nem sikerült.",
	"saveuser"		=> "A felhasználó mentése nem sikerült.",
	"searchnothing"		=> "Meg kell adnod a keresendõ kulcsszót.",
	
	// misc
	"miscnofunc"		=> "Nem mûködik ez a funkció.",
	"miscfilesize"		=> "A fájl mérete nagyobb a megengedettnél.",
	"miscfilepart"		=> "Csak részben sikerült feltölteni a fájlt.",
	"miscnoname"		=> "Meg kell adnod egy nevet.",
	"miscselitems"		=> "Nem választottál ki egy elemet sem.",
	"miscdelitems"		=> "Biztosan törölni akarod ezt a(z) \"+num+\" elemet?",
	"miscdeluser"		=> "Biztosan törölni akarod a következõ felhasználót: '\"+user+\"'?",
	"miscnopassdiff"	=> "Az új jelszó ugyanaz, mint a jelenlegi.",
	"miscnopassmatch"	=> "Eltérõek a jelszavak.",
	"miscfieldmissed"	=> "Kihagytál egy fontos mezõt.",
	"miscnouserpass"	=> "Érvénytelen a felhasználónév vagy a jelszó.",
	"miscselfremove"	=> "Saját magadat nem távolíthatod el.",
	"miscuserexist"		=> "A felhasználó már létezik.",
	"miscnofinduser"	=> "Nem található a felhasználó.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "ENGEDÉLYEK MÓDOSÍTÁSA",
	"editlink"		=> "SZERKESZTÉS",
	"downlink"		=> "LETÖLTÉS",
	"uplink"		=> "FEL",
	"homelink"		=> "KIINDULÁSI KÖNYVTÁR",
	"reloadlink"		=> "FRISSÍTÉS",
	"copylink"		=> "MÁSOLÁS",
	"movelink"		=> "ÁTHELYEZÉS",
	"dellink"		=> "TÖRLÉS",
	"comprlink"		=> "ARCHIVÁLÁS",
	"adminlink"		=> "ADMIN",
	"logoutlink"		=> "KILÉPÉS",
	"uploadlink"		=> "FELTÖLTÉS",
	"searchlink"		=> "KERESÉS",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Név",
	"sizeheader"		=> "Méret",
	"typeheader"		=> "Típus",
	"modifheader"		=> "Módosítva",
	"permheader"		=> "Engedélyek",
	"actionheader"		=> "Mûveletek",
	"pathheader"		=> "Útvonal",
	
	// buttons
	"btncancel"		=> "Mégse",
	"btnsave"		=> "Mentés",
	"btnchange"		=> "Módosítás",
	"btnreset"		=> "Alaphelyzet",
	"btnclose"		=> "Bezárás",
	"btncreate"		=> "Létrehozás",
	"btnsearch"		=> "Keresés",
	"btnupload"		=> "Feltöltés",
	"btncopy"		=> "Másolás",
	"btnmove"		=> "Áthelyezés",
	"btnlogin"		=> "Bejelentkezés",
	"btnlogout"		=> "Kijelentkezés",
	"btnadd"		=> "Hozzáadás",
	"btnedit"		=> "Szerkesztés",
	"btnremove"		=> "Áthelyezés",
	
	// actions
	"actdir"		=> "Könyvtár",
	"actperms"		=> "Engedélyek módosítása",
	"actedit"		=> "Fájl szerkesztése",
	"actsearchresults"	=> "A keresés eredménye",
	"actcopyitems"		=> "Elem(ek) másolása",
	"actcopyfrom"		=> "Másolás a(z) /%s mappából a(z) /%s mappába ",
	"actmoveitems"		=> "Elem(ek) áthelyezése",
	"actmovefrom"		=> "Áthelyezés a(z) /%s mappából a(z) /%s mappába ",
	"actlogin"		=> "Bejelentkezés",
	"actloginheader"	=> "Bejelentkezés a QuiXplorer használatára",
	"actadmin"		=> "Adminisztrálás",
	"actchpwd"		=> "A jelszó megváltoztatása",
	"actusers"		=> "Felhasználók",
	"actarchive"		=> "Elem(ek) archiválása",
	"actupload"		=> "Fájl(ok) feltöltése",
	
	// misc
	"miscitems"		=> "elem",
	"miscfree"		=> "Szabad terület",
	"miscusername"		=> "Felhasználónév",
	"miscpassword"		=> "Jelszó",
	"miscoldpass"		=> "A régi jelszó",
	"miscnewpass"		=> "Az új jelszó",
	"miscconfpass"		=> "A jelszó megerõsítése",
	"miscconfnewpass"	=> "Az új jelszó megerõsítése",
	"miscchpass"		=> "Jelszócsere",
	"mischomedir"		=> "Kiindulási könyvtár",
	"mischomeurl"		=> "Kezdõ URL",
	"miscshowhidden"	=> "A rejtett elemek láthatók",
	"mischidepattern"	=> "Minta elrejtése",
	"miscperms"		=> "Engedélyek",
	"miscuseritems"		=> "(név, kiindulási könyvtár, rejtett elemek megjelenítése, engedélyek, aktív)",
	"miscadduser"		=> "új felhasználó",
	"miscedituser"		=> "'%s' felhasználó módosítása",
	"miscactive"		=> "Aktív",
	"misclang"		=> "Nyelv",
	"miscnoresult"		=> "A keresés eredménytelen.",
	"miscsubdirs"		=> "Keresés az alkönyvtárakban",
	"miscpermnames"		=> array("Csak nézet","Módosítás","Jelszócsere","Módosítás és jelszócsere",
					"Adminisztrátor"),
	"miscyesno"		=> array("Igen","Nem","I","N"),
	"miscchmod"		=> array("Tulajdonos", "Csoport", "Közönség"),
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
