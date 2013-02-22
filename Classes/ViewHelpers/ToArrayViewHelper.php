<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Steffen Ritter <steffen.ritter@typo3.org>
*
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Simple page browser that splits all results to only show the
 * ones from the current page, and then sets additional variables
 * that can be used to create next/previous links
 *
 * @author	Steffen Ritter <steffen.ritter@typo3.org>
 *
 */
class Tx_MediaGallery_ViewHelpers_ToArrayViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * main render function
	 *
	 * @param mixed $object
	 * @return array
	 */
	public function render($object) {
		$data = array();

		if (is_object($object)) {
			if (method_exists($object, 'toArray')) {
				$data = $object->toArray();
			} else {
				$data = (array)$object;
			}
		} elseif (is_array($object)) {
			$data = &$object;
		} else {
			$data = array($object);
		}
		return $data;
	}

}

?>