<?php

// Portuguese Language Module for v2.3 (translated by Paulo Brito, geral@oitavaesfera.com, http://www.oitavaesfera.com)

$GLOBALS["charset"] = "iso-8859-1";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d/m/y H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ERRO(S)",
	"back"			=> "Voltar",
	
	// root
	"home"			=> "A directoria inicial n�o existe, verifique as configura��es.",
	"abovehome"		=> "A directoria actual n�o pode estar acima da directoria inicial.",
	"targetabovehome"	=> "A directoria alvo n�o pode estar acima da directoria principal.",
	
	// exist
	"direxist"		=> "Esta directoria n�o existe.",
	//"filedoesexist"	=> "Este ficheiro j� existe.",
	"fileexist"		=> "Este ficheiro n�o existe.",
	"itemdoesexist"		=> "Este item j� existe.",
	"itemexist"		=> "Este item n�o existe.",
	"targetexist"		=> "A directoria n�o existe.",
	"targetdoesexist"	=> "A directoria j� existe.",
	
	// open
	"opendir"		=> "N�o � poss�vel abrir a directoria.",
	"readdir"		=> "N�o � poss�vel ler a directoria.",
	
	// access
	"accessdir"		=> "N�o est� autorizado a aceder a esta directoria.",
	"accessfile"		=> "N�o est� autorizado a aceder a este ficheiro.",
	"accessitem"		=> "N�o est� autorizado a aceder a este item.",
	"accessfunc"		=> "N�o est� autorizado a usar esta fun��o.",
	"accesstarget"		=> "N�o est� autorizado a aceder � directoria.",
	
	// actions
	"permread"		=> "N�o foi poss�vel visualizar as permiss�es.",
	"permchange"		=> "N�o foi poss�vel modificar as permiss�es.",
	"openfile"		=> "N�o foi poss�vel abrir o ficheiro.",
	"savefile"		=> "N�o foi poss�vel gravar o ficheiro.",
	"createfile"		=> "N�o foi poss�vel criar o ficheiro.",
	"createdir"		=> "N�o foi poss�vel criar a directoria.",
	"uploadfile"		=> "N�o foi poss�vel o envio do ficheiro.",
	"copyitem"		=> "N�o foi poss�vel a c�pia.",
	"moveitem"		=> "N�o foi poss�vel mover.",
	"delitem"		=> "N�o foi poss�vel apagar o ficheiro.",
	"chpass"		=> "N�o foi poss�vel modificar a password.",
	"deluser"		=> "N�o foi poss�vel remover o utilizador.",
	"adduser"		=> "N�o foi poss�vel adicionar o utilizador.",
	"saveuser"		=> "N�o foi poss�vel gravar o utilizador.",
	"searchnothing"		=> "Deve ser inserido um valor para ser feita a procura.",
	
	// misc
	"miscnofunc"		=> "Fun��o n�o dispon�vel.",
	"miscfilesize"		=> "O ficheiro ultrapassa o tamanho m�ximo permitido.",
	"miscfilepart"		=> "O ficheiro foi apenas enviado parcialmente.",
	"miscnoname"		=> "Deve ser fornecido um nome.",
	"miscselitems"		=> "N�o foi seleccionado qualquer item.",
	"miscdelitems"		=> "Tem certeza que deseja apagar este(s) \"+num+\" item(s)?",
	"miscdeluser"		=> "Tem certeza que deseja apagar o utilizador '\"+user+\"'?",
	"miscnopassdiff"	=> "A nova password n�o � diferente da actual.",
	"miscnopassmatch"	=> "As passwords n�o s�o iguais.",
	"miscfieldmissed"	=> "Um campo importante est� vazio.",
	"miscnouserpass"	=> "Username ou password incorrectos.",
	"miscselfremove"	=> "N�o pode remover-se a si pr�prio.",
	"miscuserexist"		=> "O utilizador j� existe.",
	"miscnofinduser"	=> "N�o foi poss�vel encontrar o utilizador.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "MODIFICAR PERMISS�ES",
	"editlink"		=> "EDITAR",
	"downlink"		=> "DOWNLOAD",
	"uplink"		=> "CIMA",
	"homelink"		=> "P�GINA INICIAL",
	"reloadlink"		=> "ACTUALIZAR",
	"copylink"		=> "COPIAR",
	"movelink"		=> "MOVER",
	"dellink"		=> "APAGAR",
	"comprlink"		=> "ARQUIVO",
	"adminlink"		=> "ADMIN",
	"logoutlink"		=> "LOGOUT",
	"uploadlink"		=> "UPLOAD",
	"searchlink"		=> "PROCURAR",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Nome",
	"sizeheader"		=> "Tamanho",
	"typeheader"		=> "Tipo",
	"modifheader"		=> "Modificado",
	"permheader"		=> "Permiss�es",
	"actionheader"		=> "Ac��es",
	"pathheader"		=> "Caminho",
	
	// buttons
	"btncancel"		=> "Cancelar",
	"btnsave"		=> "Gravar",
	"btnchange"		=> "Modificar",
	"btnreset"		=> "Reiniciar",
	"btnclose"		=> "Fechar",
	"btncreate"		=> "Criar",
	"btnsearch"		=> "Procurar",
	"btnupload"		=> "Upload",
	"btncopy"		=> "Copiar",
	"btnmove"		=> "Mover",
	"btnlogin"		=> "Login",
	"btnlogout"		=> "Logout",
	"btnadd"		=> "Novo",
	"btnedit"		=> "Editar",
	"btnremove"		=> "Remover",
	
	// actions
	"actdir"		=> "Directoria",
	"actperms"		=> "Modificar permiss�es",
	"actedit"		=> "Editar ficheiro",
	"actsearchresults"	=> "Resultados da procura",
	"actcopyitems"		=> "Copiar item(s)",
	"actcopyfrom"		=> "Copiar de /%s para /%s ",
	"actmoveitems"		=> "Mover item(s)",
	"actmovefrom"		=> "Mover de /%s para /%s ",
	"actlogin"		=> "Login",
	"actloginheader"	=> "Fa�a o login para usar o QuiXplorer",
	"actadmin"		=> "Administra��o",
	"actchpwd"		=> "Modificar password",
	"actusers"		=> "utilizadores",
	"actarchive"		=> "Arquivo de item(s)",
	"actupload"		=> "Upload de ficheiro(s)",
	
	// misc
	"miscitems"		=> "Item(s)",
	"miscfree"		=> "Livres",
	"miscusername"		=> "Username",
	"miscpassword"		=> "Password",
	"miscoldpass"		=> "Password antiga",
	"miscnewpass"		=> "Nova password",
	"miscconfpass"		=> "Confirmar password",
	"miscconfnewpass"	=> "Confirmar a nova password",
	"miscchpass"		=> "Modificar password",
	"mischomedir"		=> "Directoria inicial",
	"mischomeurl"		=> "URL da p�gina inicial",
	"miscshowhidden"	=> "Mostrar items escondidos",
	"mischidepattern"	=> "Esconder esquema",
	"miscperms"		=> "Permiss�es",
	"miscuseritems"		=> "(nome, directoria inicial, mostrar items escondidos, permiss�es, activo)",
	"miscadduser"		=> "novo utilizador",
	"miscedituser"		=> "editar utilizador '%s'",
	"miscactive"		=> "Activo",
	"misclang"		=> "Linguagem",
	"miscnoresult"		=> "N�o h� resultados dispon�veis.",
	"miscsubdirs"		=> "Procurar subdirectorias",
	"miscpermnames"		=> array("Ver apenas","Modificar","Alterar password","Modificar a password",
					"Administrador"),
	"miscyesno"		=> array("Sim","N�o","Y","N"),
	"miscchmod"		=> array("Propriet�rio", "Grupo", "P�blico"),
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
