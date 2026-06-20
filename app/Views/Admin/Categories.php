<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">مدیریت دسته‌بندی‌ها</h2>
                    <p class="text-gray-500 text-sm mt-1">مدیریت دسته‌بندی‌های محصولات فروشگاه</p>
                </div>
                <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    افزودن دسته‌بندی جدید
                </button>
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">تعداد کل دسته‌بندی‌ها</p>
                <p class="text-2xl font-bold" id="totalCategories"><?= $stats['total'] ?></p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">دسته‌بندی‌های فعال</p>
                <p class="text-2xl font-bold" id="activeCategories"><?= $stats['active'] ?></p>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">دسته بندی های غیر فعال</p>
                <p class="text-2xl font-bold" id="totalCategoryProducts"><?= $stats['inactive'] ?></p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="table-responsive">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">آیکون</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">نام دسته‌بندی</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">نام انگلیسی</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">تعداد محصولات</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">وضعیت</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-folder-open text-4xl mb-2 block"></i>
                                    دسته‌بندی‌ای یافت نشد!
                                    <button onclick="openAddModal()" class="block mx-auto mt-3 text-blue-600 hover:text-blue-700">
                                        افزودن دسته‌بندی جدید
                                    </button>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($categories as $category): ?>
                            <tr class="category-row border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center text-blue-600 text-xl">
                                        <i class="fas <?= htmlspecialchars($category['icon']) ?>"></i>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($category['name']) ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="px-2 py-1 bg-gray-100 rounded text-sm"><?= htmlspecialchars($category['slug']) ?></code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-blue-600"><?= $category['products_count'] ?></span>
                                    <span class="text-xs text-gray-500">محصول</span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($category['is_active']): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                        <i class="fas fa-check-circle"></i>
                                        فعال
                                    </span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                                        <i class="fas fa-times-circle"></i>
                                        غیرفعال
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <button data-id="<?= $category['id'] ?>"
                                                data-name="<?= htmlspecialchars($category['name'] ?? '') ?>"
                                                data-slug="<?= htmlspecialchars($category['slug'] ?? '') ?>"
                                                data-icon="<?= htmlspecialchars($category['icon'] ?? '') ?>"
                                                data-status="<?= $category['is_active'] ?>"
                                                class="edit-btn p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="/admin/categories/delete"
                                              method="POST"
                                              style="display:inline;">

                                            <input type="hidden"
                                               name="_token"
                                               value="<?= \App\Helpers::csrfToken() ?>">

                                            <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $category['id'] ?>"
                                            >
                                            <button onclick="return confirm('حذف شود؟')"  class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<div id="categoryModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800">افزودن دسته‌بندی جدید</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="categoryForm" method="POST" action="/admin/categories/store">
            <div class="p-6 space-y-4">
                <input type="hidden"
                        name="_token"
                        value="<?= \App\Helpers::csrfToken() ?>">

                <input type="hidden" name="id" id="categoryId" value="">

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag ml-1 text-gray-400"></i>
                        نام دسته‌بندی <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="categoryName" required
                           placeholder="مثال: لپ‌تاپ"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-code ml-1 text-gray-400"></i>
                        نام انگلیسی (اسلاگ) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="slug" id="categorySlug" required
                           placeholder="مثال: laptop"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">برای آدرس‌دهی و URL استفاده می‌شود</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-icons ml-1 text-gray-400"></i>
                        آیکون (Font Awesome)
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="icon" id="categoryIcon"
                               placeholder="مثال: fa-laptop"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <div id="iconPreview" class="w-12 h-12 border rounded-lg flex items-center justify-center text-2xl text-gray-500">
                            <i class="fas fa-tag"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">کد آیکون از Font Awesome (مثال: fa-laptop, fa-mobile-alt)</p>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" id="categoryStatus" class="w-4 h-4 text-blue-600 rounded">
                        <span class="text-gray-700">فعال</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 p-6 border-t bg-gray-50">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-save ml-1"></i>
                    ذخیره
                </button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                    انصراف
                </button>
            </div>
        </form>
    </div>
</div>