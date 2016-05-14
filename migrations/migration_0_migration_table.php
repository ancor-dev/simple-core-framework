<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 * This is main migration that create `migration` table.
 */

return [
    'up' => function ($conn) {
        /** @var \PDO $conn */
        $sql = "
            CREATE TABLE IF NOT EXISTS `migration` (
              `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
              `name` VARCHAR(255),
              `createdAt` INTEGER UNSIGNED
            )
        ";
        $conn->exec($sql);
    },
    'down' => function ($conn) {
        /** @var \PDO $conn */
        $sql = "DROP TABLE IF EXISTS `migration`";

        $conn->exec($sql);
    },
];
