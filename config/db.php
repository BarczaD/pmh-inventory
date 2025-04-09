<?php

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost:3306;dbname=pmh-inventory',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

return $config;
