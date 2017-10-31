/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: fckplugin.js
 * 	Plugin definition file.
 * 
 * Version:  2.0 RC2
 * Modified: 2004-11-22 11:20:10
 * 
 * File Authors:
 * 		Angel Franco Calixto (a_d_baco@yahoo.com)
 */

// Register the related commands.
FCKCommands.RegisterCommand( 'MosButtons', new FCKDialogCommand( 'MosButtons', FCKLang.DlgMosButtonsTitle	, FCKConfig.PluginsPath + 'mos/fck_mosButtons.html'	, 250, 150, FCK.GetNamedCommandState, 'InsertImage' ) ) ;

// Create the "MosButtons" toolbar button.
var oMosButtonsItem		= new FCKToolbarButton( 'MosButtons', FCKLang['DlgMosButtonsTitle'] ) ;
oMosButtonsItem.IconPath	= FCKConfig.PluginsPath + 'mos/favicon.gif' ;

FCKToolbarItems.RegisterItem( 'MosButtons', oMosButtonsItem ) ;	// 'MosButtons' is the name used in the Toolbar config.

