<?php use App\Helpers;?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>ورود | فروشگاه آنلاین</title>
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?= $pageSettings['favicon'] ?>">
    <meta name="author" content="مهدی مشایخی">
    <meta name="keywords" content="<?= htmlspecialchars($pageSettings['meta_keywords']) ?>">
    <meta name="description" content="<?= htmlspecialchars($pageSettings['meta_description']) ?>">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">

<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-4">
        <div class="flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-store text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    <?= htmlspecialchars($pageSettings['store_name']) ?>
                </h1>
            </a>
        </div>
    </div>
</nav>

<div class="container mx-auto px-4 py-12 md:py-20">
    <div class="max-w-md mx-auto">

        <div class="text-center mb-8">
            <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-circle text-4xl text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">خوش آمدید!</h1>
            <p class="text-gray-500">برای ورود اطلاعات خود را وارد کنید</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-md animate__animated animate__fadeInDown" id="alert-message">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-white text-lg"></i>
                        <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['success']) ?></span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php Helpers::removeSession("success"); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-md animate__animated animate__fadeInDown" id="alert-message">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-white text-lg"></i>
                        <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['error']) ?></span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php Helpers::removeSession("error"); ?>
            <?php endif; ?>
            <form id="loginForm" method="POST" action="/admin">
                <input type="hidden"
                        name="_token"
                        value="<?= \App\Helpers::csrfToken() ?>">

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope ml-1 text-gray-400"></i>
                        ایمیل
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           required
                           autocomplete="off"
                           placeholder="example@gmail.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock ml-1 text-gray-400"></i>
                        رمز عبور
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               autocomplete="off"
                               placeholder="********"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                        <button type="button" id="togglePassword" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                    <i class="fas fa-sign-in-alt ml-2"></i>
                    ورود
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="/" class="text-gray-500 hover:text-blue-600 transition text-sm">
                <i class="fas fa-arrow-right ml-1"></i>
                بازگشت به صفحه اصلی
            </a>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.querySelector('i').classList.toggle('fa-eye');
        togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>