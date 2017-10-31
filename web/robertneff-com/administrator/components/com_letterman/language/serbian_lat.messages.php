<?php

define( "LM_SUBSCRIBE_SUBJECT", "Vaša prijava za Novosti" );
define( "LM_SUBSCRIBE_MESSAGE", 
"Pozdrav [NAME],

uspešno ste se prijavili za Novosti na 
[mosConfig_live_site].
Hvala Vam!

Da potvrdite prijavu, molim Vas kliknite na donji link ili ga prekopirajte
u Vaš pretraživač.

[LINK]

_________________________
[mosConfig_live_site]" );

define( "LM_UNSUBSCRIBE_SUBJECT", "Servis Novosti na [mosConfig_live_site]: Odjava" );
define( "LM_UNSUBSCRIBE_MESSAGE", 
"Pozdrav [NAME],

odjavili ste servis Novosti na sajtu [mosConfig_live_site].
Hvala što ste koristili naš servis.

________________________
[mosConfig_live_site]" );

define( "LM_NEWSLETTER_FOOTER", 
"<br/><br/>___________________________________________________________<br/>
Prijavljeni ste na listi za primanje Novosti<br/>
na sajtu [mosConfig_live_site].<br/>
Da biste se odjavili, možete kliknuti ovde: [UNLINK]" );

/* Module */
define( "LM_FORM_NOEMAIL", "Molim vas unesite validan e-mail." );
define( "LM_FORM_SHORTERNAME", "Molim Vas unesite kraće korisničko ime. Hvala." );
define( "LM_FORM_NONAME", "Molim Vas unesite ime za prijavu. Hvala." );
define( "LM_SUBSCRIBE", "Prijavi se" );
define( "LM_UNSUBSCRIBE", "Odjavi se" );
define( "LM_BUTTON_SUBMIT", "Kreni!" );

/* Backend */
define( "LM_ERROR_NEWSLETTER_COULDNTBESENT", "Newsletter nije poslat!" );
define( "LM_NEWSLETTER_SENDTO_X_USERS", "Newsletter poslat na {X} prijava" );
define( "LM_IMPORT_USERS", "Uvezi prijavljene" );
define( "LM_EXPORT_USERS", "Izvezi prijavljene" );
define( "LM_UPLAOD_FAILED", "Upload nije uspeo" );
define( "LM_ERROR_PARSING_XML", "Error Parsing the XML File" );
define( "LM_ERROR_NO_XML", "Molim upload-ujte samo xml fajlove" );
define( "LM_ERROR_EMAIL_ALREADY_ONLIST", "E-mail je ve' na listi" );
define( "LM_SUCCESS_ON_IMPORT", "Uspešno uvezeno {X} prijavljenih." );
define( "LM_IMPORT_FINISHED", "Uvoz završen" );
define( "LM_ERROR_DELETING_FILE", "Brisanje fajla nije uspelo" );
define( "LM_DIR_NOT_WRITABLE", "Ne mogu da upišem u direktorijum ".$GLOBALS['mosConfig_cachepath'] );
define( "LM_ERROR_INVALID_EMAIL", "Neispravna e-mail adresa" );
define( "LM_ERROR_EMPTY_EMAIL", "Prazna e-mail adresa" );
define( "LM_ERROR_EMPTY_FILE", "Greška: prazan fajl" );
define( "LM_ERROR_ONLY_TEXT", "Samo tekst" );

define( "LM_SELECT_FILE", "Molim Vas odaberite fajl" );
define( "LM_YOUR_XML_FILE", "Vaš YaNC/Letterman XML Export fajl" );
define( "LM_YOUR_CSV_FILE", "CSV Import fajl" );
define( "LM_POSITION_NAME", "Pozicija -Ime- kolone" );
define( "LM_NAME_COL", "Kolona ime" );
define( "LM_POSITION_EMAIL", "Pozicija -Email- kolone" );
define( "LM_EMAIL_COL", "Kolona Email" );
define( "LM_STARTFROM", "Početak uvoza od linije..." );
define( "LM_STARTFROMLINE", "Početak od linije" );
define( "LM_CSV_DELIMITER", "CSV Delimiter" );
define( "LM_CSV_DELIMITER_TIP", "CSV Delimiter: , ; ili tabulator" );

/* Newsletter Management */
define( "LM_NM", "Newsletter menadžer" );
define( "LM_MESSAGE", "Poruka" );
define( "LM_LAST_SENT", "Zadnje poslato" );
define( "LM_SEND_NOW", "Pošalji sad" );
define( "LM_CHECKED_OUT", "Checked Out" );
define( "LM_NO_EXPIRY", "Završetak: Nema isteka roka" );
define( "LM_WARNING_SEND_NEWSLETTER", "Jeste li sigurni da želite da pošaljete Novosti?\\nUpozorenje: Ako šaljete mail većoj grupi korisnika, izvršavanje može da potraje!" );
define( "LM_SEND_NEWSLETTER", "Pošalji Novosti" );
define( "LM_SEND_TO_GROUP", "Pošalji grupi" );
define( "LM_MAIL_FROM", "Mail od" );
define( "LM_DISABLE_TIMEOUT", "Isključi tajmaut" );
define( "LM_DISABLE_TIMEOUT_TIP", "Čekirajte da biste sprečili skript da generiše tajmaut grešku. <br/><strong>Ne radi u safe modu!<strong>" );
define( "LM_REPLY_TO", "Odgovori" );
define( "LM_MSG_HTML", "Poruka (HTML-WYSIWYG)" );
define( "LM_MSG", "Poruka (HTML-source)" );
define( "LM_TEXT_MSG", "Alternativna tekst poruka" );
define( "LM_NEWSLETTER_ITEM", "Tekst Novosti" );

/* Subscriber Management */
define( "LM_SUBSCRIBER", "Prijavljeni" );
define( "LM_NEW_SUBSCRIBER", "Novi pretplatnik" );
define( "LM_EDIT_SUBSCRIBER", "Izmeni pretplatnike" );
define( "LM_SELECT_SUBSCRIBER", "Upravljanje pretplatnicima" );
define( "LM_SUBSCRIBER_NAME", "Ime pretplatnika" );
define( "LM_SUBSCRIBER_EMAIL", "Email pretplatnika" );
define( "LM_SIGNUP_DATE", "Datum prijave" );
define( "LM_CONFIRMED", "Potvrđeno" );
define( "LM_SUBSCRIBER_SAVED", "Informacije o pretplatniku su sačuvane" );
define( "LM_SUBSCRIBERS_DELETED", "Uspešno ste obrisali {X} pretplatnika" );
define( "LM_SUBSCRIBER_DELETED", "Pretplatnik je obrisan." );

/* Frontend */
define( "LM_ALREADY_SUBSCRIBED", "Već ste se pretplatili na naše Novosti." );
define( "LM_NOT_SUBSCRIBED", "Trenutno NISTE prijavljeni za primanje Novosti." );
define( "LM_YOUR_DETAILS", "Vaši podaci:" );
define( "LM_SUBSCRIBE_TO", "Prijavite se za naše Novosti" );
define( "LM_UNSUBSCRIBE_FROM", "Odjavite se sa liste primanje Novosti" );
define( "LM_VALID_EMAIL_PLEASE", "Unesite e-mail adresu!" );
define( "LM_SAME_EMAIL_TWICE", "E-mail koji ste uneli je već registrovan!" );
define( "LM_ERROR_SENDING_SUBSCRIBE", "Poruka za prijavljivanje nije poslata:" );
define( "LM_SUCCESS_SUBSCRIBE", "Upisali ste se na listu za primanje Novosti." );
define( "LM_RETURN_TO_NL", "Povratak u Novosti" );
define( "LM_ERROR_UNSUBSCRIBE_OTHER_USER", "Žao nam je. Ne možete izbrisati druge korisnike iz liste!" );
define( "LM_ERROR_SENDING_UNSUBSCRIBE", "Poruka za odjavljivanje nije poslata:" );
define( "LM_SUCCESS_UNSUBSCRIBE", "vaša e-mail adresa je izbrisana sa liste za primanje Novosti" );
define( "LM_SUCCESS_CONFIRMATION", "Vaš nalog je potvrđen" );
define( "LM_ERROR_CONFIRM_ACC_NOTFOUND", "Ne postoji nalog pridružen vašem linku za potvrdu." );

define( "LM_CONFIRMED_ACCOUNTS_ONLY", "Samo potvrđenim nalozima?" );
define( "LM_CONFIRMED_ACCOUNTS_ONLY_TIP", "Pošalji Novosti samo <strong>potvrđenim</strong> nalozima prijavljenih korisnika. Prijavljeni koji nisu potvrdili svoju prijavu neće primiti Novosti." );

define( "LM_NAME_TAG_USAGE", "Možete koristiti oznaku <strong>[NAME]</strong> u tekstu da bi slali personalizovane Novosti. <br/>Pri slanju [NAME] se zamenjuje imenom korisnika / prijavljenog." );

define( "LM_USERS_TO_SUBSCRIBERS", "Prijavi registrovane korisnike sajta za primanje Novosti" );
define( "LM_ASSIGN_USERS", "Pridruži korisnike" );

/**
 * @since Letterman 1.2.0
 */
define( 'LM_SEND_LOG', 'NOVOSTI Pošalji Log' );
define( 'LM_NUMBER_OF_MAILS_SENT', '%s od %s mail-ova poslato do sada.');
define( 'LM_SEND_NEXT_X_MAILS', 'Kliknite dugme da pošaljete sledećih %s mail-ova.');
define( 'LM_CHANGE_MAILS_PER_STEP', 'Promeni iznos mailova-po-koraku');
define( 'LM_CONFIRM_ABORT_SENDING', 'Da li ste sigurni da želite da obustavite slanje ovih Novosti?');
define( 'LM_MAILS_PER_STEP', 'Koliko mail-ova da pošaljem odjednom?');
define( 'LM_CONFIRM_UNSUBSCRIBE', 'Da li ste sigurni da želite da se odjavite sa našeg servisa Novosti?');

/**
 * @since Letterman 1.2.1
 */
define( 'LM_COMPOSE_NEWSLETTER', 'Sasatavi Novosti od stavki iz sadržaja');
define( 'LM_USABLE_TAGS', 'Oznake koje možete koristiti' );
define( 'LM_CONTENT_ITEMS', 'Stavke sadržaja' );
define( 'LM_ADD_CONTENT', 'Dodaj stavke sadžaja / članke' );
define( 'LM_ADD_CONTENT_TOOLTIP', 'Ako odabirate stavke sadržaja iz liste, tag će biti dodat u polje teksta. Taj tag ce biti renderovan u okviru celog članka (u delu za čist tekst sa slikama) kada kliknete na Snimi.' );
define( 'LM_ATTACHMENTS', 'Attachments' );
define( 'LM_ATTACHMENTS_TOOLTIP', 'Možete odabrati jedan ili više datoteka iz fascikle %s, koji će biti dodati u mail kada ga šaljete. Ne brinite za tag [ATTACHMENT ..] - on će biti uklonjen kada šaljete Novosti!' );
define( 'LM_MULTISELECT', 'Multi-select fajlova sa Ctrl-MouseClick' );

?>