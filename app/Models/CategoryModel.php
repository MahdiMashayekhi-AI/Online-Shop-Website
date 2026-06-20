<?php

namespace App\Models;

use Core\Model;
use PDO;

class CategoryModel extends Model{
    protected static string $table = "categories";

    public static function getAll(){
        if (self::$db === null) self::connect();

        return self::$db->query("
            SELECT c.*, COUNT(p.id) as products_count
            FROM " . static::$table . " c
            LEFT JOIN products p
                ON p.category_id = c.id
            GROUP BY c.id
            ORDER BY c.id DESC
        ")->fetchAll();
    }

    public static function getBySlug($slug){
        if (self::$db === null) self::connect();

        $query = self::$db->prepare(
            "SELECT id, slug 
         FROM " . static::$table . " 
         WHERE slug = ?
         LIMIT 1"
        );
        $query->execute([$slug]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function stats()
    {
        if (self::$db === null) self::connect();

        return self::$db->query("
            SELECT COUNT(*) AS total,
             SUM(is_active = 1) AS active,
             SUM(is_active = 0) AS inactive
            FROM " . static::$table)->fetch();
    }

    public static function popular($limit = 4) {
        if (self::$db === null) self::connect();

        return self::$db->query("
            SELECT c.*, COUNT(p.id) AS products_count
            FROM " . static::$table . " c
            LEFT JOIN products p
                ON p.category_id = c.id
                AND p.is_active = 1
            WHERE c.is_active = 1
            GROUP BY c.id
            ORDER BY products_count DESC
            LIMIT {$limit}")->fetchAll();
    }

    public static function active() {
        if (self::$db === null) self::connect();

        return self::$db->query("
                    SELECT * 
                    FROM " . static::$table . " 
                    WHERE is_active = 1 
                    ORDER BY name ASC")->fetchAll();
    }
}