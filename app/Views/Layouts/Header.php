<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?= htmlspecialchars($title) ?? 'فروشگاه آنلاین' ?> | بهترین قیمت‌ها</title>
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?= $pageSettings['favicon'] ?>">
    <meta name="author" content="مهدی مشایخی">
    <meta name="keywords" content="<?= htmlspecialchars($pageSettings['meta_keywords']) ?>">
    <meta name="description" content="<?= htmlspecialchars($pageSettings['meta_description']) ?>">
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-4">

        <div class="hidden lg:flex items-center justify-between gap-4">
            <a href="/" class="flex items-center gap-2 hover:opacity-90 transition">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-store text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    <?= htmlspecialchars($pageSettings['store_name']) ?>
                </h1>
            </a>

            <div class="flex items-center gap-6 mr-10">
                <a href="/" class="text-gray-700 hover:text-blue-600 transition font-medium">
                    خانه
                </a>
                <a href="/products" class="text-gray-700 hover:text-blue-600 transition font-medium">
                    محصولات
                </a>
                <a href="/about-us" class="text-gray-700 hover:text-blue-600 transition font-medium">
                    درباره ما
                </a>
                <a href="/contact-us" class="text-gray-700 hover:text-blue-600 transition font-medium">
                    تماس با ما
                </a>
            </div>

            <div class="flex-1 max-w-md">
                <div class="relative text-center">
                    <form action="/products" method="GET">
                        <input type="text"
                               name="search"
                               value="<?= htmlspecialchars($search) ?>"
                               placeholder="جستجوی محصولات..."
                               class="w-full lg:w-3/4 items-center py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </form>
                </div>
            </div>

            <div class="flex gap-3">
                <?php if (!empty($_SESSION['user'])) {?>
                    <a href="/logout" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold text-sm text-center">
                        <i class="fas fa-user ml-1"></i>
                        خروج
                    </a>
                <?php } else { ?>
                    <a href="/login" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm text-center">
                        <i class="fas fa-user ml-1"></i>
                        ورود | ثبت‌نام
                    </a>
                <?php } ?>
                <a href="/cart" class="relative bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-shopping-cart text-xl text-gray-700"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>

        <div class="lg:hidden">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-3 py-1 rounded-lg">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                        فروشگاه‌آنلاین
                    </h1>
                </a>
                <button id="mobileMenuBtn" class="text-gray-700 text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div id="mobileMenu" class="hidden mt-4 space-y-4">
                <div class="relative">
                    <form action="/products" method="GET">
                        <input type="text"
                               name="search"
                               value="<?= htmlspecialchars($search) ?>"
                               placeholder="جستجوی محصولات..."
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </form>
                </div>

                <div class="flex flex-col space-y-2 border-t border-gray-100 pt-3">
                    <a href="/" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                        <i class="fas fa-home w-5 text-gray-400"></i>
                        <span>خانه</span>
                    </a>
                    <a href="/products" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                        <i class="fas fa-box w-5 text-gray-400"></i>
                        <span>محصولات</span>
                    </a>
                    <a href="/about-us" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                        <i class="fas fa-info-circle w-5 text-gray-400"></i>
                        <span>درباره ما</span>
                    </a>
                    <a href="/contact-us" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                        <i class="fas fa-phone-alt w-5 text-gray-400"></i>
                        <span>تماس با ما</span>
                    </a>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <?php if (!empty($_SESSION['user'])) {?>
                        <a href="/logout" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold text-sm text-center">
                            <i class="fas fa-user ml-1"></i>
                            خروج
                        </a>
                    <?php } else { ?>
                        <a href="/login" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm text-center">
                            <i class="fas fa-user ml-1"></i>
                            ورود | ثبت‌نام
                        </a>
                    <?php } ?>
                    <a href="/cart" class="relative bg-gray-100 p-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-xl text-gray-700"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
