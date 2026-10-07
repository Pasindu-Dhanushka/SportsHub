<?php
return [
    'host' => getenv('DB_HOST') ?: 'sql106.infinityfree.com',
    'port' => getenv('DB_PORT') ?: '3306',
    'database' => getenv('DB_DATABASE') ?: 'if0_43113395_sportshub',
    'username' => getenv('DB_USERNAME') ?: 'if0_43113395',
    'password' => getenv('DB_PASSWORD') ?: 'si5NxFnYIS',
    'charset' => 'utf8mb4',
];