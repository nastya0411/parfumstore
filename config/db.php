<?php
if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] == "parfumstore.infobox.vip") {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=diplom_parfum',
        // 'username' => 'parfum',
        // 'password' => '5R9-Brq-uth-dda',
        // scrLwiG6Ec9D7ETn3vLi
        'username' => 'parfum',
        'password' => '5R9-Brq-uth-dda',
        'charset' => 'utf8',
        // Schema cache options (for production environment)
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ];
}

if (str_contains(__DIR__, "home")) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=MariaDB-11.2;dbname=diplom_parfum',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ];
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=diplom_parfum',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
