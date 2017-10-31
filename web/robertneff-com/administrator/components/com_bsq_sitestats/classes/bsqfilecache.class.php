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
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle
*
*/

/* ensure this file is being included by a parent file */
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

/**
 * Class for managing a file-based cache. BSQCache manages data structures. This is used
 * as a wrapper around 3rd-party modules that output files to keep them thread safe but
 * still extremely fast.
 *
 */

define('BSQ_FC_ALREADYEXISTS', 0);

class BSQFileCache
{
	var $orgFilename = null;
	var $cacheFilename = null;
	var $lockFilename = null;
	var $cacheTime = 0;
	var $lockTimeout = 0;
	
	/**
	 * Constructor for the BSQFileCache class.
	 *
	 * @param string $filename Name of the file that needs to be updated
	 * @param string $group Group identifier for this object, in case we have conflicting filenames. Use '' if you don't care.
	 * @param integer $cacheTime Number of seconds to cache this file for. 0 = don't cache
	 * @param integer $lockTimeout Number of seconds before the .lck file is considered dead, in case the lock holder dies.
	 *
	 */
	function BSQFileCache($filename, $group, $cacheTime, $lockTimeout=30)
	{
		global $bsqFileCachePath;
		
		if (!$filename)
			die('BSQFileCache(): Missing filename!');
		
		//Save the original
		$this->orgFilename = $filename; 
		
		$this->cacheFilename = $bsqFileCachePath . '/';
		if ($group) {
			$this->cacheFilename .= $group . '_';
		}
		$this->cacheFilename .= basename($filename);
		$this->lockFilename = $this->cacheFilename . '.lock';
		
		$this->cacheTime = $cacheTime;
	}
	
	/**
	 * Is this cache file up to date?
	 *
	 * @return boolean true if this file is up to date. False if it isn't.
	 * 
	 */
	function isCurrent()
	{
		if (!$this->cacheTime) {
			return false; //Always regenerate if caching is disabled
		}
		
		$arr = @stat($this->cacheFilename);
		if (!is_array($arr)) { 
			return false; //File doesn't exist
		}
		
		$diff = time() - $arr['mtime'];
		if($diff >= $this->cacheTime)
			return false;
			
		return true;
	}
	
	/**
	 * Get a lock on the cache file so we can write to it exclusively.
	 *
	 * @return string if we got a lock on the cached file.
	 *         false if the lock timed out
	 *         true if we couldn't get the lock, but we already have a working copy of the original file
	 *
	 */
	function lock()
	{
		@$arr = stat($this->lockFilename);
		if (is_array($arr)) {
			$diff = time() - $arr['mtime'];
			
			//If the lock has expired, heal the lock by updating its mtime
			if ($diff >= $this->lockTimeout) {
				if (!@touch($this->lockFilename)) {
					die('Error healing lock '.$this->lockFilename.' on '.$this->cacheFilename);
				}
				
				return $this->cacheFilename;
			}
			else if (file_exists($this->orgFilename)) {
				return true;
			}
			else {
				//Lock contention. Do a sleeping spin lock and hope that the lock frees up.
				$waitInterval = 100000; /* 100 ms at a time */
				$waitTimes = $this->lockTimeout * 10; /* Number of $waitIntervals to wait */
				
				for ($i = 0; $i < $waitTimes; $i++) {
					if (!file_exists($this->lockFilename)) {
						//OMG. Someone released the lock on it. Return the file to write to
						return $this->getLock();
					}
					
					usleep($waitInterval);
				}
				return false; //Lock timeout
			}
		}
		else {
			if (!@touch($this->lockFilename)) {
				die('Error getting lock '.$this->lockFilename.' on '.$this->cacheFilename);
			}
			return $this->cacheFilename; //Success!
		}	
	}
	
	/**
	 * Unlock the cache file after we've written to it and updated the working copy. 
	 *
	 * If you don't call this, things will go seriously wrong.
	 * If you call this after NOT getting the lock, you could really screw up the cache.
	 *
	 */
	function unlock()
	{
		if (!@unlink($this->lockFilename)) {
			die('Error unlocking '.$this->lockFilename.' on '.$this->cacheFilename);
		}
	}
	
	/**
	 * Flush cached to working copy. The file must still be locked for integrity to be maintained.
	 *
	 * @return boolean TRUE on success. FALSE on failure.
	 */
	function makeLive()
	{
		//Deal with windows not understanding unix type rename command 
		if (!@rename($this->cacheFilename, $this->orgFilename)) {
     		if (!@copy($this->cacheFilename, $this->orgFilename)) {
         		@unlink($this->cacheFilename);
         		return false;
     		}
   		}
   		return true;
	}
}



?>