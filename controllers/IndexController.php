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
        Core::$app->httpError(401, '<a href="/">Go to Site</a>', 'Logged out');
    } // end logoutAction()

    /**
     * Print any debug info
     */
    public function debugAction()
    {
//        $stmt = Core::$app->db->query("SELECT * FROM `sqlite_master` WHERE `name` = 'migration' AND `type` = 'table'");
//        $stmt = Core::$app->db->query("SELECT * FROM `migration`");
//        $stmt = Core::$app->db->exec("DELETE FROM migration WHERE id > 1");
//        $stmt = Core::$app->db->exec("DROP TABLE page");
        print_r($stmt->fetchAll(PDO::FETCH_OBJ));
//        $m = new MigrationManager();
//        $ms = $m->findAllMigrations();
//        print_r($ms);
    } // end debugAction()
}
