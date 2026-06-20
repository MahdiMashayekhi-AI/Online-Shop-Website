<?php

namespace App\Models;

use Core\Model;

class SettingModel extends Model {
    protected static string $table = "settings";

    public static function all()
    {
        if (self::$db === null) self::connect();

        $query = self::$db->query(
            "SELECT * FROM " . static::$table
        );

        return $query->fetch();
    }
}