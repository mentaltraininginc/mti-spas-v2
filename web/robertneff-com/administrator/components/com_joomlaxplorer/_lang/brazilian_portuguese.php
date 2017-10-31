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
	"home"			=> "O diretório home não existe, verifique suas opções.",
	"abovehome"		=> "O diretório atual não pode estar acima do diretório home.",
	"targetabovehome"	=> "O diretório de destino não pode estar acima do diretório home.",
	
	// exist
	"direxist"		=> "Este diretório não existe.",
	//"filedoesexist"	=> "Este arquivo já existe.",
	"fileexist"		=> "Este arquivo não existe.",
	"itemdoesexist"		=> "Este item já existe.",
	"itemexist"		=> "Este item não existe.",
	"targetexist"		=> "O diretório de destino não existe.",
	"targetdoesexist"	=> "O item de destino já existe.",
	
	// open
	"opendir"		=> "Impossível abrir diretório.",
	"readdir"		=> "Impossível ler diretório.",
	
	// access
	"accessdir"		=> "Você não tem permissão para acesar esse diretório.",
	"accessfile"		=> "Você não tem permissão para acesar esse arquivo.",
	"accessitem"		=> "Você não tem permissão para acesar esse item.",
	"accessfunc"		=> "Você não tem permissão para usar essa função.",
	"accesstarget"		=> "Você não tem permissão para acesar o diretório de destino.",
	
	// actions
	"permread"		=> "Falha ao buscar permissões.",
	"permchange"		=> "Falha ao alterar permissões.",
	"openfile"		=> "Falha ao abrir o arquivo.",
	"savefile"		=> "Falha ao salvar o arquivo.",
	"createfile"		=> "Falha ao criar o arquivo.",
	"createdir"		=> "Falha ao criar o diretório.",
	"uploadfile"		=> "Falha ao enviar o arquivo.",
	"copyitem"		=> "Falha ao copiar.",
	"moveitem"		=> "Falha ao mover.",
	"delitem"		=> "Falha ao apagar.",
	"chpass"		=> "Falha ao alterar a senha.",
	"deluser"		=> "Falha ao remover usuário.",
	"adduser"		=> "Falha ao adicioanr usuário.",
	"saveuser"		=> "Falha ao salvar usuário.",
	"searchnothing"		=> "Você deve fornecer alguma coisa para buscar.",
	
	// misc
	"miscnofunc"		=> "Função não-disponível.",
	"miscfilesize"		=> "O arquivo excede o tamanho máximo permitido.",
	"miscfilepart"		=> "O arquivo foi enviado apenas parcialmente.",
	"miscnoname"		=> "Você deve fornecer um nome.",
	"miscselitems"		=> "Você não selecionou nenhum item(s).",
	"miscdelitems"		=> "Você tem certeza que deseja apagar estes \"+num+\" item(s)?",
	"miscdeluser"		=> "Você tem certeza que deseja apagar o usuário '\"+user+\"'?",
	"miscnopassdiff"	=> "A nova senha não é diferente da atual.",
	"miscnopassmatch"	=> "As senhas não coincidem.",
	"miscfieldmissed"	=> "Você esqueceu um campo importante.",
	"miscnouserpass"	=> "Nome de usuário ou senha incorretos.",
	"miscselfremove"	=> "Você não pode se auto-remover.",
	"miscuserexist"		=> "Usuário já existente.",
	"miscnofinduser"	=> "Usuário não encontrado.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "ALTERAR PERMISSÕES",
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
	"actionheader"		=> "Ações",
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
	"actdir"		=> "Diretório",
	"actperms"		=> "Alterar permissões",
	"actedit"		=> "Editar arquivo",
	"actsearchresults"	=> "Buscar resultados",
	"actcopyitems"		=> "Copiar item(s)",
	"actcopyfrom"		=> "Copiar de /%s para /%s ",
	"actmoveitems"		=> "Mover item(s)",
	"actmovefrom"		=> "Mover de /%s para /%s ",
	"actlogin"		=> "Login",
	"actloginheader"	=> "Login para usar QuiXplorer",
	"actadmin"		=> "Administração",
	"actchpwd"		=> "Alterar senha",
	"actusers"		=> "Usuários",
	"actarchive"		=> "Arquivar item(s)",
	"actupload"		=> "Enviar arquivo(s)",
	
	// misc
	"miscitems"		=> "Item(s)",
	"miscfree"		=> "Gratuito",
	"miscusername"		=> "Nome de usuário",
	"miscpassword"		=> "Senha",
	"miscoldpass"		=> "Senha antiga",
	"miscnewpass"		=> "Nova senha",
	"miscconfpass"		=> "Confirmar senha",
	"miscconfnewpass"	=> "Confirmar nova senha",
	"miscchpass"		=> "Alterar senha",
	"mischomedir"		=> "Diretório Home",
	"mischomeurl"		=> "Home URL",
	"miscshowhidden"	=> "Mostrar itens ocultos",
	"mischidepattern"	=> "Ocultar padrão",
	"miscperms"		=> "Permissões",
	"miscuseritems"		=> "(nome, diretório home, mostrar itens ocultos, permissões, ativo)",
	"miscadduser"		=> "adicionar usuário",
	"miscedituser"		=> "editar usuário '%s'",
	"miscactive"		=> "Ativo",
	"misclang"		=> "Língua",
	"miscnoresult"		=> "Sem resultados.",
	"miscsubdirs"		=> "Buscar subdiretórios",
	"miscpermnames"		=> array("Somente ver","Modificar","Alterar senha","Modificar & Alterar senha",
					"Administração"),
	"miscyesno"		=> array("Sim","Não","S","N"),
	"miscchmod"		=> array("Dono", "Grupo", "Público"),
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
