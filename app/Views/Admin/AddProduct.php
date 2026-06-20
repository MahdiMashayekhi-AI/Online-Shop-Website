<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">افزودن محصول جدید</h2>
                    <p class="text-gray-500 text-sm mt-1">اطلاعات محصول را وارد کنید</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="window.location.href='/admin/products'" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-arrow-right ml-1"></i>
                        بازگشت
                    </button>
                </div>
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
        <form id="addProductForm" action="/admin/add-product" method="POST" enctype="multipart/form-data">
            <input type="hidden"
                    name="_token"
                    value="<?= \App\Helpers::csrfToken() ?>">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Section -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">اطلاعات پایه محصول</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-tag ml-1 text-gray-400"></i>
                                    نام محصول <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="productName" required
                                    placeholder="مثال: لپ‌تاپ گیمینگ ایسوس TUF Gaming F15"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-link ml-1 text-gray-400"></i>
                                    Slug <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="slug" id="productName" required
                                       placeholder="laptop-asus-tuf-f15-gaming"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-folder ml-1 text-gray-400"></i>
                                    دسته‌بندی <span class="text-red-500">*</span>
                                </label>
                                <select id="category" name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-align-left ml-1 text-gray-400"></i>
                                    توضیحات کوتاه
                                </label>
                                <textarea id="shortDesc" rows="4" name="shortDesc"
                                        placeholder="توضیحات مختصر درباره محصول..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-file-alt ml-1 text-gray-400"></i>
                                    توضیحات کامل
                                </label>
                                <textarea id="fullDesc" rows="8" name="description"
                                        placeholder="توضیحات کامل محصول شامل ویژگی‌ها، مشخصات فنی، نحوه استفاده و ..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">قیمت و موجودی</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-dollar-sign ml-1 text-gray-400"></i>
                                    قیمت اصلی (تومان) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="price" required name="price"
                                    placeholder="مثال: 25990000"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-percent ml-1 text-gray-400"></i>
                                    قیمت پس از تخفیف
                                </label>
                                <input type="number" id="discountPrice" name="discountPrice"
                                    placeholder="در صورت وجود تخفیف"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-boxes ml-1 text-gray-400"></i>
                                    موجودی <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="stock" required name="stock"
                                    placeholder="تعداد موجود"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-toggle-on ml-1 text-gray-400"></i>
                                    وضعیت محصول
                                </label>
                                <select id="status" name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="1">فعال</option>
                                    <option value="0">غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="space-y-6">

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">تصویر محصول</h3>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-image ml-1 text-gray-400"></i>
                                تصویر اصلی <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer"
                                 onclick="document.getElementById('mainImageInput').click()">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500 text-sm">برای آپلود تصویر اصلی کلیک کنید</p>
                                <input type="file" name="main_image" id="mainImageInput" accept="image/*" class="hidden" onchange="previewMainImage(this)">
                            </div>
                                <div id="mainImagePreview" class="hidden mt-3">
                                    <div class="image-preview">
                                        <img id="mainPreviewImg" src="" alt="پیش‌نمایش" class="w-32 h-32 object-cover rounded-lg">
                                        <span class="remove-image" onclick="removeMainImage()">×</span>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                            <i class="fas fa-save ml-2"></i>
                            ذخیره محصول
                        </button>
                        <button type="reset" class="w-full mt-3 bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition">
                            پاک کردن فرم
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>