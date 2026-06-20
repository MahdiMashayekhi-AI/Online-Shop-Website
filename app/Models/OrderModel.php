<?php

namespace App\Models;

use Core\Model;


class OrderModel extends Model
{
    protected static string $table = "orders";

    public static function getAllOrders($page = 1, $perPage = 10, $status = 'all', $search = '', $sort = 'newest')
    {
        if (self::$db === null) self::connect();

        $offset = ($page - 1) * $perPage;

        $where = [];
        $params = [];

        if ($status !== 'all') {
            $where[] = "o.status = ?";
            $params[] = $status;
        }

        if (!empty($search)) {
            $where[] = "(o.id LIKE ? OR u.full_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";

            $search = "%{$search}%";

            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $whereSql = "";
        if (!empty($where))
            $whereSql = "WHERE " . implode(" AND ", $where);

        switch ($sort) {
            case 'oldest':
                $orderSql = "ORDER BY o.created_at ASC";
                break;

            case 'price_high':
                $orderSql = "ORDER BY o.total_price DESC";
                break;

            case 'price_low':
                $orderSql = "ORDER BY o.total_price ASC";
                break;

            default:
                $orderSql = "ORDER BY o.created_at DESC";
        }

        $query = self::$db->prepare("
            SELECT o.*, u.full_name as customer_name, u.email, u.phone
            FROM " . static::$table . " o
            LEFT JOIN users u ON o.user_id = u.id
            {$whereSql}
            {$orderSql}
            LIMIT {$perPage} OFFSET {$offset}
        ");

        $query->execute($params);

        return $query->fetchAll();
    }

    public static function getTotalOrdersCount($status = 'all', $search = '')
    {
        if (self::$db === null) self::connect();

        $where = [];
        $params = [];

        if ($status !== 'all') {
            $where[] = "o.status = ?";
            $params[] = $status;
        }

        if (!empty($search)) {
            $where[] = "(o.id LIKE ? OR u.full_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";

            $search = "%{$search}%";

            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $whereSql = "";

        if (!empty($where)) {
            $whereSql = "WHERE " . implode(" AND ", $where);
        }

        $query = self::$db->prepare("
            SELECT COUNT(*)
            FROM " . static::$table . " o
            LEFT JOIN users u ON o.user_id = u.id
            {$whereSql}
        ");

        $query->execute($params);

        return (int) $query->fetchColumn();
    }

    public static function stats()
    {
        if (self::$db === null) self::connect();

        return self::$db->query("
            SELECT
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 'shipped' THEN 1 ELSE 0 END) as shipped,
                SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
            FROM " . static::$table
        )->fetch();
    }

    public static function getOrderById($id)
    {
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            SELECT o.*, u.full_name as customer_name, u.email, u.phone
            FROM " . static::$table . " o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.id = ?
        ");

        $query->execute([$id]);

        $order = $query->fetch();

        if (!$order) {
            return null;
        }

        $query = self::$db->prepare("
            SELECT oi.*, p.name as product_name
            FROM order_items oi
            LEFT JOIN products p
                ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");

        $query->execute([$id]);

        $order['items'] = $query->fetchAll();

        return $order;
    }

    public static function createOrder($userId, $items, $totalPrice)
    {
        if (self::$db === null) self::connect();

        $totalItems = 0;
        foreach ($items as $item) {
            $totalItems += $item['quantity'];
        }

        $query = self::$db->prepare("
            INSERT INTO " . static::$table . "
            (user_id, total_items, total_price, status, created_at)
            VALUES (?, ?, ?, 'pending', ?)
        ");

        $query->execute([
            $userId,
            $totalItems,
            $totalPrice,
            time()
        ]);

        $orderId = self::$db->lastInsertId();

        $query = self::$db->prepare("
            INSERT INTO order_items
            (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($items as $item) {
            $query->execute([
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            ]);
        }

        return $orderId;
    }

    public static function getDashboardStats()
    {
        if (self::$db === null) self::connect();

        $totalOrders = self::$db->query(
            "SELECT COUNT(*) FROM " . static::$table
        )->fetchColumn();

        $query = self::$db->prepare("
            SELECT SUM(total_price)
            FROM " . static::$table . "
            WHERE created_at >= ?
            AND status != 'cancelled'
        ");

        $query->execute([
            strtotime('first day of this month midnight')
        ]);

        return [
            'total' => $totalOrders,
            'monthly_sales' => $query->fetchColumn() ?? 0
        ];
    }

    public static function getRecentOrders($limit = 3)
    {
        if (self::$db === null) self::connect();

        return self::$db->query("
            SELECT o.*, u.full_name as customer_name, u.email, u.phone
            FROM " . static::$table . " o
            LEFT JOIN users u
                ON o.user_id = u.id
            ORDER BY o.created_at DESC
            LIMIT {$limit}
        ")->fetchAll();
    }
}