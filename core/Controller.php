<?php

namespace Core;

use App\Models\SettingModel;

class Controller {
    protected function view(string $name, array $data = [], bool $return = false)
    {
        $globalData = [
            'pageSettings' => SettingModel::all(),
            "search" => trim($_GET['search'] ?? '')
        ];

        extract(array_merge($globalData, $data));

        ob_start();
        require "../app/Views/{$name}.php";
        $output = ob_get_clean();

        if ($return) return $output;

        echo $output;
    }
}