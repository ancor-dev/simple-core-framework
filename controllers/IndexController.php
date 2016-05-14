<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace controllers;

use core\Core;
use core\models\MigrationManager;
use PDO;

/**
 * Class IndexController
 * @package controllers
 */
class IndexController extends ControllerBase
{
    /**
     * Index page action
     */
    public function indexAction()
    {
        $this->setPageTitle('Home');

        return $this->render('index/index', [
        ]);

    } // end indexAction()

    /**
     * Logging out current user
     */
    public function logoutAction()
    {
        Core::$app->httpError(401, 'Logged out. <a href="/">Go to Site</a>', 'Logged out');
    } // end logoutAction()

    /**
     * Print any debug info
     */
    public function debugAction()
    {
    } // end debugAction()
}
