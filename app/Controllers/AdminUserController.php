<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\UserModel;
use Core\Controller;

class AdminUserController extends Controller {
    public function index(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 6;
        $role = $_GET['role'] ?? 'all';
        $status = $_GET['status'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
        $editUser = null;
        if($editId > 0) $editUser = UserModel::find($editId);

        $users = UserModel::list($page, $limit, $role, $status, $search, $sort);
        $totalUsers = UserModel::countUsers($role, $status, $search);
        $totalPages = max(1, ceil($totalUsers / $limit));
        $page = min($page, $totalPages);
        $stats = UserModel::stats();

        $content = $this->view("Admin/Users", [
            'users' => $users,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalUsers' => $totalUsers,
            'stats' => $stats,
            'currentRole' => $role,
            'currentStatus' => $status,
            'currentSearch' => $search,
            'currentSort' => $sort,
            'editUser' => $editUser
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'مدیریت کاربران',
            'active' => 'users',
            'scripts' => ['/js/users.js']
        ]);
    }

    public function store()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
            Helpers::setSession("error", "لطفا تمام فیلد ها را پر کنید");
            Helpers::redirect("/admin/users");
        }

        if (strlen($fullName) < 2 || strlen($fullName) > 100) {
            Helpers::setSession("error", "نام و نام خانوادگی نامعتبر است");
            Helpers::redirect("/admin/users");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helpers::setSession("error", "ایمیل نامعتبر است");
            Helpers::redirect("/admin/users");
        }

        if (!empty($phone) && !preg_match('/^[0-9]{10,15}$/', $phone)) {
            Helpers::setSession("error", "شماره تلفن نامعتبر است");
            Helpers::redirect("/admin/users");
        }

        if (strlen($password) < 6) {
            Helpers::setSession("error", "رمز عبور باید حداقل 6 کاراکتر باشد");
            Helpers::redirect("/admin/users");
        }

        if ($password !== $confirmPassword) {
            Helpers::setSession("error", "رمز عبور و تکرار آن یکسان نیستند");
            Helpers::redirect("/admin/users");
        }

        if (UserModel::findByEmail($email)) {
            Helpers::setSession("error", "این ایمیل قبلا ثبت شده است");
            Helpers::redirect("/admin/users");
        }

        $role = ($role === 'admin') ? 'admin' : 'customer';

        $result = UserModel::insert([
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'is_active' => $isActive,
            'created_at' => time()
        ]);

        if ($result)
            Helpers::setSession("success", "کاربر جدید با موفقیت اضافه شد");
        else
            Helpers::setSession("error", "خطا در افزودن کاربر");

        Helpers::redirect("/admin/users");
    }

    public function update()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = (int)($_POST['id'] ?? 0);
        $user = UserModel::find($id);
        if (!$user) {
            Helpers::setSession("error", "کاربر مورد نظر یافت نشد");
            Helpers::redirect("/admin/users");
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $password = $_POST['password'] ?? '';

        if (empty($fullName) || empty($email)) {
            Helpers::setSession("error", "لطفا تمام فیلد های الزامی را پر کنید");
            Helpers::redirect("/admin/users");
        }

        if (strlen($fullName) < 2 || strlen($fullName) > 100) {
            Helpers::setSession("error", "نام و نام خانوادگی نامعتبر است");
            Helpers::redirect("/admin/users");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helpers::setSession("error", "ایمیل نامعتبر است");
            Helpers::redirect("/admin/users");
        }

        if (!empty($phone) && !preg_match('/^[0-9]{10,15}$/', $phone)) {
            Helpers::setSession("error", "شماره تلفن نامعتبر است");
            Helpers::redirect("/admin/users");
        }

        $existingEmail = UserModel::findByEmail($email);
        if ($existingEmail && $existingEmail['id'] != $id) {
            Helpers::setSession("error", "این ایمیل قبلا ثبت شده است");
            Helpers::redirect("/admin/users");
        }

        $role = ($role === 'admin') ? 'admin' : 'customer';

        $updateData = [
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'role' => $role,
            'is_active' => $isActive
        ];

        if (!empty($password)) {
            if (strlen($password) < 6) {
                Helpers::setSession("error", "رمز عبور باید حداقل 6 کاراکتر باشد");
                Helpers::redirect("/admin/users");
            }

            $updateData['password'] =
                password_hash($password, PASSWORD_DEFAULT);
        }

        $result = UserModel::update($id, $updateData);
        if ($result)
            Helpers::setSession("success", "اطلاعات کاربر با موفقیت ویرایش شد");
        else
            Helpers::setSession("error", "خطا در ویرایش کاربر");

        Helpers::redirect("/admin/users");
    }

    public function delete()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) Helpers::redirect("/admin/users");

        if ($id === 1) {
            Helpers::setSession("error", "امکان حذف ادمین اصلی وجود ندارد");
            Helpers::redirect("/admin/users");
        }

        $user = UserModel::find($id);
        if (!$user) {
            Helpers::setSession("error", "کاربر مورد نظر یافت نشد");
            Helpers::redirect("/admin/users");
        }

        $result = UserModel::delete($id);
        if ($result)
            Helpers::setSession("success", "کاربر با موفقیت حذف شد");
        else
            Helpers::setSession("error", "خطا در حذف کاربر");

        Helpers::redirect("/admin/users");
    }

    public function getUser(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = (int)($_GET['id'] ?? 0);
        $user = UserModel::find($id);

        if($user){
            unset($user['password']);
            $user['status'] = $user['is_active'] == 1 ? 'active' : 'inactive';
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'کاربر یافت نشد']);
        }
        exit;
    }
}