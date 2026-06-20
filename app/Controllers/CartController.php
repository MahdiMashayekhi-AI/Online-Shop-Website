<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\ProductModel;
use Core\Controller;
use App\Models\OrderModel;

class CartController extends Controller {

    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        $title = "سبد خرید";

        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $this->view("Cart", [
            'cart' => $cart,
            'subtotal' => $subtotal,
            "title" => $title,
        ]);
    }

    public function add()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0 || $quantity <= 0) {
            Helpers::setSession("error", "درخواست نامعتبر است");
            Helpers::redirect("/cart");
        }

        if ($quantity > 10) {
            Helpers::setSession("error", "حداکثر تعداد مجاز 10 عدد است");
            Helpers::redirect("/cart");
        }

        $product = ProductModel::find($productId);
        if (!$product || (int)$product['is_active'] !== 1) {
            Helpers::setSession("error", "محصول یافت نشد");
            Helpers::redirect("/cart");
        }

        if (!Helpers::hasSession("cart"))
            Helpers::setSession("cart", []);

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['qty'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => (int)$product['id'],
                'name' => $product['name'],
                'price' => (float)$product['price'],
                'image' => $product['main_image'],
                'qty' => $quantity
            ];
        }

        Helpers::setSession("success", "محصول به سبد خرید اضافه شد");
        Helpers::redirect("/cart");
    }

    public function increase()
    {
        $productId = (int)($_POST['product_id'] ?? 0);

        if ($productId > 0 && isset($_SESSION['cart'][$productId]))
            if ($_SESSION['cart'][$productId]['qty'] < 10)
                $_SESSION['cart'][$productId]['qty']++;

        Helpers::redirect("/cart");
    }

    public function decrease()
    {
        $productId = (int)($_POST['product_id'] ?? 0);

        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['qty']--;

            if ($_SESSION['cart'][$productId]['qty'] <= 0)
                unset($_SESSION['cart'][$productId]);
        }

        Helpers::redirect("/cart");
    }

    public function remove()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        if ($productId > 0) unset($_SESSION['cart'][$productId]);

        Helpers::redirect("/cart");
    }

    public function checkout()
    {
        if (!isset($_SESSION['user'])) {
            Helpers::setSession("error", "ابتدا وارد حساب کاربری شوید");
            Helpers::redirect("/login");
        }

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            Helpers::setSession("error", "سبد خرید خالی است");
            Helpers::redirect("/cart");
        }

        $userId = (int)$_SESSION['user']['id'];
        $items = [];
        $totalPrice = 0;

        foreach ($cart as $productId => $item) {

            $product = ProductModel::find((int)$productId);

            if (!$product || (int)$product['is_active'] !== 1) {
                unset($_SESSION['cart'][$productId]);
                continue;
            }

            $price = (float)$product['price'];

            $qty = (int)$item['qty'];

            if ($qty <= 0) continue;

            $items[] = [
                'product_id' => (int)$productId,
                'quantity' => $qty,
                'price' => $price
            ];

            $totalPrice += $price * $qty;
        }

        if (empty($items)) {
            Helpers::setSession("error", "سبد خرید معتبر نیست");
            Helpers::redirect("/cart");
        }

        $orderId = OrderModel::createOrder($userId, $items, $totalPrice);

        if ($orderId) {
            Helpers::removeSession("cart");
            Helpers::setSession("success", "سفارش ثبت شد: #" . $orderId);
            Helpers::redirect("/cart");
        }

        Helpers::setSession("error", "خطا در ثبت سفارش");
        Helpers::redirect("/cart");
    }
}