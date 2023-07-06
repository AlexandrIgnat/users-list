<?php

namespace App\controllers;

use PDO;

class DbConnection
{
    private static PDO $pdo;

    /**
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        $config = include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
        $config = $config['database'];
        self::$pdo = new PDO("mysql:dbname={$config['database']};host=127.0.0.1;charset={$config['charset']};", "{$config['username']}", "{$config['password']}");

        return self::$pdo;
    }
}