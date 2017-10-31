<?php

// English Language Module for v2.3 (translated by the QuiX project)

$GLOBALS["charset"] = "iso-8859-7";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d/m/Y H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ERROR(S)",
	"back"			=> "Επιστροφή",
	
	// root
	"home"			=> "Ο μητρικός κατάλογος δέν υπάρχει, παρακαλώ ελέξτε τις ρυθμίσεις σας.",
	"abovehome"		=> "Ο τρέχων κατάλογος δέν μπορεί να υπερβαίνει τον μητρικό κατάλογο.",
	"targetabovehome"	=> "Ο επιλεγμένος κατάλογος δέν μπορεί να υπερβαίνει τον μητρικό κατάλογο.",
	
	// exist
	"direxist"		=> "Αυτός ο κατάλογος δέν υπάρχει.",
	//"filedoesexist"	=> "Αυτό το αρχείο δέν υπάρχει.",
	"fileexist"		=> "Αυτό το αρχείο δέν υπάρχει.",
	"itemdoesexist"		=> "Αυτό το αντικείμενο υπάρχει ήδη.",
	"itemexist"		=> "Αυτό το αντικείμενο υπάρχει ήδη.",
	"targetexist"		=> "Ό επιλεγμένος κατάλογος δέν υπάρχει.",
	"targetdoesexist"	=> "Το επιλεγμένο αντικείμενο υπάρχει ήδη.",
	
	// open
	"opendir"		=> "Είναι αδύνατον να ανοιχτεί ο κατάλογος.",
	"readdir"		=> "Είναι αδύνατον να διαβαστεί ο κατάλογος.",
	
	// access
	"accessdir"		=> "Δέν σας επιτρέπεται πρόσβαση σ' αυτόν τον κατάλογο.",
	"accessfile"		=> "Δέν σας επιτρέπεται πρόσβαση σ' αυτό το αρχείο.",
	"accessitem"		=> "Δέν σας επιτρέπεται πρόσβαση σ' αυτό το αντικείμενο.",
	"accessfunc"		=> "Δέν σας επιτρέπεται πρόσβαση σ' αυτή την λειτουργία.",
	"accesstarget"		=> "Δέν σας επιτρέπεται πρόσβαση σ' αυτόν τον κατάλογο.",
	
	// actions
	"permread"		=> "Η διαδικασία ανάκτησης προσβάσεων δέν κατέστει δυνατό να εκτελεστεί.",
	"permchange"		=> "Η διαδικασία μετατροπής προσβάσεων απέτυχε.",
	"openfile"		=> "Η διαδικασία ανοίγματος αρχείου απέτυχε.",
	"savefile"		=> "Η διαδικασία αποθήκευσης αρχείου απέτυχε.",
	"createfile"		=> "Η διαδικασία δημιουργίας αρχείου απέτυχε.",
	"createdir"		=> "Η διαδικασία δημιουργίας καταλόγου απέτυχε.",
	"uploadfile"		=> "Η διαδικασία φόρτωσης αρχείου απέτυχε.",
	"copyitem"		=> "Η διαδικασία αντιγραφής απέτυχε.",
	"moveitem"		=> "Η διαδικασία μετακίνησης απέτυχε.",
	"delitem"		=> "Η διαδικασία διαγραφής απέτυχε.",
	"chpass"		=> "Η διαδικασία μεταβολής κωδικού πρόσβασης απέτυχε.",
	"deluser"		=> "Η διαδικασία απομάκρυνσης χρήστη απέτυχε.",
	"adduser"		=> "Η διαδικασία προσθήκης χρήστη απέτυχε.",
	"saveuser"		=> "Η διαδικασία αποθήκευσης των στοιχείων του χρήστη απέτυχε.",
	"searchnothing"		=> "Είναι απαραίτητο να ορίσετε κάποια φράση για την οποία θα εκτελεστεί η αναζήτηση.",
	
	// misc
	"miscnofunc"		=> "Η διαδικασία δέν είναι διαθέσιμη.",
	"miscfilesize"		=> "Το αρχείο υπερβαίνει το μέγιστο επιτρεπτό μέγεθος.",
	"miscfilepart"		=> "Το αρχείο φορτώθηκε αποσπασματικά.",
	"miscnoname"		=> "Πρέπει να ορίσετε ένα όνομα.",
	"miscselitems"		=> "Δέν έχετε επιλέξει αντικείμενο(α).",
	"miscdelitems"		=> "Θέλετε να προχωρήσετε στην διαγραφή \"+num+\" αντικειμένου(ων);",
	"miscdeluser"		=> "Θέλετε να προχωρήσετε στην διαγραφή του χρήστη '\"+user+\"';",
	"miscnopassdiff"	=> "Ο νέος κωδικός πρόσβασης δέν παρουσιάζει διαφορά από τον προηγούμενο.",
	"miscnopassmatch"	=> "Οι κωδικοί δέν ταιριάζουν μεταξύ τους.",
	"miscfieldmissed"	=> "Παραλείψατε ένα σημαντικό πεδίο.",
	"miscnouserpass"	=> "Το όνομα χρήστη ή ο κωδικός πρόσβασης δέν είναι σωστά.",
	"miscselfremove"	=> "Δέν μπορείτε να αφαιρέσετε τον εαυτό σας.",
	"miscuserexist"		=> "Ο χρήστης υπάρχει ήδη.",
	"miscnofinduser"	=> "Ο χρήστης δέν μπορεί να βρεθεί.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "ΑΛΛΑΓΗ ΔΙΚΑΙΩΜΑΤΩΝ ΠΡΟΣΒΑΣΗΣ",
	"editlink"		=> "ΕΠΕΞΕΡΓΑΣΙΑ",
	"downlink"		=> "ΑΠΟΘΗΚΕΥΣΗ",
	"uplink"		=> "ΠΑΝΩ",
	"homelink"		=> "ΑΡΧΙΚΗ ΣΕΛΙΔΑ",
	"reloadlink"		=> "ΑΝΑΝΕΩΣΗ",
	"copylink"		=> "ΑΝΤΙΓΡΑΦΗ",
	"movelink"		=> "ΜΕΤΑΚΙΝΗΣΗ",
	"dellink"		=> "ΔΙΑΓΡΑΦΗ",
	"comprlink"		=> "ΣΥΜΠΙΕΣΗ",
	"adminlink"		=> "ΔΙΑΧΕΙΡΙΣΤΗΣ",
	"logoutlink"		=> "ΕΞΟΔΟΣ",
	"uploadlink"		=> "ΦΟΡΤΩΣΗ",
	"searchlink"		=> "ΑΝΑΖΗΤΗΣΗ",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> 'joomla System Information (joomla, Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Όνομα",
	"sizeheader"		=> "Μέγεθος",
	"typeheader"		=> "Τύπος",
	"modifheader"		=> "Τροποποίηση",
	"permheader"		=> "Δικ/τα",
	"actionheader"		=> "Ενέργειες",
	"pathheader"		=> "Διαδρομή",
	
	// buttons
	"btncancel"		=> "'Ακυρο",
	"btnsave"		=> "Αποθήκυεση",
	"btnchange"		=> "Αλλαγή",
	"btnreset"		=> "Αναίρεση",
	"btnclose"		=> "Κλείσιμο",
	"btncreate"		=> "Δημιουργία",
	"btnsearch"		=> "Αναζήτηση",
	"btnupload"		=> "Φόρτωση",
	"btncopy"		=> "Αντιγραφή",
	"btnmove"		=> "Μετακίνηση",
	"btnlogin"		=> "Είσοδος",
	"btnlogout"		=> "Έξοδος",
	"btnadd"		=> "Προσθήκη",
	"btnedit"		=> "Επεξεργασία",
	"btnremove"		=> "Αφαίρεση",
	
	// actions
	"actdir"		=> "Κατάλογος",
	"actperms"		=> "Αλλαγή δικαιωμάτων πρόσβασης",
	"actedit"		=> "Επεξεργασία Αρχείου",
	"actsearchresults"	=> "Αποτελέσματα Αναζήτησης",
	"actcopyitems"		=> "Αντιγραφή Αντικειμένου(ων)",
	"actcopyfrom"		=> "Αντιγραφή από /%s σε /%s ",
	"actmoveitems"		=> "Μετακίνηση Αντικειμένου(ων)",
	"actmovefrom"		=> "Μετακίνηση από /%s σε /%s ",
	"actlogin"		=> "Είσοδος",
	"actloginheader"	=> "Όνομα που χρησιμοποιεί το QuiXplorer",
	"actadmin"		=> "Διαχείριση",
	"actchpwd"		=> "Αλλαγή Κωδικού Πρόσβασης",
	"actusers"		=> "Χρήστες",
	"actarchive"		=> "Συμπίεση Αντικειμένου(ων)",
	"actupload"		=> "Φόρτωση Αρχείου(ων)",
	
	// misc
	"miscitems"		=> "Αντικείμενο(α)",
	"miscfree"		=> "Ελεύθερο",
	"miscusername"		=> "Όνομα Χρήστη",
	"miscpassword"		=> "Κωδικός Πρόσβασης",
	"miscoldpass"		=> "Παλιός Κωδικός",
	"miscnewpass"		=> "Νέος Κωδικός",
	"miscconfpass"		=> "Επαλήθευση Κωδικού",
	"miscconfnewpass"	=> "Επαλήθευση Νέου Κωδικού",
	"miscchpass"		=> "Αλλαγή Κωδικού",
	"mischomedir"		=> "Αρχικός Κατάλογος",
	"mischomeurl"		=> "URL Αρχικού Καταλόγου",
	"miscshowhidden"	=> "Εμφάνιση κρυφών αντικειμένων",
	"mischidepattern"	=> "Απόκρυψη μορφής",
	"miscperms"		=> "Δικαιώματα πρόσβασης",
	"miscuseritems"		=> "(όνομα, μητρικός κατάλογος, εμφάνιση κρυφών αντικειμένων, δικαιώματα, ενεργό)",
	"miscadduser"		=> "προσθήκη χρήστη",
	"miscedituser"		=> "επεξεργασία χρήστη '%s'",
	"miscactive"		=> "Ενεργό",
	"misclang"		=> "Γλώσσα",
	"miscnoresult"		=> "Δέν υπάρχουν αποτελέσματα.",
	"miscsubdirs"		=> "Αναζήτηση σε υποκαταλόγους",
	"miscpermnames"		=> array("Μόνο για θέαση","Μεταβολή","Μεταβολή Κωδικού Πρόσβασης","Μεταβολή Κωδικού Πρόσβασης",
					"Διαχειριστής"),
	"miscyesno"		=> array("Ναί","Όχι","Ν","Ο"),
	"miscchmod"		=> array("Ιδιοκτήτης", "Ομάδα", "Δημόσιο"),
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
