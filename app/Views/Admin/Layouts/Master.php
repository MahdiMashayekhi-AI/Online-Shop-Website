<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?= htmlspecialchars($title) ?? 'پنل ادمین' ?> | فروشگاه آنلاین</title>
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../<?= $pageSettings['favicon'] ?>">
    <meta name="author" content="مهدی مشایخی">
    <meta name="keywords" content="<?= htmlspecialchars($pageSettings['meta_keywords']) ?>">
    <meta name="description" content="<?= htmlspecialchars($pageSettings['meta_description']) ?>">
    <?php if (!empty($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <style>
        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }
        .image-preview {
            position: relative;
            display: inline-block;
        }
        .image-preview .remove-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .notification-row:hover {
            background-color: #f3f4f6;
        }
        .notification-unread {
            background-color: #f0f9ff;
            border-right: 3px solid #3b82f6;
        }
        .modal {
            transition: all 0.3s ease;
        }
        .modal.show {
            display: flex !important;
        }
        .pagination-btn.active {
            background-color: #3b82f6;
            color: white;
        }
        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .type-badge {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <aside class="bg-gradient-to-b from-gray-900 to-gray-800 text-white w-72 flex-shrink-0 overflow-y-auto sidebar-menu shadow-xl z-20">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-700">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-3 py-2 rounded-lg">
                    <i class="fas fa-store text-2xl"></i>
                </div>
                <div>
                    <a href="/" class="text-xl font-bold cursor-pointer">فروشگاه‌آنلاین</a>
                    <p class="text-xs text-gray-400">پنل مدیریت</p>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-white"><?= htmlspecialchars($_SESSION['admin']['name']) ?></p>
                        <p class="text-xs text-gray-400">مدیر ارشد</p>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-400">تاریخ امروز:</span>
                        <span class="text-white" id="currentDate"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs mt-1">
                        <span class="text-gray-400">ساعت:</span>
                        <span class="text-white" id="currentTime"></span>
                    </div>
                </div>
            </div>

            <nav class="space-y-1 sidebar-menu">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3 px-3">داشبورد</p>

                <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>داشبورد اصلی</span>
                </a>

                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3 mt-4 px-3">مدیریت محصولات</p>

                <a href="/admin/add-product" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'addProduct') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-plus-circle w-5"></i>
                    <span>افزودن محصول جدید</span>
                </a>
                <a href="/admin/products" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'products') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-list-alt w-5"></i>
                    <span>لیست محصولات</span>
                </a>
                <a href="/admin/categories" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'categories') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-tags w-5"></i>
                    <span>دسته‌بندی‌ها</span>
                </a>

                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3 mt-4 px-3">مدیریت سفارشات</p>

                <a href="/admin/orders" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'orders') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span>همه سفارشات</span>
                </a>

                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3 mt-4 px-3">مدیریت کاربران</p>

                <a href="/admin/users" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'users') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-users w-5"></i>
                    <span>همه کاربران</span>
                </a>

                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3 mt-4 px-3">تنظیمات</p>

                <a href="/admin/shop-settings" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'shopSettings') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-store w-5"></i>
                    <span>تنظیمات فروشگاه</span>
                </a>
                <a href="/admin/public-settings" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'publicSettings') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-sliders-h w-5"></i>
                    <span>تنظیمات عمومی</span>
                </a>
                <a href="/admin/contact-messages" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($active === 'contacts') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';?> transition group">
                    <i class="fas fa-contact-card w-5"></i>
                    <span>ارتباط با ما</span>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-700">
                    <a href="/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-900/20 hover:text-red-300 transition group">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>خروج از حساب</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <?= $content ?>
</div>

<script>
    function updateDateTime() {
        const now = new Date();

        const persianDate = new Intl.DateTimeFormat('fa-IR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            weekday: 'long'
        }).format(now);

        const time = now.toLocaleTimeString('fa-IR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        document.getElementById('currentDate').innerHTML = persianDate;
        document.getElementById('currentTime').innerHTML = time;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

<?php if (!empty($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <script src="<?= $script ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>