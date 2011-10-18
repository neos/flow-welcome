<?php
namespace TYPO3\Welcome\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Welcome".                    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Controller with a welcome start screen for FLOW3
 *
 */
class StandardController extends \TYPO3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @var \TYPO3\FLOW3\Package\PackageManagerInterface
	 * @FLOW3\Inject
	 */
	protected $packageManager;

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('flow3PathRoot', realpath(FLOW3_PATH_ROOT));
		$this->view->assign('flow3PathWeb', realpath(FLOW3_PATH_WEB));
		$this->view->assign('isMyPackageActive', $this->packageManager->isPackageActive('MyCompany.MyPackage'));

		$baseUri = $this->request->getBaseUri();
		$this->view->assign('baseUri', $baseUri);

		$this->view->assign('isWindows', DIRECTORY_SEPARATOR !== '/');

		$flow3Package = $this->packageManager->getPackage('TYPO3.FLOW3');
		$version = $flow3Package->getPackageMetaData()->getVersion();
		$this->view->assign('version', $version);

		$activePackages = $this->packageManager->getActivePackages();
		$this->view->assign('activePackages', $activePackages);

		$this->view->assign('notDevelopmentContext', $this->objectManager->getContext() !== 'Development');
	}

	/**
	 * @return void
	 */
	public function redirectAction() {
		$this->redirect('index');
	}
}

?>