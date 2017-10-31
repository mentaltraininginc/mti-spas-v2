<?php

// French Language Module for v2.3 (translated by Olivier Pariseau & the QuiX project)

$GLOBALS["charset"] = "iso-8859-1";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d/m/Y H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ERREUR(S)",
	"back"			=> "Page pr�c�dente",
	
	// root
	"home"			=> "Le r�pertoire home n'existe pas, v�rifiez vos pr�f�rences.",
	"abovehome"		=> "Le r�pertoire courant n'a pas l'air d'etre au-dessus du r�pertoire home.",
	"targetabovehome"	=> "Le r�pertoire cible n'a pas l'air d'etre au-dessus du r�pertoire home.",
	
	// exist
	"direxist"		=> "Ce r�pertoire n'existe pas.",
	//"filedoesexist"	=> "Ce fichier existe deja.",
	"fileexist"		=> "Ce fichier n'existe pas.",
	"itemdoesexist"		=> "Cet item existe deja.",
	"itemexist"		=> "Cet item n'existe pas.",
	"targetexist"		=> "Le r�pertoire cible n'existe pas.",
	"targetdoesexist"	=> "L'item cible existe deja.",
	
	// open
	"opendir"		=> "Impossible d'ouvrir le r�pertoire.",
	"readdir"		=> "Impossible de lire le r�pertoire.",
	
	// access
	"accessdir"		=> "Vous n'etes pas autoris� a acceder a ce r�pertoire.",
	"accessfile"		=> "Vous n'etes pas autoris� a acc�der a ce fichier.",
	"accessitem"		=> "Vous n'etes pas autoris� a acc�der a cet item.",
	"accessfunc"		=> "Vous ne pouvez pas utiliser cette fonction.",
	"accesstarget"		=> "Vous n'etes pas autoris� a acc�der au repertoire cible.",
	
	// actions
	"permread"		=> "Lecture des permissions �chou�e.",
	"permchange"		=> "Changement des permissions �chou�.",
	"openfile"		=> "Ouverture du fichier �chou�e.",
	"savefile"		=> "Sauvegarde du fichier �chou�e.",
	"createfile"		=> "Cr�ation du fichier �chou�e.",
	"createdir"		=> "Cr�ation du r�pertoire �chou�e.",
	"uploadfile"		=> "Envoie du fichier �chou�.",
	"copyitem"		=> "La copie a �chou�e.",
	"moveitem"		=> "Le d�placement a �chou�.",
	"delitem"		=> "La supression a �chou�e.",
	"chpass"		=> "Le changement de mot de passe a �chou�.",
	"deluser"		=> "La supression de l'usager a �chou�e.",
	"adduser"		=> "L'ajout de l'usager a �chou�e.",
	"saveuser"		=> "La sauvegarde de l'usager a �chou�e.",
	"searchnothing"		=> "Vous devez entrez quelquechose � chercher.",
	
	// misc
	"miscnofunc"		=> "Fonctionalit� non disponible.",
	"miscfilesize"		=> "La taille du fichier exc�de la taille maximale autoris�e.",
	"miscfilepart"		=> "L'envoi du fichier n'a pas �t� compl�t�.",
	"miscnoname"		=> "Vous devez entrer un nom.",
	"miscselitems"		=> "Vous n'avez s�lectionn� aucuns item(s).",
	"miscdelitems"		=> "�tes-vous certain de vouloir supprimer ces \"+num+\" item(s)?",
	"miscdeluser"		=> "�tes-vous certain de vouloir supprimer l'usager '\"+user+\"'?",
	"miscnopassdiff"	=> "Le nouveau mot de passe est indentique au pr�c�dent.",
	"miscnopassmatch"	=> "Les mots de passe diff�rent.",
	"miscfieldmissed"	=> "Un champs requis n'a pas �t� rempli.",
	"miscnouserpass"	=> "Nom d'usager ou mot de passe invalide.",
	"miscselfremove"	=> "Vous ne pouvez pas supprimer votre compte.",
	"miscuserexist"		=> "Ce nom d'usager existe d�j�.",
	"miscnofinduser"	=> "Usager non trouv�.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "CHANGER LES PERMISSIONS",
	"editlink"		=> "�DITER",
	"downlink"		=> "T�L�CHARGER",
	"uplink"		=> "PARENT",
	"homelink"		=> "HOME",
	"reloadlink"		=> "RAFRA�CHIR",
	"copylink"		=> "COPIER",
	"movelink"		=> "D�PLACER",
	"dellink"		=> "SUPPRIMER",
	"comprlink"		=> "ARCHIVER",
	"adminlink"		=> "ADMINISTRATION",
	"logoutlink"		=> "D�CONNECTER",
	"uploadlink"		=> "ENVOYER",
	"searchlink"		=> "RECHERCHER",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Nom",
	"sizeheader"		=> "Taille",
	"typeheader"		=> "Type",
	"modifheader"		=> "Modifi�",
	"permheader"		=> "Perm's",
	"actionheader"		=> "Actions",
	"pathheader"		=> "Chemin",
	
	// buttons
	"btncancel"		=> "Annuler",
	"btnsave"		=> "Sauver",
	"btnchange"		=> "Changer",
	"btnreset"		=> "R�initialiser",
	"btnclose"		=> "Fermer",
	"btncreate"		=> "Cr�er",
	"btnsearch"		=> "Chercher",
	"btnupload"		=> "Envoyer",
	"btncopy"		=> "Copier",
	"btnmove"		=> "D�placer",
	"btnlogin"		=> "Connecter",
	"btnlogout"		=> "D�connecter",
	"btnadd"		=> "Ajouter",
	"btnedit"		=> "�diter",
	"btnremove"		=> "Supprimer",
	
	// actions
	"actdir"		=> "R�pertoire",
	"actperms"		=> "Changer les permissions",
	"actedit"		=> "�diter le fichier",
	"actsearchresults"	=> "R�sultats de la recherche",
	"actcopyitems"		=> "Copier le(s) item(s)",
	"actcopyfrom"		=> "Copier de /%s � /%s ",
	"actmoveitems"		=> "D�placer le(s) item(s)",
	"actmovefrom"		=> "D�placer de /%s � /%s ",
	"actlogin"		=> "Connecter",
	"actloginheader"	=> "Connecter pour utiliser QuiXplorer",
	"actadmin"		=> "Administration",
	"actchpwd"		=> "Changer le mot de passe",
	"actusers"		=> "Usagers",
	"actarchive"		=> "Archiver le(s) item(s)",
	"actupload"		=> "Envoyer le(s) fichier(s)",
	
	// misc
	"miscitems"		=> "Item(s)",
	"miscfree"		=> "Disponible",
	"miscusername"		=> "Usager",
	"miscpassword"		=> "Mot de passe",
	"miscoldpass"		=> "Ancien mot de passe",
	"miscnewpass"		=> "Nouveau mot de passe",
	"miscconfpass"		=> "Confirmer le mot de passe",
	"miscconfnewpass"	=> "Confirmer le nouveau mot de passe",
	"miscchpass"		=> "Changer le mot de passe",
	"mischomedir"		=> "R�pertoire home",
	"mischomeurl"		=> "URL home",
	"miscshowhidden"	=> "Voir les items cach�s",
	"mischidepattern"	=> "Cacher pattern",
	"miscperms"		=> "Permissions",
	"miscuseritems"		=> "(nom, r�pertoire home, Voir les items cach�s, permissions, actif)",
	"miscadduser"		=> "ajouter un usager",
	"miscedituser"		=> "editer l'usager '%s'",
	"miscactive"		=> "Actif",
	"misclang"		=> "Langage",
	"miscnoresult"		=> "Aucun r�sultats.",
	"miscsubdirs"		=> "Rechercher dans les sous-r�pertoires",
	"miscpermnames"		=> array("Lecture seulement","Modifier","Changement le mot de passe","Modifier & Changer le mot de passe",
					"Administrateur"),
	"miscyesno"		=> array("Oui","Non","O","N"),
	"miscchmod"		=> array("Propri�taire", "Groupe", "Publique"),
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
