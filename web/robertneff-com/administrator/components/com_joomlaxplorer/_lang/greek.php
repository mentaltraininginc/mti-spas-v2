<?php

// English Language Module for v2.3 (translated by the QuiX project)

$GLOBALS["charset"] = "iso-8859-7";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d/m/Y H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ERROR(S)",
	"back"			=> "���������",
	
	// root
	"home"			=> "� �������� ��������� ��� �������, �������� ������ ��� ��������� ���.",
	"abovehome"		=> "� ������ ��������� ��� ������ �� ���������� ��� ������� ��������.",
	"targetabovehome"	=> "� ����������� ��������� ��� ������ �� ���������� ��� ������� ��������.",
	
	// exist
	"direxist"		=> "����� � ��������� ��� �������.",
	//"filedoesexist"	=> "���� �� ������ ��� �������.",
	"fileexist"		=> "���� �� ������ ��� �������.",
	"itemdoesexist"		=> "���� �� ����������� ������� ���.",
	"itemexist"		=> "���� �� ����������� ������� ���.",
	"targetexist"		=> "� ����������� ��������� ��� �������.",
	"targetdoesexist"	=> "�� ���������� ����������� ������� ���.",
	
	// open
	"opendir"		=> "����� �������� �� �������� � ���������.",
	"readdir"		=> "����� �������� �� ��������� � ���������.",
	
	// access
	"accessdir"		=> "��� ��� ����������� �������� �' ����� ��� ��������.",
	"accessfile"		=> "��� ��� ����������� �������� �' ���� �� ������.",
	"accessitem"		=> "��� ��� ����������� �������� �' ���� �� �����������.",
	"accessfunc"		=> "��� ��� ����������� �������� �' ���� ��� ����������.",
	"accesstarget"		=> "��� ��� ����������� �������� �' ����� ��� ��������.",
	
	// actions
	"permread"		=> "� ���������� ��������� ���������� ��� �������� ������ �� ����������.",
	"permchange"		=> "� ���������� ���������� ���������� �������.",
	"openfile"		=> "� ���������� ���������� ������� �������.",
	"savefile"		=> "� ���������� ����������� ������� �������.",
	"createfile"		=> "� ���������� ����������� ������� �������.",
	"createdir"		=> "� ���������� ����������� ��������� �������.",
	"uploadfile"		=> "� ���������� �������� ������� �������.",
	"copyitem"		=> "� ���������� ���������� �������.",
	"moveitem"		=> "� ���������� ����������� �������.",
	"delitem"		=> "� ���������� ��������� �������.",
	"chpass"		=> "� ���������� ��������� ������� ��������� �������.",
	"deluser"		=> "� ���������� ������������ ������ �������.",
	"adduser"		=> "� ���������� ��������� ������ �������.",
	"saveuser"		=> "� ���������� ����������� ��� ��������� ��� ������ �������.",
	"searchnothing"		=> "����� ���������� �� ������� ������ ����� ��� ��� ����� �� ���������� � ���������.",
	
	// misc
	"miscnofunc"		=> "� ���������� ��� ����� ���������.",
	"miscfilesize"		=> "�� ������ ���������� �� ������� ��������� �������.",
	"miscfilepart"		=> "�� ������ ��������� �������������.",
	"miscnoname"		=> "������ �� ������� ��� �����.",
	"miscselitems"		=> "��� ����� �������� �����������(�).",
	"miscdelitems"		=> "������ �� ����������� ���� �������� \"+num+\" ������������(��);",
	"miscdeluser"		=> "������ �� ����������� ���� �������� ��� ������ '\"+user+\"';",
	"miscnopassdiff"	=> "� ���� ������� ��������� ��� ����������� ������� ��� ��� �����������.",
	"miscnopassmatch"	=> "�� ������� ��� ���������� ������ ����.",
	"miscfieldmissed"	=> "����������� ��� ��������� �����.",
	"miscnouserpass"	=> "�� ����� ������ � � ������� ��������� ��� ����� �����.",
	"miscselfremove"	=> "��� �������� �� ���������� ��� ����� ���.",
	"miscuserexist"		=> "� ������� ������� ���.",
	"miscnofinduser"	=> "� ������� ��� ������ �� ������.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "������ ����������� ���������",
	"editlink"		=> "�����������",
	"downlink"		=> "����������",
	"uplink"		=> "����",
	"homelink"		=> "������ ������",
	"reloadlink"		=> "��������",
	"copylink"		=> "���������",
	"movelink"		=> "����������",
	"dellink"		=> "��������",
	"comprlink"		=> "��������",
	"adminlink"		=> "������������",
	"logoutlink"		=> "������",
	"uploadlink"		=> "�������",
	"searchlink"		=> "���������",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "�����",
	"sizeheader"		=> "�������",
	"typeheader"		=> "�����",
	"modifheader"		=> "�����������",
	"permheader"		=> "���/��",
	"actionheader"		=> "���������",
	"pathheader"		=> "��������",
	
	// buttons
	"btncancel"		=> "'�����",
	"btnsave"		=> "����������",
	"btnchange"		=> "������",
	"btnreset"		=> "��������",
	"btnclose"		=> "��������",
	"btncreate"		=> "����������",
	"btnsearch"		=> "���������",
	"btnupload"		=> "�������",
	"btncopy"		=> "���������",
	"btnmove"		=> "����������",
	"btnlogin"		=> "�������",
	"btnlogout"		=> "������",
	"btnadd"		=> "��������",
	"btnedit"		=> "�����������",
	"btnremove"		=> "��������",
	
	// actions
	"actdir"		=> "���������",
	"actperms"		=> "������ ����������� ���������",
	"actedit"		=> "����������� �������",
	"actsearchresults"	=> "������������ ����������",
	"actcopyitems"		=> "��������� ������������(��)",
	"actcopyfrom"		=> "��������� ��� /%s �� /%s ",
	"actmoveitems"		=> "���������� ������������(��)",
	"actmovefrom"		=> "���������� ��� /%s �� /%s ",
	"actlogin"		=> "�������",
	"actloginheader"	=> "����� ��� ������������ �� QuiXplorer",
	"actadmin"		=> "����������",
	"actchpwd"		=> "������ ������� ���������",
	"actusers"		=> "�������",
	"actarchive"		=> "�������� ������������(��)",
	"actupload"		=> "������� �������(��)",
	
	// misc
	"miscitems"		=> "�����������(�)",
	"miscfree"		=> "��������",
	"miscusername"		=> "����� ������",
	"miscpassword"		=> "������� ���������",
	"miscoldpass"		=> "������ �������",
	"miscnewpass"		=> "���� �������",
	"miscconfpass"		=> "���������� �������",
	"miscconfnewpass"	=> "���������� ���� �������",
	"miscchpass"		=> "������ �������",
	"mischomedir"		=> "������� ���������",
	"mischomeurl"		=> "URL ������� ���������",
	"miscshowhidden"	=> "�������� ������ ������������",
	"mischidepattern"	=> "�������� ������",
	"miscperms"		=> "���������� ���������",
	"miscuseritems"		=> "(�����, �������� ���������, �������� ������ ������������, ����������, ������)",
	"miscadduser"		=> "�������� ������",
	"miscedituser"		=> "����������� ������ '%s'",
	"miscactive"		=> "������",
	"misclang"		=> "������",
	"miscnoresult"		=> "��� �������� ������������.",
	"miscsubdirs"		=> "��������� �� �������������",
	"miscpermnames"		=> array("���� ��� �����","��������","�������� ������� ���������","�������� ������� ���������",
					"������������"),
	"miscyesno"		=> array("���","���","�","�"),
	"miscchmod"		=> array("����������", "�����", "�������"),
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
