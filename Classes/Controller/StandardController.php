<?php
namespace Neos\Welcome\Controller;

/*
 * This file is part of the Neos.Welcome package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Package\PackageManager;

/**
 * Controller with a welcome start screen for Flow
 */
class StandardController extends \Neos\Flow\Mvc\Controller\ActionController
{
    /**
     * @Flow\Inject
     * @var PackageManager
     */
    protected $packageManager;

    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('flowPathRoot', realpath(FLOW_PATH_ROOT));
        $this->view->assign('flowPathWeb', realpath(FLOW_PATH_WEB));
        $this->view->assign('isPackageAvailable', $this->packageManager->isPackageAvailable('MyCompany.MyPackage'));

        $baseUri = $this->request->getHttpRequest()->getUri()->withPath('/')->withQuery('')->withFragment('');
        $this->view->assign('baseUri', $baseUri);

        $this->view->assign('isWindows', DIRECTORY_SEPARATOR !== '/');

        $flowPackage = $this->packageManager->getPackage('Neos.Flow');
        $version = $flowPackage->getInstalledVersion();
        $this->view->assign('version', $version);

        $availablePackages = $this->packageManager->getAvailablePackages();
        $this->view->assign('availablePackages', $availablePackages);

        $this->view->assign('notDevelopmentContext', !$this->objectManager->getContext()->isDevelopment());
    }

    /**
     * @return void
     */
    public function redirectAction()
    {
        $this->redirect('index');
    }
}
