<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Benjamin Mack (benni@typo3.org)
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
 * @author	Benjamin Mack <benni@typo3.org>
 *
 */
class Tx_MediaGallery_ViewHelpers_PagebrowserViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * main render function
	 *
	 * @param array $completeItemList an array containing all items
	 * @param integer $itemsPerPage an array containing all items
	 * @param string $shownItemList the name of the variable that will contain all items that should be shown
	 * @param string $previousPage the name of the variable that contains the prev page number
	 * @param string $nextPage the name of the variable that contains the next page number
	 * @return string the content
	 */
	public function render(array $completeItemList, $itemsPerPage, $shownItemList, $previousPage, $nextPage) {
		$templateVariableContainer = $this->renderingContext->getTemplateVariableContainer();
		$nextPageValue = 0;
		if ($itemsPerPage > 0) {

				// find the current page
			$currentPage = 1;
			if ($this->renderingContext->getControllerContext()->getArguments()->hasArgument('page')) {
				$currentPage = $this->renderingContext->getControllerContext()->getArguments()->getArgument('page')->getValue();
				$currentPage = intval($currentPage);
			}
	
				// cut down the whole items
			$startPosition = ($currentPage-1) * $itemsPerPage;
			$shownItemListValue = array_slice($completeItemList, $startPosition, $itemsPerPage, TRUE);
			
			if (count($completeItemList) > ($currentPage * $itemsPerPage)) {
				$nextPageValue = $currentPage+1;
			}
		} else {
			$shownItemListValue = $completeItemList;
		}

			// add the new variables
		$templateVariableContainer->add($shownItemList, $shownItemListValue);
		$templateVariableContainer->add($previousPage, $currentPage-1);
		$templateVariableContainer->add($nextPage, $nextPageValue);
		
			// render the content
		$content = $this->renderChildren();

			// remove the new variables
		$templateVariableContainer->remove($shownItemList);
		$templateVariableContainer->remove($previousPage);
		$templateVariableContainer->remove($nextPage);

		return $content;
	}

}

?>