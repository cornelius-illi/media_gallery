<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Cornelius Illi <cornelius.illi@shintertuer.net>
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
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class tx_MediaGallery_Utility_LoadRegisteredHooks {
	
	/**
 	* returns an array of all semesters
 	*
 	* @param	array		$config: extension configuration array
 	* @return	array		$config array with extra codes merged in
 	*/
	public function user_loadRegisteredHooks($config) {
		$items = array();
		
		if(isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['media_gallery']['onReadyJS'])) {
			foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['media_gallery']['onReadyJS'] as $key => $userFunc) {
				$userFunc = $userFunc.'->getLabel';	
				$params = array();
				$label =  t3lib_div::callUserFunction($userFunc, $params, $this);
				$items[] = array( 0 => $label, 1 => $key);			
			}
		}
		
		$config['items'] = array_merge($config['items'] , $items);
		return $config;
	}
}

?>