<?php
const DB_HOST = 'MySQL-8.0:3306';
const DB_NAME = 'php_kurdina';
const DB_USER = 'root';
const DB_PASS = '';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>