<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\ContactModel;
use Core\Controller;

class AdminContactsController extends Controller {

    public function index(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 6;

        $messages = ContactModel::getMessages($page, $limit);
        $totalMessages = ContactModel::count();
        $stats = ContactModel::stats();
        $totalPages = ceil($totalMessages / $limit);

        $content = $this->view("Admin/Contacts", [
            'messages' => $messages,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalMessages' => $totalMessages,
            'stats' => $stats
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'ارتباطات کاربران',
            'active' => 'contacts'
        ]);
    }

    public function show(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = $_GET['id'] ?? 0;
        if($id == 0) Helpers::redirect("/admin/contact-messages");

        $message = ContactModel::find($id);
        if(!$message) Helpers::redirect("/admin/contact-messages");

        if($message['is_read'] == 0) {
            ContactModel::markAsRead($id);
            $message['is_read'] = 1;
        }

        $content = $this->view("Admin/ContactDetail", [
            'message' => $message
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'جزئیات پیام',
            'active' => 'contacts'
        ]);
    }

    public function delete(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $id = $_POST['id'] ?? 0;
        if($id > 0) {
            ContactModel::delete($id);
            Helpers::setSession("success", "پیام با موفقیت حذف شد");
        }

        Helpers::redirect("/admin/contact-messages");
    }
}