<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core\models;

use core\AbstractORM;

/**
 * Class Migration
 * @package core\models
 */
class MigrationORM extends AbstractORM
{
    /**
     * @var string migration name
     */
    public $name;
    /**
     * @var int creation date
     */
    public $createdAt;

    /**
     * @inheritdoc
     */
    public static function attributes()
    {
        return [
            'name',
            'createdAt',
        ];
    } // end attributes()

    /**
     * @inheritdoc
     */
    public static function table()
    {
        return 'migration';
    } // end table()
}
