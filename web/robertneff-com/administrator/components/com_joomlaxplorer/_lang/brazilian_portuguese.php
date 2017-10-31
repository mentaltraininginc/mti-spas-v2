<?php

// English Language Module for v2.3 (translated by the QuiX project)

$GLOBALS["charset"] = "iso-8859-1";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ERRO(S)",
	"back"			=> "Voltar",
	
	// root
	"home"			=> "O diret�rio home n�o existe, verifique suas op��es.",
	"abovehome"		=> "O diret�rio atual n�o pode estar acima do diret�rio home.",
	"targetabovehome"	=> "O diret�rio de destino n�o pode estar acima do diret�rio home.",
	
	// exist
	"direxist"		=> "Este diret�rio n�o existe.",
	//"filedoesexist"	=> "Este arquivo j� existe.",
	"fileexist"		=> "Este arquivo n�o existe.",
	"itemdoesexist"		=> "Este item j� existe.",
	"itemexist"		=> "Este item n�o existe.",
	"targetexist"		=> "O diret�rio de destino n�o existe.",
	"targetdoesexist"	=> "O item de destino j� existe.",
	
	// open
	"opendir"		=> "Imposs�vel abrir diret�rio.",
	"readdir"		=> "Imposs�vel ler diret�rio.",
	
	// access
	"accessdir"		=> "Voc� n�o tem permiss�o para acesar esse diret�rio.",
	"accessfile"		=> "Voc� n�o tem permiss�o para acesar esse arquivo.",
	"accessitem"		=> "Voc� n�o tem permiss�o para acesar esse item.",
	"accessfunc"		=> "Voc� n�o tem permiss�o para usar essa fun��o.",
	"accesstarget"		=> "Voc� n�o tem permiss�o para acesar o diret�rio de destino.",
	
	// actions
	"permread"		=> "Falha ao buscar permiss�es.",
	"permchange"		=> "Falha ao alterar permiss�es.",
	"openfile"		=> "Falha ao abrir o arquivo.",
	"savefile"		=> "Falha ao salvar o arquivo.",
	"createfile"		=> "Falha ao criar o arquivo.",
	"createdir"		=> "Falha ao criar o diret�rio.",
	"uploadfile"		=> "Falha ao enviar o arquivo.",
	"copyitem"		=> "Falha ao copiar.",
	"moveitem"		=> "Falha ao mover.",
	"delitem"		=> "Falha ao apagar.",
	"chpass"		=> "Falha ao alterar a senha.",
	"deluser"		=> "Falha ao remover usu�rio.",
	"adduser"		=> "Falha ao adicioanr usu�rio.",
	"saveuser"		=> "Falha ao salvar usu�rio.",
	"searchnothing"		=> "Voc� deve fornecer alguma coisa para buscar.",
	
	// misc
	"miscnofunc"		=> "Fun��o n�o-dispon�vel.",
	"miscfilesize"		=> "O arquivo excede o tamanho m�ximo permitido.",
	"miscfilepart"		=> "O arquivo foi enviado apenas parcialmente.",
	"miscnoname"		=> "Voc� deve fornecer um nome.",
	"miscselitems"		=> "Voc� n�o selecionou nenhum item(s).",
	"miscdelitems"		=> "Voc� tem certeza que deseja apagar estes \"+num+\" item(s)?",
	"miscdeluser"		=> "Voc� tem certeza que deseja apagar o usu�rio '\"+user+\"'?",
	"miscnopassdiff"	=> "A nova senha n�o � diferente da atual.",
	"miscnopassmatch"	=> "As senhas n�o coincidem.",
	"miscfieldmissed"	=> "Voc� esqueceu um campo importante.",
	"miscnouserpass"	=> "Nome de usu�rio ou senha incorretos.",
	"miscselfremove"	=> "Voc� n�o pode se auto-remover.",
	"miscuserexist"		=> "Usu�rio j� existente.",
	"miscnofinduser"	=> "Usu�rio n�o encontrado.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "ALTERAR PERMISS�ES",
	"editlink"		=> "EDITAR",
	"downlink"		=> "DOWNLOAD",
	"uplink"		=> "SOBE",
	"homelink"		=> "HOME",
	"reloadlink"		=> "RECARREGAR",
	"copylink"		=> "COPIAR",
	"movelink"		=> "MOVER",
	"dellink"		=> "APAGAR",
	"comprlink"		=> "ARQUIVO",
	"adminlink"		=> "ADMIN",
	"logoutlink"		=> "SAIR",
	"uploadlink"		=> "ENVIAR",
	"searchlink"		=> "BUSCAR",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Nome",
	"sizeheader"		=> "Tamanho",
	"typeheader"		=> "Tipo",
	"modifheader"		=> "Modificado",
	"permheader"		=> "Perm's",
	"actionheader"		=> "A��es",
	"pathheader"		=> "Caminho",
	
	// buttons
	"btncancel"		=> "Cancelar",
	"btnsave"		=> "Salvar",
	"btnchange"		=> "Alterar",
	"btnreset"		=> "Limpar",
	"btnclose"		=> "Fechar",
	"btncreate"		=> "Criar",
	"btnsearch"		=> "Buscar",
	"btnupload"		=> "Enviar",
	"btncopy"		=> "Copiar",
	"btnmove"		=> "Mover",
	"btnlogin"		=> "Login",
	"btnlogout"		=> "Sair",
	"btnadd"		=> "Adicionar",
	"btnedit"		=> "Editar",
	"btnremove"		=> "Remover",
	
	// actions
	"actdir"		=> "Diret�rio",
	"actperms"		=> "Alterar permiss�es",
	"actedit"		=> "Editar arquivo",
	"actsearchresults"	=> "Buscar resultados",
	"actcopyitems"		=> "Copiar item(s)",
	"actcopyfrom"		=> "Copiar de /%s para /%s ",
	"actmoveitems"		=> "Mover item(s)",
	"actmovefrom"		=> "Mover de /%s para /%s ",
	"actlogin"		=> "Login",
	"actloginheader"	=> "Login para usar QuiXplorer",
	"actadmin"		=> "Administra��o",
	"actchpwd"		=> "Alterar senha",
	"actusers"		=> "Usu�rios",
	"actarchive"		=> "Arquivar item(s)",
	"actupload"		=> "Enviar arquivo(s)",
	
	// misc
	"miscitems"		=> "Item(s)",
	"miscfree"		=> "Gratuito",
	"miscusername"		=> "Nome de usu�rio",
	"miscpassword"		=> "Senha",
	"miscoldpass"		=> "Senha antiga",
	"miscnewpass"		=> "Nova senha",
	"miscconfpass"		=> "Confirmar senha",
	"miscconfnewpass"	=> "Confirmar nova senha",
	"miscchpass"		=> "Alterar senha",
	"mischomedir"		=> "Diret�rio Home",
	"mischomeurl"		=> "Home URL",
	"miscshowhidden"	=> "Mostrar itens ocultos",
	"mischidepattern"	=> "Ocultar padr�o",
	"miscperms"		=> "Permiss�es",
	"miscuseritems"		=> "(nome, diret�rio home, mostrar itens ocultos, permiss�es, ativo)",
	"miscadduser"		=> "adicionar usu�rio",
	"miscedituser"		=> "editar usu�rio '%s'",
	"miscactive"		=> "Ativo",
	"misclang"		=> "L�ngua",
	"miscnoresult"		=> "Sem resultados.",
	"miscsubdirs"		=> "Buscar subdiret�rios",
	"miscpermnames"		=> array("Somente ver","Modificar","Alterar senha","Modificar & Alterar senha",
					"Administra��o"),
	"miscyesno"		=> array("Sim","N�o","S","N"),
	"miscchmod"		=> array("Dono", "Grupo", "P�blico"),
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
