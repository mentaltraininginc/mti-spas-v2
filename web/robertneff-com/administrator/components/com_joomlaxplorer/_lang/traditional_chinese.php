<?php

// traditional chinese Language Module for v2.3 (translated by Which)

$GLOBALS["charset"] = "big5";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "���~",
	"back"			=> "�^�W��",
	
	// root
	"home"			=> "The home directory doesn't exist, check your settings.",
	"abovehome"		=> "The current directory may not be above the home directory.",
	"targetabovehome"	=> "The target directory may not be above the home directory.",
	
	// exist
	"direxist"		=> "�o�ؿ����s�b.",
	//"filedoesexist"	=> "�o�ؿ��w�s�b.",
	"fileexist"		=> "�o�ɮפ��s�b.",
	"itemdoesexist"		=> "�o���ؤw�s�b.",
	"itemexist"		=> "�o���ؤ��s�b.",
	"targetexist"		=> "�o�ؼХؿ����s�b.",
	"targetdoesexist"	=> "�o�ؼж��ؤw�s�b.",
	
	// open
	"opendir"		=> "�L�k���}�ؿ�.",
	"readdir"		=> "�L�kŪ���ؿ�.",
	
	// access
	"accessdir"		=> "�z�����\�s���o�ӥؿ�.",
	"accessfile"		=> "�z�����\�s���o���ɮ�.",
	"accessitem"		=> "�z�����\�s���o�Ӷ���.",
	"accessfunc"		=> "�z�����\�ϥγo�ӥ\��.",
	"accesstarget"		=> "�z�����\�s���o�ӥؼХؿ�.",
	
	// actions
	"permread"		=> "���o�v������.",
	"permchange"		=> "�v����異��.",
	"openfile"		=> "���}�ɮץ���.",
	"savefile"		=> "�ɮ��x�s����.",
	"createfile"		=> "�s�W�ɮץ���.",
	"createdir"		=> "�s�W�ؿ�����.",
	"uploadfile"		=> "�ɮפW�ǥ���.",
	"copyitem"		=> "�ƻs����.",
	"moveitem"		=> "���ʥ���.",
	"delitem"		=> "�R������.",
	"chpass"		=> "���K�X����.",
	"deluser"		=> "�����ϥΪ̥���.",
	"adduser"		=> "�[�J�ϥΪ̥���.",
	"saveuser"		=> "�x�s�ϥΪ̥���.",
	"searchnothing"		=> "�z������J�Ǥ���ӷj�M.",
	
	// misc
	"miscnofunc"		=> "�\��L��.",
	"miscfilesize"		=> "�ɮפj�p�w�F��̤j.",
	"miscfilepart"		=> "�ɮץu�������w�W��.",
	"miscnoname"		=> "�z������J�W��.",
	"miscselitems"		=> "�z�٥���ܥ��󶵥�.",
	"miscdelitems"		=> "�z�T�w�n�R���o�� \"+num+\" ����?",
	"miscdeluser"		=> "�z�T�w�n�R���ϥΪ� '\"+user+\"'?",
	"miscnopassdiff"	=> "�s�K�X���±K�X�ۦP.",
	"miscnopassmatch"	=> "�K�X����.",
	"miscfieldmissed"	=> "�z��|�@�ӭ��n���.",
	"miscnouserpass"	=> "�ϥΪ̦W�٩αK�X���~.",
	"miscselfremove"	=> "�z�L�k�����z�ۤv.",
	"miscuserexist"		=> "�ϥΪ̤w�s�b.",
	"miscnofinduser"	=> "�L�k���ϥΪ�.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "����v��",
	"editlink"		=> "�s��",
	"downlink"		=> "�U��",
	"uplink"		=> "�W�@�h",
	"homelink"		=> "�D��",
	"reloadlink"		=> "���s���J",
	"copylink"		=> "�ƻs",
	"movelink"		=> "����",
	"dellink"		=> "�R��",
	"comprlink"		=> "���Y",
	"adminlink"		=> "�޲z��",
	"logoutlink"		=> "�n�X",
	"uploadlink"		=> "�W��",
	"searchlink"		=> "�j�M",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "�W��",
	"sizeheader"		=> "�j�p",
	"typeheader"		=> "����",
	"modifheader"		=> "�̫��s",
	"permheader"		=> "�v��",
	"actionheader"		=> "�ʧ@",
	"pathheader"		=> "���|",
	
	// buttons
	"btncancel"		=> "����",
	"btnsave"		=> "�x�s",
	"btnchange"		=> "���",
	"btnreset"		=> "���]",
	"btnclose"		=> "����",
	"btncreate"		=> "�s�W",
	"btnsearch"		=> "�j�M",
	"btnupload"		=> "�W��",
	"btncopy"		=> "�ƻs",
	"btnmove"		=> "����",
	"btnlogin"		=> "�n�J",
	"btnlogout"		=> "�n�X",
	"btnadd"		=> "�W�[",
	"btnedit"		=> "�s��",
	"btnremove"		=> "����",
	
	// actions
	"actdir"		=> "�ؿ�",
	"actperms"		=> "����v��",
	"actedit"		=> "�s���ɮ�",
	"actsearchresults"	=> "�j�M���G",
	"actcopyitems"		=> "�ƻs����",
	"actcopyfrom"		=> "�q /%s �ƻs�� /%s ",
	"actmoveitems"		=> "���ʶ���",
	"actmovefrom"		=> "�q /%s ���ʨ� /%s ",
	"actlogin"		=> "�n�J",
	"actloginheader"	=> "�n�J�H�ϥ� QuiXplorer",
	"actadmin"		=> "�޲z���",
	"actchpwd"		=> "���K�X",
	"actusers"		=> "�ϥΪ�",
	"actarchive"		=> "���Y����",
	"actupload"		=> "�W���ɮ�",
	
	// misc
	"miscitems"		=> "����",
	"miscfree"		=> "Free",
	"miscusername"		=> "�ϥΪ̦W��",
	"miscpassword"		=> "�K�X",
	"miscoldpass"		=> "�±K�X",
	"miscnewpass"		=> "�s�K�X",
	"miscconfpass"		=> "�T�{�K�X",
	"miscconfnewpass"	=> "�T�{�s�K�X",
	"miscchpass"		=> "���K�X",
	"mischomedir"		=> "�D���ؿ�",
	"mischomeurl"		=> "�D�� URL",
	"miscshowhidden"	=> "������ö���",
	"mischidepattern"	=> "���ü˦�",
	"miscperms"		=> "�v��",
	"miscuseritems"		=> "(�W��, �D���ؿ�, ������ö���, �v��, �ҥ�)",
	"miscadduser"		=> "�W�[�ϥΪ�",
	"miscedituser"		=> "�s��ϥΪ� '%s'",
	"miscactive"		=> "�ҥ�",
	"misclang"		=> "�y��",
	"miscnoresult"		=> "�L���G�i��.",
	"miscsubdirs"		=> "�j�M�l�ؿ�",
	"miscpermnames"		=> array("�u���s��","�ק�","���K�X","�ק�Χ��K�X",
					"�޲z��"),
	"miscyesno"		=> array("�O��","�_","Y","N"),
	"miscchmod"		=> array("�Ҧ��H", "�s��", "���}��"),
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
