<?php

namespace App;

use IntlDateFormatter;

class Helpers {
    public static function toPersianNumber($number) {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

        return str_replace($en, $fa, (string) $number);
    }

    public static function removeDecimal($number) {
        $numberStr = (string) $number;

        if(strpos($numberStr, '.') !== false)
            $numberStr = substr($numberStr, 0, strpos($numberStr, '.'));

        return (int) $numberStr;
    }

    public static function formatPrice($number) {
        $intNumber = self::removeDecimal($number);

        $formatted = number_format($intNumber, 0, '.', ',');

        return self::toPersianNumber($formatted);
    }

    public static function calculateDiscount($realPrice, $disPrice){
        return round((($realPrice - $disPrice) / $realPrice) * 100);
    }

    public static function timeAgo(int $timestamp): string
    {
        $diff = time() - $timestamp;

        if($diff < 60) {
            return 'چند لحظه پیش';
        } elseif($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' دقیقه پیش';
        } elseif($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' ساعت پیش';
        } elseif($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' روز پیش';
        } else
            return self::jalaliFormatter()->format($timestamp);
    }

    public static function jalaliFormatter($pattern = "yyyy/MM/dd")
    {
        static $cache = [];

        if (!isset($cache[$pattern])) {

            $cache[$pattern] = new IntlDateFormatter(
                "fa_IR",
                IntlDateFormatter::FULL,
                IntlDateFormatter::FULL,
                "Asia/Tehran",
                IntlDateFormatter::TRADITIONAL,
                $pattern
            );
        }

        return $cache[$pattern];
    }

    public static function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function getSession(string $key, bool $remove = false): mixed
    {
        if (!isset($_SESSION[$key])) return null;

        $value = $_SESSION[$key];

        if ($remove) {
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);
        }

        return $value;
    }

    public static function hasSession(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function removeSession(string $key): void
    {
        $_SESSION[$key] = null;
        unset($_SESSION[$key]);
    }

    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    public static function csrfToken(): string
    {
     if (!self::hasSession("_csrf"))
         self::setSession("_csrf", bin2hex(random_bytes(32)));

     return self::getSession("_csrf");
    }

    public static function validateCsrfToken(?string $token): bool
    {
        if (!self::hasSession("_csrf") || empty($token)) return false;

        return hash_equals(self::getSession("_csrf"), $token);
    }

    public static function uploadImage(string $inputName, string $directory, ?string $default = null): ?string{
        if (empty($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK)
            return $default;

        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mimeType = finfo_file(
            $finfo,
            $_FILES[$inputName]['tmp_name']
        );

        finfo_close($finfo);

        if (!isset($allowedMimeTypes[$mimeType]))
            return $default;

        if ($_FILES[$inputName]['size'] > 5 * 1024 * 1024)
            return $default;

        if (!is_dir($directory))
            mkdir($directory, 0777, true);

        $extension = $allowedMimeTypes[$mimeType];

        $filename =
            uniqid('', true) .
            '.' .
            $extension;

        $path =
            rtrim($directory, '/') .
            '/' .
            $filename;

        move_uploaded_file(
            $_FILES[$inputName]['tmp_name'],
            $path
        );

        return $path;
    }

    public static function getOrderBadge($status) {
        $statuses = [
            'pending' => ['label' => 'در انتظار پرداخت', 'color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'],
            'processing' => ['label' => 'در حال پردازش', 'color' => 'bg-purple-100 text-purple-800', 'icon' => 'fa-spinner'],
            'shipped' => ['label' => 'ارسال شده', 'color' => 'bg-orange-100 text-orange-800', 'icon' => 'fa-truck'],
            'delivered' => ['label' => 'تحویل شده', 'color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
            'cancelled' => ['label' => 'لغو شده', 'color' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle']
        ];

        return $statuses[$status] ?? $statuses['pending'];
    }

    public static function truncate($text, $limit = 100, $ending = '...') {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }
        return mb_substr($text, 0, $limit) . $ending;
    }
}