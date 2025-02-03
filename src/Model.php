<?php

namespace BaseProject;

use PDO;
use Exception;

abstract class Model {
    protected static string $table;

    public static function all(): array {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        $result = $stmt->fetchAll();

        Logger::log(static::$table, "SELECT", ["query" => "ALL"]);

        return $result;
    }

    public static function find(int $id): ?array {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        Logger::log(static::$table, "SELECT", ["id" => $id]);

        return $result ?: null;
    }

    public static function create(array $data): bool {
        $db = Database::connect();
        $keys = array_keys($data);
        $fields = implode(", ", $keys);
        $placeholders = ":" . implode(", :", $keys);

        $sql = "INSERT INTO " . static::$table . " ($fields) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $executed = $stmt->execute();
        
        if ($executed) {
            Logger::log(static::$table, "INSERT", $data);
        }

        return $executed;
    }

    public static function update(int $id, array $data): bool {
        $db = Database::connect();
        $fields = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

        $sql = "UPDATE " . static::$table . " SET $fields WHERE id = :id";
        $stmt = $db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $executed = $stmt->execute();

        if ($executed) {
            Logger::log(static::$table, "UPDATE", array_merge(["id" => $id], $data));
        }

        return $executed;

    }

    public static function delete(int $id): bool {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $executed = $stmt->execute();
        
        if ($executed) {
            Logger::log(static::$table, "DELETE", ["id" => $id]);
        }

        return $executed;
    }
}
