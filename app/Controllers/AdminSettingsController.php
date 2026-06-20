<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\SettingModel;
use Core\Controller;

class AdminSettingsController extends Controller {
    public function shopSettings(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $content = $this->view("Admin/ShopSettings", [], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'تنظیمات فروشگاه',
            'active' => 'shopSettings',
            'styles' => ['/css/admin/shop-settings.css'],
            'scripts' => ['/js/shop-settings.js']
        ]);
    }

    public function shopStore()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $requiredFields = [
            'store_name',
            'store_name_en',
            'slogan',
            'description',
            'phone',
            'email',
            'address',
            'instagram',
            'telegram',
            'twitter',
            'linkedin'
        ];

        foreach ($requiredFields as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                Helpers::setSession("error", "تمامی فیلد ها را تکمیل کنید");
                Helpers::redirect("/admin/shop-settings");
            }
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            Helpers::setSession("error", "ایمیل معتبر نیست");
            Helpers::redirect("/admin/shop-settings");
        }

        if (!preg_match('/^[0-9]{10,15}$/', trim($_POST['phone']))) {
            Helpers::setSession("error", "شماره تماس نامعتبر است");
            Helpers::redirect("/admin/shop-settings");
        }

        $socialLinks = [
            'instagram',
            'telegram',
            'twitter',
            'linkedin'
        ];

        foreach ($socialLinks as $link) {
            if (!filter_var($_POST[$link], FILTER_VALIDATE_URL)) {
                Helpers::setSession("error", "یکی از لینک های شبکه های اجتماعی معتبر نیست");
                Helpers::redirect("/admin/shop-settings");
            }
        }

        $settings = SettingModel::all();

        $logoPath = Helpers::uploadImage(
            'logo',
            'images/settings',
            $settings['logo']
        );

        $faviconPath = Helpers::uploadImage(
            'favicon',
            'images/settings',
            $settings['favicon']
        );

        SettingModel::update(1, [
            'store_name' => trim($_POST['store_name']),
            'store_name_en' => trim($_POST['store_name_en']),
            'slogan' => trim($_POST['slogan']),
            'description' => trim($_POST['description']),

            'logo' => $logoPath,
            'favicon' => $faviconPath,

            'phone' => trim($_POST['phone']),
            'email' => trim($_POST['email']),
            'address' => trim($_POST['address']),

            'instagram' => trim($_POST['instagram']),
            'telegram' => trim($_POST['telegram']),
            'twitter' => trim($_POST['twitter']),
            'linkedin' => trim($_POST['linkedin'])
        ]);

        Helpers::setSession("success", "تنظیمات فروشگاه با موفقیت ذخیره شد");
        Helpers::redirect("/admin/shop-settings");
    }

    public function publicSettings(){
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $settings = SettingModel::all();

        $content = $this->view("Admin/PublicSettings", [
            "settings" => $settings
        ], true);

        $this->view("Admin/Layouts/Master", [
            'content' => $content,
            'title' => 'تنظیمات عمومی',
            'active' => 'publicSettings',
            'styles' => ['/css/admin/public-settings.css'],
            'scripts' => []
        ]);
    }

    public function publicStore()
    {
        if (!isset($_SESSION['admin'])) Helpers::redirect("/admin");

        $requiredFields = [
            'site_language',
            'timezone',
            'date_format',
            'currency',
            'shipping_cost',
            'free_shipping_min_amount',
            'estimated_shipping_days',
            'tax_percent',
            'tax_code',
            'meta_description',
            'meta_keywords'
        ];

        foreach ($requiredFields as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                Helpers::setSession("error", "تمامی فیلد ها را تکمیل کنید");
                Helpers::redirect("/admin/public-settings");
            }
        }

        $shippingCost = (int)($_POST['shipping_cost'] ?? 0);
        $freeShipping = (int)($_POST['free_shipping_min_amount'] ?? 0);
        $shippingDays = (int)($_POST['estimated_shipping_days'] ?? 0);
        $taxPercent = (float)($_POST['tax_percent'] ?? 0);

        if ($shippingCost < 0) {
            Helpers::setSession("error", "هزینه ارسال نامعتبر است");
            Helpers::redirect("/admin/public-settings");
        }

        if ($freeShipping < 0) {
            Helpers::setSession("error", "حداقل خرید برای ارسال رایگان نامعتبر است");
            Helpers::redirect("/admin/public-settings");
        }

        if ($shippingDays < 0) {
            Helpers::setSession("error", "تعداد روز ارسال نامعتبر است");
            Helpers::redirect("/admin/public-settings");
        }

        if ($taxPercent < 0 || $taxPercent > 100) {
            Helpers::setSession("error", "درصد مالیات نامعتبر است");
            Helpers::redirect("/admin/public-settings");
        }

        SettingModel::update(1, [
            'site_language' => trim($_POST['site_language']),
            'timezone' => trim($_POST['timezone']),
            'date_format' => trim($_POST['date_format']),
            'currency' => trim($_POST['currency']),

            'shipping_cost' => $shippingCost,
            'free_shipping_min_amount' => $freeShipping,
            'estimated_shipping_days' => $shippingDays,
            'shipping_enabled' => isset($_POST['shipping_enabled']) ? 1 : 0,

            'tax_percent' => $taxPercent,
            'tax_code' => trim($_POST['tax_code']),

            'meta_description' => trim($_POST['meta_description']),
            'meta_keywords' => trim($_POST['meta_keywords'])
        ]);

        Helpers::setSession("success", "تنظیمات با موفقیت ذخیره شد");
        Helpers::redirect("/admin/public-settings");
    }

}