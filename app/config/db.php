<?php

$dbHost = getenv('DATABASE_HOST') ?? "localhost";
$dbName = getenv('DATABASE_NAME') ?? "app";

return [
    "class" => \app\core\Database::class,
    "dsn" => "mysql:host={$dbHost};dbname={$dbName}",
    'username' => getenv('DATABASE_USER') ?? 'root',
    'password' => getenv("DB_PASSWORD") ?? "app",
    'charset' => getenv("DB_CHARSET") ?? "utf8mb4",
];
