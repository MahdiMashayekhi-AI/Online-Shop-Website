<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\ContactModel;
use Core\Controller;

class ContactController extends Controller{

    public function index(){
        $title = "ارتباط با ما";

        $this->view("Contact", compact("title"));
    }

    public function store(){

        $fullname = trim($_POST['fullname'] ?? '') ;
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $ip_address = $_SERVER['REMOTE_ADDR'];

        if (empty($fullname) || empty($email) || empty($phone) || empty($subject) || empty($message)){
            Helpers::setSession("error", "لطفا تمامی فیلد را پر کنید");
            Helpers::redirect("/contact-us");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helpers::setSession("error", "ایمیل وارد شده معتبر نیست");
            Helpers::redirect("/contact-us");
        }

        if (!preg_match('/^09\d{9}$/', $phone)) {
            Helpers::setSession("error", "شماره وارد شده معتبر نیست");
            Helpers::redirect("/contact-us");
        }

        ContactModel::insert([
            "full_name" => $fullname,
            "email" => $email,
            "phone" => $phone,
            "subject" => $subject,
            "message" => $message,
            "ip_address" => $ip_address,
            "created_at" => time()
        ]);

        setcookie("user_message", "success", time() + 5, "/");

        Helpers::redirect("/contact-us");
    }
}