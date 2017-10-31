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

/* Only include this file if you intend to use the graphing component of BSQ Sitestats,
   as including this file will add a significant amount of code */

require_once($mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats/bsqglobals.inc.php');
require_once($bsqClassPath . '/bsqfilecache.class.php');

if(!file_exists($bsqGraphPath . '/jpgraph.php')) {
	die(_BSQ_JPGRAPHMISSING);
}

/* JPGraph includes */
require_once($bsqGraphPath . '/jpgraph.php');
require_once($bsqGraphPath . '/jpgraph_line.php');
require_once($bsqGraphPath . '/jpgraph_bar.php');

/**
 * Wrapper for all BSQGraph___ classes
 *
 */
class BSQGraph
{
	var $fileCache;
	var $liveFilename = null;
	var $cacheFilename = null;
	var $liveWebPath = null;
	var $graph = null;
	
	var $leftMargin = 45;
	var $rightMargin = 30;
	var $topMargin = 20;
	var $bottomMargin = 60;
	var $lockTimeout = 60;
	var $graphScale = 'textlin';
	
	/**
	 * Setup the graph object.
	 *
	 * @param integer $width Width of the image to be generated.
	 * @param integer $height Height of the image to be generated.
	 * @param integer $cacheTime Amount of time to cache the image.
	 * @param string $graphTitle Title for the graph
	 * @param string $uniqueHandle Unique string to identify this graph. 
	 *
	 * @return string Filename relative to the root directory of the image file if it is cached.
	 *	       boolean TRUE if OK
	 *	 	   boolean FALSE if an error occured.
	 *           
	 */
	function init($width, $height, $cacheTime, $graphTitle, $uniqueHandle)
	{
		global $bsqGraphImgPath, $bsqGraphImgWebPath, $bsqAppTitleVer;
		
		if (!$uniqueHandle) {
			die('Unique handle must be present for caching to work');
		}
		
		$filename = sprintf("%s_w%d_h%d.png", $uniqueHandle, $width, $height);
		$this->liveFilename = $bsqGraphImgPath.'/'.$filename;
		$this->liveWebPath = $bsqGraphImgWebPath . '/' . $filename;
		
		$this->fileCache = new BSQFileCache($this->liveFilename, '', $cacheTime, $this->lockTimeout);
		if ($this->fileCache->isCurrent()) {
			return $this->liveWebPath;
		}
		else {
			$result = $this->fileCache->lock();
			if (is_string($result)) {
				//We got the lock. Here's the filename to write to
				$this->cacheFilename = $result;
			}
			else if ($result) {
				//Is locked by another proc, but we already have a working copy
				return $this->liveWebPath;
			}
			else {
				die('BSQGraph::init() Timed out trying to get a lock');	
			}
		}
		
		$this->graph = new Graph($width, $height);
		$this->graph->SetScale($this->graphScale);
		$this->graph->SetShadow();
		$this->graph->img->SetMargin($this->leftMargin, $this->rightMargin, $this->topMargin, $this->bottomMargin);
		$this->graph->legend->Pos(.1,.1,"left","top");
		
		if ($graphTitle) {
			$this->graph->title->Set($graphTitle);
		}
		
		if ($bsqAppTitleVer) {
			$this->graph->subtitle->Set($bsqAppTitleVer);
		}
		
		return true;
	}
	
	/**
	 * Write out the Graph to the live filename. Make sure to call unlock() right after this.
	 *
	 * @return string Web filename of the image if flushing worked.
	 *         boolean false if an error occured.
	 */
	function flush()
	{
		$this->graph->title->SetFont(FF_FONT1,FS_BOLD);
		$this->graph->subtitle->SetFont(FF_FONT0,FS_NORMAL);
		$this->graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$this->graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		
	    //Write the graph out to a file
		$this->graph->Stroke($this->cacheFilename);
		$retVal = $this->fileCache->makeLive();
		if($retVal) {
			$retVal = $this->liveWebPath;
		}
		
		$this->fileCache->unlock();
		
		return $retVal;
	}
	
	/**
	 * If something happens between locking the cache and rendering the graph, call this to
	 * unlock the cache. The cache will no longer be locked after this, so don't you dare write
	 * to the file.
	 *
	 */
	function abort()
	{
		$this->fileCache->unlock();
	}
}


/**
 * Linear Graphing class for BSQ Sitestats. Depends on BSQGraph
 *
 */
class BSQGraphLine extends BSQGraph 
{
	var $numSets = 0;
	var $datasetColors = array('red', 'blue', 'green', 'yellow');
	
	/**
	 * Constructor for the BSQGraphLine class
	 *
	 */
	function BSQGraphLine()
	{
		$this->numSets = 0;
	}
	
	/**
	 * Setup the graph object.
	 *
	 * @param integer $width Width of the image to be generated.
	 * @param integer $height Height of the image to be generated.
	 * @param integer $cacheTime Amount of time to cache the image.
	 * @param string $graphTitle Title for the graph
	 * @param string $uniqueHandle Unique string to identify this graph. 
	 *
	 * @return string Filename relative to the root directory of the image file if it is cached.
	 *	       boolean TRUE if OK
	 *	 	   boolean FALSE if an error occured.
	 *           
	 */
	function init($width, $height, $cacheTime, $graphTitle, $uniqueHandle)
	{
		$result = parent::init($width, $height, $cacheTime, $graphTitle, $uniqueHandle);
		if ($result === true) {
			//If things went ok, do a little more work before we return
			$this->graph->legend->Pos(.1,.1,"left","top");
		}
		
		return $result;
	}
	
	/**
	 * Setup the X Axis of the graph
	 *
	 * @param array $labels Array of labels to be used for the X axis. Even if you have an interval
	 *                      > 1, you still need to provide a label for every point that will be displayed.
	 * @param integer $tickInterval Optional parameter to show every nth X-axis label instead of all of them
	 * @param string $title Optional title for the X axis 
	 *
	 */
	function setXAxis($labels, $tickInterval=1, $title='')
	{
		$this->graph->xaxis->SetTextTickInterval($tickInterval);
		$this->graph->xaxis->SetTickLabels($labels);
		$this->graph->xaxis->SetLabelAngle(90);
		
		if ($title) {
			$this->graph->xaxis->title->Set($title);
		}
	}
	
	/**
	 * Setup the Y Axis of the graph
	 *
	 * @param string $title Title for the Y axis
	 */
	function setYAxis($title)
	{
		if ($title) {
			$this->graph->yaxis->title->Set($title);
		}
	}
	
	/**
	 * Add a dataset to the graph.
	 *
	 * @param array $points Array of point values to add to the graph.
	 * @param array $legendTitle Title of this set that will be displayed on the legend
	 * @param array $color Optional color for this graph in text. See JPGraph documentation for valid colors
	 *
	 */
	function addDataset($points, $legendTitle, $color='')
	{
		$dplot = new LinePlot($points);
		
		//Set the color of the dataset
		if ($color) {
			$dplot->SetColor($color);
		}
		else {
			$dplot->SetColor($this->datasetColors[$this->numSets]);
		}
		
		//Set the legend text if it's there
		if ($legendTitle) {
			$dplot->SetLegend($legendTitle);
		}
		
		//Add this set to our graph
		$this->graph->Add($dplot);
		
		$this->numSets++;
	}
	
	/**
	 * Write out the Graph to the live filename. Make sure to call unlock() right after this.
	 *
	 * @return string Web filename of the image if flushing worked.
	 *         boolean false if an error occured.
	 */
	function flush()
	{
		$retVal = false;
		
		$this->graph->xgrid->Show(true,false);
		
		return parent::flush();
	}
	
	
}

/**
 * Bar Graphing class for BSQ Sitestats
 *
 */
class BSQGraphBar extends BSQGraph 
{
	var $graph = null;
	
	/**
	 * Standard constructor
	 *
	 */
	function BSQGraphBar()
	{
		
	}
	
	/**
	 * Setup the graph object.
	 *
	 * @param integer $width Width of the image to be generated.
	 * @param integer $height Height of the image to be generated.
	 * @param integer $cacheTime Amount of time to cache the image.
	 * @param string $graphTitle Title for the graph
	 * @param string $uniqueHandle Unique string to identify this graph. 
	 *
	 * @return string Filename relative to the root directory of the image file if it is cached.
	 *	       boolean TRUE if OK
	 *	 	   boolean FALSE if an error occured.
	 *           
	 */
	function init($width, $height, $cacheTime, $graphTitle, $uniqueHandle)
	{
		return parent::init($width, $height, $cacheTime, $graphTitle, $uniqueHandle);
	}
	
	/**
	 * This will set the bars from raw rows from the database 
	 *
	 * @param array $rows Array of row arrays that contain columns to be used as labels and values
	 * @param mixed $labelCol key of the column that contains the labels
	 * @param mixed $valueCol key of the column that contains the values
	 * @param string $valueColor Color to display values with. A valid JPGraph color string
	 * @param string $barFillColor Color to fill bars with. A valid JPGraph color string
	 */
	function setBarsFromRows($rows, $labelCol, $valueCol, $valueColor, $barFillColor)
	{
		$labels = array();
		$values = array();
		
		$longestLabel = 0;
		foreach ($rows as $row) {
			/* $labels[] = strtr($row[$labelCol], " ", "\n"); //Replace spaces with newlines to make it thinner */
			$labels[] = $row[$labelCol];
			$values[] = $row[$valueCol];
			$longestLabel = max($longestLabel, strlen($row[$labelCol]));
		}
		
		/* Set the left margin, based on how long the longest label is, since the font isn't fixed-width */
		if ($longestLabel >= 10) {
			$this->leftMargin = intval(6.5 * $longestLabel);
		}
		else {
			$this->leftMargin = intval(8.5 * $longestLabel);
		}
		
		$this->topMargin = 70;
		$this->bottomMargin = 20;
		$this->rightMargin = 25;
		$this->graph->Set90AndMargin($this->leftMargin, $this->rightMargin, $this->topMargin, $this->bottomMargin);
		
		$this->graph->xaxis->SetTickLabels($labels);
		$this->graph->xaxis->SetLabelAlign('right','center'); 
		
		$this->graph->yaxis->scale->SetGrace(13); /* 13% extra space on the end for good luck ;) */
		$this->graph->yaxis->SetLabelAngle(90);
		
		$bplot = new BarPlot($values);
		if ($barFillColor) {
			$bplot->SetFillColor($barFillColor);
		}
		$bplot->value->Show();
		$bplot->value->SetAngle(0);
		$bplot->value->SetFormat('%d');
		if ($valueColor) {
			$bplot->value->SetColor($valueColor);
		}
		$this->graph->Add($bplot);
	}
	
	/**
	 * Write out the Graph to the live filename. Make sure to call unlock() right after this.
	 *
	 * @return string Web filename of the image if flushing worked.
	 *         boolean false if an error occured.
	 */
	function flush()
	{
		return parent::flush();
	}
}

?>