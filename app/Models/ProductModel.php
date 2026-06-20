<?php

namespace App\Models;

use Core\Model;
use PDO;

class ProductModel extends Model{
    protected static string $table = "products";

    public static function search(string $keyword){
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            SELECT *
            FROM ". static::$table ." 
            WHERE name LIKE ?
            AND is_active = 1
        ");

        $query->execute(["%{$keyword}%"]);
        return $query->fetchAll();
    }

    public static function relatedProducts(int $categoryId, int $productId)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            SELECT *
            FROM ". static::$table ."
            WHERE category_id = ?
            AND id != ?
            LIMIT 4
        ");

        $query->execute([
            $categoryId,
            $productId
        ]);

        return $query->fetchAll();
    }

    public static function paginate(string $search, int $categoryId, int $page, int $perPage) {
        if (self::$db === null) self::connect();

        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT p.*, c.name AS category_name
            FROM ". static::$table." p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE 1=1
        ";

        $params = [];

        if ($search !== '') {
            $sql .= " AND p.name LIKE ?";
            $params[] = "%{$search}%";
        }

        if ($categoryId > 0) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }

        $sql .= "
            ORDER BY p.id DESC
            LIMIT {$perPage}
            OFFSET {$offset}
        ";

        $query = self::$db->prepare($sql);
        $query->execute($params);

        return $query->fetchAll();
    }

    public static function countAll(string $search, int $categoryId)
    {
        if (self::$db === null) self::connect();

        $sql = "
            SELECT COUNT(*) AS total
            FROM ". static::$table ."
            WHERE 1=1
        ";

        $params = [];

        if ($search !== '') {
            $sql .= " AND name LIKE ?";
            $params[] = "%{$search}%";
        }

        if ($categoryId > 0) {
            $sql .= " AND category_id = ?";
            $params[] = $categoryId;
        }

        $query = self::$db->prepare($sql);
        $query->execute($params);

        return (int)$query->fetch()['total'];
    }

    public static function stats()
    {
        if (self::$db === null) self::connect();

        $query = self::$db->query("
            SELECT
                COUNT(*) AS total,
                SUM(stock > 0) AS in_stock,
                SUM(stock = 0) AS out_stock,
                SUM(discounted_price IS NOT NULL) AS discounted
            FROM ". static::$table
        );

        return $query->fetch();
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

    public static function getDashboardStats() {
        if (self::$db === null) self::connect();

        $query = self::$db->query("SELECT COUNT(*) as total FROM " . static::$table);
        return $query->fetchColumn();
    }

    public static function getBestSellingProducts($limit = 3) {
        if (self::$db === null) self::connect();

        $sql = "SELECT p.id, p.name, p.price, 
            COALESCE(SUM(oi.quantity), 0) as total_sold
            FROM " . static::$table . " p
            LEFT JOIN order_items oi ON p.id = oi.product_id
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT {$limit}";

        $query = self::$db->query($sql);
        return $query->fetchAll();
    }

    public static function getCategorySalesStats($limit = 4) {
        if (self::$db === null) self::connect();

        $sql = "SELECT 
                c.id,
                c.name,
                c.icon,
                COUNT(DISTINCT oi.order_id) as total_orders,
                SUM(oi.quantity) as total_sold,
                SUM(oi.quantity * oi.price) as total_revenue
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.id
            LEFT JOIN order_items oi ON oi.product_id = p.id
            WHERE c.is_active = 1
            GROUP BY c.id
            HAVING total_sold > 0
            ORDER BY total_revenue DESC
            LIMIT {$limit}";

        $query = self::$db->query($sql);
        return $query->fetchAll();
    }

    public static function getMostExpensiveProducts($limit = 3) {
        if (self::$db === null) self::connect();

        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
            FROM " . static::$table . " p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.is_active = 1
            ORDER BY p.price DESC
            LIMIT {$limit}";

        $query = self::$db->query($sql);
        return $query->fetchAll();
    }

    public static function getNewestProducts($limit = 4) {
        if (self::$db === null) self::connect();

        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
            FROM " . static::$table . " p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.is_active = 1
            ORDER BY p.created_at DESC
            LIMIT {$limit}";

        $query = self::$db->query($sql);
        return $query->fetchAll();
    }
}