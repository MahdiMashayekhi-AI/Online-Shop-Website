<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\UserModel;
use Core\Controller;

class AuthController extends Controller
{
    public function indexLogin(){
        $this->view("Auth/Login");
    }

    public function login(){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            Helpers::setSession("error", "لطفا همه فیلد ها رو پر کنید");
            Helpers::redirect("/login");
        }

        $user = UserModel::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            Helpers::setSession("error", "ایمیل یا رمز عبور اشتباه میباشد");
            Helpers::redirect("/login");
        }

        if ($user['is_active'] != 1) {
            Helpers::setSession("error", "دسترسی شما محدود شده است");
            Helpers::redirect("/login");
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            "id" => $user['id'],
            "email" => $user['email'],
            "name" => $user['full_name'],
            "phone" => $user['phone']
        ];

        Helpers::redirect("/");
    }

    public function indexRegister(){
        $this->view("Auth/Register");
    }

    public function register(){
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirmPassword'] ?? '');

        if (empty($fullname) || empty($email) ||
            empty($phone) || empty($password) ||
            empty($confirmPassword)) {
            Helpers::setSession("error", "تمامی فیلد ها رو لطفا پرکنید");
            Helpers::redirect("/register");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helpers::setSession("error", "ایمیل وارد شده معتبر نیست");
            Helpers::redirect("/register");
        }

        if (!preg_match('/^09\d{9}$/', $phone)) {
            Helpers::setSession("error", "شماره وارده شده معتبر نیست");
            Helpers::redirect("/register");
        }

        if (strlen($password) < 6) {
            Helpers::setSession("error", "رمز عبور باید حداقل 6 کارکتر باشد");
            Helpers::redirect("/register");
        }

        if ($password !== $confirmPassword) {
            Helpers::setSession("error", "رمز و تکرار آن یکی نیستند");
            Helpers::redirect("/register");
        }

        if (UserModel::findByEmail($email)) {
            Helpers::setSession("error", "این ایمیل قبلا وارد شده است");
            Helpers::redirect("/register");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userId = UserModel::register(
            $fullname,
            $email,
            $phone,
            $hashedPassword,
            time()
        );

        session_regenerate_id(true);

        Helpers::setSession('user', [
            "id" => $userId,
            "email" => $email,
            "name" => $fullname,
            "phone" => $phone
        ]);

        Helpers::redirect("/");
    }

    public function logout(){
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['admin']) && !empty($_SESSION['admin']))
            Helpers::removeSession("admin");

        if (isset($_SESSION['user']) && !empty($_SESSION['user']))
            Helpers::removeSession("user");

        Helpers::redirect("/");
    }

    public function admin(){
        if (isset($_SESSION['admin']) && !empty($_SESSION['admin']))
            Helpers::redirect("admin/dashboard");

        $this->view("Auth/Admin");
    }

    public function adminLogin(){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            Helpers::setSession("error", "لطفا همه فیلد ها را پر کنید");
            Helpers::redirect("/admin");
        }

        $user = UserModel::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            Helpers::setSession("error", "ایمیل یا رمز عبور اشتباه میباشد");
            Helpers::redirect("/admin");
        }

        if ($user['role'] !== 'admin') {
            Helpers::setSession("error", "ایمیل یا رمز عبور اشتباه میباشد");
            Helpers::redirect("/admin");
        }

        Helpers::setSession("admin", [
            "id" => $user['id'],
            "email" => $user['email'],
            "name" => $user['full_name']
        ]);

        Helpers::redirect("/admin/dashboard");
    }
}