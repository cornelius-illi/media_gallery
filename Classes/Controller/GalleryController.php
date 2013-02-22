<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ingmar Schlecht <ingmar@typo3.org>, TYPO3 Association
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 *
 *
 * @package media_gallery
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_MediaGallery_Controller_GalleryController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * fileCollectionRepository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 */
	protected $fileCollectionRepository;


	/**
	 * fileRepository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 */
	protected $fileRepository;


	/**
	 * Inject file collection repository
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileCollectionRepository $fileCollectionRepository
	 * @return void
	 */
	public function injectFileCollectionRepository(\TYPO3\CMS\Core\Resource\FileCollectionRepository $fileCollectionRepository) {
		$this->fileCollectionRepository = $fileCollectionRepository;
	}

	/**
	 * Inject file repository
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileRepository $fileRepository
	 * @return void
	 */
	public function injectFileRepository(\TYPO3\CMS\Core\Resource\FileRepository $fileRepository) {
		$this->fileRepository = $fileRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$fileCollections = $this->getAvailableFileCollections();

			// redirect to the single-gallery view if there is only one collection and this one
			// is actually set by the settings (flexforms or TS)
		if (count($fileCollections) === 1 && $this->settings['fileCollections'] != '') {
			$fileCollection = reset($fileCollections);
			$this->forward('showGallery', NULL, NULL, array('fileCollectionUid' => $fileCollection->getIdentifier()));
		}

		$this->view->assign('fileCollections', $fileCollections);
	}

	/**
	 * Show all images of a single collection
	 *
	 * @param int $fileCollectionUid
	 * @param int $page the page number
	 * @return void
	 */
	public function showGalleryAction($fileCollectionUid, $page = 1) {
		$fileCollections = $this->getAvailableFileCollections();
		$showOverviewLink = !(count($fileCollections) === 1 && $this->settings['fileCollections'] != '');

		/** @var $fileCollection t3lib_file_Collection_StaticFileCollection */
		$fileCollection = $this->fileCollectionRepository->findByUid($fileCollectionUid);
		$fileCollection->loadContents();
		
		$this->view->assign('fileCollection', $fileCollection);
		$this->view->assign('showOverviewLink', $showOverviewLink);
		$this->view->assign('galleryUid', $fileCollectionUid);
		
		$hook = array(); // to allow conditional logic in templates <f:if condition="{settings.onreadyjs} == {hooks.slider}"
		$extKey = t3lib_div::camelCaseToLowerCaseUnderscored( $this->controllerContext->getRequest()->getControllerExtensionKey() );
		$onReadyJS = "";
		// Hook
		if(isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$extKey]['onReadyJS'])) {
			foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$extKey]['onReadyJS'] as $key => $userFunc) {
				$hook[$key] = $key; 
				if($key === $this->settings['onreadyjs']) {
					$params = array(
							'fileCollectionId' => $fileCollection->getIdentifier(),
							'settings' => $this->settings
					);
					
					// load onReady-code
					$onReadyFunc = $userFunc.'->getOnReadyJS';
					$onReadyJS = t3lib_div::callUserFunction($onReadyFunc, $params, $this);
				}				
			}
		}
		
		$this->view->assign('hook', $hook );
		
		if( !empty($onReadyJS) ) {
			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('tx-mediagallery-' . $fileCollection->getIdentifier(), '
					jQuery(document).ready(function() {
						'.$onReadyJS.'
					});
			');
		}		
	}


	/**
	 * Show single image
	 *
	 * @param int $singleItemIndex
	 * @param int $page the page number
	 * @return void
	 */
	public function showImageAction($singleItemIndex, $page = 1) {

		/** @var $fileCollection t3lib_file_Collection_StaticFileCollection */
		$fileCollection = $this->fileCollectionRepository->findByUid($this->request->getArgument('fileCollectionUid'));
		$fileCollection->loadContents();
		$this->view->assign('fileCollection', $fileCollection);

		$fileCollectionItems = $fileCollection->getItems();
		$galleryItem = $fileCollectionItems[$singleItemIndex];
		$this->view->assign('galleryItem', $galleryItem);
	}




	/**
	 * return all available image galeries for this plugin
	 *
	 * @return array of image galleries
	 */
	public function getAvailableFileCollections() {
		$fileCollections = array();
		$limitToFileCollections = $this->settings['fileCollections'];
		if ($limitToFileCollections) {
			$fileCollectionUids = t3lib_div::trimExplode(',', $limitToFileCollections);	
			foreach ($fileCollectionUids as $fileCollectionUid) {
				$fileCollections[] = $this->fileCollectionRepository->findByUid($fileCollectionUid);
			}
		} else {
			$fileCollections = $this->fileCollectionRepository->findAll();
		}
		return $fileCollections;
	}

}
?>