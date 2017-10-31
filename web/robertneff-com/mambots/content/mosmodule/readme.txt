MosModule & modulebot mambot 
Version 1.02

Concept: The BotSquad
Coding: Chanh Ong
Documentation: Tony Scida
http://mosforge.net/projects/COAddOns/

Copyright (C) 2004 Al Warren
All rights reserved
Modulebot mambot is Free Software
Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html

=====================================================

This mambot displays any module inside a content item.

-----------------------------------------------------

Installation:
After the standard Mambot install of the new MosModule bot.  If you want 
to use the old legacy mambot then copy modulebot.php to the /mambots directory.

-----------------------------------------------------

Note: 
- Important: Make sure to enable MosModule in Mambot manager!
- This is a rewrite of modulebot to be compatible with Mambo 4.5.1 or above
- This Mambot is design to be backward compatible with modulebot as long as
  Mambo still support legacy bot.
- use either MosModule or modulebot would work only if you do the copy the modulebot.php
  as describe above.

Usage: 
  {Mosmodule module=somemoduletitle} - this is the title of the module as 
    can be seen in the Module Manager. Module titles can also be seen with the 
    list bot below.
  {MosModule user1} - Where "user1" is any module block position.
  {MosModule list} - Displays a list of available modules and block positions.
  {MosModule section=FAQ} - Displays the entire section randomly

-----------------------------------------------------

Warnings and Restrictions:
Certain modules (for example Newsflash and Polls) cannot be called twice on 
the same page and will cause errors.

This mambot has not been tested with all existing modules.

This mambot has not been tested with all existing mambots, but is known not 
to conflict with any core mambots.

By default, the module will fill the width of the content area. If you wish 
to control the width and positioning of modules in content area, you will 
want to enclose the modulebot tag(s) in a div and either assign a class to 
controll the display in your template_css.css file, or use inline styles (if 
you are using a WYSIWYG editor such as htmlarea2, you will need to switch to 
source mode in order to create the <div> tag).