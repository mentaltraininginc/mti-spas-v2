<?php
/**
* FacileForms - A Joomla Forms Application
* @version 1.4.4
* @package FacileForms
* @copyright (C) 2004-2005 by Peter Koch
* @license Released under the terms of the GNU General Public License
**/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMRECRECEIVED', 'Form record received');
/*1.3.0*/define('_FACILEFORMS_PROCESS_RECORDSAVEDID', 	'Record saved to database with ID: ');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMID', 			'Form ID');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMTITLE', 		'Form title');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMNAME', 		'Form name');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SUBMITTEDAT', 	'Submitted at');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SUBMITTERIP', 	'Submitter IP');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PROVIDER', 		'Submitter provider');
/*1.3.0*/define('_FACILEFORMS_PROCESS_BROWSER', 		'Submitter browser');
/*1.3.0*/define('_FACILEFORMS_PROCESS_OPSYS', 			'Submitter operating system');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SUBMITSUCCESS', 	'Form successfully submitted');
/*1.3.0*/define('_FACILEFORMS_PROCESS_UNPUBLISHED',		'Form is unpublished');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SAVERECFAILED',	'Save record failed');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SAVESUBFAILED',	'Save subrecord failed');
/*1.3.0*/define('_FACILEFORMS_PROCESS_UPLOADFAILED',	'File upload failed');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SENDMAILFAILED',	'Send mail failed');
/*1.3.0*/define('_FACILEFORMS_PROCESS_ATTACHMTFAILED',	'Create attachment file failed');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILENOTWRTBLE',	'File is not writable');
/*1.3.0*/define('_FACILEFORMS_PROCESS_DIRNOTWRTBLE',	'Directory is not writable');
/*1.3.0*/define('_FACILEFORMS_PROCESS_DIRNOTEXISTS',	'Directory does not exist');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILEEXISTS',		'File with same name allready exists');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILEMOVEFAILED',	'File could not be moved');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILECHMODFAILED', 'Change file permissions failed (chmod)');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGESTART',		'Start');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGEPREV',		'Previous');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGENEXT',		'Next');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGEEND',			'End');
/*1.4.1*/define('_FACILEFORMS_PROCESS_LINE',			'Line');
/*1.4.1*/define('_FACILEFORMS_PROCESS_MSGLINE',			'From line');
/*1.4.1*/define('_FACILEFORMS_PROCESS_MSGUNKNOWN',		'From unknown');
/*1.4.1*/define('_FACILEFORMS_PROCESS_IN',				'in');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ENTER',			'Enter');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ATLINE',			'at line');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ARRAY',			'Array');
/*1.4.1*/define('_FACILEFORMS_PROCESS_OBJECT',			'Object');
/*1.4.1*/define('_FACILEFORMS_PROCESS_RESOURCE',		'Resource');
/*1.4.1*/define('_FACILEFORMS_PROCESS_UNKNOWN',			'Unknown');
/*1.4.1*/define('_FACILEFORMS_PROCESS_LEAVE',			'Leave');
/*1.4.1*/define('_FACILEFORMS_PROCESS_WARNSTK',			'WARNING: _ff_traceExit() called at empty stack');
/*1.4.1*/define('_FACILEFORMS_PROCESS_EXCAUGHT',		'EXCEPTION CAUGHT BY FACILEFORMS');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PHPLEVEL',		'PHP error level :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PHPFILE',			'PHP filename    :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PHPLINE',			'PHP linenumber  :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_LASTPOS',			'Last known pos  :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ERRMSG',			'Error message   :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PIECE',			'Piece');
/*1.4.1*/define('_FACILEFORMS_PROCESS_QPIECEOF',		'Query of');
/*1.4.1*/define('_FACILEFORMS_PROCESS_QTITLEOF',		'Title of');
/*1.4.1*/define('_FACILEFORMS_PROCESS_QVALUEOF',		'Value of');
/*1.4.1*/define('_FACILEFORMS_PROCESS_SCRIPT',			'Script');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BFPIECE',			'Before form piece');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BFPIECEC',		'Before form custom piece code');
/*1.4.1*/define('_FACILEFORMS_PROCESS_AFPIECE',			'After form piece');
/*1.4.1*/define('_FACILEFORMS_PROCESS_AFPIECEC',		'After form custom piece code');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BSPIECE',			'Begin submit piece');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BSPIECEC',		'Begin submit custom piece code');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ESPIECE',			'End submit piece');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ESPIECEC',		'End submit custom piece code');

/*1.4.1*/define('_FACILEFORMS_XML_ELEMENT',				'XML element');
/*1.4.1*/define('_FACILEFORMS_XML_ATLINE',				'at line');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPELEM',			'Unexpected element');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPATTR',			'Unexpected attribute');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPDATA',			'Unxepected data');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPCLOS',			'Unexpected closing tag');
/*1.4.1*/define('_FACILEFORMS_XML_REFMISSED',			'Fatal error: package reference missed');
/*1.4.1*/define('_FACILEFORMS_XML_MISSFNAME',			'Missing file name.');
/*1.4.1*/define('_FACILEFORMS_XML_ERROPENF',			'Error opening file');

?>