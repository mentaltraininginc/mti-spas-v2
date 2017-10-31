<?php
/*
BSQ_Sitestats is written by Brent Stolle (c) 2005
Brent can be contacted at dev@bs-squared.com or at http://www.bs-squared.com/

This software is FREE. Please distribute it under the terms of the GNU/GPL License
See http://www.gnu.org/copyleft/gpl.html GNU/GPL for details.

If you fork this to create your own project, please make a reference to BSQ_Sitestats
someplace in your code and provide a link to http://www.bs-squared.com

BSQ_Sitestats is based on and made to operate along side of Shaun Inman's ShortStat
http://www.shauninman.com/
*/

/**
* bsq_sitestats Class
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Sebastian BERGMANN <sb@sebastian-bergmann.de>
* @author Fabien MARTY <fab@php.net>
* @author Michiel Bijland
* @author Brent Stolle
*
*/

/* ensure this file is being included by a parent file */
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

require_once($mosConfig_absolute_path.'/includes/Cache/Lite.php');

class BSQCache extends Cache_Lite {


   /**
    * Default cache group for function caching
    *
    * @var string $_defaultGroup
    */
    var $_defaultGroup = 'bsq_cache';
    
    
    /**
    * Constructor
    *
    * $options is an assoc. To have a look at availables options,
    * see the constructor of the Cache_Lite class in 'Cache_Lite.php'
    *
    * Comparing to Cache_Lite constructor, there is another option :
    * $options = array(
    *     (...) see Cache_Lite constructor
    *     'defaultGroup' => default cache group for function caching (string)
    * );
    *
    * @param array $options options
    * @access public
    */
    function BSQCache($options = array(NULL))
    {
    	global $mosConfig_absolute_path;
        if (isset($options['defaultGroup'])) {
            $this->_defaultGroup = $options['defaultGroup'];
        }
        if (!isset($options['cacheDir'])){
        	$options['cacheDir']= $mosConfig_absolute_path.'/administrator/components/com_bsq_sitestats/cache/';
        }
        if (!isset($options['lifeTime'])){
        	$options['lifeTime']='3600';
        }
        $this->Cache_Lite($options);
    }
    
   /**
    * Enable or disable the cache
    * 
    * @param boolean $enable 1=enable cache. 0=disable it.
    * 
    */
   function enableCache($enable)
   {
   		$this->_caching = $enable ? true : false;
   }
   
   /**
    * Calls a cacheable function or method (or not if there is already a cache for it)
    *
    * Arguments of this method are read with func_get_args. So it doesn't appear
    * in the function definition. Synopsis : 
    * call('functionName', $arg1, $arg2, ...)
    * (arg1, arg2... are arguments of 'functionName')
    *
    * @return mixed result of the function/method
    * @access public
    */
    function call()
    {
        $arguments = func_get_args();
        $id = serialize($arguments); // Generate a cache id
        if (!$this->_fileNameProtection) {
            $id = md5($id);
            // if fileNameProtection is set to false, then the id has to be hashed
            // because it's a very bad file name in most cases
        }
        $data = $this->get($id, $this->_defaultGroup);
        if ($data !== false) {
            $result = unserialize($data);
        } else {
            $target = array_shift($arguments);
            if (strstr($target, '::')) { // classname::staticMethod
                list($class, $method) = explode('::', $target);
                $result = call_user_func_array(array($class, $method), $arguments);
            } else if (strstr($target, '->')) { // object->method
                // use a stupid name ($objet_123456789 because) of problems when the object
                // name is the same as this var name
                list($object_123456789, $method) = explode('->', $target);
                global $$object_123456789;
                $result = call_user_func_array(array($$object_123456789, $method), $arguments);
            } else { // function
                $result = call_user_func_array($target, $arguments);
            }
            $this->save(serialize($result), $id, $this->_defaultGroup);
        }
        return $result;
    }
}
?>