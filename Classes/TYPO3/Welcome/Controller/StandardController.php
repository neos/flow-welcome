<?php
namespace TYPO3\Welcome\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Welcome".               *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Controller with a welcome start screen for Flow
 *
 */
class StandardController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\Flow\Package\PackageManagerInterface
	 * @Flow\Inject
	 */
	protected $packageManager;

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('flowPathRoot', realpath(FLOW_PATH_ROOT));
		$this->view->assign('flowPathWeb', realpath(FLOW_PATH_WEB));
		$this->view->assign('isMyPackageActive', $this->packageManager->isPackageActive('MyCompany.MyPackage'));

		$baseUri = $this->request->getHttpRequest()->getBaseUri();
		$this->view->assign('baseUri', $baseUri);

		$this->view->assign('isWindows', DIRECTORY_SEPARATOR !== '/');

		$flowPackage = $this->packageManager->getPackage('TYPO3.Flow');
		$version = $flowPackage->getPackageMetaData()->getVersion();
		$this->view->assign('version', $version);

		$activePackages = $this->packageManager->getActivePackages();
		$this->view->assign('activePackages', $activePackages);

		$this->view->assign('notDevelopmentContext', !$this->objectManager->getContext()->isDevelopment());
	}

	/**
	 * @return void
	 */
	public function redirectAction() {
		$this->redirect('index');
	}
}

?>