<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 * Page table
 */

return [
    'up' => function ($conn) {
        /** @var \PDO $conn */
        $sql = "
            CREATE TABLE IF NOT EXISTS `page` (
              `id` INTEGER PRIMARY KEY AUTOINCREMENT,
              `name` VARCHAR(255),
              `title` VARCHAR(255),
              `description` VARCHAR(255),
              `keywords` VARCHAR(255),
              UNIQUE (`name`)
            )
        ";
        $conn->exec($sql);
    },
    'down' => function ($conn) {
        /** @var \PDO $conn */
        $sql = "DROP TABLE IF EXISTS `page`";
        $conn->exec($sql);
    },
];
