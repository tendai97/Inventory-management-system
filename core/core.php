<?php
$fileData = pathinfo(__FILE__);
$normalizedPath = str_replace('\\', '/', $fileData['dirname']);
define('LOCAL_ROOT_PATH',
        substr($normalizedPath, 0, strlen($normalizedPath)-strlen('core')));

// Search first "/" occurrence
$slashPos = strpos(LOCAL_ROOT_PATH, '/');

if (substr($_SERVER['DOCUMENT_ROOT'], strlen($_SERVER['DOCUMENT_ROOT'])-1 ,1) == '/')
	$documentRoot = $_SERVER['DOCUMENT_ROOT'];
else
	$documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
//echo "-0-".SITE_NAME.$_SESSION[SITE_NAME]['language']."--";

define ('SITE_NAME',
        substr( $normalizedPath,
                strlen($documentRoot),
                strlen($normalizedPath)-strlen('core')-strlen($documentRoot)-1)
);
//echo "-0-".SITE_NAME.$_SESSION[SITE_NAME]['language']."--";
if (SITE_NAME == '') {
	define('SITE_NAME', $_SERVER['HTTP_HOST']);
	define('WEB_FOLDER', '/');
} else
	define('WEB_FOLDER', SITE_NAME.'/');
//echo ("COST:".LOCAL_ROOT_PATH."-".SITE_NAME."-".WEB_FOLDER."-".$_SERVER['DOCUMENT_ROOT']."<br />");
?>