<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace controllers;

use core\Core;

/**
 * Worging with migrations
 * @package controllers
 */
class MigrationController extends ControllerBase
{

    /**
     * Migrate all migrations
     */
    public function migrateAction()
    {
        Core::$app->migration->migrate();

        return 'All migrations was applied';
    } // end migrateAction()

    /**
     * Unapply one migration by time and name
     */
    public function downOneAction()
    {
        $name = Core::$app->request->query('name');
        $time = Core::$app->request->query('time');

        if (!$name || !$time) {
            return 'Please specify the name of the migration';
        }

        if (Core::$app->migration->downOne($time, $name)) {
            return "Migration '{$time}_{$name}' successful canceled!";
        }

        return 'Error';
    } // end downOneAction()
}
