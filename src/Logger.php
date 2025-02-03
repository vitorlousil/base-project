<?php

namespace BaseProject;

use PDO;
use Exception;

class Logger {
    private static string $logFile = __DIR__ . '/../logs/db.log';

    public static function log(string $table, string $action, array $data): void {
        try {
            $db = Database::connect();
            $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

            // Registra no banco de dados
            $stmt = $db->prepare("INSERT INTO logs (tabela, acao, dados) VALUES (:table, :action, :data)");
            $stmt->execute([
                ":table" => $table,
                ":action" => $action,
                ":data" => $jsonData
            ]);

            // Registra no arquivo de log
            $logEntry = "[" . date("Y-m-d H:i:s") . "] [$table] [$action] $jsonData" . PHP_EOL;
            file_put_contents(self::$logFile, $logEntry, FILE_APPEND);
        } catch (Exception $e) {
            file_put_contents(self::$logFile, "Erro ao gravar log: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }
}
