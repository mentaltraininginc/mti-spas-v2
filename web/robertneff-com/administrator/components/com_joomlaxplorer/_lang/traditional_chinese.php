<?php

// traditional chinese Language Module for v2.3 (translated by Which)

$GLOBALS["charset"] = "big5";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "錯誤",
	"back"			=> "回上頁",
	
	// root
	"home"			=> "The home directory doesn't exist, check your settings.",
	"abovehome"		=> "The current directory may not be above the home directory.",
	"targetabovehome"	=> "The target directory may not be above the home directory.",
	
	// exist
	"direxist"		=> "這目錄不存在.",
	//"filedoesexist"	=> "這目錄已存在.",
	"fileexist"		=> "這檔案不存在.",
	"itemdoesexist"		=> "這項目已存在.",
	"itemexist"		=> "這項目不存在.",
	"targetexist"		=> "這目標目錄不存在.",
	"targetdoesexist"	=> "這目標項目已存在.",
	
	// open
	"opendir"		=> "無法打開目錄.",
	"readdir"		=> "無法讀取目錄.",
	
	// access
	"accessdir"		=> "您不允許存取這個目錄.",
	"accessfile"		=> "您不允許存取這個檔案.",
	"accessitem"		=> "您不允許存取這個項目.",
	"accessfunc"		=> "您不允許使用這個功能.",
	"accesstarget"		=> "您不允許存取這個目標目錄.",
	
	// actions
	"permread"		=> "取得權限失敗.",
	"permchange"		=> "權限更改失敗.",
	"openfile"		=> "打開檔案失敗.",
	"savefile"		=> "檔案儲存失敗.",
	"createfile"		=> "新增檔案失敗.",
	"createdir"		=> "新增目錄失敗.",
	"uploadfile"		=> "檔案上傳失敗.",
	"copyitem"		=> "複製失敗.",
	"moveitem"		=> "移動失敗.",
	"delitem"		=> "刪除失敗.",
	"chpass"		=> "更改密碼失敗.",
	"deluser"		=> "移除使用者失敗.",
	"adduser"		=> "加入使用者失敗.",
	"saveuser"		=> "儲存使用者失敗.",
	"searchnothing"		=> "您必須輸入些什麼來搜尋.",
	
	// misc
	"miscnofunc"		=> "功能無效.",
	"miscfilesize"		=> "檔案大小已達到最大.",
	"miscfilepart"		=> "檔案只有部分已上傳.",
	"miscnoname"		=> "您必須輸入名稱.",
	"miscselitems"		=> "您還未選擇任何項目.",
	"miscdelitems"		=> "您確定要刪除這些 \"+num+\" 項目?",
	"miscdeluser"		=> "您確定要刪除使用者 '\"+user+\"'?",
	"miscnopassdiff"	=> "新密碼跟舊密碼相同.",
	"miscnopassmatch"	=> "密碼不符.",
	"miscfieldmissed"	=> "您遺漏一個重要欄位.",
	"miscnouserpass"	=> "使用者名稱或密碼錯誤.",
	"miscselfremove"	=> "您無法移除您自己.",
	"miscuserexist"		=> "使用者已存在.",
	"miscnofinduser"	=> "無法找到使用者.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "更改權限",
	"editlink"		=> "編輯",
	"downlink"		=> "下載",
	"uplink"		=> "上一層",
	"homelink"		=> "主頁",
	"reloadlink"		=> "重新載入",
	"copylink"		=> "複製",
	"movelink"		=> "移動",
	"dellink"		=> "刪除",
	"comprlink"		=> "壓縮",
	"adminlink"		=> "管理員",
	"logoutlink"		=> "登出",
	"uploadlink"		=> "上傳",
	"searchlink"		=> "搜尋",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "名稱",
	"sizeheader"		=> "大小",
	"typeheader"		=> "類型",
	"modifheader"		=> "最後更新",
	"permheader"		=> "權限",
	"actionheader"		=> "動作",
	"pathheader"		=> "路徑",
	
	// buttons
	"btncancel"		=> "取消",
	"btnsave"		=> "儲存",
	"btnchange"		=> "更改",
	"btnreset"		=> "重設",
	"btnclose"		=> "關閉",
	"btncreate"		=> "新增",
	"btnsearch"		=> "搜尋",
	"btnupload"		=> "上傳",
	"btncopy"		=> "複製",
	"btnmove"		=> "移動",
	"btnlogin"		=> "登入",
	"btnlogout"		=> "登出",
	"btnadd"		=> "增加",
	"btnedit"		=> "編輯",
	"btnremove"		=> "移除",
	
	// actions
	"actdir"		=> "目錄",
	"actperms"		=> "更改權限",
	"actedit"		=> "編輯檔案",
	"actsearchresults"	=> "搜尋結果",
	"actcopyitems"		=> "複製項目",
	"actcopyfrom"		=> "從 /%s 複製到 /%s ",
	"actmoveitems"		=> "移動項目",
	"actmovefrom"		=> "從 /%s 移動到 /%s ",
	"actlogin"		=> "登入",
	"actloginheader"	=> "登入以使用 QuiXplorer",
	"actadmin"		=> "管理選單",
	"actchpwd"		=> "更改密碼",
	"actusers"		=> "使用者",
	"actarchive"		=> "壓縮項目",
	"actupload"		=> "上傳檔案",
	
	// misc
	"miscitems"		=> "項目",
	"miscfree"		=> "Free",
	"miscusername"		=> "使用者名稱",
	"miscpassword"		=> "密碼",
	"miscoldpass"		=> "舊密碼",
	"miscnewpass"		=> "新密碼",
	"miscconfpass"		=> "確認密碼",
	"miscconfnewpass"	=> "確認新密碼",
	"miscchpass"		=> "更改密碼",
	"mischomedir"		=> "主頁目錄",
	"mischomeurl"		=> "主頁 URL",
	"miscshowhidden"	=> "顯示隱藏項目",
	"mischidepattern"	=> "隱藏樣式",
	"miscperms"		=> "權限",
	"miscuseritems"		=> "(名稱, 主頁目錄, 顯示隱藏項目, 權限, 啟用)",
	"miscadduser"		=> "增加使用者",
	"miscedituser"		=> "編輯使用者 '%s'",
	"miscactive"		=> "啟用",
	"misclang"		=> "語言",
	"miscnoresult"		=> "無結果可用.",
	"miscsubdirs"		=> "搜尋子目錄",
	"miscpermnames"		=> array("只能瀏覽","修改","更改密碼","修改及更改密碼",
					"管理員"),
	"miscyesno"		=> array("是的","否","Y","N"),
	"miscchmod"		=> array("所有人", "群組", "公開的"),
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
