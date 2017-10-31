MosCmenuTree module
Version 1.09

Develop By: Chanh Ong
Documentation: Chanh Ong
http://mosforge.net/projects/COAddOns
http://sourceforge.net/projects/coaddons/
http://developer.joomla.org/sf/sfmain/do/viewProject/projects.coaddons

Copyright (C) 2004 Al Warren
All rights reserved
MosCmenuTree module is Free/Donate Software
Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html

============================================================

This module displays any section of content in a Menu Tree.

------------------------------------------------------------

Installation:
1. Use Mambo module install manager to do the install of MosCmenuTree.  
2. Make sure you publish this module
3. Make sure you set the parameters to your choice of options.  
For example: 
. You need to enter a value of a section ID that you want to display in the menu tree
. You could also include an additional category to be part of the menu tree
. You need to select "Tree type": Tree, List, ByCat, or dropdown
. You need to select "Order by": Name or ID
. And many others option that change the way the tree look
. You can change the look of the module by using "moduleclass_sfx"
. You can get the effect of a real menu by setting the "Item ID" to your menu item as noted
  (Note: create a menu item with a link to your "Table - Content Section" of your choice)

------------------------------------------------------------

Addtional Usage: 
. If you want to display "New" or "Upd" image to indicate the content is "New" or "Upd" then 
you need to update "Title Alias" to have a date with the format of "yyyy-mm-dd".
. If the create date is less then 14 days then the "New" image will appear.
. If the "Title Alias" has the date value less then 14 days then the "Upd" image will appear.
. If the "showupdated" field is set with a value then MosCmenuTree will only show article that
has been updated recently with the "Title Alias" containing the date value less then num of days
For examples: If "showupdated=14" and "Title Alias=today-14" Then the "New" or "Upd" will show


------------------------------------------------------------

Warnings and Restrictions:
N/A