<?php $page='
<p><span style="font-size:1.5em;font-weight:bold">samSiteMap™ beta, Version .6.2</span><br />
(Alpha for non-english websites)<br />
Copyright © 2005 Steve Graham, SAM Code Team, All rights reserved.<br />
<a href="http://coders.mlshomequest.com/" target="_new">http://coders.mlshomequest.com/</a>  (pop up window)</p>
<span style="font-size:1.5em;font-weight:bold"><p align="center">samSiteMap Documentation<br ><hr /></p></span>
<span style="font-size:1.5em;font-weight:bold"><p>Table of Contents</p></span>
<p><a href="#About:">About samSiteMap</a><br /><br />
<a href="#Features:">Features</a><br /><br />
<a href="#License:">License</a><br /><br />
<a href="#Quick Setup:">Quick Setup</a><br /><br />
<a href="#Advanced Usage:">Advanced&nbsp; Reference</a><br />
    <span style="padding:0 0 0 10"><a href="#Control Panel:">The Control Panel:</a></span><br />
    <span style="padding:0 0 0 20"><a href="#Index Manager:">Index Manager:</a></span><br />
    <span style="padding:0 0 0 40"><a href="#The Configuration Tab:">The Configuration Tab:</a></span><br />
    <span style="padding:0 0 0 40"><a href="#User Sort/Search Tab:">User Sort/Search Tab:</a></span><br />
    <span style="padding:0 0 0 40"><a href="#Root Items Tab:">Root Items Tab:</a><br /></span>
    <span style="padding:0 0 0 40"><a href="#Expand Tab (ALL):">Expand Tab (ALL):</a></span><br />
    <span style="padding:0 0 0 40"><a href="#Index Preview Tab:">Index Preview Tab:</a></span><br />
    <span style="padding:0 0 0 20"><a href="#Global Defaults:">Global Defaults:</a></span><br />
    <span style="padding:0 0 0 20"><a href="#Search/Rank Settings:">Search/Rank Settings:</a></span><br>
    <span style="padding:0 0 0 20"><a href="#Clean samSiteMap Cache:">Clean samSiteMap Cache:</a><br /></span><br />
<a href="#Language:">Language Settings</a><br /></p>
<p>To sign up for notification about upcoming changes, or alerts relative to samSiteMap, see this page at our website:<br />
<a href="http://coders.mlshomequest.com/component/option,com_yanc/Itemid,38/" target="_new">Mail List for samSiteMap (pop up window)</a></p>
<span style="font-size:1.5em;font-weight:bold"><p><a name="About:">About samSiteMap</a></p></span>
<p>samSiteMap creates complex document trees (Indexes) and lists, from standard 
Mambo/Joomla! content and Components.&nbsp; Using Menus, Menu items, and Template 
positions, samSiteMap assembles a descendent document tree that includes all 
standard content and components, including content(articles), contacts, 
sections, categories, weblinks, and newsfeeds.&nbsp; Each item is displayed 
according to the user\'s access privilege level (admin configurable - shownoauth etc..) ,&nbsp; 
has an appropriate Itemid in the URL, is URL formed as it would be in the 
standard menus, and uses standard SEF if enabled in the CMS.</p>
<p>Users can opt to see this list as a document tree or a standard sorted list, 
and can additionally sort by rating, votes, or&nbsp; hits.&nbsp; Each item 
contains a small &quot;description&quot; (resembles a search engine\'s description) which 
can be set to varying sizes by the administrators.&nbsp; </p>
<p>samSiteMap also includes a search engine which will look for &quot;any&quot;, &quot;all&quot;, or 
&quot;phrase&quot; search terms and includes a &quot;*&quot; wildcard character that can be used 
with any of the above, in any position.&nbsp; Searches are full text, and search 
results will return a portion of the item\'s text that includes the first search hit(s) as well as density ratings.&nbsp; Searches include all content contained 
within the document tree as setup by the administrators.&nbsp; Searches are 
limited to Items in the descendent document tree, and will not return Items that 
the Front End users cannot access via the menu items included in the Indexes 
root configuration.</p>
<p>samSiteMap is highly configurable, and is completely language skinned for 
users who do not have English speaking patrons accessing their website.&nbsp; As 
of this first release, only English (en_us) language files are included in 
samSiteMap\'s distribution, but 
both Front End and Admin language files can be copied, modified, renamed to have 
the appropriate local or language in the filename, and returned to their 
appropriate directories for use by samSiteMap.&nbsp; samSiteMap will find any 
language files that match either 
the CMS language setting or Locale setting and use them before using the default 
language files.</p>
<span style="font-size:1.5em;font-weight:bold"><p><a name="Features:">Features:</a></p></span>
<blockquote>
    <p><a href="#Complex Directory Trees:">Complex Directory Trees:</a><br />
  <a href="#Sorted Document Lists:">Sorted Document Lists:</a><br />
  <a href="#Every WebPage Within Two Clicks:">Every WebPage Within Two Clicks:</a><br />
  <a href="#Different Content Types: Same Page:">Different Content Types: Same 
  Page:</a><br />
  <a href="#Advanced Search Engine:">Advanced Search Engine:</a><br />
  <a href="#Wheres the Search Module">Where\'s the Search Module?</a><br />
  <a href="#Admin Editable Page Text:">Admin Editable Page Text:</a><br />
  <a href="#samSiteMap is Dynamic:">samSiteMap is Dynamic:</a><br />
  <a href="#Indexes are Cachable:">Indexes are Cacheable:</a><br />
  <a href="#Indexes can Use Global Settings:">Indexes can Use Global Settings:</a><br />
  <a href="#Indexes are User Access Level Sensitive:">Indexes are User Access 
  Level Sensitive:</a><br />
  <a href="#samSiteMap Uses the assigned Itemids:">samSiteMap Uses the assigned 
  Itemids:</a><br />
  <a href="#Language Skinnable:">Language Skin able:</a></p>

  <span style="font-size:1.1em;font-weight:bold"><p><a name="Complex Directory Trees:">Complex Directory Trees:</a></p></span>
    <p>samSiteMap creates complex directory trees derived from Mambo/Joomla! 
    Positions, Menus, and Menu Items.&nbsp; Will search for content derived from 
    all standard content (sections, categories, content, contacts, weblinks, 
    newsfeeds).&nbsp; Document trees are presented open explorer style and the 
    CMS administrator can block any content by type to prevent its display (or 
    choose not to include it in the corresponding Index at all).</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Sorted Document Lists:">Sorted Document Lists:</a></p></span>
    <p>Front End users can select the option to view document trees as Alpha 
    sorted document lists.&nbsp; Administrators can set this as a default if 
    they wish to.&nbsp; Users can sort document lists by hits, votes, or rating, 
    and enable/disable the short descriptions attached to each item.&nbsp; Each 
    of these options is admin configurable, and can be disabled/enabled from the 
    admin utilities.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Every WebPage Within Two Clicks:">Every WebPage Within Two Clicks:</a></p></span>
    <p>For search engines, and for Front End user convenience, no standard 
    content has to be more than two clicks from your home page.&nbsp; Search 
    engines have an easier time finding all of your content and indexing your site, and Front End Users 
    appreciate the easy access to all content when frustrated by complex menu 
    systems.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Different Content Types: Same Page:">Different Content Types: Same 
  Page:</a></p></span>
    <p>Indexes created by samSiteMap can be used to aggregate lists of different 
    &quot;types&quot; of content that focus on a specific subject or interest.&nbsp; For 
    example, show an Index with all content types that relate to cars on 
    one Index page (car content section, car weblinks category, car newsfeeds 
    category, car contacts category) and horses on another (similar list - 
    change car to horse).&nbsp; This is the quickest way to create 
    these types of Indexes and allow your front end users to search (using the 
    search engine) different CMS content &quot;types&quot; that are of similar subject 
    concentration.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Advanced Search Engine:">Advanced Search Engine:</a></p></span>
    <p>samSiteMap\'s Search Engine allows Front End Users to search for &quot;any&quot;, 
    &quot;all&quot; or &quot;phrase&quot; search terms.&nbsp; Also includes a wildcard option (&quot;*&quot;) 
    that can be used in any position in any of the search terms.&nbsp; Results 
    are ranked by % of webmasters maximum density setting (set in back end) and 
    can be configured to highlight (and bold) search terms in any color.&nbsp; 
    Search description lengths are independent of the settings for normal 
    Document Trees and Document Lists, and can be set to any length desired by 
    the administrators.&nbsp; Searches are limited to Items accessible via the 
    configured document tree, allowing for concentrations of subject matter by 
    the administrator, or whole site searches if configured as a true Sitemap 
    Index.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Wheres the Search Module">
  Where\'s the Search Module?</a></p></span>
    <p>Coming....</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Admin Editable Page Text:">Admin Editable Page Text:</a></p></span>
    <p>Administrators can Include HTML text on any Index created with samSiteMap 
    in a manner that resembles adding content to a normal article or news item 
    (except the use of mosimage or any other mambots).&nbsp; 
    samSiteMap uses the CMS configured editor, allowing for normal entry of 
    text in samSiteMap Indexes.&nbsp; Text is displayed above the Document Tree/List and 
    above the search/sort options.&nbsp; Pages are styled as normal CMS content, 
    with admin configurable Titles (sets browser title too) and normal Article 
    titles as allowed for in the Template\'s CSS.&nbsp; This allows for the 
    creation of Indexes that look and feel like normal articles, with special 
    options (Document Tree\'s/Map\'s and search/sort options appended to end of 
    Text).&nbsp; Page text is optional.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="samSiteMap is Dynamic:">samSiteMap is Dynamic:</a></p></span>
    <p>The only fixed items in an Index created with samSiteMap are its root 
    Items.&nbsp; If these are template positions, Indexes will always include 
    all published Menus, Menu Items, and their descendent content derived from 
    menus that are shown in that template position.&nbsp; New menus, deleted 
    menus, or changes 
    made to any menu in that template position will be reflected in the Index.&nbsp; If the Root Items are 
    Menus, the Index will always include any published Menu Items for that menu, 
    and if Menu Items, all published descendent content.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Indexes are Cachable:">Indexes are 
  Cacheable:</a></p></span>
    <p>samSiteMap allows admins to turn on caching for any Index.&nbsp; On 
    larger Indexes, this markedly reduces server utilization, and lowers page 
    load times.&nbsp; Cache timeout is automatically set to be whatever the CMS 
    cache timeout is set to, and to use the same directory for cache files.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Indexes can Use Global Settings:">Indexes can Use Global Settings:</a></p></span>
    <p>samSiteMap maintains a Global Settings Index to make setup and creation 
    of Indexes faster and easier.&nbsp; Set the Global settings to your most 
    used options, then just set any differences required in any new Index.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Indexes are User Access Level Sensitive:">Indexes are User Access 
  Level Sensitive:</a></p></span>
    <p>samSiteMap has two access display settings that mirror the CMS\'s menu and 
    content options.&nbsp; Administrators can elect to not show any unauthorized 
    content (Unauthorized items won\'t be displayed), or to show first level 
    titles only for unauthorized items (samSiteMap won\'t show unauthorized 
    descriptions).&nbsp; If &quot;Show Unauthorized&quot; is selected, 
    Document Tree assembly (Document Lists are derived from the Trees so same is 
    true) will stop at the first unauthorized item showing only its title 
    (unlinked - text only) with an appropriate remark (like &quot;Members Only&quot;) and 
    a crossed out Icon if admin has selected to show Icons.&nbsp; Descendents of 
    that specific Item will not be shown.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="samSiteMap Uses the assigned Itemids:">samSiteMap Uses the 
  assigned Itemids:</a></p></span>
    <p>We all know how important it has become to not have the same content 
    accessible via two different URLs.&nbsp; Search Engines are known to 
    de-index websites that have duplicated content at different URLs.&nbsp; 
    samSiteMap uses the assigned Itemids for each menu item and all of its 
    descendents, and forms the URLs as they are formed in the normal menuing 
    system.&nbsp; The inclusion of the Itemid URL parameter also ensures that content displays properly 
    according to the Menu settings setup up by the site administrators.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Language Skinnable:">Language 
  Skin able:</a></p></span>
    <p>Both the Front End, and Admin Utilities for samSiteMap are 100% language 
    skinned via language files (we think we got it all, please let us know if we 
    missed something).&nbsp; To use samSiteMap in a language other than English 
    (en_us), copy the two language files (or front end only if admins read 
    English and Front End users don\'t) contained in the &quot;lang&quot; directories in 
    each component directory, modify the language to reflect what is appropriate 
    for the new language, change the file name to include either the CMS 
    setting\'s 
    Locale setting or Language setting, then copy the files back to the &quot;lang&quot; 
    directories.&nbsp; samSiteMap automatically searches for language files in 
    these directories that match the Local setting first, the Language setting 
    second, and if not found, the default en_us file included with samSiteMap.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Previewable from the Admin Utilities:">
  Preview-able from the Admin 
  Utilities:</a></p></span>
    <p>When editing Indexes, administrators have a tab available that will load 
    the Index for them to preview.&nbsp; This allows for quick and easy review 
    of changes and edits (after saving the Index) without having to keep a 
    second browser window open or having to leave the back end.</p>
</blockquote>
<span style="font-size:1.5em;font-weight:bold"><p><a name="License:">License:</a></p></span>
<blockquote>
  <p>Copyright <font face="Times New Roman">© 2005, Steve Graham, SAM Code Team</font></p>
  <p>samSiteMap™ is free software; you can redistribute it and/or modify it under 
  the terms of the GNU General Public License (GNU GPL) as published by the Free Software 
  Foundation; either version 2 of the license, or (at your option) any later 
  version, subject to our requirements listed here.&nbsp; Any derivative work must comply with our &quot;Credit Requirements 
  for Derivative Works&quot; section below.</p>
  <p>In the event that there is a conflict between any current or future 
  release of the GNU GPL, and any of our requirements stated here, Our 
  requirements will take precedence and void the conflicting sections, or 
  subsections only of the GNU GPL license.</p>
  <p>The Copyright holders (Steve Graham, SAM Code Team) specifically exclude 
  any add-on scripts, or add-on APIs written by other individuals (or groups, 
  companies, etc...) and designed to be incorporated into samSiteMap via our 
  normal external script and component API inclusion methodologies from any 
  provisions of, or requirements to also be, GNU GPL licensed.&nbsp; To qualify 
  for this exclusion, the scripts must not modify or change in any way,&nbsp; 
  the original code, classes, functions, methodologies, output (except as 
  provided for in the base code of samSiteMap\'s inclusion methods and 
  functions), or files included in samSiteMap and must not duplicate any 
  copyright protected code from samSiteMap which is licensed under the GNU GPL.&nbsp; </p>
  <p>Please note that the GPL states (and we require, in the event that the GNU 
  GPL changes) that any headers in files, and Copyright 
  notices, as well as credits in headers, source files and output (screens, 
  prints, etc.) can not be removed.&nbsp; You can however, extend them with your 
  own credits.&nbsp; Make sure you understand our conditions for this, in the 
  section below, if you choose to create a derivative work based on samSiteMap.</p>
  <blockquote>
  <span style="font-size:1.1em;font-weight:bold"><p>Crediting Requirements for 
  Derivative Works:</p></span>
  <p>samSiteMap uses a unique credit rendering system that renders credits for 
  Front End pages on two lines, and Admin (back end) pages on one line.&nbsp; </p>
  <p>The first line of the Front End page\'s credit section is the samSiteMap 
  name and version, linked to the SAM Code Team\'s website.&nbsp; The second line 
  will alternate between two different credit lines that link back to the 
  websites that underwrote the costs for developing samSiteMap, participated in 
  its development, and made it possible to release samSiteMap under GNU GPL 
  licensing.&nbsp; </p>
  <p>The rendering of these links (credit lines) in the front end must not be 
  modified, except in the following manner:&nbsp; If you modify samSiteMap, and 
  distribute your modified version, you may add an equal weight second credit 
  line, to the function responsible for creating it, that links back to your 
  website (the original lines must still render two times out of three page 
  loads), and you may replace the first line that links back to the SAM Code 
  Team\'s website with a line linking back to yours (and has the name you are 
  assigning to your project as a link title).&nbsp; Whether you replace the 
  first line or not, in accordance with the GNU GPL you must indicate in that 
  line that your project is derived from this one (samSiteMap), although it does 
  not have to link back to the SAM Code Team\'s website.&nbsp; </p>
  <p>The credit line in the Admin (back end) section is at the bottom of each 
  page, and links back to the SAM Code Team website.&nbsp; This line may be 
  modified in the same manner as the first credit line in the Front End.</p>
  <p>All credit and copyright sections in all source files must be left Intact 
  and unmodified, although you 
  may add your own on to them in a manner that indicates that you have modified 
  the files, in accordance with, and per requirements of the GNU GPL guidelines.</p>
  <p>Per GNU GPL guidelines your derivative product must also be released under, 
  and conform to, GNU GPL Licensing.</p>
  </blockquote>
  <p>This program is distributed in the hope that it will be useful, but WITHOUT 
  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS&nbsp; 
  FOR A PARTICULAR PURPOSE.&nbsp; See the GNU General Public License for more 
  details.</p>
  <p>You should have received a copy of the GNU General Public License along 
  with this program;&nbsp; if not, write to the Free Software Foundation, Inc., 
  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.</p>
  <p>The &quot;GNU General Public License&quot; (GNU GPL) is available at:<br />
  <a href="http://www.gnu.org/copyleft/gpl.html">
  http://www.gnu.org/copyleft/gpl.html</a> </p>
</blockquote>
<p>&nbsp;</p>
<span style="font-size:1.5em;font-weight:bold"><p><a name="Quick Setup:">Quick Setup:</a></p></span>
<blockquote>
  <p>samSiteMap will run immediately upon installation, and does not require 
  configuration to provide a basic sitemap.&nbsp; samSiteMap comes with a 
  &quot;Default Index&quot; preconfigured to provide this Index (or site map).&nbsp; It can be called 
  via a menu link, or simply by the url (i.e.
  <a href="http://yoursite/index.php?option=com_samsitemap">
  http://yoursite.com/index.php?option=com_samsitemap</a> ).&nbsp; samSiteMap 
  uses this &quot;Default Index&quot; whenever it is called without a menu assigned Itemid&nbsp; 
  in the URL (called without a 
  menu item).&nbsp; If you plan to use samSiteMap primarily as a &quot;whole site&quot; 
  Sitemap only, the default Index is the one to use.&nbsp; It will automatically 
  include all menus and menu items found in all template positions, unless you change the Root Mode setting 
  for the Default Index.&nbsp; Menu\'s will be ordered in the same order that 
  they are listed in for each template in the module manager for that menu.</p>
  <p><b>If you are using a 3rd Party, non Joomla!/Mambo menu system</b>, be sure 
  to read about how to use these with samSiteMap under our &quot;<a href="#Advanced Usage:">Advanced 
  Reference</a>&quot; section.</p>
  <p>If you want to change the display order of the template positions 
  (remember, menus will be ordered relative to the template positions), use the 
  instructions that follow.&nbsp; If the menu ordering is not correct for your 
  Index (and you can\'t change the display order for that menu module\'s display 
  within that template position), you will need to create a custom &quot;Root Items&quot; 
  definition for the default Index.&nbsp; To see how to change the &quot;Root Items&quot; 
  definition, look for &quot;Root Items&quot; in the Advanced Usage section of this 
  document, under the &quot;Configuration Tab&quot; options.&nbsp; Its very easy to do.</p>
  <p>Start by creating a menu item in one of your menus to samSiteMap (&quot;component&quot; 
  Menu Item Type), so that it will be available for assignment to an Index while you are in the samSiteMap admin 
  utilities.</p>
  <p>If you would like to change the template order (i.e.: display order), you 
  will need to know the id numbers of your template positions in the 
  mos_template_positions database.&nbsp; In the admin/back end, 
  under Site&gt;Template Manager&gt;Module Positions, there will be a list displayed 
  of all your template positions, in their normal order.&nbsp; Make a note of the 
  id numbers listed to the left side of each template position that you want to change 
  the Index order for (you won\'t need all the id numbers, just the ones for the 
  template positions you want to move to the top of your Index), and the order you want them to appear in, in 
  your Index.</p>
  <p>In samSiteMap admin Control Panel, select the option &quot;Index Manager&quot;, then 
  the &quot;Default Index&quot;, go to the &quot;Configuration&quot; tab (the default 
  tab) and look for 
  the &quot;Template Position Order&quot; option field on the upper right side.&nbsp; In that box, enter the 
  Template Positions you want listed first, in the order you want them to be 
  listed (first to last goes left to right), separated by commas.&nbsp; There is a help Icon to the right with more 
  detail.</p>
  <p>Under the &quot;Configuration&quot; tab, there is  a drop down selection box 
  labeled &quot;Menu Item Assignment&quot;.&nbsp; You should see the menu item you created 
  in the drop down box.&nbsp; Select that menu item to assign this Index to that 
  menu item.&nbsp; If you only need samSiteMap for a singular &quot;whole site&quot; type 
  site map and use the Default Index for that, you do not have to assign the 
  menu item.&nbsp; However, doing so reduces the amount of work that samSiteMap 
  has to do since it will look first for an Index assigned to the Itemid it sees 
  in the URL before loading the Default Index.&nbsp; Assigning the Default Index 
  to a Menu Item will not prevent it from loading if called via a URL without an 
  Itemid in it, it will just reduce the amount work samSiteMap has to do before 
  loading the Index for this specific menu item.</p>
  <p>While you are there, take a moment to look around at all the options 
  available to you.&nbsp; The &quot;User Sort/Search&quot; tab has all the options for 
  displaying the front end sort and search options as you want them to 
  (including turning them off so that they don\'t display).&nbsp; </p>
  <p>The &quot;Root Items&quot; is for Custom Indexes, and allows you to add any Template 
  Position, Menu, or Menu Item available on your site to the Index.&nbsp; This 
  list can be as narrow or as broad as you would like it to be.&nbsp; For use as 
  a Site Map Index, you probably will not need it, unless using the Template 
  Position Order does not provide the Content/Document Tree you want your 
  visitors to see.&nbsp; </p>
  <p>The &quot;Expand Options&quot; tab is where you select what types of content you want 
  samSiteMap to find (Menu Item Descendents) and display.&nbsp; </p>
  <p>The &quot;Index Preview&quot; allows you to preview your Index from the back end, but 
  it can only show saved Indexes.&nbsp; If you haven\'t saved your 
  changes, they won\'t show up in the preview.</p>
  <p>We have included fairly detailed &quot;help&quot; icons for almost all of the options 
  available while editing an Index, So you should be able to go through it 
  without looking back here too much.</p>
</blockquote>
<span style="font-size:1.5em;font-weight:bold"><p><a name="Advanced Usage:">
Advanced Reference:</a></p></span>
<blockquote>
  <p><a href="#It All Starts with the Document Tree:">It All Starts with the 
  Document Tree:</a><br />
  <a href="#What samSiteMap Wont Find:">What samSiteMap Wont Find:</a><br />
  <a href="#How does it work">How does it work</a><br>
  <a href="#Using 3rd Party Menus:">Using 3rd Party Menus:</a> <br>
  <a href="#The Control Panel:">The Control Panel:</a></p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="It All Starts with the Document Tree:">It All Starts with the 
  Document Tree:</a></p></span>
    <p>samSiteMap Finds Site Content while mapping out its Document Tree.&nbsp; 
    This allows it to make decisions with regard to content type display (is 
    that content in a blog, or a category table??&nbsp; Does that category 
    belong to the weblinks component, newsfeeds, contacts, or normal content??) 
    and appropriate access levels.&nbsp; It also creates a very accurate map of 
    the documents available to any given user via the included Menus or 
    Menu Items, filtered through their user access level.&nbsp; If an item is 
    available to them (access privilege), and it is a descendent of a Menu Item (in other words, 
    they have a way to get there) it will display in samSiteMap.&nbsp; Items (published or 
    not, right access level or not) that are not accessible via a menu will not 
    display.&nbsp; </p>
    <p>This is real handy for certain types of content that do not belong on 
    this type of list.&nbsp; For example, we use several content items as "site 
    content" that specifically pertain to the use of our websites (like special 
    pages to respond to certain inquiries etc..).&nbsp; They just don\'t belong 
    on any of our Indexes, so we make sure they are in sections and/or 
    categories that have no menu item links.&nbsp; That way they don\'t show up in 
    our Indexes.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="What samSiteMap Wont Find:">What samSiteMap 
  Won\'t Find:</a></p></span>
    <p>samSiteMap will not attempt to find any content that derives from a Link URL 
    type menu item, a non-core (3pd) component, or a menu spacer.&nbsp; In fact, 
    although you can include a Menu Spacer in an Index as a Root Item, it won\'t 
    display.&nbsp; Link URL Menu item\'s and non-core component links will display, but 
    samSiteMap does not know how to search for their descendent content, so 
    won\'t.&nbsp; Link URL menu items and non-core components show only as a Link (title only) 
    with no description.</p>
    <p>Menu Items will always display (except spacers), even if only as a Linked 
    Title.&nbsp; In these cases, samSiteMap will still respect the users access 
    level, it just does not search for descendents.</p>
    <p>We are currently working on a 3pd"s API for non-core components.&nbsp; 
    Although still a work in progress, it is showing great promise and will 
    require little time from 3pd"s to include themselves in Indexes (if the 
    administrator enables their scripts).&nbsp; We do not have a projected 
    release date yet, this is falling behind a couple of other projects right 
    now.&nbsp; We hope to have it completed by the end of the year.</p>
    <p>We have no idea what/or if any 3PD menu systems will work with samSiteMap.&nbsp; 
    If they use the normal Mambo/Joomla! menu tables for their menu items and 
    menus, they will probably work.&nbsp; If not, they won\'t for sure.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="How does it work">How does it work?</a></p></span>
    <p>samSiteMap uses three major internal indexes to assemble document trees, 
    from which it displays either document trees or sorted lists.&nbsp; The 
    first is for all items and their attributes, the second for the true 
    document tree, and the third holds references to the first and second and is 
    ordered based on type of display (list or map).&nbsp; The primary index allows for parent-child 
    relationships that cross database tables and interpolates their 
    relationships to assist the document tree Index.&nbsp; The document tree 
    Index uses special values and keys to "remember" the relationships and uses 
    them to assemble the front end user\'s accessible document tree.&nbsp; The 
    third (the rendering index) is&nbsp; a list of all the accessible items, 
    sorted based on display type (List, Map, Search etc...) and used to render 
    the page.</p>
    <p>It all starts with the &quot;Root Items&quot;, which if you are using Auto Config 
    root mode includes all the available Template Positions, and the Itemid in 
    the URL, from which samSiteMap makes a decision as to what Index to load.&nbsp; 
    Indexes contain all the admin configurable options, and a special &quot;Root 
    Items&quot; category which dictates the point from which samSiteMap starts the 
    process of creating the document tree.</p>
    <p>The code is a&nbsp; little messy, but it works very well and as we get closer to a 
    final release for this Version of samSiteMap, it will get refactored 
    continuously until it is a little easier to read.&nbsp; If you like to hack, 
    you might want to wait until this Version is released as stable.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Using 3rd Party Menus:">Using 3rd Party Menus:</a></p></span>
    <p>samSiteMap will work with the majority of the 3rd party menu systems 
    currently available, but requires a workaround to display them in any 
    Indexes created.&nbsp; As long as the 3rd party menu system gets its menu 
    items from the standard Joomla!/Mambo menuing system, it will work.&nbsp; If 
    your menu system does not require you to add menu items into it, and instead 
    has you select a Joomla!/Mambo menu for it to use, the following should 
    work:</p>
    <p>samSiteMap will not find, or use, menu modules that are not published.&nbsp; 
    Clearly in order to prevent these menu modules from displaying while using a 
    3rd party menu system, it is necessary to un-publish the menu module being 
    duplicated by a 3rd party menu system.&nbsp; To work around this with 
    samSiteMap you will need to publish the menu module so that samSiteMap can 
    find it.&nbsp; You can do this, without causing the menu to display, by 
    moving the menu module (the Joomla!/Mambo menu module, not any module that 
    is provided by a 3rd party menu application) into an unused template 
    position and re-publishing it.&nbsp; By moving it into a template 
    position that is unused, Joomla!/Mambo will not display it, eliminating the 
    problem of duplicate display.&nbsp; Publishing it will allow samSiteMap to 
    see it as a legitimate published menu to include in any Index you create.</p>
  <blockquote>
    <p><b>With &quot;Auto Config&quot; Root Mode:</b></p>
    <p>Moving this menu into a template position that has a higher internal id, 
    causes it to move down the displayed list relative to other menus that are 
    in, for example, the &quot;left&quot; template position.&nbsp; To change this, make a 
    note of the id assigned to the unused template position you moved the menu 
    module into.&nbsp; You can find this id by going into the backend: 
    Site-&gt;Template Manager-&gt;Module Positions.&nbsp; It will be displayed as a 
    small number just to the left of that template position\'s name in the list on 
    the Module Positions screen.</p>
    <p>Go into samSiteMap, go to Index Manager, and edit the Index that you are 
    working on and want this menu included in.&nbsp; Under the &quot;Configuration&quot; 
    tab, right hand side, two fields down, you will see a field for Template 
    Position Order.&nbsp; Enter the number you noted for that template position 
    here.&nbsp; This will move the unused template position to the top of samSiteMap\'s rendering list and display that menu first.&nbsp; There are 
    additional instructions under the ? button to the right of the Template 
    Positions Order field, or alternatively you can read more about this under 
    &quot;<a href="#Auto Config Root Mode:">Auto Config</a>&quot;, in the &quot;Index Manager&quot; section of the &quot;Advanced 
    Reference&quot; area of this document.</p>
    <p><b>With &quot;Manual Config&quot; Root Mode:</b></p>
    <p>Be sure that you take the time to add the template position you moved the 
    affected menu into, to the &quot;Root Items&quot; list for your Index.&nbsp; 
    Otherwise, it will not be found by samSiteMap.</p>
  </blockquote>
<span style="font-size:1.1em;font-weight:bold"><p><a name="The Control Panel:">The Control Panel:</a></p></span>
  <p>As of this writing, there are five options available under the &quot;Control 
  Panel&quot;, all pretty self explanatory.&nbsp; &quot;<a href="#Global Defaults:">Global Defaults</a>&quot; allows you to 
  edit samSiteMap\'s global defaults for all Indexes.&nbsp; &quot;<a href="#Index Manager:">Index Manager</a>&quot; is 
  the tool used to configure and setup Indexes (site maps), &quot;<a href="#Search/Rank Settings:">Search/Rank 
  Settings</a>&quot; holds the settings used for searches and search rankings, &quot;<a href="#Clean samSiteMap Cache:">Clean samSiteMap Cache</a>&quot; cleans all files out of 
  samSiteMap\'s cache, and &quot;Documentation&quot; 
  brings you to this screen.</p>
<blockquote>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Index Manager:">Index Manager:</a></p></span>
    <p>Index Manager will list all available Index (site map) 
    configurations, and allow you to Edit and/or Delete any one of them except 
    the &quot;Default Index&quot;.&nbsp; The Default Index can only be edited, it can not 
    be deleted.</p>
    <p>After Installation, you will only have one Index, and that will be the 
    Default Index.&nbsp; Others will show up as you create them.</p>
    <blockquote>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Edit Index:">Edit Index:</a></p></span>
      <p><a href="#The Configuration Tab:">The Configuration Tab:</a><br />
      <a href="#User Sort/Search Tab:">User Sort/Search Tab:</a><br />
      <a href="#Root Items Tab:">Root Items Tab:</a><br />
      <a href="#Expand Tab (ALL):">Expand Tab (ALL):</a><br />
      <a href="#Index Preview Tab:">Index Preview Tab:</a></p>
      <p>Clicking on any Index in the Index Manager brings you to the Edit Index 
      screen.&nbsp; This is where you can configure and or change your Index 
      configuration.&nbsp; The standard Admin Menus will disappear if you are 
      using a version of Mambo later than or equal to 4.5.2.3, or Joomla! 
      version 1.0.&nbsp; The Edit Index utility has to load an incredible amount 
      of data, and ran very slow when the page also had to load the standard 
      Java Menu.&nbsp; We disabled it to speed the page up.</p>
      <p>Notice that you have two save options!&nbsp; &quot;Save&quot; will save the 
      configuration, and return you to this same screen.&nbsp; This is handy for 
      quick changes, followed by previews in the &quot;Index Preview&quot; tab.&nbsp; If 
      you want to save, and exit, pick the &quot;Save&amp;Exit&quot; option, which will save 
      the Index configuration and return you to the Control Panel.</p>
      <p>&quot;Cancel&quot; will cancel the Edit session and return you to the Index 
      Manager.</p>
      <p>&quot;New&quot;, &quot; Edit&quot;, and &quot;Delete&quot; will only show up when you are editing a 
      saved configuration, and not when you are creating a new one.&nbsp; They 
      apply specifically to the &quot;Root Item&quot; entries, and will allow you to add, 
      edit, and or delete Root Items.&nbsp; As of this writing, the &quot;Edit&quot; 
      option has no function yet, and we are trying to determine if it can 
      contribute anything really useful.&nbsp; If not, we will delete it from 
      future releases.</p>
      <p>If you are creating a new configuration, and want to add Root Items, 
      save the configuration and the Root Item menu options will appear.</p>
    <blockquote>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="The Configuration Tab:">The &quot;Configuration&quot; Tab:</a></p></span>
      <p><a href="#Auto Config Root Mode:">Auto Config Root Mode:</a><br />
      <a href="#Manual Config Root Mode:">Manual Config Root Mode:</a><br />
      <a href="#Page Title: Index Name: Search Title:">Page Title: Index Name: 
      Search Title:</a><br />
      <a href="#MenuItem Assignment:">Menu Item Assignment:</a><br />
      <a href="#Use Cache:">Use Cache:</a><br />
      <a href="#Show/Hide Unauthorized:">Show/Hide Unauthorized:</a><br />
      <a href="#Include Self:">Include Self:</a><br />
      <a href="#Show Menu Titles:">Show Menu Titles:</a><br />
      <a href="#Item Descriptions:">Item Descriptions:</a><br />
      <a href="#Icons:">Icons:</a><br />
      <a href="#Show Empty Containers:">Show Empty Containers:</a><br />
      <a href="#Show Duplicates:">Show Duplicates:</a><br />
      <a href="#Default View:">Default View:</a><br />
      <a href="#Default Sort:">Default Sort:</a></p>  
      <blockquote>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Auto Config Root Mode:">Auto Config Root Mode:</a></p></span>
      <p>Auto Config Root Mode is a special superset of all published content of 
      your website, accessed via all template positions.&nbsp; All template 
      positions will be included in the Document Tree creation (as Root Items), 
      although you will not see them.&nbsp; This a great way to ensure that any 
      new Menus or Menu Items created or altered after you create this Index are 
      included in the Document Tree.&nbsp; This mode is fairly automatic, 
      requiring little more than adjustments to the Template Position Order if 
      needed.&nbsp; If your Items are not displaying as you would like them to, 
      make note of your Template Position\'s id fields in the mos_template_positions database and the order you would like to display 
      them in. Alternatively, you can use the numbers shown to the left of each 
      template position in the Module Template Positions manager window (admin 
      utilities&gt;site&gt;template 
      manager&gt;module positions).</p>
      <p>Go into samSiteMap, click on &quot;Edit Indexes&quot;, then select the Index you 
      are modifying (default should be used for your &quot;whole site&quot; site map), then 
      look for the &quot;Configuration&quot; tab (the default Tab).&nbsp; On the right 
      hand side, two fields down is &quot;Template Position Order&quot;.&nbsp; Enter the 
      ids of the Template positions you want to move to the top of the Index 
      only, in the order you want them to display in, separated by commas.</p>
      <p>Save the Index, then check to see if it is ordering correctly in the 
      Preview Index Tab.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Manual Config Root Mode:">Manual Config Root Mode:</a></p></span>
      <p>If you are using Manual Config for your Root Mode, you will need to 
      manually add the Items you want to include as Root Items into your Index 
      configuration.&nbsp; You can do this from the &quot;Root Items&quot; tab.&nbsp; 
      Fairly easy, just follow the prompts to include any template position, 
      menu, or menu item.&nbsp; Once you have added all the appropriate Items, 
      take a moment to order them as you want them to display.&nbsp; </p>
      <p>Only these specific entries are static, and then only their id\'s are.&nbsp; 
      If you change a menu item\'s title for example, or any of the descendent 
      content it points to, samSiteMap will find the correct title and content.&nbsp; 
      The same is true for template positions and for menus.&nbsp; Remember that 
      a template position includes all the published menus that display within 
      that position, and a menu includes all menu items that are published in it.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Page Title: Index Name: Search Title:">Page Title: Index Name: 
    Search Title:</a></p></span>
      <p>Name is used only within the samSiteMap utilities, it will never be 
      displayed in the Front End.&nbsp; Page Title will be displayed just as an 
      Article title would be (it also becomes the page title for the browser), 
      and Search Title is a reference we are reserving for future use.&nbsp; 
      Search Title will be used to display search options for different Indexes 
      within a search module.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="MenuItem Assignment:">
    Menu Item Assignment:</a></p></span>
      <p>samSiteMap will always look for an Itemid in its calling URL.&nbsp; If 
      it does not find one, it will load the default Index.&nbsp; If it does 
      find one, it will look for an Index that has been assigned to that 
      Menu Item and if it is able to find one, it will load it.&nbsp; If it 
      can\'t 
      find an Index assigned to the Itemid in the URL, it loads the default 
      Index</p>
      <p>In order to assign an Itemid to samSiteMap, you must first create a menu 
      link to samSiteMap (menu item type "Component")&nbsp; in one of your menus.&nbsp; Then it will 
      automatically be included in the drop down box for Menu Item Assignment 
      while you are in the Edit Index window.&nbsp; 
      Menu Item Assignments are exclusive to Indexes, no two can have the same.&nbsp; 
      If you assign a Menu Item to an Index that another Index is already using, 
      the other Index will be changed to &quot;not assigned&quot;.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Use Cache:">Use Cache:</a></p></span>
      <p>If you select this option, samSiteMap will cache its non-search pages.&nbsp; 
      Cache timeout will be the same as is set for the CMS under the site&gt;global 
      settings menu selection.&nbsp; samSiteMap also uses the same directory, 
      and the same requirements apply as the directory must be writable.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show/Hide Unauthorized:">Show/Hide Unauthorized:</a></p></span>
      <p>This is almost the same option as you find under Joomla!/Mambo for 
      Menu Items and Content.&nbsp; It will allow front end users to see Items 
      that they are not Authorized to access.&nbsp; In addition, there will be 
      an explanation to the right of the title (it will not be a link, or have a 
      description) explaining, i.e.:(Members Only).</p>
      <p>Any Descendents of that Unauthorized Item will not be displayed.&nbsp; 
      Document Tree rendering stops at an unauthorized Item.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Include Self:">Include Self:</a></p></span>
      <p>Your option.&nbsp; If your Index includes the Menu Item that called 
      samSiteMap, this will give you the option not to render it.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Menu Titles:">Show Menu Titles:</a></p></span>
      <p>Menu\'s are not links, they are titles only.&nbsp; If including them 
      makes your Index make more sense, you can opt for that here.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Item Descriptions:">Item Descriptions:</a></p></span>
      <p>Descriptions are an &quot;admin set&quot; number of characters stripped from the 
      beginning of the content text for the Items Displayed.&nbsp; It is not 
      complete, and its really not a description.&nbsp; It resembles what you 
      would see returned by a search engine like Google.&nbsp; This option will 
      turn them on or off, whichever you prefer.&nbsp; Admins can set the length 
      for descriptions in Global Settings only.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Icons:">Icons:</a></p></span>
      <p>samSiteMap has a very primitive, but useful set of Icons it can Include 
      in your Indexes.&nbsp; They are essentially a folder, and a page.&nbsp; 
      This will improve with the next few releases as we have time to set 
      something better up.</p>
      <p>This options turns then on and off.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Empty Containers:">Show Empty Containers:</a></p></span>
      <p>At its core, samSiteMap recognizes two types of entities.&nbsp; 
      Containers (Items that have children or descendents) and Items.&nbsp; This 
      option allows you to turn off the display of&nbsp; containers (like 
      sections and categories) which have no descendents in the internal 
      document tree.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Duplicates:">Show Duplicates:</a></p></span>
      <p>This is a very helpful option, if you find that one Of your Indexes is 
      displaying certain Items more than once. Setting this to &quot;hide&quot; will 
      prevent the second instance of that item from rendering in your Index.&nbsp; 
      It will also keep any descendents below that item from displaying on the 
      second instance.</p>
      <p>&nbsp;WATCH OUT, this means you have two different menu items pointed 
      at the same content.&nbsp; That could lead to a black mark with some of 
      the search engines.&nbsp; If you are having this problem, see if you can 
      determine why, and really try to eliminate the second menu item to that 
      same content section,&nbsp; category, or item.&nbsp; If you have to have two 
      menu items to that content, see if you can\'t make the second one a URL Link 
      instead of any kind of internal Mambo/Joomla! link (category table, 
      section table, blog, etc...).&nbsp; </p>
      <p>Copy the URL you get in your browser when you access it via the first 
      menu item, and use that to create the second menu item, of type link URL.&nbsp; 
      Since linkURL menu types do not get Itemid assignments, the second link 
      will be identical to the first, except for perhaps a different title, and 
      being located on a different menu.</p>
      <p>Since samSiteMap will not search for descendents of a linkURL type menu 
      item, it will also solve the problem of duplicate items showing in your 
      Index.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Default View:">Default View:</a></p></span>
      <p>Set the default view (map or list) here.&nbsp; Pages will be rendered 
      first in this view, after which the Front End user can elect to change it 
      if the &quot;Show Menu&quot; option is enabled under the &quot;User Sort/Search&quot; tab.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Default Sort:">Default Sort:</a></p></span>
      <p>Same as above, but for the sort options.</p>
      </blockquote>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="User Sort/Search Tab:">User Sort/Search Tab:</a></p></span>
       <p><a href="#Show Menu:">Show Menu:</a><br />
      <a href="#View Selection:">View Selection:</a><br />
      <a href="#Sort Options:">Sort Options:</a><br />
      <a href="#Show Rating Sort Option:">Show Rating Sort Option:</a><br />
      <a href="#Descriptions Selection:">Descriptions Selection:</a><br />
      <a href="#Allow Searching:">Allow Searching:</a><br />
      <a href="#Show/Hide Search Options:">Show/Hide Search Options:</a></p>
  <blockquote>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Menu:">Show Menu:</a></p></span>
      <p>Turn on/off the rendering of the User menu that allows them to change 
      View, Sort, and Description options.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="View Selection:">View Selection:</a></p></span>
      <p>Turn off the View option only, rest of menu remains.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Sort Options:">Sort Options:</a></p></span>
      <p>Turn off the Sort option only, rest of menu remains.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Rating Sort Option:">Show Rating Sort Option:</a></p></span>
      <p>If you do not have Ratings enabled for your content, having a sort option 
      for them does not make a lot of sense.&nbsp; This will allow you to turn 
      that specific sort option off.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Descriptions Selection:">Descriptions Selection:</a></p></span>
      <p>Turns off the Descriptions user selection, rest of menu remains.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Allow Searching:">Allow Searching:</a></p></span>
      <p>Disabling the Search Menu will not enable the functions.&nbsp; Some 
      folks don\'t want that menu active unless a search is executed, like from a 
      module or external link.&nbsp; This option turns off the search features 
      altogether.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show/Hide Search Options:">Show/Hide Search Options:</a></p></span>
      <p>Turns off the display of the search options (all of them).&nbsp; Search 
      features will still work, and if a search is executed from an external 
      source (just has to be in the URL) the menu will activate and display.&nbsp; Only 
      turns off the search menu when an Index is loaded in non-search mode.</p>
  </blockquote>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Root Items Tab:">Root Items Tab:</a></p></span>
      <p>Root Items dictate where samSiteMap begins its process of creating the 
      internal document tree.&nbsp; In Auto Config mode, the Root Items will 
      automatically include all template module positions found in the CMS\'s 
      database (mos_template_positions database).&nbsp; This inclusion is done 
      internally and is not reflected in the &quot;Root Items&quot; tab.&nbsp; </p>
      <p>In Manual Config mode, samSiteMap will only use the items that you add 
      to this list to create the document tree.&nbsp; Items that can be included 
      are: template positions, menus, or menu items.</p>
      <p>To add Root Items, from the Root Items tab, Select the &quot;new&quot; icon from 
      the upper right action icons.&nbsp; At the select item type screen, select 
      the item type you wish to add and click on the &quot;Select Item&quot; icon.&nbsp; 
      You will then be taken to the Select Item screen where you can make your 
      selection.&nbsp; After making your selection, click on the &quot;Save&quot; icon at 
      the top.&nbsp; The new item will be added to the Index\'s Root Item list 
      and you will be returned to the Root Items tab in the Edit Index screen.</p>
      <p><b>NOTE:&nbsp; Some wysiwyg editors do not recover from this process
      </b>(TinyMCE in our testing).&nbsp; Although the "Configuration" tab may 
      not show your text for this Index it is still there.&nbsp; If you need to 
      edit the text for the Index after adding or deleting a Root Item, you will 
      need to save your Index.&nbsp; After saving the Index, the normal wysiwyg 
      field in the "Configuration" tab will return.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Expand Tab (ALL):">Expand Tab (ALL):</a></p></span>
    <p>Pretty self explanatory, each option allows you to turn on , or off, the 
    rendering of that specific content type.&nbsp; Remember that turning off a 
    parent type (section or category) stops the Document Tree from rendering its 
    descendents.&nbsp; Menu Item links that link below that level will still 
    render, this only effects discovery options.</p>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Index Preview Tab:">Index Preview Tab:</a></p></span>
    <p>We put this in, because we always wish for it when we are playing with 
    other components.&nbsp; This tab is a frame pointed at your website, to the 
    URL for the Index you are editing.&nbsp; If the Index you are editing does 
    not have a Menu Assignment, you will need to log in to see the correct 
    Index.&nbsp; Also, the Index will always render as the correctly logged in 
    user (you - in the front end) unless you are logged in as a Super 
    Administrator.&nbsp; Each link will show you what the Index will look like, 
    and what it will render like for each listed access level (Public, 
    Registered, or&nbsp; Special).</p>
    </blockquote>
    </blockquote>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Global Defaults:">Global Defaults:</a></p></span>
       <p><a href="#Sublevel Padding:">Sublevel Padding:</a><br />
      <a href="#Description Lengths:">Description Lengths:</a></p>
    <p>Most Global Settings are the same as available in the Edit Index window.&nbsp; Some are unique and 
    not duplicated under the Edit Index option.&nbsp; They are:</p>
  <blockquote>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Sublevel Padding:">Sublevel Padding:</a></p></span>
      <p>samSiteMap pads the left side of Items in its displays.&nbsp; In list 
      mode, its 1x pad value, in map mode its sublevel x pad value.&nbsp; This 
      number is integer, only, do not include quotes, pct, px, % or anything non 
      integer.&nbsp; It is applied as px.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Description Lengths:">Description Lengths:</a></p></span>
      <p>Character Length for Descriptions.&nbsp; Applies to List and Map View 
      modes only, as Search result description lengths are set under the 
      &quot;Search/Rank Settings&quot; tab.&nbsp; This will trim the content text for each Item, 
      starting from the beginning, so that it does 
      not exceed this number (plus 15 chars).&nbsp; If it can find a period, or 
      a space within the next 15 characters following this cut off point, it 
      will extend the description to that point.</p>
  </blockquote>
  <span style="font-size:1.1em;font-weight:bold"><p><a name="Search/Rank Settings:">Search/Rank Settings:</a></p></span>
        <p><a href="#Highlight Search Terms:">Highlight Search Terms:</a><br />
      <a href="#Highlight Titles:">Highlight Titles:</a><br />
        <a href="#Description Lengths:">Description Lengths:</a><br />
      <a href="#Show Search Item Ranks:">Show Search Item Ranks:</a><br />
      <a href="#CSS highlight color (HEX):">CSS highlight color (HEX):</a><br />
      <a href="#Bold Highlight Font">Bold Highlight Font</a><br />
      <a href="#Show Wildcard Line:">Show Wildcard Line:</a></p>
  <blockquote>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Highlight Search Terms:">Highlight Search Terms:</a></p></span>
      <p>Turn all search term highlighting off or on.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Highlight Titles:">Highlight Titles:</a></p></span>
      <p>Turn search term highlighting for item titles off or on.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Description Lengths:">Description Lengths:</a></p></span>
      <p>Same as for Global Settings, but applies only to descriptions for 
      returned search items.&nbsp; Character length maximum for that 
      description.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Search Item Ranks:">Show Search Item Ranks:</a></p></span>
      <p>If you don\'t want to see the Rank column on a search return, turn it 
      off here.</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="CSS highlight color (HEX):">CSS highlight color (HEX):</a></p></span>
      <p>Will be added into a span tag that surrounds a found search term in an 
      Item.&nbsp; Will be applied as style="font-color: #FF0000".&nbsp; Although 
      we are expecting a HEX number, you can also use a recognized CSS color 
      name (like red, blue, green etc...).</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Bold Highlight Font">Bold Highlight Font?</a></p></span>
      <p>Turn bold attribute off or on for highlighted search terms.&nbsp; 
      Applied as style="font-weight:bold".</p>
    <span style="font-size:1.1em;font-weight:bold"><p><a name="Show Wildcard Line:">Show Wildcard Line:</a></p></span>
      <p>Turn off or on the display below the search box that says "*"=wildcard.</p>
  </blockquote>
      <span style="font-size:1.1em;font-weight:bold"><p><a name="Clean samSiteMap Cache:">Clean samSiteMap Cache:</a></p></span>
      <p>Deletes any existing cache files stored by samSiteMap.&nbsp; samSiteMap 
      will automatically clean the cache whenever you save an Index 
      configuration, or when saving Root Items within an Index.&nbsp; If we 
      missed something, you can clean it manually here.</p>
</blockquote>
</blockquote>
<span style="font-size:1.5em;font-weight:bold"><p><a name="Language:">Language:</a></p></span>
<blockquote>
  <p>We have made an honest attempt to make samSiteMap 100% language skin able.&nbsp; 
  All language is contained in two language files, one for the front end, and 
  one for the admin utilities.&nbsp; Each is contained in a lang directory, 
  which is inside each respective component directory for samSiteMap.&nbsp; 
  samSiteMap will look first in those directories for files that match the 
  Mambo/Joomla! Local setting, then if it fails it will look for a file that 
  matches the Language setting.&nbsp; If both fail, it loads the default en_us 
  file.&nbsp; We tested this part, and know it works.</p>
  <p>If you translate a language file (or both), please send us a copy of your 
  translation.&nbsp; </p>
  <p>As of now, samSiteMap is about 99% certain not to work with unicode, 
  although we hope to add that option later.&nbsp; ASCII English will work for 
  sure, ANSII may.&nbsp; We suggest trying it out on your site before trying to 
  edit the Language files.&nbsp; In particular, check the List sort options, and 
  the search function.</p>
  <p>If you find that it does not work in your language, there are some tweaks 
  we are hoping to do before the next beta release.&nbsp; We just need some non-English 
  websites, and folks who speak something other than English to test with.&nbsp; 
  We will not be focusing on unicode until we are very close to, or perhaps even 
  after the first stable release.</p>
  <p>If you are a coder/hacker who wants to assist in this effort. please contact us through 
  the contact us options on our website at
  <a href="http://coders.mlshomequest.com">http://coders.mlshomequest.com</a> .</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </blockquote>
  <p>Although not real comprehensive, we hope that this documentation, along 
  with the documentation we provide in the form of ? buttons throughout 
  samSiteMap\'s admin component will be sufficient.&nbsp; If you have additional questions, or need 
  support, please contact us through the contact forms on our website at
  <a href="http://coders.mlshomequest.com">http://coders.mlshomequest.com</a> .&nbsp; 
  We also maintain a simpleboard forum there for folks who wish to join the site 
  and participate directly on the forum.</p>
  <p>Free support is provided on an &quot;as available&quot; basis only.</p>
  '; ?>