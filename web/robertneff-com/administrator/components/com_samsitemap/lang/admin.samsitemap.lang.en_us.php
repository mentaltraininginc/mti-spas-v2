<?php
/*
Language file for samSiteMap admin utilities
*/
$lang = '';
//General
$lang['hide'] = 'Hide';
$lang['show'] = 'Show';
$lang['useglobal'] = 'Global';
$lang['use_global'] = 'Use Global';
$lang['yes'] = 'Yes';
$lang['no'] = 'No';
$lang['samSiteMap'] = 'samSiteMap';
//Title for Help Icons
$lang['index_asst'] = 'Description';
    //Names that are displayed for the Default Index and GLobal Settings
$lang['default_Index_name'] = 'Default Index';
$lang['global_Index_name'] = 'Global Settings';
$lang['notused'] = 'Not Used';
$lang['na'] = 'Not Applicable';
$lang['notset'] = 'Not Set';
    //used to seperate various text items
$lang['text_delim'] = ':';

//save function
$lang['save_success'] = 'Index Saved!';
$lang['save_failure'] = 'An error was encountered attempting to save Index';
$lang['saved'] = 'Saved!';
$lang['not_saved'] = 'An error was encountered while saving';

//cpanel
$lang['cpanel_title'] = 'Control Panel';
$lang['cpanel_global_defaults'] = 'Global Defaults';
$lang['cpanel_search_settings'] = 'Search/Rank Settings';
$lang['cpanel_index_manager'] = 'Index Manager';
$lang['cpanel_help'] = 'Documentation';
$lang['cpanel_samSM_website']= 'samSiteMap Website';
$lang['cpanel_clear_cache'] = 'Clean samSiteMap Cache';
$lang['cpanel_clear_cache_msg'] = 'Cached Cleaned';

//text for showIndexes function

$lang['showconfigs_title'] = "Index Manager";
$lang['showconfigs_config_name'] = "Index Name";
$lang['showconfigs_assignment'] = "Assignment";
$lang['showconfigs_menu_type'] = "Menu";
$lang['showconfigs_menu_item_title'] = "Menu Item Title";
$lang['showconfigs_itemid'] = "Itemid: ";
$lang['showconfigs_page_title'] = "Page Title";
$lang['showconfigs_search_title'] = "Search Title";
$lang['delete_index_successful'] = "Index(s) Deleted";
$lang['delete_index_failed'] = "Error Deleting Index";
$lang['delete_index_not_allowed'] = "Indexes for Global Settings and Default Index cannot be deleted";

//test for Search/Rank Settings
    $lang['sr_title'] = 'Search and Rank Settings';
    $lang['sr_weight_title'] = '<center><b>This rating section of samSiteMap is experimental.  We have set what we consider to be reasonable defaults during the installation of samSiteMap, but welcome you to mess around with them to get your best results.  You should consider this part to be transitional as it will most likely change before the next release.</b></center>';
    $lang['sr_weight_label'] = 'The following weights are proportional.  For example density weight of 5, title weight of 3, and  all weight of 1 are the same as (and equal to) 50,30 and 10.  They do not need to add up to any number, each is independent and weights according to your selection.  The weighting determines how many times their individual values are included.  We realize this isn\'t real clear, but the formulas are inter-related and somewhat hard to explain.';
    $lang['sr_formulas'] = '<br />
    The basic (simplified) formula is:<br />
    $chrdens = $total_search_characters(termchars x searchhits) / $total_item_chars (includes all characters in both the title, and the complete and full description(or article), not just what is shown on the search screen)<br />
    $rating_density = $chrdens / $maxdens //establishes a value relative to 1<br />
    Then for each weighting factor:<br />
    $density = ($dens >= $maxdens)? $maxdens x $density_weight: $rating_density x $density_weight<br />
    $title = (search term in title)? 1 x $title_weight: $rating_density x $title_weight<br />
    $all = (search term in title and description)? 1 x $all_weight: $rating_density x $all_weight<br /> and finally:<br />
    ($total_of_all_values($density + $title + $all)/ $total_ofall_weight_values) x 100<br />
    <b>We invite your input and suggestions for the rating features of samSiteMap</b>';
    $lang['vsr_maxdens_lbl'] = 'Maximum Density:';
    $lang['vsr_maxdens_desc'] = '<b>Int</b> Maximum density to equate to 100% in the rank column.  Integer only, do not add a percent (%) sign after it.  We have found that values between 5 and 10 work well.  To see true density (make that very close density), make this 100.';
    $lang['vsr_show_hl_lbl'] = 'Highlight search terms?';
    $lang['vsr_show_hl_desc'] = 'Enable Highlighting of search terms in search results';
    $lang['vsr_search_clr_lbl'] = 'CSS highlight color (HEX):';
    $lang['vsr_search_clr_desc'] = 'CSS Hex value for highlighting search terms (red is:#FF0000).  Can also be a recognized CSS color value name.';
    $lang['vsr_title_hl_lbl'] = 'Highlight Titles?';
    $lang['vsr_title_hl_desc'] = 'Highlight Titles in addition to descriptions';
    $lang['vsr_search_bld_lbl'] = 'Bold Highlight Font?';
    $lang['vsr_search_bld_desc'] = 'Make font for highlighted items bold';
    $lang['vsr_desc_len_lbl'] = 'Description Lengths:';
    $lang['vsr_desc_len_desc'] = '<b>Int</b> Length (in characters) for Search Descriptions';
    $lang['vsr_sho_wc_lbl'] = 'Show Wildcard line:';
    $lang['vsr_sho_wc_desc'] = 'Enable/Disable Explanation below search terms for Wildcard searches';
    $lang['vsr_sho_rtng_lbl'] = 'Show Search Item Ranks:';
    $lang['vsr_sho_rtng_desc'] = 'Enable/Disable the rank/rating column in search results';
    //Rating options
    $lang['vsr_densw_lbl'] = 'Density Weight:';
    $lang['vsr_densw_desc'] = '<b>Int</b> Weighting factor to use for Search Term Density.';
    $lang['vsr_titlew_lbl'] = 'Title Weight:';
    $lang['vsr_titlew_desc'] = '<b>Int</b> Weighting factor to use when a search term is found in the title.';
    $lang['vsr_allw_label'] = 'All Weight:';
    $lang['vsr_allw_desc'] = '<b>Int</b> Weighting factor to use when a search term is found in both the title and the description.';


//Edit Index Text
$lang['editIndex_title'] = "Edit Index: ";
    //<td> width parameter for editIndex form
    $lang['option_tdwidth'] = '150px';
    $lang['settings_tdwidth'] = '200px';

    //Page Text Tab
    $lang['editIndex_tab_text'] = 'Page Text';
    $lang['editIndex_text_th'] = 'Page Text';


    //Configuration Tab
        //default DB fields
        $lang['newIndex_def_title'] = 'Site Map';
        $lang['newIndex_def_name'] = 'NewIndex';

    $lang['editIndex_tab_config'] = 'Configuration';
    $lang['editIndex_config_option'] = 'Option';
    $lang['editIndex_config_setting'] = 'Setting';
    $lang['editIndex_config_description'] = 'Description';
    $lang['editIndex_config_name_label'] = 'Index Name:';
    $lang['editIndex_config_name_desc'] = 'Name for this Index configuration'
            .'.  Not displayed, for use in management and configuration';

    $lang['vconfigs_title_lbl'] = 'Page Title:';
    $lang['editIndex_default_title'] = 'SiteMap';
    $lang['vconfigs_title_desc'] = 'Title for page';
    $lang['vconfigs_search_title_lbl'] = 'Search Title:';
    $lang['vconfigs_search_title_desc'] = 'Title for search option and modules';
    $lang['vconfigs_itemid_lbl'] = 'Menu Item Assignment:';
    $lang['vconfigs_itemid_desc'] = 'Menu Item that will activate this Index.';
    $lang['editIndex_assign_fail'] = 'No samSiteMap Menu Items found.  Menu Items'
        .' must be added to Menus before they can be assigned to an Index in'
        .' samSiteMap';
    $lang['not_assigned_lbl'] = 'Not Assigned';
    $lang['editIndex_editr_wrng'] = 'Editors may not display properly after changing'
        .' Root Items.  If you just made Root Item changes and your text is not displaying'
        .', Save this Index and it will correct Itself.';
    $lang['vparams_useconfig_lbl'] = 'Root Mode:';
    $lang['vparams_useconfig_desc'] = 'Auto Config is primarily for use as a'
        .' "Whole Site" (Site Map) Index.  It will use all menus in all template'
        .' positions as Root Items and ignore any items in the current Root Item List for this'
        .' Index.  In Manual Config Mode, the Index will be derived from the'
        .' Root Item List contained in this configuration only.';
    $lang['vparams_useconfig_opt1'] = 'Auto Config';
    $lang['vparams_useconfig_opt2'] = 'Manual Config';
    $lang['vparams_pospri_lbl'] = 'Template Position Order:';
    $lang['vparams_pospri_desc'] = '<b>Applies to Auto Config option above'
        .' only!</b><br />Correction for normal ordering of template positions.'
        .'  Menus in Indexes are ordered relative to their assigned Template'
        .' Position.  If your posititions are not in the order you want them'
        .' in for proper display of your Index, you can correct that here.  '
        .'Enter a comma delimited list of the position ids (INT id numbers) of'
        .' the positions you want to move to the top.  Order as you want them '
        .'to render, ie: 13,5,1  The remainder will display below these, in '
        .'their normal order.  Position ids can be found under the Site>Template'
        .' Manager>Module Positions menu option';
    $lang['vparams_usecache_lbl'] = 'Use Cache:';
    $lang['vparams_usecache_desc'] = 'Use Caching for the output of this component';
    $lang['vparams_noauth_lbl'] = 'Show/Hide Unauthorized:';
    $lang['vparams_noauth_desc'] = 'If Show is selected, Unauthorized'
        .' items will display as text only (not links), without descriptions.  '
        .'In addition, there will be a parenthesized reason to the right of the'
        .' title (for example "Members Only").  If icons are enabled, they will'
        .' be displayed crossed out with red Xs.  Children/descendents of that'
        .' item will not be rendered at all.';
    $lang['vparams_showself_lbl'] = 'Include Self:';
    $lang['vparams_showself_desc'] = 'Include link to this Menu Item '
        .'in lists/maps created by samSiteMap';
    $lang['vparams_menutitles_lbl'] = 'Show Menu Titles:';
    $lang['vparams_menutitles_desc'] = 'Hide/Show Menu Titles for '
        .'included menus';
    $lang['vparams_pad_lbl'] = 'Sublevel Padding:';
    $lang['vparams_pad_desc'] = 'Padding (in pixels) for sublevels.  '
        .'Numeric only, ie: 20 , not 20px';
    $lang['vparams_desc_lbl'] = 'Item Descriptions:';
    $lang['vparams_desc_desc'] = 'Show/Hide descriptions for listed '
        .'items.  Can be overridden by user, if Show Menu option is enabled';
    $lang['vparams_icons_lbl'] = 'Icons:';
    $lang['vparams_icons_desc'] = 'Show/Hide Icons';
    $lang['vparams_showempty_lbl'] = 'Show Empty Containers:';
    $lang['vparams_showempty_desc'] = 'Only applies to non-menu Items '
        .'found by samSiteMap.  Containers are links to pages that primarily '
        .'list other pages, like Section and Category tables.';
    $lang['vparams_multirender_lbl'] = 'Show Duplicates:';
    $lang['vparams_multirender_desc'] = 'Applies to non-menu Items '
        .'found by SiteMap.  This can solve some problems with highly developed '
        .'menus.  If you have multiple menu links to singular items (like both '
        .'blog entries and table entries for a singular category or section) '
        .'this option will prevent the second instance of that item (and any '
        .'descended items) from displaying more than once.';
    $lang['vparams_view_lbl'] = 'Default View:';
    $lang['vparams_view_option1'] = 'Map';
    $lang['vparams_view_option2'] = 'List';
    $lang['vparams_view_desc'] = 'Default Page Style: can be overridden'
        .' by user, if Show Menu option is enabled';
    $lang['vparams_sort_lbl'] = 'Default Sort:';
    $lang['vparams_sort_option1'] = 'Normal';
    $lang['vparams_sort_option2'] = 'By Hits';
    $lang['vparams_sort_option3'] = 'By Rating';
    $lang['vparams_sort_option4'] = 'By Votes';
    $lang['vparams_sort_desc'] = 'Default Sort for Page: can be '
        .'overridden by user, if Show Menu option is enabled';
    $lang['vparams_desclen_lbl'] = 'Description Lengths:';
    $lang['vparams_desclen_desc'] = 'Numeric Only, description Length'
        .' (in characters) for items listed in this Index.'
        .'  Can be disabled by user if Description Selection is enabled';

    //User Options Tab
    $lang['editIndex_tab_menuoptions'] = 'User Sort/Search';
    $lang['vparams_showmenu_lbl'] = 'Show Menu:';
    $lang['vparams_showmenu_desc'] = 'Enable/Disable User view/sort/'
        .'descriptions menu';
    $lang['vparams_search_ok_lbl'] = 'Allow Searching?';
    $lang['vparams_search_ok_desc'] = 'Enable/Disable searching on this Index.  If disabled, search requests will be ignored (like from a search module)';
    $lang['vparams_showview_lbl'] = 'View Selection:';
    $lang['vparams_showview_desc'] = 'Enable/Disable View selection '
        .'option';
    $lang['vparams_showsearch_lbl'] = 'Show/Hide Search Options:';
    $lang['vparams_showsearch_desc'] = 'Hide/Show search options unless a search is executed from the URL (like from a module).  Search Menu will always show when samSiteMap is in search mode';
    $lang['vparams_showsort_lbl'] = 'Sort Options:';
    $lang['vparams_showsort_desc'] = 'Enable/Disable Sort selection '
        .'option';

    $lang['vparams_ratingsort_lbl'] = 'Show rating sort Option:';
    $lang['vparams_ratingsort_desc'] = 'Enable/Disable Rating option '
        .'in Sort Selections';

    $lang['vparams_showdesc_lbl'] = 'Descriptions Selection:';
    $lang['vparams_showdesc_desc'] = 'Enable/Disable Descriptions '
        .'(hide/show) selection option';

    //Root Items Tab
    $lang['editIndex_tab_root'] = 'Root Items';
    $lang['editIndex_root_item'] = 'Item';
    $lang['editIndex_root_type'] = 'Type';
    $lang['editIndex_root_ordering'] = 'Ordering';
    $lang['editIndex_root_itemid'] = 'Parent Itemid';
    $lang['editIndex_root_nonefound'] = 'No Items added yet, or using Auto Config'
        .' option';
    $lang['editIndex_root_savefirst'] = 'Index must be saved before Root Items can be added';
        //  Type Labels
        $lang['editIndex_root_tp'] = 'Template Position';
        $lang['editIndex_root_mi'] = 'Menu Item';
        $lang['editIndex_root_menu'] = 'Menu';
        $lang['editIndex_root_descendent'] = 'Menu Item Descendent';

    //Menu Assigment Tab


    //Expand Options Tab
    $lang['editIndex_tab_expand'] = 'Expand Options';
    $lang['editIndex_expand_desc'] = 'Options below determine discovery/display options for non-menu items.  Discovery of a branch descended from a menu item will stop at the first "hide" option.  For example, content items that fall below a category or section menu item will not be expanded/discovered if the category or section is hidden';
    $lang['vparams_exp_sections_lbl'] = 'Sections:';
    $lang['vparams_exp_sections_desc'] = 'Will find and display'
        .' any Sections which are non-Menu Items and descend from the Root Item List';
    $lang['vparams_exp_categories_lbl'] = 'Content Categories:';
    $lang['vparams_exp_categories_desc'] = 'Will find and display'
        .' any descended Content Categories (blogs, archives and normal content).';
    $lang['vparams_exp_content_lbl'] = 'Content Items:';
    $lang['vparams_exp_content_desc'] = 'Will find and display'
        .' any descended Content Items';
    $lang['vparams_exp_nf_cat_lbl'] = 'Newsfeeds Categories:';
    $lang['vparams_exp_nf_cat_desc'] = 'Will find and display'
        .' Newsfeeds categories';
    $lang['vparams_exp_newsfeeds_lbl'] = 'Newsfeeds:';
    $lang['vparams_exp_newsfeeds_desc'] = 'Will find and display'
        .' any descended Newsfeeds';
    $lang['vparams_exp_wl_cat_lbl'] = 'Weblinks Categories';
    $lang['vparams_exp_wl_cat_desc'] = 'Will find and display'
        .' Weblinks categories';
    $lang['vparams_exp_weblinks_lbl'] = 'Weblinks:';
    $lang['vparams_exp_weblinks_desc'] = 'Will find and display'
        .' any descended Weblinks';
    $lang['vparams_exp_ct_cat_lbl'] = 'Contact Categories:';
    $lang['vparams_exp_ct_cat_desc'] = 'Will find and display'
        .' Contact categories';
    $lang['vparams_exp_contacts_lbl'] = 'Contact Items:';
    $lang['vparams_exp_contacts_desc'] = 'Will find and display'
        .' any descended Contact Items';

    //Preview Tab
    $lang['editIndex_tab_preview'] = 'Index Preview';
    $lang['editIndex_preview_desc'] = 'Showing last saved configuration of this'
        .' Index.  To see unsaved changes, save this Index configuration and return to this Tab';
    $lang['editIndex_preview_desc2'] = 'To use the different access level links below, you must be logged into the front end as an Administrator or Super Administrator (You can log in below, if you are not already logged in).  Links will only effect the output of the samSiteMap component.  All other parts of your website (modules, menus, etc...) will not be affected';
    $lang['editIndex_preview_link0'] = 'Show Public';
    $lang['editIndex_preview_link1'] = 'Show Registered';
    $lang['editIndex_preview_link2'] = 'Show Special';

//Select Item Type Text

$lang['selectItemt_title'] = 'Add Index Item: Select Item Type';
$lang['selectItemt_table_desc'] = 'Description';
$lang['selectItemt_table_select'] = 'Select Item Type';
$lang['selectItemt_pos_label'] = 'Template Position';
$lang['selectItemt_pos_desc'] = 'Renders (finds) all published menus and menu'
    .' items for selected template position, in thier assigned order';
$lang['selectItemt_menu_label'] = 'Menu';
$lang['selectItemt_menu_desc'] = 'Renders (finds) all published menu items for '
    .'selected menu, in thier assigned order';
$lang['selectItemt_mitem_label'] = 'Single Menu Item';
$lang['selectItemt_mitem_desc'] = 'Renders a single menu item';

//Select Item Text

$lang['selectItem_title'] = 'Add Index Item: Select Item';
$lang['selectItem_table_select'] = 'Select Item';

//Toolbars
$lang['tb_save'] = 'Save';
$lang['tb_save_exit'] = 'Save&Exit';
$lang['tb_cancel'] = 'Cancel';
$lang['tb_new'] = 'New';
$lang['tb_edit'] = 'Edit';
$lang['tb_delete'] = 'Delete';
$lang['tb_root_items'] = 'Root Items:';
$lang['tb_new_root_item'] = 'New Root Item';
$lang['tb_edit_root_item'] = 'Edit Root Item';
$lang['tb_delete_root_item'] = 'Delete Root Item';
$lang['tb_select_item'] = 'Select Item';


?>