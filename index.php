<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 *
 * We can not use only one entry point.
 * Instead use one entry point, we need to include this to every page.
 */
error_reporting(E_ALL);

$cmsDir = __DIR__;
$config = [
    'cmsDir'        => $cmsDir,
    'pubDir'        => __DIR__,
    'viewsDir'      => $cmsDir.'/views',
    'migrationsDir' => $cmsDir.'/migrations',
    'baseTitle'     => 'T&C Admin',
    'db'            => [
        'file' => $cmsDir.'/main.db',
    ],
];

require(__DIR__."/vendor/autoload.php");

// Main \core\Core
$core = \core\Core::getInstance();

// Core configuration
$core->config($config);
