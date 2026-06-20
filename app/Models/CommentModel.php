<?php

namespace App\Models;

use Core\Model;

class CommentModel extends Model{
    protected static string $table = "comments";

    public static function getByProduct(int $productId)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            SELECT c.*, u.full_name
            FROM " . static::$table . " c
            JOIN users u
            ON c.user_id = u.id
            WHERE c.product_id = ?
            ORDER BY c.created_at DESC
        ");

        $query->execute([$productId]);
        return $query->fetchAll();
    }

    public static function getAverageRating(int $productId)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            SELECT AVG(rating) AS average_rating
            FROM " . static::$table . "
            WHERE product_id = ?
        ");

        $query->execute([$productId]);
        return $query->fetch();
    }
}