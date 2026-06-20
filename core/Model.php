<?php

namespace Core;

use PDO;
use PDOException;

class Model
{
    protected static ?PDO $db = null;
    protected static string $table;

    protected static function connect(): void
    {
        try {
            self::$db = new PDO("mysql:host=localhost;dbname=shop;charset=utf8;", "root", "");
        } catch (PDOException $e) {
            die("Error Connection " . $e->getMessage());
        }
    }

    public static function all()
    {
        if (self::$db === null) self::connect();

        $query = self::$db->query(
            "SELECT * FROM " . static::$table
        );

        return $query->fetchAll();
    }

    public static function find(int $id)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare(
            "SELECT * FROM " . static::$table . " WHERE id = ? LIMIT 1"
        );

        $query->execute([$id]);

        return $query->fetch();
    }

    public static function select(string $columns = "*", array $where = [], array $orderBy = [], ?int $limit = null, ?int $offset = null)
    {
        if (self::$db === null) self::connect();

        $sql = "SELECT {$columns} FROM " . static::$table;

        $params = [];

        if (!empty($where)) {
            $conditions = [];

            foreach ($where as $column => $value) {
                $conditions[] = "{$column} = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!empty($orderBy) && isset($orderBy[0], $orderBy[1])) {
            $sql .= " ORDER BY {$orderBy[0]} {$orderBy[1]}";
        }

        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";

            if ($offset !== null) {
                $sql .= " OFFSET {$offset}";
            }
        }

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function count(array $where = [])
    {
        if (self::$db === null) self::connect();

        $sql = "SELECT COUNT(*) FROM " . static::$table;

        $params = [];

        if (!empty($where)) {

            $conditions = [];

            foreach ($where as $column => $value) {
                $conditions[] = "{$column} = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $query = self::$db->prepare($sql);
        $query->execute($params);

        return (int)$query->fetchColumn();
    }

    public static function insert(array $data)
    {
        if (self::$db === null) self::connect();

        $q = [];
        foreach ($data as $item) $q[] = "?";

        $query = self::$db->prepare(
            "INSERT INTO " . static::$table . " (" . implode(", ", array_keys($data)) . ") VALUES (" . implode(", ", $q) . ")"
        );
        return $query->execute(array_values($data));
    }

    public static function update(int $id, array $data)
    {
        if (self::$db === null) self::connect();

        $fields = [];

        foreach ($data as $column => $value) {
            $fields[] = "{$column} = ?";
        }

        $sql = "
        UPDATE " . static::$table . "
        SET " . implode(', ', $fields) . "
        WHERE id = ?
    ";

        $query = self::$db->prepare($sql);

        $values = array_values($data);
        $values[] = $id;

        return $query->execute($values);
    }

    public static function delete(int $id)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare(
            "DELETE FROM " . static::$table . " WHERE id = ?"
        );

        return $query->execute([$id]);
    }
}