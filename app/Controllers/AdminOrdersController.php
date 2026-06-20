<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\OrderModel;
use Core\Controller;

class AdminOrdersController extends Controller{
    public function index(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $page = max(1, (int)($_GET['page'] ?? 1));
        $status = $_GET['status'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';
        $limit = 6;

        $orders = OrderModel::getAllOrders($page, $limit, $status, $search, $sort);
        $totalOrders = OrderModel::getTotalOrdersCount($status, $search);
        $stats = OrderModel::stats();
        $totalPages = ceil($totalOrders / $limit);

        $content = $this->view("Admin/Orders", [
            'orders' => $orders,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalOrders' => $totalOrders,
            'stats' => $stats,
            'currentStatus' => $status,
            'currentSearch' => $search,
            'currentSort' => $sort
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'مدیریت سفارشات',
            'active' => 'orders'
        ]);
    }

    public function show()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect('/admin');

        $id = (int) ($_GET['id'] ?? 0);

        $order = OrderModel::getOrderById($id);

        if (!$order)
            Helpers::redirect('/admin/orders');

        $content = $this->view(
            "Admin/OrderShow",
            compact('order'),
            true
        );

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'جزئیات سفارش',
            'active' => 'orders'
        ]);
    }

    public function edit()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect('/admin');

        $id = (int) ($_GET['id'] ?? 0);
        $order = OrderModel::getOrderById($id);
        if (!$order)
            Helpers::redirect('/admin/orders');

        $content = $this->view(
            "Admin/OrderEdit",
            compact('order'),
            true
        );

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'ویرایش سفارش',
            'active' => 'orders'
        ]);
    }

    public function updateStatus()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect('/admin');

        $id = (int) ($_POST['id'] ?? 0);

        $status = $_POST['status'] ?? '';

        $validStatuses = [
            'pending',
            'processing',
            'shipped',
            'delivered',
            'cancelled'
        ];

        if (!in_array($status, $validStatuses))
            Helpers::redirect('/admin/orders');

        OrderModel::update($id, [
            'status' => $status
        ]);

        Helpers::redirect('/admin/orders');
    }
}