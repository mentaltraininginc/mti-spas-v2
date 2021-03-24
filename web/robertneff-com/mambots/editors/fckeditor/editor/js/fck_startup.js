﻿/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * This file has been compacted for best loading performance.
 */
var NS;if (!(NS=window.parent.__FCKeditorNS)) NS=window.parent.__FCKeditorNS=new Object();
Array.prototype.addItem=function(item){var i=this.length;this[i]=item;return i;};Array.prototype.indexOf=function(value){for (var i=0;i<this.length;i++){if (this[i]==value) return i;};return-1;};String.prototype.startsWith=function(value){return (this.substr(0,value.length)==value);};String.prototype.endsWith=function(value,ignoreCase){var L1=this.length;var L2=value.length;if (L2>L1) return false;if (ignoreCase){var oRegex=new RegExp(value+'$','i');return oRegex.test(this);}else return (L2==0||this.substr(L1-L2,L2)==value);};String.prototype.remove=function(start,length){var s='';if (start>0) s=this.substring(0,start);if (start+length<this.length) s+=this.substring(start+length,this.length);return s;};String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,'');};String.prototype.ltrim=function(){return this.replace(/^\s*/g,'');};String.prototype.rtrim=function(){return this.replace(/\s*$/g,'');};String.prototype.replaceNewLineChars=function(replacement){return this.replace(/\n/g,replacement);}
FCK_STATUS_NOTLOADED=window.parent.FCK_STATUS_NOTLOADED=0;FCK_STATUS_ACTIVE=window.parent.FCK_STATUS_ACTIVE=1;FCK_STATUS_COMPLETE=window.parent.FCK_STATUS_COMPLETE=2;FCK_TRISTATE_OFF=window.parent.FCK_TRISTATE_OFF=0;FCK_TRISTATE_ON=window.parent.FCK_TRISTATE_ON=1;FCK_TRISTATE_DISABLED=window.parent.FCK_TRISTATE_DISABLED=-1;FCK_UNKNOWN=window.parent.FCK_UNKNOWN=-1000;FCK_TOOLBARITEM_ONLYICON=window.parent.FCK_TOOLBARITEM_ONLYTEXT=0;FCK_TOOLBARITEM_ONLYTEXT=window.parent.FCK_TOOLBARITEM_ONLYTEXT=1;FCK_TOOLBARITEM_ICONTEXT=window.parent.FCK_TOOLBARITEM_ONLYTEXT=2;FCK_EDITMODE_WYSIWYG=window.parent.FCK_EDITMODE_WYSIWYG=0;FCK_EDITMODE_SOURCE=window.parent.FCK_EDITMODE_SOURCE=1;
var FCKBrowserInfo;if (!(FCKBrowserInfo=NS.FCKBrowserInfo)){FCKBrowserInfo=NS.FCKBrowserInfo=new Object();var sAgent=navigator.userAgent.toLowerCase();FCKBrowserInfo.IsIE=(sAgent.indexOf("msie")!=-1);FCKBrowserInfo.IsGecko=!FCKBrowserInfo.IsIE;FCKBrowserInfo.IsSafari=(sAgent.indexOf("safari")!=-1);FCKBrowserInfo.IsNetscape=(sAgent.indexOf("netscape")!=-1);};
var FCKScriptLoader=new Object();FCKScriptLoader.IsLoading=false;FCKScriptLoader.Queue=new Array();FCKScriptLoader.AddScript=function(scriptPath){FCKScriptLoader.Queue[FCKScriptLoader.Queue.length]=scriptPath;if (!this.IsLoading) this.CheckQueue();};FCKScriptLoader.CheckQueue=function(){if (this.Queue.length>0){this.IsLoading=true;var sScriptPath=this.Queue[0];var oTempArray=new Array();for (i=1;i<this.Queue.length;i++) oTempArray[i-1]=this.Queue[i];this.Queue=oTempArray;this.LoadFile(sScriptPath);}else{this.IsLoading=false;if (this.OnEmpty) this.OnEmpty();};};if (FCKBrowserInfo.IsSafari){FCKScriptLoader.LoadFile=function(filePath){if (filePath.lastIndexOf('.css')>0){this.CheckQueue();return;};var oXmlRequest=new XMLHttpRequest();oXmlRequest.open("GET",filePath,false);oXmlRequest.send(null);if (oXmlRequest.status==200){try{eval(oXmlRequest.responseText);}catch (e){alert('Error parsing '+filePath+': '+e.message);};}else alert('Error loading '+filePath);this.CheckQueue();};}else{FCKScriptLoader.LoadFile=function(filePath){var e;if (filePath.lastIndexOf('.css')>0){e=document.createElement('LINK');e.rel='stylesheet';e.type='text/css';}else{e=document.createElement("script");e.type="text/javascript";};document.getElementsByTagName("head")[0].appendChild(e);if (e.tagName=='LINK'){if (FCKBrowserInfo.IsIE) e.onload=FCKScriptLoader_OnLoad;else FCKScriptLoader.CheckQueue();e.href=filePath;}else{e.onload=e.onreadystatechange=FCKScriptLoader_OnLoad;e.src=filePath;};};function FCKScriptLoader_OnLoad(){if (this.tagName=='LINK'||!this.readyState||this.readyState=='loaded') FCKScriptLoader.CheckQueue();};}
var FCKURLParams=new Object();var aParams=document.location.search.substr(1).preg_split('&');for (i=0;i<aParams.length;i++){var aParam=aParams[i].preg_split('=');var sParamName=aParam[0];var sParamValue=aParam[1];FCKURLParams[sParamName]=sParamValue;}
var FCK=new Object();FCK.Name=FCKURLParams['InstanceName'];FCK.Status=FCK_STATUS_NOTLOADED;FCK.EditMode=FCK_EDITMODE_WYSIWYG;var aElements=window.parent.document.getElementsByName(FCK.Name);var i=0;while (FCK.LinkedField=aElements[i++]){if (FCK.LinkedField.tagName=='INPUT'||FCK.LinkedField.tagName=='TEXTAREA') break;};var FCKTempBin=new Object();FCKTempBin.Elements=new Array();FCKTempBin.AddElement=function(element){var iIndex=FCKTempBin.Elements.length;FCKTempBin.Elements[iIndex]=element;return iIndex;};FCKTempBin.RemoveElement=function(index){var e=FCKTempBin.Elements[index];FCKTempBin.Elements[index]=null;return e;};FCKTempBin.Reset=function(){var i=0;while (i<FCKTempBin.Elements.length) FCKTempBin.Elements[i++]==null;FCKTempBin.Elements.length=0;}
var FCKConfig=FCK.Config=new Object();if (document.location.protocol=='file:'){FCKConfig.BasePath=document.location.pathname.substr(1);FCKConfig.BasePath=FCKConfig.BasePath.replace(/\\/gi,'/');FCKConfig.BasePath='file://'+FCKConfig.BasePath.substring(0,FCKConfig.BasePath.lastIndexOf('/')+1);}else{FCKConfig.BasePath=document.location.pathname.substring(0,document.location.pathname.lastIndexOf('/')+1);FCKConfig.FullBasePath=document.location.protocol+'//'+document.location.host+FCKConfig.BasePath;};FCKConfig.EditorPath=FCKConfig.BasePath.replace(/editor\/$/,'');FCKConfig.ProcessHiddenField=function(){this.PageConfig=new Object();var oConfigField=window.parent.document.getElementById(FCK.Name+'___Config');if (!oConfigField) return;var aCouples=oConfigField.value.preg_split('&');for (var i=0;i<aCouples.length;i++){if (aCouples[i].length==0) continue;var aConfig=aCouples[i].preg_split('=');var sKey=unescape(aConfig[0]);var sVal=unescape(aConfig[1]);if (sKey=='CustomConfigurationsPath') FCKConfig[sKey]=sVal;else if (sVal.toLowerCase()=="true") this.PageConfig[sKey]=true;else if (sVal.toLowerCase()=="false") this.PageConfig[sKey]=false;else if (!isNaN(sVal)) this.PageConfig[sKey]=parseInt(sVal);else this.PageConfig[sKey]=sVal;};};FCKConfig.LoadPageConfig=function(){for (var sKey in this.PageConfig) FCKConfig[sKey]=this.PageConfig[sKey];};FCKConfig.ToolbarSets=new Object();FCKConfig.Plugins=new Object();FCKConfig.Plugins.Items=new Array();FCKConfig.Plugins.Add=function(name,langs,path){FCKConfig.Plugins.Items.addItem([name,langs,path]);}
var FCKeditorAPI;function FCKeditorAPI_GetInstance(instanceName){return this.__Instances[instanceName];};if (!window.parent.FCKeditorAPI){FCKeditorAPI=window.parent.FCKeditorAPI=new Object();FCKeditorAPI.__Instances=new Object();FCKeditorAPI.Version='2.0';FCKeditorAPI.GetInstance=FCKeditorAPI_GetInstance;}else FCKeditorAPI=window.parent.FCKeditorAPI;FCKeditorAPI.__Instances[FCK.Name]=FCK;
function Window_OnContextMenu(e){if (e) e.preventDefault();else{if (event.srcElement==document.getElementById('eSourceField')) return true;};return false;};window.document.oncontextmenu=Window_OnContextMenu;if (FCKBrowserInfo.IsGecko){function Window_OnResize(){var oFrame=document.getElementById('eEditorArea');oFrame.height=0;var oCell=document.getElementById(FCK.EditMode==FCK_EDITMODE_WYSIWYG?'eWysiwygCell':'eSource');var iHeight=oCell.offsetHeight;oFrame.height=iHeight-2;};window.onresize=Window_OnResize;};if (FCKBrowserInfo.IsIE){var aCleanupDocs=new Array();aCleanupDocs[0]=document;function Window_OnBeforeUnload(){var d,e;var j=0;while (d=aCleanupDocs[j++]){var i=0;while (e=d.getElementsByTagName("DIV").item(i++)){if (e.FCKToolbarButton) e.FCKToolbarButton=null;if (e.FCKSpecialCombo) e.FCKSpecialCombo=null;if (e.Command) e.Command=null;};i=0;while (e=d.getElementsByTagName("TR").item(i++)){if (e.FCKContextMenuItem) e.FCKContextMenuItem=null;};aCleanupDocs[j]=null;};if (typeof(FCKTempBin)!='undefined') FCKTempBin.Reset();};window.attachEvent("onunload",Window_OnBeforeUnload);};function Window_OnLoad(){if (FCKBrowserInfo.IsNetscape) document.getElementById('eWysiwygCell').style.paddingRight='2px';LoadConfigFile();};window.onload=Window_OnLoad;function LoadConfigFile(){FCKScriptLoader.OnEmpty=ProcessHiddenField;FCKScriptLoader.AddScript('../fckconfig.js');};function ProcessHiddenField(){FCKConfig.ProcessHiddenField();LoadCustomConfigFile();};function LoadCustomConfigFile(){if (FCKConfig.CustomConfigurationsPath.length>0){FCKScriptLoader.OnEmpty=LoadPageConfig;FCKScriptLoader.AddScript(FCKConfig.CustomConfigurationsPath);}else{LoadPageConfig();};};function LoadPageConfig(){FCKConfig.LoadPageConfig();LoadStyles();};function LoadStyles(){FCKScriptLoader.OnEmpty=LoadScripts;FCKScriptLoader.AddScript(FCKConfig.SkinPath+'fck_editor.css');FCKScriptLoader.AddScript(FCKConfig.SkinPath+'fck_contextmenu.css');};function LoadScripts(){FCKScriptLoader.OnEmpty=null;if (FCKBrowserInfo.IsIE) FCKScriptLoader.AddScript('js/fckeditorcode_ie_1.js');else FCKScriptLoader.AddScript('js/fckeditorcode_gecko_1.js');};function LoadLanguageFile(){FCKScriptLoader.OnEmpty=LoadEditor;FCKScriptLoader.AddScript('lang/'+FCKLanguageManager.ActiveLanguage.Code+'.js');};function LoadEditor(){FCKScriptLoader.OnEmpty=null;if (FCKLang) window.document.dir=FCKLang.Dir;FCK.StartEditor();}
