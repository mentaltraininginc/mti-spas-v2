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
	"home"			=> "A directoria inicial não existe, verifique as configurações.",
	"abovehome"		=> "A directoria actual não pode estar acima da directoria inicial.",
	"targetabovehome"	=> "A directoria alvo não pode estar acima da directoria principal.",
	
	// exist
	"direxist"		=> "Esta directoria não existe.",
	//"filedoesexist"	=> "Este ficheiro já existe.",
	"fileexist"		=> "Este ficheiro não existe.",
	"itemdoesexist"		=> "Este item já existe.",
	"itemexist"		=> "Este item não existe.",
	"targetexist"		=> "A directoria não existe.",
	"targetdoesexist"	=> "A directoria já existe.",
	
	// open
	"opendir"		=> "Não é possível abrir a directoria.",
	"readdir"		=> "Não é possível ler a directoria.",
	
	// access
	"accessdir"		=> "Não está autorizado a aceder a esta directoria.",
	"accessfile"		=> "Não está autorizado a aceder a este ficheiro.",
	"accessitem"		=> "Não está autorizado a aceder a este item.",
	"accessfunc"		=> "Não está autorizado a usar esta função.",
	"accesstarget"		=> "Não está autorizado a aceder à directoria.",
	
	// actions
	"permread"		=> "Não foi possível visualizar as permissões.",
	"permchange"		=> "Não foi possível modificar as permissões.",
	"openfile"		=> "Não foi possível abrir o ficheiro.",
	"savefile"		=> "Não foi possível gravar o ficheiro.",
	"createfile"		=> "Não foi possível criar o ficheiro.",
	"createdir"		=> "Não foi possível criar a directoria.",
	"uploadfile"		=> "Não foi possível o envio do ficheiro.",
	"copyitem"		=> "Não foi possível a cópia.",
	"moveitem"		=> "Não foi possível mover.",
	"delitem"		=> "Não foi possível apagar o ficheiro.",
	"chpass"		=> "Não foi possível modificar a password.",
	"deluser"		=> "Não foi possível remover o utilizador.",
	"adduser"		=> "Não foi possível adicionar o utilizador.",
	"saveuser"		=> "Não foi possível gravar o utilizador.",
	"searchnothing"		=> "Deve ser inserido um valor para ser feita a procura.",
	
	// misc
	"miscnofunc"		=> "Função não disponível.",
	"miscfilesize"		=> "O ficheiro ultrapassa o tamanho máximo permitido.",
	"miscfilepart"		=> "O ficheiro foi apenas enviado parcialmente.",
	"miscnoname"		=> "Deve ser fornecido um nome.",
	"miscselitems"		=> "Não foi seleccionado qualquer item.",
	"miscdelitems"		=> "Tem certeza que deseja apagar este(s) \"+num+\" item(s)?",
	"miscdeluser"		=> "Tem certeza que deseja apagar o utilizador '\"+user+\"'?",
	"miscnopassdiff"	=> "A nova password não é diferente da actual.",
	"miscnopassmatch"	=> "As passwords não são iguais.",
	"miscfieldmissed"	=> "Um campo importante está vazio.",
	"miscnouserpass"	=> "Username ou password incorrectos.",
	"miscselfremove"	=> "Não pode remover-se a si próprio.",
	"miscuserexist"		=> "O utilizador já existe.",
	"miscnofinduser"	=> "Não foi possível encontrar o utilizador.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "MODIFICAR PERMISSÕES",
	"editlink"		=> "EDITAR",
	"downlink"		=> "DOWNLOAD",
	"uplink"		=> "CIMA",
	"homelink"		=> "PÁGINA INICIAL",
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
	"permheader"		=> "Permissões",
	"actionheader"		=> "Acções",
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
	"actperms"		=> "Modificar permissões",
	"actedit"		=> "Editar ficheiro",
	"actsearchresults"	=> "Resultados da procura",
	"actcopyitems"		=> "Copiar item(s)",
	"actcopyfrom"		=> "Copiar de /%s para /%s ",
	"actmoveitems"		=> "Mover item(s)",
	"actmovefrom"		=> "Mover de /%s para /%s ",
	"actlogin"		=> "Login",
	"actloginheader"	=> "Faça o login para usar o QuiXplorer",
	"actadmin"		=> "Administração",
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
	"mischomeurl"		=> "URL da página inicial",
	"miscshowhidden"	=> "Mostrar items escondidos",
	"mischidepattern"	=> "Esconder esquema",
	"miscperms"		=> "Permissões",
	"miscuseritems"		=> "(nome, directoria inicial, mostrar items escondidos, permissões, activo)",
	"miscadduser"		=> "novo utilizador",
	"miscedituser"		=> "editar utilizador '%s'",
	"miscactive"		=> "Activo",
	"misclang"		=> "Linguagem",
	"miscnoresult"		=> "Não há resultados disponíveis.",
	"miscsubdirs"		=> "Procurar subdirectorias",
	"miscpermnames"		=> array("Ver apenas","Modificar","Alterar password","Modificar a password",
					"Administrador"),
	"miscyesno"		=> array("Sim","Não","Y","N"),
	"miscchmod"		=> array("Proprietário", "Grupo", "Público"),
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
