<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Config
{
    private static $pdo;

    public static function getConnection()
    {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();

            $dbName = $_ENV['DB_NAME'];
            $userName = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $host = $_ENV['DB_HOST'];

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('ERROR: ' . $e->getMessage());
            }
        
        return self::$pdo;
    }
}

