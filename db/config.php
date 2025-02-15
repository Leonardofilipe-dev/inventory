<?php
class Config
{
    const DB_NAME = 'inventory';
    const USER_NAME = 'root';
    const PASSWORD = '';
    const HOST = 'localhost';

    public static function getConnection()
    {
        try {
            $pdo = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME, self::USER_NAME, self::PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
}
