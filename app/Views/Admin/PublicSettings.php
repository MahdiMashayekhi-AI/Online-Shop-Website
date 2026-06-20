<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">تنظیمات عمومی</h2>
                <p class="text-gray-500 text-sm mt-1">پیکربندی کلی سیستم و تنظیمات فروشگاه</p>
            </div>
        </div>
    </header>

    <div class="p-6">
        <?php use App\Helpers;?>
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

        <form id="generalSettingsForm" method="POST" action="/admin/public-settings" enctype="multipart/form-data">
            <input type="hidden"
                    name="_token"
                    value="<?= \App\Helpers::csrfToken() ?>">
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-globe ml-2 text-blue-600"></i>
                    تنظیمات سایت
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            زبان سایت
                        </label>
                        <select id="siteLanguage" name="site_language" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="fa" <?= $pageSettings['site_language'] == 'fa' ? 'selected' : '' ?>>فارسی</option>
                            <option value="en" <?= $pageSettings['site_language'] == 'en' ? 'selected' : '' ?>>English</option>
                            <option value="ar" <?= $pageSettings['site_language'] == 'ar' ? 'selected' : '' ?>>العربية</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            منطقه زمانی
                        </label>
                        <select id="timezone" name="timezone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="Asia/Tehran" <?= ($pageSettings['timezone'] === "Asia/Tehran") ? 'selected' : '' ?>>ایران ( Tehran )</option>
                            <option value="Asia/Dubai" <?= ($pageSettings['timezone'] === "Asia/Dubai") ? 'selected' : '' ?>>دبی ( Dubai )</option>
                            <option value="UTC" <?= ($pageSettings['timezone'] === "UTC") ? 'selected' : '' ?>>UTC</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            قالب تاریخ
                        </label>
                        <select id="date_format" name="date_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="jalali" <?= ($settings['date_format'] === "jalali") ? 'selected' : '' ?>>شمسی (۱۴۰۳/۰۱/۱۵)</option>
                            <option value="gregorian" <?= ($settings['date_format'] === "gregorian") ? 'selected' : '' ?> >میلادی (2024/04/05)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            واحد پول
                        </label>
                        <select id="currency" name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="IRR" <?= ($settings['currency'] === "IRR") ? 'selected' : '' ?>>تومان ایران (IRR)</option>
                            <option value="USD" <?= ($settings['currency'] === "USD") ? 'selected' : '' ?>>دلار آمریکا (USD)</option>
                            <option value="EUR" <?= ($settings['currency'] === "EUR") ? 'selected' : '' ?>>یورو (EUR)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-truck ml-2 text-blue-600"></i>
                    تنظیمات ارسال
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            هزینه ارسال (تومان)
                        </label>
                        <input type="number" name="shipping_cost" id="shippingCost" value="<?= $settings['shipping_cost'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            حداقل خرید برای ارسال رایگان (تومان)
                        </label>
                        <input type="number" name="free_shipping_min_amount" id="freeShippingMin" value="<?= $settings['free_shipping_min_amount'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            زمان تخمینی ارسال (روز)
                        </label>
                        <input type="number" name="estimated_shipping_days" id="estimatedDelivery" value="<?= $settings['estimated_shipping_days'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <div class="toggle-switch">
                                <input type="checkbox" name="shipping_enabled" id="enableShipping" <?= $settings['shipping_enabled'] ? 'checked' : '' ?> value="1">
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="text-gray-700">فعال بودن سیستم ارسال</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-chart-line ml-2 text-blue-600"></i>
                    تنظیمات مالی
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            مالیات (درصد)
                        </label>
                        <input type="number" name="tax_percent" id="taxRate" value="<?= $settings['tax_percent'] ?>" step="0.5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            کد مالیاتی
                        </label>
                        <input type="text" name="tax_code" id="taxCode" value="<?= $settings['tax_code'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fab fa-google ml-2 text-blue-600"></i>
                    تنظیمات سئو
                </h3>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            توضیحات متا (Meta Description)
                        </label>
                        <textarea id="metaDescription" rows="2" name="meta_description"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"><?= $settings['meta_description'] ?></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            کلمات کلیدی (Meta Keywords)
                        </label>
                        <input type="text" name="meta_keywords" id="metaKeywords" value="<?= $settings['meta_keywords'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-save ml-2"></i>
                    ذخیره تنظیمات
                </button>
                <a href="/admin/public-settings" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                    <i class="fas fa-undo-alt ml-2"></i>
                    بازنشانی
                </a>
            </div>
        </form>
    </div>
</main>