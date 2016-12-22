<?php
return [
    'dispatcher' => [
        // 'host' => getenv('R7_DISPATCHER_HOST'),
        // 'port' => getenv('R7_DISPATCHER_PORT'),
        'host' => "10.1.9.182",
        'port' => 10002
    ],
    'displayErrorDetails' => true,
    'addContentLengthHeader' => true,
    'db' => [
        'host' => '127.0.0.1',
        'user' => 'postgres',
        'pass' => 'postgres',
        'dbname' => 'filemanager'
    ]
];
