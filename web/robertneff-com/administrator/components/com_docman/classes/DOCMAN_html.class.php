<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: DOCMAN_html.class.php,v 1.27 2005/04/14 01:28:26 johanjanssens Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Official website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

if (defined('_DOCMAN_HTML_CLASS')) {
    return;
} else {
    define('_DOCMAN_HTML_CLASS', 1);
}

$pear_path = $_DOCMAN->getPath('contrib', 'pear');
require_once $pear_path . 'HTML_Select.php';

/**
* DOCMAN HTML Select Class
* Utility class for drawing select lists
* @package DOCMan_1.3.0
*/

class dmHTML_Select extends HTML_Select
{
	/**
     * Class constructor
     *
     * @param     string    $name       (optional)Name attribute of the SELECT
     * @param     int       $size       (optional) Size attribute of the SELECT
     * @param     mixed     $attributes (optional)Either a typical HTML attribute string 
     *                                  or an associative array
     * @param     int       $tabOffset  (optional)Number of tabs to offset HTML source
     * @access    public
     * @return    void
     * @throws    
     */
	
	function dmHTML_Select($name = '', $size = 1, $attributes = null, $tabOffset = 0) {
       parent::HTML_Select($name, $size, false, $attributes, $tabOffset);
    }
}

/**
* DOCMAN HTML UserSelect Class
* Utility class for drawing user select lists
* @package DOCMan_1.3.0
*/

class dmHTML_UserSelect extends dmHTML_Select
{
	function dmHTML_UserSelect($name = '', $size = 1, $attributes = null, $tabOffset = 0)
    {
       parent::dmHTML_Select($name, $size, $attributes, $tabOffset);
    }
    
    function addLabel($text, $value)
    {
    	 $this->addOption($text, $value, false, 'class="label"');
    }
    
    function addGeneral($everyone_is = null , $codes = null)
    {   
        $this->addLabel(_DML_GENERAL, _DM_PERMIT_NOOWNER);

        if (! $codes || stristr($codes, 'author') != false)
            $this->addOption(_DML_CREATOR, _DM_PERMIT_CREATOR);
        if (! $codes || stristr($codes, 'all') != false)
            $this->addOption( _DML_ALL_REGISTERED, _DM_PERMIT_REGISTERED);
        if ($everyone_is)
            $this->addOption($everyone_is, _DM_PERMIT_EVERYONE);
    }
    
    function addDocmanGroups()
    {
        global $database;

        $database->setQuery("SELECT groups_id, groups_name "
             . "\n  FROM #__docman_groups "
             . "\n ORDER BY groups_name ASC");
        $groupslist = $database->loadObjectList();

        if (count($groupslist)) 
        {
           	$this->addLabel( _DML_DOCMAN_GROUPS, _DM_PERMIT_NOOWNER);
            
         	foreach($groupslist as $groupslist) {
                $addID = (-1 * $groupslist->groups_id) + _DM_PERMIT_GROUP ;
                $this->addOption($groupslist->groups_name, $addID);
            }
        }
    }
    
    function addMamboGroups()
    {
        $this->addLabel( _DML_MAMBO_GROUPS, _DM_PERMIT_NOOWNER);
        $this->addOption('Author'   , _DM_PERMIT_AUTHOR);
        $this->addOption('Editor'   , _DM_PERMIT_EDITOR);
        $this->addOption('Publisher', _DM_PERMIT_PUBLISHER);
    }
    
  	function addUsers()
    {
        global $database;

        $database->setQuery("SELECT id, name, username "
             . "\n FROM #__users "
             . "\n ORDER BY name ASC");
        $usersTemp = $database->loadObjectList();

        if (count($usersTemp)) 
        {   
           	$this->addLabel(_DML_USERS, _DM_PERMIT_NOOWNER);
           
            foreach($usersTemp as $usersTemp) {
                $this->addOption($usersTemp->username . "(" . $usersTemp->name . ")", $usersTemp->id);
            }
        }
    }
}

/**
* DOCMAN HTML Class
* Utility class for all HTML drawing classes
* @desc class General HTML creation class. We use it for back/front ends.
* @package DOCMan_1.3.0
*/

class dmHTML extends mosHTML 
{
    // TODO :: merge categoryList and categoryParentList
    // add filter option ?
    function categoryList($id, $action, $options = array())
    {
        global $_DOCMAN;
        require_once($_DOCMAN->getPath('classes', 'utils'));
        $list = DOCMAN_utils::categoryArray();
        // assemble menu items to the array
        foreach ($list as $item) {
            $options[] = mosHTML::makeOption($item->id, $item->treename);
        }
        $parent = mosHTML::selectList($options, 'catid', 'id="catid" class="inputbox" size="1" onchange="' . $action . '"', 'value', 'text', $id);
        return $parent;
    }

    function categoryParentList($id, $action, $options = array())
    {
        global $_DOCMAN, $database;
        require_once($_DOCMAN->getPath('classes', 'utils'));
        $list = DOCMAN_utils::categoryArray();

        $cat = new mosDMCategory($database);
        $cat->load($id);

        $this_treename = '';
        foreach ($list as $item) {
            if ($this_treename) {
                if ($item->id != $cat->id && strpos($item->treename, $this_treename) === false) {
                    $options[] = mosHTML::makeOption($item->id, $item->treename);
                }
            } else {
                if ($item->id != $cat->id) {
                    $options[] = mosHTML::makeOption($item->id, $item->treename);
                } else {
                    $this_treename = "$item->treename/";
                }
            }
        }

        $parent = mosHTML::selectList($options, 'parent_id', 'class="inputbox" size="1"', 'value', 'text', $cat->parent_id);
        return $parent;
    }

    function imageList($name, &$active, $javascript = null, $directory = null)
    {
        global $mosConfig_absolute_path;

        if (!$javascript) {
            $javascript = "onchange=\"javascript:if (document.adminForm." . $name . ".options[selectedIndex].value!='') {document.imagelib.src='../images/stories/' + document.adminForm." . $name . ".options[selectedIndex].value} else {document.imagelib.src='../images/blank.png'}\"";
        }
        if (!$directory) {
            $directory = '/images/stories';
        }

        $imageFiles = mosReadDirectory($mosConfig_absolute_path . $directory);
        $images = array(mosHTML::makeOption('', _DML_SELECTIMAGE));
        foreach ($imageFiles as $file) {
            if (eregi("bmp|gif|jpg|png", $file)) {
                $images[] = mosHTML::makeOption($file);
            }
        }
        $images = mosHTML::selectList($images, $name, 'id="'.$name.'" class="inputbox" size="1" ' . $javascript, 'value', 'text', $active);

        return $images;
    }
    
    function viewerList(&$document, $name)
    {
    	global $_DMUSER;
    	
    	$html = '';
    	
    	if($_DMUSER->canAssignViewer($document)) 
    	{
   	 		//create select list
   			$select =& new dmHTML_UserSelect($name, 1 ); 
    		$select->addOption(_DML_SELECT_USER, _DM_PERMIT_NOOWNER);
    		$select->addGeneral(_DML_EVERYBODY);
    		$select->addMamboGroups();
    		$select->addDocmanGroups();
    		$select->addUsers();
    		$select->setSelectedValues(array($document->dmowner));
    		$html = $select->toHtml();
    	} else {
    		$username = DOCMAN_Utils::getUserName($document->dmowner);
    		$html .= '<input type="text" readonly="readonly" value="'.$username.'"  />';
    		$html .= '<input type="hidden" name="dmowner" value="'.$document->dmowner.'" />';
    	}
    
		return $html; 
    }
    
    function maintainerList(&$document, $name)
    {
    	global $_DMUSER;
    	
    	$html = '';
    	
    	if($_DMUSER->canAssignMaintainer($document)) 
    	{
    		//create select list
    		$select =& new dmHTML_UserSelect($name, 1 ); 
    		$select->addOption(_DML_SELECT_USER, _DM_PERMIT_NOOWNER);
    		$select->addGeneral(_DML_NO_USER_ACCESS);
    		$select->addMamboGroups();
    		$select->addDocmanGroups();
    		$select->addUsers();
    		$select->setSelectedValues(array($document->dmmantainedby));
    		$html = $select->toHtml();
    	} else {
    		$username = DOCMAN_Utils::getUserName($document->dmmantainedby);
    		$html .= '<input type="text" readonly="readonly" value="'.$username.'"  />';
    		$html .= '<input type="hidden" name="dmmantainedby" value="'.$document->dmmantainedby.'" />';
    	}
    	
		return $html;
    }

    /* uploadSelectList
	 * 		Return a select list for what UPLOAD methods are available to
	 *		this user: link, transfer, upload
	 *		Parm: $method - method to select. If blank, we pick first one.
	 */
    function uploadSelectList($method = '')
    {
        global $_DOCMAN , $_DMUSER;

        $allow_all = $_DMUSER->isAdmin ? true : false;

        if (! $allow_all) {
            $allowed = $_DOCMAN->getCfg('methods' , array('http'));
        }

        $default_method = null;
        if ($method) {
            $default_method = $method;
        }

        $methods = array();
        if ($allow_all || in_array('http' , $allowed)) {
            $methods[] = mosHTML::makeOption('http', _DML_OPTION_HTTP);
            if (! $default_method) {
                $default_method = 'http' ;
            }
        }
        if ($allow_all || in_array('transfer' , $allowed)) {
            $methods[] = mosHTML::makeOption('transfer', _DML_OPTION_XFER);
            if (! $default_method) {
                $default_method = 'transfer' ;
            }
        }
        if ($allow_all || in_array('link' , $allowed)) {
            $methods[] = mosHTML::makeOption('link', _DML_OPTION_LINK);
            if (! $default_method) {
                $default_method = 'link' ;
            }
        }

        return mosHTML::selectList($methods,
            'method', 'class="inputbox" size="3"', 'value', 'text', $default_method);
    }

    function docEditFieldsJS($checkList = null)
    {
        $checks = array();
        if ($checkList) {
            $checks = explode("|" , $checkList);
        }

        ?>
			$msg="";
            if (form.dmname.value == ""){
                $msg += '\n<?php echo _DML_ENTRY_NAME;
        ?>';
            } if (form.dmdate_published.value == "") {
                $msg += "\n<?php echo _DML_ENTRY_DATE;
        ?>";
            } if (form.dmfilename.value == "") {
                $msg += "\n<?php echo _DML_ENTRY_DOC;
        ?>" ;
            } if (form.catid.value == "0") {
                $msg +="\n<?php echo _DML_ENTRY_CAT;
        ?>" ;
            } if (form.dmowner.value == "<?php echo _DM_PERMIT_NOOWNER;
        ?>" ||
                  form.dmowner.value == "" ) {
                    $msg +="\n<?php echo _DML_ENTRY_OWNER;
        ?>" ;
            } if (form.dmmantainedby.value == "<?php echo _DM_PERMIT_NOOWNER;
        ?>"||
                  form.dmmantainedby.value == "" ) {
                    $msg +="\n<?php echo _DML_ENTRY_MAINT;
        ?>" ;
            } if( form.document_url ){
				if( form.document_url.value != "" ){
				if( form.dmfilename.value != "<?php echo _DM_DOCUMENT_LINK;
        ?>"){
				  if( form.dmfilename.value != "" ){
					$msg += "\n<?php echo _DML_ENTRY_DOCLINK;
        ?>";
				  }
				}else{

					var linkname = form.document_url.value.toLowerCase();;
					var cind = linkname.indexOf( "://" );
					if(
						cind < 0 <?php
        if (count($checks) > 0) {
            echo " || \n\t(\n\t\t";

            $useAnd = false;
            foreach($checks as $check) {
                if ($useAnd) {
                    echo " &&\n\t\t";
                }
                $lng = 3 + strlen($check);
                echo "linkname.substr( 0 , $lng ) != \"" . $check . '://"';
                $useAnd = true;
            }
            echo "\n\t)";
        }

        ?>

					){ // Invalid URL (no schema://)
							if( cind >= 0 ){
								linkname = linkname.substr( 0, cind+3 );
							}else{
								linkname = "none";
							}
							$msg += "\n<?php echo _DML_ENTRY_DOCLINK_PROTOCOL;
        ?>";
							$msg += " (" + linkname + ")";
				  }else{
					if( cind+3 == linkname.length ){
							$msg += "\n<?php echo _DML_ENTRY_DOCLINK_NAME;
        ?>";
							$msg += " (" + linkname + "???)";
					}
				  }
				}
            }
			}

	<?php
    }
}

/**
* Tab Creation Class
* @package DOCMan_1.3.0
*/
class dmTabs extends mosTabs 
{
	function dmTabs($useCookies) 
	{
		global $mainframe, $mosConfig_live_site;
		
		$this->useCookies = $useCookies;
		
		ob_start();
        ?>
        <!-- Begin Tabs -->
        <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="<?php echo $mosConfig_live_site ?>/includes/js/tabs/tabpane.css" />
		<script type="text/javascript" src="<?php echo $mosConfig_live_site ?>/includes/js/tabs/tabpane.js"></script>
        <!-- End Tabs -->
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
         
        if(method_exists($mainframe, 'addCustomHeadTag')) {
        	$mainframe->addCustomHeadTag($html);
        } else {
        	echo $html;
        }
	}
}

?>
