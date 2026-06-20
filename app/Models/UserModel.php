<?php

namespace App\Models;

use Core\Model;

class UserModel extends Model{
    protected static string $table = "users";

    public static function findByEmail($email){
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
            SELECT *
            FROM " . static::$table . " 
            WHERE email = ? 
            LIMIT 1");

        $query->execute([$email]);
        return $query->fetch();
    }

    public static function register($fullname, $email, $phone, $password, $createAt){
        if (self::$db === null) self::connect();

        $query = self::$db->prepare("
        INSERT INTO " . static::$table . " 
        (full_name, email, phone, password, created_at)
        VALUES (?, ?, ?, ?, ?)
    ");

        $query->execute([
            $fullname,
            $email,
            $phone,
            $password,
            $createAt
        ]);

        return self::$db->lastInsertId();
    }

    public static function list($page = 1, $perPage = 10, $role = 'all', $status = 'all', $search = '', $sort = 'newest'){
        if (self::$db === null) self::connect();

        $offset = ($page - 1) * $perPage;

        $whereConditions = [];
        $params = [];

        if($role !== 'all'){
            $whereConditions[] = "role = ?";
            $params[] = $role;
        }

        if($status !== 'all'){
            $whereConditions[] = "is_active = ?";
            $params[] = ($status === 'active') ? 1 : 0;
        }

        if(!empty($search)){
            $whereConditions[] = "(full_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $whereSql = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

        switch($sort){
            case 'newest':
                $orderSql = "ORDER BY created_at DESC";
                break;
            case 'oldest':
                $orderSql = "ORDER BY created_at ASC";
                break;
            case 'name_asc':
                $orderSql = "ORDER BY full_name ASC";
                break;
            case 'name_desc':
                $orderSql = "ORDER BY full_name DESC";
                break;
            default:
                $orderSql = "ORDER BY id DESC";
        }

        $sql = "SELECT * FROM " . self::$table . " {$whereSql} {$orderSql} LIMIT {$perPage} OFFSET {$offset}";
        $query = self::$db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    }

    public static function countUsers($role = 'all', $status = 'all', $search = ''){
        if (self::$db === null) self::connect();

        $whereConditions = [];
        $params = [];

        if($role !== 'all'){
            $whereConditions[] = "role = ?";
            $params[] = $role;
        }

        if($status !== 'all'){
            $whereConditions[] = "is_active = ?";
            $params[] = ($status === 'active') ? 1 : 0;
        }

        if(!empty($search)){
            $whereConditions[] = "(full_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $whereSql = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

        $sql = "SELECT COUNT(*) as total FROM " . self::$table . " {$whereSql}";
        $query = self::$db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();

        return $result['total'];
    }

    public static function stats(){
        if (self::$db === null) self::connect();

        $query = self::$db->query("SELECT COUNT(*) as total FROM " . static::$table);
        $total = $query->fetch()['total'];

        $query = self::$db->query("SELECT COUNT(*) as active FROM " . static::$table . " WHERE is_active = 1");
        $active = $query->fetch()['active'];

        $inactive = $total - $active;

        $query = self::$db->query("SELECT COUNT(*) as admins FROM " . static::$table . " WHERE role = 'admin'");
        $admins = $query->fetch()['admins'];

        $currentTimestamp = time();
        $firstDayOfMonth = strtotime(date('Y-m-01 00:00:00', $currentTimestamp));
        $query = self::$db->prepare("SELECT COUNT(*) as new_users FROM " . static::$table . " WHERE created_at >= ?");
        $query->execute([$firstDayOfMonth]);
        $newUsers = $query->fetch()['new_users'];

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'admins' => $admins,
            'new_users' => $newUsers
        ];
    }

    public static function getDashboardStats() {
        if (self::$db === null) self::connect();

        $query = self::$db->query("SELECT COUNT(*) as total FROM " . self::$table);
        $totalUsers = $query->fetch()['total'];

        $oneWeekAgo = strtotime('-7 days');
        $query = self::$db->prepare("SELECT COUNT(*) as new_week FROM " . self::$table . " WHERE created_at >= ?");
        $query->execute([$oneWeekAgo]);
        $newUsersThisWeek = $query->fetch()['new_week'];

        return [
            'total' => $totalUsers,
            'new_this_week' => $newUsersThisWeek
        ];
    }

}