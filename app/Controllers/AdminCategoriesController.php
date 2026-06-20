<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\CategoryModel;
use Core\Controller;

class AdminCategoriesController extends Controller{
    public function index(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $categories = CategoryModel::getAll();
        $stats = CategoryModel::stats();

        $content = $this->view("Admin/Categories", [
            'categories' => $categories,
            'stats' => $stats
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'دسته بندی ها',
            'active' => 'categories',
            'styles' => ['/css/admin/categories.css'],
            'scripts' => ['/js/categories.js']
        ]);
    }

    public function store()
    {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $icon = trim($_POST['icon'] ?? '');

        if (empty($name) || empty($slug) || empty($icon)){
            Helpers::setSession("error", "لطفا تمامی موارد رو پر کنید");
            Helpers::redirect("/admin/categories");
        }

        if (strlen($name) < 2 || strlen($name) > 100) {
            Helpers::setSession("error", "نام دسته بندی باید بین 2 تا 100 کاراکتر باشد");
            Helpers::redirect("/admin/categories");
        }

        if (!preg_match('/^[a-z0-9\-]+$/', $slug)) {
            Helpers::setSession("error", "اسلاگ فقط می‌تواند شامل حروف کوچک انگلیسی، اعداد و خط تیره باشد");
            Helpers::redirect("/admin/categories");
        }

        $existing = CategoryModel::getBySlug($slug);
        if ($existing) {
            Helpers::setSession("error", "این اسلاگ قبلاً استفاده شده است");
            Helpers::redirect("/admin/categories");
        }

        CategoryModel::insert([
            'name'      => htmlspecialchars($_POST['name']),
            'slug'      => htmlspecialchars($_POST['slug']),
            'icon'      => htmlspecialchars($_POST['icon']),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ]);


        Helpers::setSession("success", "دسته بندی با موفقیت اضافه شد");
        Helpers::redirect("/admin/categories");
    }

    public function update()
    {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $icon = trim($_POST['icon'] ?? '');

        if (empty($name) || empty($slug) || empty($icon)){
            Helpers::setSession("error", "لطفا تمامی موارد رو پر کنید");
            Helpers::redirect("/admin/categories");
        }

        if (strlen($name) < 2 || strlen($name) > 100) {
            Helpers::setSession("error", "نام دسته بندی باید بین 2 تا 100 کاراکتر باشد");
            Helpers::redirect("/admin/categories");
        }

        if (!preg_match('/^[a-z0-9\-]+$/', $slug)) {
            Helpers::setSession("error", "اسلاگ فقط می‌تواند شامل حروف کوچک انگلیسی، اعداد و خط تیره باشد");
            Helpers::redirect("/admin/categories");
        }

        $existing = CategoryModel::getBySlug($slug);
        if ($existing && isset($existing['id']) && $existing['id'] != $id) {
            Helpers::setSession("error", "این اسلاگ قبلاً استفاده شده است");
            Helpers::redirect("/admin/categories");
        }

        CategoryModel::update($id, [
            'name'      => htmlspecialchars($name),
            'slug'      => htmlspecialchars($slug),
            'icon'      => htmlspecialchars($icon),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ]);

        Helpers::setSession("success", "دسته بندی با موفقیت بروزرسانی شد");
        Helpers::redirect("/admin/categories");
    }

    public function delete()
    {
        $id = (int)$_POST['id'];

        if (!CategoryModel::find($id)) {
            Helpers::setSession("error", "دسته بندی یافت نشد");
            Helpers::redirect("/admin/categories");
        }

        CategoryModel::delete($id);

        Helpers::setSession("success", "دسته بندی با موفقیت حذف شد");
        Helpers::redirect("/admin/categories");
    }
}

