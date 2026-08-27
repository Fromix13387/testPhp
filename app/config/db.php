<?php

$dbHost = getenv('DB_HOST') ?: "localhost";
$dbName = getenv('DB_NAME') ?: "app";

return [
    "class" => \app\core\Database::class,
    "dsn" => "mysql:host={$dbHost};dbname={$dbName}",
    'username' => getenv('DB_USER') ?: 'user',
    'password' => getenv("DB_PASSWORD") ?: "user",
    'charset' => getenv("DB_CHARSET") ?: "utf8mb4",
];
