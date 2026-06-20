<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">مدیریت محصولات</h2>
                    <p class="text-gray-500 text-sm mt-1">مدیریت و ویرایش محصولات فروشگاه</p>
                </div>
                <a href="/admin/add-product" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    افزودن محصول جدید
                </a>
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

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">کل محصولات</p>
                <p class="text-2xl font-bold" id="totalProducts"><?= \App\Helpers::toPersianNumber($stats['total']) ?></p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">موجود در انبار</p>
                <p class="text-2xl font-bold" id="inStockProducts"><?= \App\Helpers::toPersianNumber($stats['in_stock']) ?></p>
            </div>
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">ناموجود</p>
                <p class="text-2xl font-bold" id="outStockProducts"><?= \App\Helpers::toPersianNumber($stats['out_stock']) ?></p>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">تخفیف‌دار</p>
                <p class="text-2xl font-bold" id="discountProducts"><?= \App\Helpers::toPersianNumber($stats['discounted']) ?></p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4 justify-between">

                <div class="flex-1">
                    <form method="GET" action="">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" id="searchInput"
                                   placeholder="جستجوی محصولات"
                                   value="<?= htmlspecialchars($search) ?? '' ?>"
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                    </form>
                </div>

                <div class="flex gap-3 flex-wrap">
                    <a href="/admin/products"
                       class="category-filter-btn active px-4 py-2 <?= $categoryId == 0 ? 'bg-blue-600 text-white' : '' ?> rounded-lg text-sm" data-category="all">
                        همه
                    </a>
                    <?php foreach($categories as $category): ?>
                        <a href="/admin/products?category=<?= $category['id'] ?>"
                           class="category-filter-btn px-4 py-2 <?= $categoryId == $category['id'] ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' ?> rounded-lg text-sm hover:bg-gray-200 transition" data-category="<?= $category['name'] ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="table-responsive">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">تصویر</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">نام محصول</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">دسته‌بندی</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">قیمت (تومان)</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">موجودی</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                    <?php foreach($products as $product): ?>
                        <tr class="product-row border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <img src="../<?= htmlspecialchars($product['main_image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="rounded-lg object-cover">
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        کد: #PRD-<?= $product['id'] ?>
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    <?= htmlspecialchars($product['category_name'] ?? '-') ?>
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <?php if (!empty($product['discounted_price'])): ?>
                                        <span class="font-bold text-green-600">
                                            <?= \App\Helpers::formatPrice(($product['discounted_price'])) ?>
                                        </span>
                                        <span class="text-xs text-gray-400 line-through mr-1">
                                            <?= \App\Helpers::formatPrice($product['price']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="font-bold text-gray-800">
                                            <?= \App\Helpers::formatPrice($product['price']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <span class="text-xs text-gray-500 mr-1">تومان</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <?php if ((int)$product['stock'] > 0): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                        <i class="fas fa-check-circle"></i>
                                        <?= \App\Helpers::toPersianNumber((int)$product['stock']) ?> عدد
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                                        <i class="fas fa-times-circle"></i>
                                        ناموجود
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2 justify-center">

                                    <a href="/admin/edit-product?id=<?= $product['id'] ?>"
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                       title="ویرایش">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="/admin/delete-product"
                                          onsubmit="return confirm('حذف این محصول؟')">
                                        <input type="hidden"
                                            name="_token"
                                            value="<?= \App\Helpers::csrfToken() ?>">

                                        <input type="hidden" name="id" value="<?= $product['id'] ?>">

                                        <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="حذف">
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

            <!-- Pagination -->
            <div class="mt-5 mb-5 md:mt-12 flex justify-center">
                <div class="flex gap-2 flex-wrap justify-center">
                    <?php if ($page > 1) {?>
                        <a href="?page=<?= $page - 1 ?>" class="px-3 md:px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm md:text-base">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php } ?>

                    <?php for($i = 1; $i <= $totalPages; $i++): ?>

                        <a href="?page=<?= $i ?>"
                           class="px-3 py-2 border <?= ($page == $i ? 'bg-blue-600 text-white' : '') ?>">
                            <?= $i ?>
                        </a>

                    <?php endfor; ?>

                    <?php if ($page < $totalPages) {?>
                        <a href="?page=<?= $page + 1 ?>" class="px-3 md:px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm md:text-base">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>
