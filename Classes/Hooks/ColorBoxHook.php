<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Cornelius Illi <cornelius.illi@hintertuer.net>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * @author	Cornelius Illi <cornelius.illi@hintertuer.net>
 * @package media_gallery
 */
class Tx_MediaGallery_Hooks_ColorBoxHook {
	
	/**
	 * the jQuery code, that is being put in the onReady-statement 
	 * @param unknown_type $fileCollectionId
	 * @param unknown_type $settings
	 * @return string
	 */
	function getOnReadyJS($params, &$Obj) {
		return 'jQuery(".tx-mediagallery-lightbox-' . $params['fileCollectionId'] . '").colorbox({
					maxWidth: ' . intval($params['settings']['single']['image']['width']) . ',
					maxHeight: ' . intval($params['settings']['single']['image']['width']) . ',
					current: "' . Tx_Extbase_Utility_Localization::translate('LLL:EXT:media_gallery/Resources/Private/Language/locallang.xml:lightbox.current', 'media_gallery') . '"
				});';
	}
	
	/**
	 * the localized label
	 * @return string
	 */
	function getLabel() {
		return 'Lightbox (jQuery Colorbox)';
	}
	
	function injectSettings() {
		return array();
	}
}