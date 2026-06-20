<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use Core\Controller;

class AdminController extends Controller {

    public function index(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $userStats = UserModel::getDashboardStats();
        $productStats = ProductModel::getDashboardStats();
        $orderStats = OrderModel::getDashboardStats();
        $recentOrders = OrderModel::getRecentOrders(3);
        $bestSellingProducts = ProductModel::getBestSellingProducts(3);
        $categoryStats = ProductModel::getCategorySalesStats(4);

        $content = $this->view("Admin/Dashboard", [
            'userStats' => $userStats,
            'productStats' => $productStats,
            'orderStats' => $orderStats,
            'recentOrders' => $recentOrders,
            'bestSellingProducts' => $bestSellingProducts,
            'categoryStats' => $categoryStats
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'داشبورد مدیریت',
            'active' => 'dashboard'
        ]);
    }
}