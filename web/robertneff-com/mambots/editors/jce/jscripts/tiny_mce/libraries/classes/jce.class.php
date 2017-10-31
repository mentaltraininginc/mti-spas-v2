<?php
/**
 * Files Class. Provides File functions for JCE
 * @author $Author: Ryan Demmer $
 * Includes some code from files.php and ImageManager.php from Wei Zhuo's Image Manager http://zhuo.org/htmlarea
 * @version $Id: files.class.php 27 2005-09-14 17:51:00 Ryan Demmer $
 */
/** boolean True if a Windows based host */
define( 'JPATH_ISWIN', (substr(PHP_OS, 0, 3) == 'WIN') );

if(!defined('DS')) {
	/** string Shortcut for the DIRECTORY_SEPERATOR define */
	define('DS', DIRECTORY_SEPARATOR);
}

if (!defined( 'JPATH_ROOT' )) {
	/** string The root directory of the file system in native format */
	define( 'JPATH_ROOT', JPath::clean( $mosConfig_absolute_path ) );
}
if (!defined( 'JPATH_FILEPEMS' )) {
	/** string The default directory permissions */
	define( 'JPATH_FILEPEMS',  !empty( $mosConfig_fileperms ) ? octdec( $mosConfig_fileperms ) : null );
}
if (!defined( 'JPATH_DIRPEMS' )) {
	/** string The default directory permissions */
	define( 'JPATH_DIRPEMS',  !empty( $mosConfig_dirperms ) ? octdec( $mosConfig_dirperms ) : null );
}

/**
 * A File handling class
 *
 * @package Joomla
 * @static
 * @since 1.1
 */
class JFile
{
    /**
    * Count the number of files in a given folder
    */
    function countFiles( $path )
    {
        $total = 0;
        if( JFolder::exists( $path ) ){
            $files = JFolder::files( $path );
            $total = count( $files );
            foreach( $files as $file ){
                if( strtolower( $file ) == 'index.html' || strtolower( $file ) == 'thumbs.db'){
                    $total = $total -1;
                }
            }
        }
        return $total;
    }
    
    /**
	 * Gets the extension of a file name
	 * @param string The file name
	 * @return string
	 */
	function getExt( $file ) {
		$dot = strrpos( $file, '.' ) + 1;
		return substr( $file, $dot );
	}

	/**
	/**
	 * Strips the last extension off a file name
	 * @param string The file name
	 * @return string
	 */
	function stripExt( $file ) {
		return preg_replace( '#\.[^.]*$#', '', $file );
	}

	/**
	 * Makes file name safe to use
	 * @param string The name of the file (not full path)
	 * @return string The sanitised string
	 */
	function makeSafe( $file ) {
		$regex = '#\.\.|[^A-Za-z0-9\.\_\- ]#';
		$file = strtolower( preg_replace( $regex, '', $file ) );
		$file = str_replace( ' ', '_', $file );
		return $file;
	}

    /**
    * Rename a file
    * @param string The path to the source file
    * @param string The path to the destination file
    * @param string An optional base path to prefix to the file names
    * @return mixed
    */
   	function copy( $src, $dest ) {

        global $cmnlang;
        $error = false;

        JPath::check( $src );
        JPath::check( $dest );

        if ( JFile::exists( $src ) ) {
            if ( is_writable( dirname( $dest ) ) ) {
                if( !@JFile::exists( $dest ) ){
                    if (!@copy( $src, $dest )) {
                        $error = $cmnlang['copy_err'];
              		}
                }else{
                    $error = $cmnlang['file_exists_err'];
                }
            }else{
                $error = $cmnlang['dir_write_err'];
            }
        }else{
            $error = $cmnlang['no_source'];
        }
        return $error;
    }

    /**
    * Rename a file
    * @param string The path to the source file
    * @param string The path to the destination file
    * @param string An optional base path to prefix to the file names
    * @return mixed
    */
    function rename( $src, $dest ) {

        global $cmnlang;
        $error = false;

        JPath::check( $src );
        JPath::check( $dest );

        if ( JFile::exists( $src ) ) {
            if ( is_writable( dirname( $dest ) )) {
                if( !@JFile::exists( $dest ) ){
                    if (!@rename( $src, $dest )) {
                        $error = $cmnlang['ren_err'];
              		}
                }else{
                    $error = $cmnlang['file_exists_err'];
                }
            }else{
                $error = $cmnlang['dir_write_err'];
            }
        }else{
            $error = $cmnlang['no_source'];
        }
        return $error;
    }

	/**
	 * Delete a file
	 * @param mixed The file name or an array of file names
	 * @return boolean  True on success
	 */
	function delete( $file ) {
		if (is_array( $file )) {
			$files = $file;
		} else {
			$files[] = $file;
		}

		$failed = 0;
		foreach ($files as $file) {
			$file = JPath::clean( $file, false );
			JPath::check( $file );
			$failed |= !unlink( $file );
		}
		return !$failed;
	}

	/**
	 * @param string The full file path
	 * @param string The buffer to read into
	 * @return boolean True on success
	 */
	function read( $file, &$buffer ) {
		JPath::check( $file );

		if (file_exists( $file )) {
			$buffer = file_get_contents( $file );
			return true;
		}
		return false;
	}

	/**
	 * @param string The full file path
	 * @param string The buffer to write
	 * @return mixed The number of bytes on success, false otherwise
	 */
	function write( $file, $buffer ) {
		JPath::check( $file );

		if (!is_writable( $file )) {
			if (!is_writable( dirname( $file ))) {
				return false;
			}
		}
		return file_put_contents( $file, $buffer );
	}

    function createCopy( $dir, $file )
    {
        $filename = basename( $file );
        $ext = JFile::getExt( $filename );
        $base = JFile::stripExt( $filename );
        $filename = $base.'_copy'.'.'.$ext;

        return $filename;
    }
    /*
    * @param string The name of the php (temporary) uploaded file
    * @param string The name of the file to put in the temp directory
    * @param string The message to return
    */
    function upload( $srcFile, $destFile, $overwrite, $unique ) {
        global $cmnlang;
        $error = false;

        $srcFile = JPath::clean( $srcFile, false );
        $destFile = JPath::clean( $destFile, false );
        JPath::check( $destFile );

        $baseDir = dirname( $destFile );

        if( $unique ){
            while( JFile::exists( $destFile ) ){
                $destFile = JPath::makePath( $baseDir, JFile::createCopy( $baseDir, $destFile ) );
            }
        }
        //File does not exist or file exists and overwrite is true
        if( !JFile::exists( $destFile ) || ( JFile::exists( $destFile ) && $overwrite ) ){
            $destFile = $destFile;
        }
        //File exists, overwrite & unique are false, return error
        if( JFile::exists( $destFile ) && !$overwrite ){
            $error = $cmnlang['upload_exists_err'];
        }else{
            if( JFolder::exists( $baseDir ) ){
                if ( is_writable( $baseDir ) ){
                    if ( move_uploaded_file( $srcFile, $destFile ) ){
   					    if ( JPath::setPermissions( $destFile ) ){
                            $error = $destFile;
       					}else{
                            $error = $cmnlang['upload_perm_err'];
                        }
                    }else{
                        $error = $cmnlang['upload_err'];
                    }
     			}else{
                    $error = $cmnlang['upload_dest_err'];
     			}
      		}else{
                $error = $cmnlang['upload_dest_err2'];
      		}
        }
        return $error;
    }

	/** Wrapper for the standard file_exists function
	 * @param string filename relative to installation dir
	 * @return boolean
	 */
	function exists( $file ) {
   		$file = JPath::clean( $file, false );
		return is_file( $file );
	}
}

/**
 * A Folder handling class
 *
 * @package Joomla
 * @static
 * @since 1.1
 */
class JFolder
{
    /**
    * Count the number of folders in a given folder
    */
    function countDirs( $path )
    {
        $total = 0;
        if( JFolder::exists( $path ) ){
            $folders = JFolder::folders( $path );
            $total = count( $folders );
        }
        return $total;
    }

    /**
	* @param string A path to create from the base path
	* @param int Directory permissions
	* @return boolean True if successful
	*/
	function create($path = '', $mode = 0755)
	{
		global $mainframe;

		JPath :: check($path);
		$path = JPath :: clean($path, false);

		// Check if dir already exists
		if (JFolder :: exists($path)) {
			return true;
		}
		// First set umask
		$origmask = @ umask(0);

        // We need to get and explode the open_basedir paths
        $obd = ini_get('open_basedir');

        // If open_basedir is et we need to get the open_basedir that the path is in
        if ($obd != null) {
            if (JPATH_ISWIN) {
                $obdSeparator = ";";
            } else {
                $obdSeparator = ":";
            }
            // Create the array of open_basedir paths
            $obdArray = explode($obdSeparator, $obd);
            $inOBD = false;
            // Iterate through open_basedir paths looking for a match
            foreach ($obdArray as $test) {
                if (!(strpos($path, $test) === false)) {
                    $obdpath = $test;
                    $inOBD = true;
                    break;
                }
            }

            if ($inOBD == false) {
            // Return false for JFolder::create because the path to be created is not in open_basedir
                return false;
            }
        }

        // Just to make sure
        $inOBD = true;

        do {
            $dir = $path;

            while (!@ mkdir($dir, $mode)) {
                $dir = dirname($dir);

                if ($obd != null) {
                    if (strpos($dir, $obdpath) === false) {
                        $inOBD = false;
                            break 2;
                    }
                }
                if ($dir == '/' || is_dir($dir))
                    break;
            }
        }
        while ($dir != $path);

        // Reset umask
        @ umask($origmask);

        // If there is no open_basedir restriction this should always be true
        if ($inOBD == false) {
            // Return false for JFolder::create -- could not create path without violating open_basedir restrictions
            $ret = false;
        } else {
            $ret = true;
        }
		return $ret;
	}
	/**
	 * Delete a folder
	 * @param mixed The folder name
	 * @return boolean True on success
	 */
	function delete( $path ) {
        $path = JPath::clean( $path, false );
		JPath::check( $path );

        // Remove all the files in folder
		$files = JFolder :: files( $path, '.', false, true );
		JFile :: delete( $files );

		// Remove sub-folders of folder
		$folders = JFolder :: folders($path, '.', false, true);
		foreach ( $folders as $folder ) {
			JFolder :: delete( $folder );
		}
        // remove the folders
        return rmdir( $path );
	}
	
	/**
    * Rename a folder
    * @param string The path to the source folder
    * @param string The path to the destination folder
    * @return mixed
    */
    function rename( $src, $dest ) {

        global $cmnlang;
        $error = false;

        JPath::check( $src );
        JPath::check( $dest );

        if ( JFolder::exists( $src ) ) {
            if ( is_writable( dirname( $dest ) )) {
                if( !@JFolder::exists( $dest ) ){
                    if (!@rename( $src, $dest )) {
                        $error = $cmnlang['ren_err'];
              		}
                }else{
                    $error = $cmnlang['dir_exists_err'];
                }
            }else{
                $error = $cmnlang['dir_write_err'];
            }
        }else{
            $error = $cmnlang['no_source'];
        }
        return $error;
    }

	/** Wrapper for the standard file_exists function
	 * @param string filename relative to installation dir
	 * @return boolean
	 */
	function exists( $path ) {
   		$path = JPath::clean( $path, false );
		return is_dir( $path );
	}

	/**
	* Utility function to read the files in a directory
	* @param string The file system path
	* @param string A filter for the names
	* @param boolean Recurse search into sub-directories
	* @param boolean True if to prepend the full path to the file name
	* @return array
	*/
	function files( $path, $filter='.', $recurse=false, $fullpath=false  ) {
		$arr = array();
		$path = JPath::clean( $path, false );
		if (!is_dir( $path )) {
			return $arr;
		}

		// prevent snooping of the file system
		//JPath::check( $path );

		// read the source directory
		$handle = opendir( $path );
		$path .= DIRECTORY_SEPARATOR;
		while ($file = readdir( $handle )) {
			$dir = $path . $file;
			$isDir = is_dir( $dir );
			if ($file <> '.' && $file <> '..') {
				if ($isDir) {
					if ($recurse) {
						$arr2 = JFolder::files( $dir, $filter, $recurse, $fullpath );
						$arr = array_merge( $arr, $arr2 );
					}
				} else {
                    if( preg_match( "/$filter/", strtolower( $file ) ) ){
						if ($fullpath) {
							$arr[] = $path . $file;
						} else {
							$arr[] = $file;
						}
					}
				}
			}
		}
		closedir( $handle );
		asort( $arr );
		return $arr;
	}
	/**
	* Utility function to read the folders in a directory
	* @param string The file system path
	* @param string A filter for the names
	* @param boolean Recurse search into sub-directories
	* @param boolean True if to prepend the full path to the file name
	* @return array
	*/
	function folders( $path, $filter='.', $recurse=false, $fullpath=false  ) {
		$arr 	= array();
		$path 	= JPath::clean( $path, false );
		if (!is_dir( $path )) {
			return $arr;
		}

		// prevent snooping of the file system
		//mosFS::check( $path );

		// read the source directory
		$handle = opendir( $path );
		$path 	.= DIRECTORY_SEPARATOR;
		while ( $file = readdir( $handle ) ) {
			$dir 	= $path . $file;
			$isDir 	= is_dir( $dir );
			if ( ( $file <> '.' ) && ( $file <> '..' ) && $isDir ) {
				// removes CVS directores from list
				if ( preg_match( "/$filter/", $file ) && !( preg_match( "/CVS/", $file ) ) ) {
					if ( $fullpath ) {
						$arr[] = $dir;
					} else {
						$arr[] = $file;
					}
				}
				if ( $recurse ) {
					$arr2 = JFolder::folders( $dir, $filter, $recurse, $fullpath );
					$arr = array_merge( $arr, $arr2 );
				}
			}
		}
		closedir( $handle );
		asort( $arr );
		return $arr;
	}

	/**
	 * Lists folder in format suitable for tree display
	 */
	function listFolderTree( $path, $filter, $maxLevel=3, $level=0, $parent=0 ) {
		$dirs = array();
		if ($level == 0) {
			$GLOBALS['_JFolder_folder_tree_index'] = 0;
		}

		if ($level < $maxLevel) {
			JPath::check( $path );

			$folders = JFolder::folders( $path, $filter );

			// first path, index foldernames
			for ($i = 0, $n = count( $folders ); $i < $n; $i++) {
				$id = ++$GLOBALS['_JFolder_folder_tree_index'];
				$name = $folders[$i];
				$fullName = JPath::clean( $path . '/' . $name, false );
				$dirs[] = array(
					'id' => $id,
					'parent' => $parent,
					'name' => $name,
					'fullname' => $fullName,
					'relname' => str_replace( JPATH_ROOT, '', $fullName )
				);
				$dirs2 = JFolder::listFolderTree( $fullName, $filter, $maxLevel, $level+1, $id );
				$dirs = array_merge( $dirs, $dirs2 );
			}
		}

		return $dirs;
	}
	
	/**
    * New folder
    * @param string $dir The base dir
    * @param string $new_dir The folder to be created
    * @return string $error on failure
    */
    function newFolder( $base, $dir, $new_dir )
    {
        global $cmnlang;
	    $error = false;
        $folder = JPath::makePath( $dir, $new_dir );
        $folder = JPath::makePath( $base, $folder );
        if( !JFolder::createFolder( $folder ) ){
            $error = $cmnlang['new_dir_err'];
        }
        return $error;
    }
    /**
    * New folder base function. A wrapper for the JFolder::create function
    * @param string $folder The folder to create
    * @return boolean true on success
    */
    function createFolder( $folder )
    {
        if( @JFolder::create( $folder ) ){
            $html = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
            $file = $folder."/index.html";
            @JFile::write( $file, $html );
        }else{
            return false;
        }
        return true;
    }
}

/**
 * An Archive handling class
 *
 * @package Joomla
 * @static
 * @since 1.1
 */
class JArchive
{
	/**
	 * @param string The name of the archive
	 * @param mixed The name of a single file or an array of files
	 * @param string The compression for the archive
	 * @param string Path to add within the archive
	 * @param string Path to remove within the archive
	 * @param boolean Automatically append the extension for the archive
	 * @param boolean Remove for source files
	 */
	function create( $archive, $files, $compress='tar', $addPath='', $removePath='', $autoExt=false, $cleanUp=false ) {

		//jimport('archive.Tar');
		global $mosConfig_absolute_path;
		require( $mosConfig_absolute_path.'/includes/Archive/tar.php' );

		if (is_string( $files )) {
			$files = array( $files );
		}
		if ($autoExt) {
			$archive .= '.' . $compress;
		}

		$tar = new Archive_Tar( $archive, $compress );
		$tar->setErrorHandling( PEAR_ERROR_PRINT );
		$tar->createModify( $files, $addPath, $removePath );

		if ($cleanUp) {
			JFile::delete( $files );
		}
		return $tar;
	}
}

/**
 * A Path handling class
 * @package Joomla
 * @since 1.1
 */
class JPath {

    /**
    * Append a / to the path if required.
    * @param string $path the path
    * @return string path with trailing /
    */
    function fixPath( $path )
    {
        //append a slash to the path if it doesn't exists.
        if( !( substr( $path, -1 ) == '/' ) )
            $path .= '/';
        return $path;
    }
   	/**
    * Concat two paths together. Basically $pathA+$pathB
    * @param string $pathA path one
    * @param string $pathB path two
    * @return string a trailing slash combinded path.
    */
    function makePath( $pathA, $pathB )
    {
        $pathA = JPath::fixPath( $pathA );
        if( substr( $pathB, 0, 1 )  ==  '/' )
            $pathB = substr( $pathB, 1 );

        return $pathA.$pathB;
    }

    /**
	 * Checks if a files permissions can be changed
	 * @param string The file path
	 * @return boolean
	 */
	function canCHMOD( $file ) {
		$perms = fileperms( $file );
		if ($perms !== false)
			if (@chmod( $file, $perms ^ 0001 ) ) {
				@chmod( $file, $perms );
				return true;
			}
		return false;
	}

	/**
	* Chmods files and directories recursivel to given permissions
	* @param path The starting file or directory (no trailing slash)
	* @param filemode Integer value to chmod files. NULL = dont chmod files.
	* @param dirmode Integer value to chmod directories. NULL = dont chmod directories.
	* @return TRUE=all succeeded FALSE=one or more chmods failed
	*/
	function setPermissions( $path, $filemode=JPATH_FILEPEMS, $dirmode=JPATH_DIRPEMS ) {
		//mosFS::check( $path );

		$ret = TRUE;
		if (is_dir($path)) {
			$dh = opendir($path);
			while ($file = readdir($dh)) {
				if ($file != '.' && $file != '..') {
					$fullpath = $path.'/'.$file;
					if (is_dir($fullpath)) {
						if (!JPath::setPermissions( $fullpath, $filemode, $dirmode )) {
							$ret = FALSE;
						}
					} else {
						if (isset($filemode)) {
							if (!@chmod( $fullpath, $filemode )) {
								$ret = FALSE;
							}
						}
					} // if
				} // if
			} // while
			closedir($dh);
			if (isset($dirmode))
				if (!@chmod($path, $dirmode)) {
					$ret = FALSE;
				}
		} else {
			if (isset($filemode))
				$ret = @chmod($path, $filemode);
		} // if
		return $ret;
	}

	function getPermissions( $path ) {
		$path = JPath::clean( $path );
   		JPath::check( $path );
 		$mode = @decoct( @fileperms( $path ) & 0777 );

		if (strlen( $mode ) < 3) {
			return '---------';
		}
		$parsed_mode='';
		for ($i = 0; $i < 3; $i++) {
			// read
			$parsed_mode .= ($mode{$i} & 04) ? "r" : "-";
			// write
			$parsed_mode .= ($mode{$i} & 02) ? "w" : "-";
			// execute
			$parsed_mode .= ($mode{$i} & 01) ? "x" : "-";
		}
		return $parsed_mode;
	}

	/**
	 * Checks for snooping outside of the file system root
	 * @param string A file system path to check
	 */
	function check( $path ) {
		if (strpos( $path, '..' ) !== false) {
			JCEUtils::BackTrace();
			die( 'JPath::check use of relative paths not permitted' ); // don't translate
		}
		if (strpos( JPath::clean($path), JPATH_ROOT ) !== 0) {
			JCEUtils::mosBackTrace();
			die( 'JPath::check snooping out of bounds @ '.$path ); // don't translate
		}
	}

	/**
	 * Function to strip additional / or \ in a path name
	 * @param string The path
	 * @param boolean Add trailing slash
	 */
	function clean( $p_path, $p_addtrailingslash=true ) {
		$retval = '';
		$path = trim( $p_path );

		if (empty( $p_path )) {
			$retval = JPATH_ROOT;
		} else {
			if (JPATH_ISWIN)	{
				$retval = str_replace( '/', DIRECTORY_SEPARATOR, $p_path );
				// Remove double \\
				$retval = str_replace( '\\\\', DIRECTORY_SEPARATOR, $retval );
			} else {
				$retval = str_replace( '\\', DIRECTORY_SEPARATOR, $p_path );
				// Remove double //
				$retval = str_replace('//',DIRECTORY_SEPARATOR,$retval);
			}
		}
		if ($p_addtrailingslash) {
			if (substr( $retval, -1 ) != DIRECTORY_SEPARATOR) {
				$retval .= DIRECTORY_SEPARATOR;
			}
		}

		return $retval;
	}
}
//Utilities Class
class JCEUtils
{	
    /**
    * Format the file size, limits to Mb.
    * @param int $size the raw filesize
    * @return string formated file size.
    */
    function formatSize($size)
    {
        if( $size < 1024 )
            return $size.' bytes';
        else if( $size >= 1024 && $size < 1024*1024 )
            return sprintf('%01.2f',$size/1024.0).' Kb';
        else
            return sprintf( '%01.2f', $size/(1024.0*1024) ).' Mb';
    }
   	/**
  	* Format the date.
    * @param int $date the unix datestamp
    * @return string formated date.
    */
   	function formatDate( $date )
   	{
        return date( "d/m/Y,H:i", $date );
   	}
   	/**
     * Format a backtrace error
     * @since 1.1
     */
    function BackTrace() {
    	if (function_exists( 'debug_backtrace' )) {
    		echo '<div align="left">';
    		foreach( debug_backtrace() as $back) {
    			if (@$back['file']) {
    				echo '<br />' . str_replace( JPATH_ROOT, '', $back['file'] ) . ':' . $back['line'];
    			}
    		}
    		echo '</div>';
    	}
    }
    function userDir( $base_dir, $type, $level, $name ){
        global $mosConfig_absolute_path;
        switch( $type )
        {
            case 'level' :
                $folder = JPath::makePath( $mosConfig_absolute_path, $base_dir );
                $folder = JPath::makePath( $folder, JFile::makeSafe( $level ) );
                if( !JFolder::exists( $folder ) ){
                    JFolder::createFolder( $folder );
                }
            break;
            case 'name' :
                $folder = JPath::makePath( $mosConfig_absolute_path, $base_dir );
                $folder = JPath::makePath( $folder, JFile::makeSafe( $name ) );
                if( !JFolder::exists( $folder ) ){
                    JFolder::createFolder( $folder );
                }
            break;
            case 'level_name' :
                $folder = JPath::makePath( $mosConfig_absolute_path, $base_dir );
                $folder = JPath::makePath( $folder, JFile::makeSafe( $level ) );
                $folder = JPath::makePath( $folder, JFile::makeSafe( $name ) );
                if( !JFolder::exists( $folder ) ){
                    JFolder::createFolder( $folder );
                }
            break;
        }
        return str_replace(  $mosConfig_absolute_path, '', $folder );
    }

}
class JCEHTML
{
	/*
	* build the select list for target window
	*/
	function Target() {
	  	global $cmnlang;
	  	$click[] = mosHTML::makeOption( '_blank', ''.$cmnlang['blank'].'' );
		$click[] = mosHTML::makeOption( '_self', ''.$cmnlang['self'].'' );
		$click[] = mosHTML::makeOption( '_parent', ''.$cmnlang['parent'].'' );
		$click[] = mosHTML::makeOption( '_top', ''.$cmnlang['top'].'' );
		$target = mosHTML::selectList( $click, 'targetlist', 'id="targetlist"', 'value', 'text' );
		return $target;
	}
	/*
	* build the select list for align window
	*/
	function Align( $option ) {
	  	global $cmnlang;
	  	$click[] = mosHTML::makeOption( '', ''.$cmnlang['align_default'].'' );
	  	$click[] = mosHTML::makeOption( 'baseline', ''.$cmnlang['align_baseline'].'' );
		$click[] = mosHTML::makeOption( 'top', ''.$cmnlang['align_top'].'' );
		$click[] = mosHTML::makeOption( 'middle', ''.$cmnlang['align_middle'].'' );
		$click[] = mosHTML::makeOption( 'bottom', ''.$cmnlang['align_bottom'].'' );
		$click[] = mosHTML::makeOption( 'texttop', ''.$cmnlang['align_texttop'].'' );
		$click[] = mosHTML::makeOption( 'absmiddle', ''.$cmnlang['align_absmiddle'].'' );
		$click[] = mosHTML::makeOption( 'absbottom', ''.$cmnlang['align_absbottom'].'' );
		$click[] = mosHTML::makeOption( 'left', ''.$cmnlang['align_left'].'' );
		$click[] = mosHTML::makeOption( 'right', ''.$cmnlang['align_right'].'' );
		$align = mosHTML::selectList( $click, 'align', 'id="align"'.$option.'', 'value', 'text' );
		return $align;
	}
	
	//Creates a Colour Picker Instance
    function colourPicker( $colblock, $colval, $defcolour, $onchange='' )
    {
        global $lib_url;
		echo"#<input type=\"text\" size=\"8\" name=\"$colval\" id=\"$colval\" value=\"$defcolour\" onchange=\"$onchange\" style=\"vertical-align:middle; padding:1px;\" />&nbsp;";
        echo"<img src=\"$lib_url/images/color.gif\" alt=\"Colour Picker\" title=\"Colour Picker\" width=\"20\" height=\"20\" onclick=\"colourPicker('$colval', '$colblock', document.getElementById('$colval').value);\" id=\"$colblock\" style=\"background-color:#$defcolour; cursor:pointer; vertical-align:middle;\" />";
    }
}
?>
