<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// adds processing for onReady rendering hooks that will be displayed withn the plugin elements
include_once(t3lib_extMgm::extPath($_EXTKEY).'Classes/Utility/LoadRegisteredHooks.php');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Gallery',
	'LLL:EXT:media_gallery/Resources/Private/Language/locallang_db.xml:tx_mediagallery_plugin_label'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . gallery;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_gallery.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Media Gallery');

?>