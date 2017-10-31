<?php
/**
* FacileForms - A Joomla Forms Application
* @version 1.4.4
* @package FacileForms
* @copyright (C) 2004-2005 by Peter Koch
* @license Released under the terms of the GNU General Public License
**/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMRECRECEIVED',	'Formular Datensatz empfangen');
/*1.3.0*/define('_FACILEFORMS_PROCESS_RECORDSAVEDID',	'Daten mit folgender ID abgespeichert: ');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMID',			'Formular ID');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMTITLE',		'Formular Titel');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FORMNAME',		'Form Name');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SUBMITTEDAT',		'Gesendet um');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SUBMITTERIP',		'Absender IP');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PROVIDER',		'Absender Provider');
/*1.3.0*/define('_FACILEFORMS_PROCESS_BROWSER',			'Absender Browser');
/*1.3.0*/define('_FACILEFORMS_PROCESS_OPSYS',			'Absender Betriebssystem');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SUBMITSUCCESS',	'Formular erfolgreich übermittelt');
/*1.3.0*/define('_FACILEFORMS_PROCESS_UNPUBLISHED',		'Formular ist nicht publiziert');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SAVERECFAILED',	'Speichern eines Datensatzes fehlgeschlagen');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SAVESUBFAILED',	'Speichern eines Unter-Datensatzes   fehlgeschlagen');
/*1.3.0*/define('_FACILEFORMS_PROCESS_UPLOADFAILED',	'Datei Upload ist fehlgeschlagen');
/*1.3.0*/define('_FACILEFORMS_PROCESS_SENDMAILFAILED',	'Versenden der EMail fehlgeschlagen');
/*1.3.0*/define('_FACILEFORMS_PROCESS_ATTACHMTFAILED',	'Erzeugung des Dateianhangs fehlgeschlagen');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILENOTWRTBLE',	'Datei ist nicht beschreibbar');
/*1.3.0*/define('_FACILEFORMS_PROCESS_DIRNOTWRTBLE',	'Verzeichnis ist nicht beschreibbar');
/*1.3.0*/define('_FACILEFORMS_PROCESS_DIRNOTEXISTS',	'Verzeichnis existiert nicht');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILEEXISTS',		'Gleichnamige Datei existriert bereits');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILEMOVEFAILED',	'Datei konnte nicht verschoben werden');
/*1.3.0*/define('_FACILEFORMS_PROCESS_FILECHMODFAILED',	'Änderung der Dateizugriffsrechte fehlgeschlagen (chmod)');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGESTART',		'Anfang');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGEPREV',		'Zurück');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGENEXT',		'Nächste');
/*1.3.0*/define('_FACILEFORMS_PROCESS_PAGEEND',			'Ende');
/*1.4.1*/define('_FACILEFORMS_PROCESS_LINE',			'Zeile');
/*1.4.1*/define('_FACILEFORMS_PROCESS_MSGLINE',			'Von Zeile');
/*1.4.1*/define('_FACILEFORMS_PROCESS_MSGUNKNOWN',		'Von unbekannt');
/*1.4.1*/define('_FACILEFORMS_PROCESS_IN',				'in');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ENTER',			'Eintritt');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ATLINE',			'bei Zeile');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ARRAY',			'Array');
/*1.4.1*/define('_FACILEFORMS_PROCESS_OBJECT',			'Objekt');
/*1.4.1*/define('_FACILEFORMS_PROCESS_RESOURCE',		'Ressource');
/*1.4.1*/define('_FACILEFORMS_PROCESS_UNKNOWN',			'Unbekannt');
/*1.4.1*/define('_FACILEFORMS_PROCESS_LEAVE',			'Austritt');
/*1.4.1*/define('_FACILEFORMS_PROCESS_WARNSTK',			'WARNUNG: _ff_traceExit() bei leerem Stapelspeicher aufgerufen');
/*1.4.1*/define('_FACILEFORMS_PROCESS_EXCAUGHT',		'AUSNAHMEBEDINGUNG DURCH FACILEFORMS AUFGEFANGEN');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PHPLEVEL',		'PHP Fehlerstufe :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PHPFILE',			'PHP Dateiname   :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PHPLINE',			'PHP Zeilennummer:');
/*1.4.1*/define('_FACILEFORMS_PROCESS_LASTPOS',			'Letzte Position :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ERRMSG',			'Fehlermeldung   :');
/*1.4.1*/define('_FACILEFORMS_PROCESS_PIECE',			'Teil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_QPIECEOF',		'Abfrage von');
/*1.4.1*/define('_FACILEFORMS_PROCESS_QTITLEOF',		'Titel von');
/*1.4.1*/define('_FACILEFORMS_PROCESS_QVALUEOF',		'Wert von');
/*1.4.1*/define('_FACILEFORMS_PROCESS_SCRIPT',			'Skript');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BFPIECE',			'Vorformular Teil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BFPIECEC',		'Vorformular Spezialteil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_AFPIECE',			'Nachformular Teil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_AFPIECEC',		'Nachformular Spezialteil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BSPIECE',			'Übermittlungsbeginn Teil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_BSPIECEC',		'Übermittlungsbeginn Spezialteil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ESPIECE',			'Übermittlungsende Teil');
/*1.4.1*/define('_FACILEFORMS_PROCESS_ESPIECEC',		'Übermittlungsende Spezialteil');

/*1.4.1*/define('_FACILEFORMS_XML_ELEMENT',				'XML Element');
/*1.4.1*/define('_FACILEFORMS_XML_ATLINE',				'bei Zeile');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPELEM',			'Unerwartetes Element');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPATTR',			'Unerwartetes Attribut');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPDATA',			'Unerwartete Daten');
/*1.4.1*/define('_FACILEFORMS_XML_UNEXPCLOS',			'Unerwartete schiessende Marke');
/*1.4.1*/define('_FACILEFORMS_XML_REFMISSED',			'Fataler Fehler: Paketreferenz verpasst');
/*1.4.1*/define('_FACILEFORMS_XML_MISSFNAME',			'Dateiname fehlt');
/*1.4.1*/define('_FACILEFORMS_XML_ERROPENF',			'Fehler beim Öffnen der Datei');
?>