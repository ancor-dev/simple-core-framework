<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core\models;

use core\Core;

/**
 * Class MigrationManager
 * @package core\models
 */
class MigrationManager
{
    /**
     * Find all migrations file
     * @return string[]|null
     * @example: return array
     *         ```
     *         [
     *             'migration_0_migration_table' => ['time' => 0, 'name' => 'migration_table'],
     *             ...
     *         ]
     *         ```
     */
    public function findAllMigrations()
    {
        $migrationsDir = Core::$app->migrationsDir;
        if (!file_exists($migrationsDir)) {
            return null;
        }
        $migrationFiles = new \DirectoryIterator(Core::$app->migrationsDir);

        $migrations = [];
        foreach ($migrationFiles as $file) {
            $name = $file->getBasename('.php');
            if (!preg_match('/^migration_(\d+)_(.+)/', $name, $info)) {
                continue;
            }

            $migration = [];
            list($match, $migration['time'], $migration['name']) = $info;
            $migrations[$name] = $migration;
        }

        return $migrations;
    } // end findAllMigrations()

    /**
     * Do the migration
     *
     * @param int    $time
     * @param string $name
     * @param bool   $check don't check if the migration was apply or not
     *
     * @return bool
     */
    public function upOne($time, $name, $check = false)
    {
        $migration = $this->loadMigration($time, $name);
        if (!$migration) {
            return false;
        }

        if ($check) {
            $model = MigrationORM::findOneByMap(['createdAt' => $time, 'name' => $name]);
            if ($model) {
                return true;
            }
        }
        /** @var \Closure $closure */
        $closure = Core::pick($migration, 'up');
        if (!$closure) {
            return false;
        }
        $closure(Core::$app->db);
        $model = new MigrationORM([
            'createdAt' => $time,
            'name' => $name,
        ]);

        return $model->save();
    } // end upOne()

    /**
     * Undo the migration
     *
     * @param int    $time
     * @param string $name
     *
     * @return bool
     */
    public function downOne($time, $name)
    {
        $migration = $this->loadMigration($time, $name);
        if (!$migration) {
            return false;
        }

        $model = MigrationORM::findOneByMap(['createdAt' => $time, 'name' => $name]);
        if (!$model) {
            return true;
        }

        /** @var \Closure $closure */
        $closure = Core::pick($migration, 'down');
        if (!$closure) {
            return false;
        }
        $closure(Core::$app->db);

        return $model->delete();
    } // end downOne()

    /**
     * @inheritdoc
     */
    public function migrate()
    {
        if (!$this->isInit()) {
            $this->initMigrations();
        }

        $migrations = $this->findAllMigrations();
        foreach ($migrations as $mig) {
            $this->upOne($mig['time'], $mig['name']);
        }
    } // end migrate()

    /**
     * Apply a migration
     *
     * @param int    $time
     * @param string $name
     *
     * @return mixed[]|null migration or null if it doesn't exist
     */
    private function loadMigration($time, $name)
    {
        $file = Core::$app->migrationsDir."/migration_{$time}_{$name}.php";
        if (!file_exists($file)) {
            return null;
        }

        return include($file);
    } // end apply()

    /**
     * Check if migratino init(table `migration` created)
     * @return bool
     */
    private function isInit()
    {
        $sql = "SELECT 1 FROM `sqlite_master` WHERE `name` = 'migration' AND `type` = 'table'";
        $stmt = Core::$app->db->query($sql);

        return (bool) $stmt->fetch();
    } // end isInit()

    /**
     * Create migrations table
     */
    private function initMigrations()
    {
        $this->upOne(0, 'migration_table', false);
    } // end initMigrations()
}
