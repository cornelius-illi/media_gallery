<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Gallery',
	array(
		'Gallery' => 'list,showGallery,showImage',
		
	),
	// non-cacheable actions
	array(
		'Image' => '',
		
	)
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['onReadyJS']['colorbox'] = t3lib_extMgm::siteRelPath($_EXTKEY).'Classes/Hooks/ColorBoxHook.php:Tx_MediaGallery_Hooks_ColorBoxHook';

?>