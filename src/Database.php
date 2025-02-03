<?php

namespace BaseProject;

use PDO;
use PDOException;
use Exception;
use Dotenv\Dotenv;

class Database {
    private static ?PDO $connection = null; 

    public static function connect(): PDO {
        if (self::$connection === null) {
            try {
                // Carrega as variáveis do .env
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
                $dotenv->load();

                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASS'];
                $charset = $_ENV['DB_CHARSET'];

                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => true
                ];

                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new Exception("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function disconnect(): void {
        self::$connection = null;
    }
}
