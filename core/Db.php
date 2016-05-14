<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

use PDO;

/**
 * Simple database for storing arrays and objects in file
 */
class Db
{
    /**
     * @var \PDO Connection instance
     */
    private static $conn;

    /**
     * Private constructor
     */
    private function __construct()
    {
    } // end __construct()

    /**
     * @inheritdoc
     * @return PDO
     */
    public static function getConnection()
    {
        if (static::$conn) {
            return static::$conn;
        }

        try {
            static::$conn = new PDO('sqlite:'.Core::$app->db['file']);
            static::$conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return static::$conn;
        } catch (\PDOException $e) {
            Core::$app->httpError(500, 'Can not connect to database');
        }

        return null;
    } // end getConnection()
}
