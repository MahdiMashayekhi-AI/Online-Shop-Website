<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">تنظیمات فروشگاه</h2>
                <p class="text-gray-500 text-sm mt-1">اطلاعات پایه و هویت فروشگاه خود را تنظیم کنید</p>
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

        <form id="shopSettingsForm" method="POST" action="/admin/shop-settings" enctype="multipart/form-data">
            <input type="hidden"
                    name="_token"
                    value="<?= \App\Helpers::csrfToken() ?>">
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-info-circle ml-2 text-blue-600"></i>
                    اطلاعات عمومی فروشگاه
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            نام فروشگاه <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="store_name" id="shopName" value="<?= $pageSettings['store_name'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            نام انگلیسی فروشگاه
                        </label>
                        <input type="text" name="store_name_en" id="shopNameEn" value="<?= $pageSettings['store_name_en'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            شعار فروشگاه
                        </label>
                        <input type="text" name="slogan" id="shopSlogan" value="<?= $pageSettings['slogan'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            توضیحات فروشگاه
                        </label>
                        <textarea id="shopDescription" rows="4" name="description"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"><?= $pageSettings['description'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-image ml-2 text-blue-600"></i>
                    لوگو و تصاویر
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            لوگوی فروشگاه
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer"
                            onclick="document.getElementById('logoInput').click()">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500 text-sm">برای آپلود لوگو کلیک کنید</p>
                            <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden" onchange="previewLogo(this)">
                        </div>
                        <div id="logoPreview" class="mt-3">
                            <div class="image-preview">
                                <img id="logoPreviewImg" src="../<?= $pageSettings['logo'] ?>" alt="<?= $pageSettings['store_name'] ?>" class="w-32 h-32 object-cover rounded-lg border">
                                <span class="remove-image" onclick="removeLogo()">×</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            آیکون فروشگاه (Favicon)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer"
                            onclick="document.getElementById('faviconInput').click()">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500 text-sm">برای آپلود آیکون کلیک کنید</p>
                            <input type="file" name="favicon" id="faviconInput" accept="image/*" class="hidden" onchange="previewFavicon(this)">
                        </div>
                        <div id="faviconPreview" class="mt-3">
                            <div class="image-preview">
                                <img id="faviconPreviewImg" src="../<?= $pageSettings['favicon'] ?>" alt="آیکون" class="w-16 h-16 object-cover rounded-lg border">
                                <span class="remove-image" onclick="removeFavicon()">×</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-phone-alt ml-2 text-blue-600"></i>
                    اطلاعات تماس
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            تلفن فروشگاه
                        </label>
                        <input type="text" name="phone" id="shopPhone" value="<?= $pageSettings['phone'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            ایمیل فروشگاه
                        </label>
                        <input type="email" name="email" id="shopEmail" value="<?= $pageSettings['email'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            آدرس فروشگاه
                        </label>
                        <textarea id="shopAddress" rows="2" name="address"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"><?= $pageSettings['address'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6 settings-section">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-share-alt ml-2 text-blue-600"></i>
                    شبکه‌های اجتماعی
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fab fa-instagram ml-1 text-pink-600"></i>
                            اینستاگرام
                        </label>
                        <input type="text" id="instagram" name="instagram" value="<?= $pageSettings['instagram'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fab fa-telegram ml-1 text-blue-500"></i>
                            تلگرام
                        </label>
                        <input type="text" id="telegram" name="telegram" value="<?= $pageSettings['telegram'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fab fa-twitter ml-1 text-blue-400"></i>
                            توییتر
                        </label>
                        <input type="text" id="twitter" name="twitter" value="<?= $pageSettings['twitter'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fab fa-linkedin ml-1 text-blue-700"></i>
                            لینکدین
                        </label>
                        <input type="text" id="linkedin" name="linkedin" value="<?= $pageSettings['linkedin'] ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-save ml-2"></i>
                    ذخیره تنظیمات
                </button>
                <a href="/admin/shop-settings" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                    <i class="fas fa-undo-alt ml-2"></i>
                    بازنشانی
                </a>
            </div>
        </form>
    </div>
</main>