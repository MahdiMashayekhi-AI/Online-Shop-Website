<?php

namespace App\Models;

use Core\Model;

class ContactModel extends Model{
    protected static string $table = "contact_messages";

    public static function getMessages(int $page = 1, int $perPage = 10)
    {
        if (self::$db === null) self::connect();

        $offset = ($page - 1) * $perPage;

        return self::$db->query("
            SELECT *
            FROM " . static::$table . "
            ORDER BY created_at DESC
            LIMIT {$perPage}
            OFFSET {$offset}
        ")->fetchAll();
    }

    public static function markAsRead(int $id)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            UPDATE " . static::$table . "
            SET is_read = 1
            WHERE id = ?
        ");

        return $query->execute([$id]);
    }

    public static function stats()
    {
        if (self::$db === null) self::connect();

        return self::$db->query("
            SELECT
                COUNT(*) AS total,
                SUM(is_read = 0) AS unread,
                SUM(is_read = 1) AS read_count
            FROM " . static::$table
        )->fetch();
    }
}