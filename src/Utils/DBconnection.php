<?php

declare(strict_types=1);

namespace App\Utils;

class DBconnection
{
    protected static \PDO $instance;

    protected static string $host = 'localhost';

    protected static string $user = 'vitor';

    protected static string $password = "senha123";

    protected static string $db = 'testdb';

    protected static int $port = 3306;

    public function __construct()
    {
        if (!isset(self::$instance)) {
            $dsn = sprintf('mysql:host=%s;dbname=%s', self::$host, self::$db);
            self::$instance = new \PDO($dsn, self::$user, self::$password);
            return;
        }
    }
}
