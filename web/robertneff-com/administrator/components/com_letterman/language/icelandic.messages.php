<?php

define( "LM_SUBSCRIBE_SUBJECT", "Skráning á póstlista hjá [mosConfig_live_site]" );
define( "LM_SUBSCRIBE_MESSAGE", 
"Halló [NAME],

þú hefur verið skráður á póstlista hjá [mosConfig_live_site].

Smelltu á tengilinn hér að neðan til að staðfesta skráninguna, eða klipptu hann og límdu í vafrann þinn.

[LINK]

_________________________
[mosConfig_live_site]" );

define( "LM_UNSUBSCRIBE_SUBJECT", "Póstlisti hjá [mosConfig_live_site]: Afskráning" );
define( "LM_UNSUBSCRIBE_MESSAGE", 
"Halló [NAME],

þú hefur verið afskráð(ur) af póstlista hjá [mosConfig_live_site]. 

________________________
[mosConfig_live_site]" );

define( "LM_NEWSLETTER_FOOTER", 
"<br/><br/>___________________________________________________________<br/>
Þú færð þennan póst <br>
því þú ert skráð(ur) á póstlista hjá [mosConfig_live_site].
Til að afskrá þig smelltu hér: [UNLINK]" );

/* Module */
define( "LM_FORM_NOEMAIL", "Vinsamlegast setjið inn tölvupóstfang." );
define( "LM_FORM_SHORTERNAME", "Vinsamlegast veljið styttra nafn, takk." );
define( "LM_FORM_NONAME", "Vinsamlegast veljið skráningarnafn, takk." );
define( "LM_SUBSCRIBE", "Skráning" );
define( "LM_UNSUBSCRIBE", "Afskráning" );
define( "LM_BUTTON_SUBMIT", "Staðfesta" );

/* Backend */
define( "LM_ERROR_NEWSLETTER_COULDNTBESENT", "Newsletter could not be send!" );
define( "LM_NEWSLETTER_SENDTO_X_USERS", "Newsletter sent to {X} users" );
define( "LM_IMPORT_USERS", "Import Subscribers" );
define( "LM_EXPORT_USERS", "Export Subscribers" );
define( "LM_UPLAOD_FAILED", "Upload Failed" );
define( "LM_ERROR_PARSING_XML", "Error Parsing the XML File" );
define( "LM_ERROR_NO_XML", "Please upload only xml files" );
define( "LM_ERROR_EMAIL_ALREADY_ONLIST", "The email is already on the list" );
define( "LM_SUCCESS_ON_IMPORT", "Successfully imported {X} Subscribers." );
define( "LM_IMPORT_FINISHED", "Import finished" );
define( "LM_ERROR_DELETING_FILE", "File Deletion failed" );
define( "LM_DIR_NOT_WRITABLE", "Cannot write to directory ".$GLOBALS['mosConfig_cachepath'] );
define( "LM_ERROR_INVALID_EMAIL", "Invalid Email address" );
define( "LM_ERROR_EMPTY_EMAIL", "Empty Email address" );
define( "LM_ERROR_EMPTY_FILE", "Error: Empty file" );
define( "LM_ERROR_ONLY_TEXT", "Only text" );

define( "LM_SELECT_FILE", "Please select a file" );
define( "LM_YOUR_XML_FILE", "Your YaNC/Letterman XML Export File" );
define( "LM_YOUR_CSV_FILE", "CSV Import File" );
define( "LM_POSITION_NAME", "Position of the -Name- column" );
define( "LM_NAME_COL", "Name Column" );
define( "LM_POSITION_EMAIL", "Position of the -Email- column" );
define( "LM_EMAIL_COL", "Email Column" );
define( "LM_STARTFROM", "Start Importing from line..." );
define( "LM_STARTFROMLINE", "Start from line" );
define( "LM_CSV_DELIMITER", "CSV Delimiter" );
define( "LM_CSV_DELIMITER_TIP", "CSV Delimiter: , ; or Tabulator" );

/* Newsletter Management */
define( "LM_NM", "Newsletter Manager" );
define( "LM_MESSAGE", "Message" );
define( "LM_LAST_SENT", "Last send" );
define( "LM_SEND_NOW", "Send now" );
define( "LM_CHECKED_OUT", "Checked Out" );
define( "LM_NO_EXPIRY", "Finish: No Expiry" );
define( "LM_WARNING_SEND_NEWSLETTER", "Are you sure you want to send the newsletter?\\nWarning: If you send mail to a large group of users this could take a while!" );
define( "LM_SEND_NEWSLETTER", "Send Newsletter" );
define( "LM_SEND_TO_GROUP", "Send to group" );
define( "LM_MAIL_FROM", "Mail from" );
define( "LM_DISABLE_TIMEOUT", "Disable timeout" );
define( "LM_DISABLE_TIMEOUT_TIP", "Check to prevend the script generating a timeout error. <br/><strong>Doesn\'t work in safe mode!<strong>" );
define( "LM_REPLY_TO", "Reply to" );
define( "LM_MSG_HTML", "Message (HTML-WYSIWYG)" );
define( "LM_MSG", "Message (HTML-source)" );
define( "LM_TEXT_MSG", "alternative Text Message" );
define( "LM_NEWSLETTER_ITEM", "Newsletter Item" );

/* Subscriber Management */
define( "LM_SUBSCRIBER", "Subscriber" );
define( "LM_NEW_SUBSCRIBER", "New Subscriber" );
define( "LM_EDIT_SUBSCRIBER", "Edit Subscriber" );
define( "LM_SELECT_SUBSCRIBER", "Select a Subscriber" );
define( "LM_SUBSCRIBER_NAME", "Subscriber Name" );
define( "LM_SUBSCRIBER_EMAIL", "Subscriber Email" );
define( "LM_SIGNUP_DATE", "Signup Date" );
define( "LM_CONFIRMED", "Confirmed" );
define( "LM_SUBSCRIBER_SAVED", "The Subscriber Information has been saved" );
define( "LM_SUBSCRIBERS_DELETED", "You successfully deleted {X} Subscribers" );
define( "LM_SUBSCRIBER_DELETED", "The Subscriber was successfully deleted." );

/* Frontend */
define( "LM_ALREADY_SUBSCRIBED", "Þú hefur þegar skráð þig á póstlistann." );
define( "LM_NOT_SUBSCRIBED", "Þú ert ekki skráð(ur) á póstlistann." );
define( "LM_YOUR_DETAILS", "Upplýsingar:" );
define( "LM_SUBSCRIBE_TO", "Skráðu þig á póstlistann" );
define( "LM_UNSUBSCRIBE_FROM", "Afskráðu þig af póstlistanum" );
define( "LM_VALID_EMAIL_PLEASE", "Vinsamlegast settu inn gilt tölvupóstfang!" );
define( "LM_SAME_EMAIL_TWICE", "Þetta tölvupóstfang er þegar skráð á póstlistann!" );
define( "LM_ERROR_SENDING_SUBSCRIBE", "Ekki tókst að senda skráningarpóstinn:" );
define( "LM_SUCCESS_SUBSCRIBE", "Tölvupóstfang þitt er komið á póstlistann." );
define( "LM_RETURN_TO_NL", "Til baka í fréttabréfin" );
define( "LM_ERROR_UNSUBSCRIBE_OTHER_USER", "Þú getur ekki hreinsað aðra notendur af listanum" );
define( "LM_ERROR_SENDING_UNSUBSCRIBE", "Ekki tókst að senda afskráningarpóstinn:" );
define( "LM_SUCCESS_UNSUBSCRIBE", "Tölvupóstfang þitt hefur verið tekið af póstlistanum" );
define( "LM_SUCCESS_CONFIRMATION", "Skráning þín hefur verið staðfest" );
define( "LM_ERROR_CONFIRM_ACC_NOTFOUND", "Aðgangur merktur tenglinum þínum finnst ekki." );

define( "LM_CONFIRMED_ACCOUNTS_ONLY", "Aðeins staðfestir notendur?" );
define( "LM_CONFIRMED_ACCOUNTS_ONLY_TIP", "Senda fréttabréfið aðeins til <strong>staðfestra</strong> áskrifenda. &Oacute;staðfestir fá ekki fréttabréfið." );

define( "LM_NAME_TAG_USAGE", "Þú getur notað <strong>[NAME]</strong> í bréfinu til að persónumerkja fréttabréfið. <br/>Þegar breÂ¥fið er sent, er [NAME] skipt út fyrir nafn viðkomandi." );

define( "LM_USERS_TO_SUBSCRIBERS", "Make Users to subscribers" );
define( "LM_ASSIGN_USERS", "Assign Users" );

/**
 * @since Letterman 1.2.0
 */
define( 'LM_SEND_LOG', 'Letterman Newsletter Send Log' );
define( 'LM_NUMBER_OF_MAILS_SENT', '%s of %s mails have been sent so far.');
define( 'LM_SEND_NEXT_X_MAILS', 'Click the button to send the next %s Mails.');
define( 'LM_CHANGE_MAILS_PER_STEP', 'Change the mails-per-step amount');
define( 'LM_CONFIRM_ABORT_SENDING', 'Do you really want to abort sending this newsletter?');
define( 'LM_MAILS_PER_STEP', 'How many mails to send at once?');
define( 'LM_CONFIRM_UNSUBSCRIBE', 'Do you really want to unsusbcribe from our Newsletter service?');

/**
 * @since Letterman 1.2.1
 */
define( 'LM_COMPOSE_NEWSLETTER', 'Compose a newsletter from content items');
define( 'LM_USABLE_TAGS', 'Tags you can use' );
define( 'LM_CONTENT_ITEMS', 'Content items' );
define( 'LM_ADD_CONTENT', 'Add content items/articles' );
define( 'LM_ADD_CONTENT_TOOLTIP', 'If you select a content item from the list, a tag will be inserted into the textarea. This tag will be rendered to the full article (Into Text only with images) when clicking on Save.' );
define( 'LM_ATTACHMENTS', 'Attachments' );
define( 'LM_ATTACHMENTS_TOOLTIP', 'You can select one or multiple files from the directory %s, which will be embedded into the mail when sending. Please do not care about the [ATTACHMENT ..] tag - it will be removed when sending the newsletter!' );
define( 'LM_MULTISELECT', 'Multi-select files with Ctrl-MouseClick' );

?>