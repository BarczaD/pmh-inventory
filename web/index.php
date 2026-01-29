<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
error_reporting(E_ALL & ~E_DEPRECATED);

try {
    $application = new yii\web\Application($config);
    $application->run();
} catch (\Exception $e) {
    // Check if it's a DB error (including wrapped PDO exceptions)
    $isDbError = ($e instanceof \yii\db\Exception ||
        ($e->getPrevious() && $e->getPrevious() instanceof \PDOException));

    if (!$isDbError) {
        throw $e;
    }

    // Clear any output buffers
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    // Send the 503 status
    if (!headers_sent()) {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Retry-After: 300');
    }

    include __DIR__ . '/db_down.html';
    exit();
}

// REMOVED: (new yii\web\Application($config))->run(); <--- This was the culprit!