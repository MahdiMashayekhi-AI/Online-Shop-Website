<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use Core\Controller;

class AdminProductController extends Controller {
    public function index(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $search = trim($_GET['search'] ?? '');
        $categoryId = (int)($_GET['category'] ?? 0);
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 6;

        $products = ProductModel::paginate(
            $search,
            $categoryId,
            $page,
            $limit
        );

        $totalProducts = ProductModel::countAll($search, $categoryId);
        $totalPages = ceil($totalProducts / $limit);

        $categories = CategoryModel::all();

        $stats = ProductModel::stats();

        $content = $this->view("Admin/ListProducts", [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'categoryId' => $categoryId,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'stats' => $stats
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'محصولات',
            'active' => 'products',
            'styles' => [],
            'scripts' => [],
        ]);
    }

    public function add(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $categories = CategoryModel::all();

        $content = $this->view("Admin/AddProduct", [
            'categories' => $categories,
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'اضافه کردن محصول',
            'active' => 'addProduct',
            'styles' => [],
            'scripts' => ['/js/add-product.js']
        ]);
    }

    public function insert()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $price = (int)($_POST['price'] ?? 0);
        $discountPrice = (int)($_POST['discountPrice'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $category = CategoryModel::find((int)($_POST['category_id'] ?? 0));

        if (empty($name)) {
            Helpers::setSession("error", "نام محصول الزامی است");
            Helpers::redirect("/admin/products/add");
        }

        if (strlen($name) < 2 || strlen($name) > 200) {
            Helpers::setSession("error", "نام محصول باید بین 2 تا 200 کاراکتر باشد");
            Helpers::redirect("/admin/products/add");
        }

        if ($slug === '') {
            Helpers::setSession("error", "اسلاگ نمیتواند خالی باشد");
            Helpers::redirect("/admin/products/add");
        }

        if (!preg_match('/^[a-z0-9\-]+$/', $slug)) {
            Helpers::setSession("error", "اسلاگ نامعتبر است");
            Helpers::redirect("/admin/products/add");
        }

        if (ProductModel::getBySlug($slug)) {
            Helpers::setSession("error", "این اسلاگ قبلاً ثبت شده است");
            Helpers::redirect("/admin/products/add");
        }

        if (!$category) {
            Helpers::setSession("error", "دسته بندی نامعتبر است");
            Helpers::redirect("/admin/products/add");
        }

        if ($price < 0) {
            Helpers::setSession("error", "قیمت نامعتبر است");
            Helpers::redirect("/admin/products/add");
        }

        if ($discountPrice < 0) {
            Helpers::setSession("error", "قیمت تخفیف نامعتبر است");
            Helpers::redirect("/admin/products/add");
        }

        if ($discountPrice > $price) {
            Helpers::setSession("error", "قیمت تخفیف نمی‌تواند بیشتر از قیمت اصلی باشد");
            Helpers::redirect("/admin/products/add");
        }

        if ($stock < 0) {
            Helpers::setSession("error", "موجودی نامعتبر است");
            Helpers::redirect("/admin/products/add");
        }

        $mainImagePath = Helpers::uploadImage('main_image', 'images/products');

        ProductModel::insert([
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'name' => $name,
            'slug' => $slug,
            'short_description' => trim($_POST['shortDesc'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (int)($_POST['price'] ?? 0),
            'discounted_price' => (int)($_POST['discountPrice'] ?? 0),
            'stock' => (int)($_POST['stock'] ?? 0),
            'main_image' => $mainImagePath,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'created_at' => time()
        ]);

        Helpers::setSession("success", "محصول با موفقیت اضافه شد");
        Helpers::redirect("/admin/products");
    }

    public function edit(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = (int)($_GET['id'] ?? 0);
        $product = ProductModel::find($id);
        if (!$product) Helpers::redirect("/admin/products");

        $categories = CategoryModel::all();

        $content = $this->view("Admin/EditProduct", compact(
            "product",
            "categories"), true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'ویرایش محصول',
            'active' => 'products',
            'styles' => ['/css/admin/edit-product.css'],
            'scripts' => []
        ]);
    }

    public function update(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = (int)($_POST['id'] ?? 0);
        $product = ProductModel::find($id);
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $price = (int)($_POST['price'] ?? 0);
        $discountPrice = (int)($_POST['discountPrice'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);

        if (!$product) {
            Helpers::redirect("/admin/products");
        }

        if (empty($name)) {
            Helpers::setSession("error", "نام محصول الزامی است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        if (strlen($name) < 2 || strlen($name) > 200) {
            Helpers::setSession("error", "نام محصول باید بین 2 تا 200 کاراکتر باشد");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        if (!preg_match('/^[a-z0-9\-]+$/', $slug)) {
            Helpers::setSession("error", "اسلاگ نامعتبر است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        $existing = ProductModel::getBySlug($slug);
        if ($existing && $existing['id'] != $id) {
            Helpers::setSession("error", "این اسلاگ قبلاً ثبت شده است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        $categoryId = (int)($_POST['category_id'] ?? 0);
        if (!CategoryModel::find($categoryId)) {
            Helpers::setSession("error", "دسته بندی نامعتبر است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        if ($price < 0) {
            Helpers::setSession("error", "قیمت نامعتبر است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        if ($stock < 0) {
            Helpers::setSession("error", "موجودی نامعتبر است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        if ($discountPrice < 0) {
            Helpers::setSession("error", "قیمت تخفیف نامعتبر است");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        if ($discountPrice > $price) {
            Helpers::setSession("error", "قیمت تخفیف نمی‌تواند بیشتر از قیمت اصلی باشد");
            Helpers::redirect("/admin/edit-product?id=" . $id);
        }

        $mainImagePath = Helpers::uploadImage(
            'main_image',
            'images/products',
            $product['main_image']
        );

        ProductModel::update($id, [
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'discounted_price' => $discountPrice,
            'stock' => $stock,
            'category_id' => $categoryId,
            'short_description' => trim($_POST['shortDesc'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'main_image' => $mainImagePath,
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ]);

        Helpers::setSession("success", "محصول با موفقیت ویرایش شد");
        Helpers::redirect("/admin/products");
    }

    public function delete()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) Helpers::redirect("/admin/products");

        $product = ProductModel::find($id);
        if (!$product) Helpers::redirect("/admin/products");

        if (!empty($product['main_image']) && file_exists($product['main_image']))
            unlink($product['main_image']);

        ProductModel::delete($id);

        Helpers::setSession("success", "محصول با موفقیت حذف شد");
        Helpers::redirect("/admin/products");
    }
}