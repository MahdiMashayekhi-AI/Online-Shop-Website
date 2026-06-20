<?php require_once __DIR__ . "/Layouts/Header.php"?>

<main>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                    به <?= htmlspecialchars($pageSettings['store_name']) ?> خوش آمدید!
                </h1>
                <p class="text-lg md:text-xl my-8 opacity-90">
                    <?= htmlspecialchars($pageSettings['slogan']) ?>
                </p>
                <a href="/products" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:shadow-xl transition transform hover:scale-105">
                    مشاهده محصولات
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Ads Section -->
    <section class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

                <div class="relative rounded-2xl overflow-hidden shadow-lg group cursor-pointer">
                    <img src="/images/ads.gif" alt="تبلیغات" class="w-full object-cover group-hover:scale-105 transition duration-500">
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-lg group cursor-pointer">
                    <img src="/images/ads.gif" alt="تبلیغات" class="w-full object-cover group-hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <?php if(!empty($popularCategories)): ?>
        <section class="py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">دسته‌بندی‌های پرطرفدار</h2>
                    <p class="text-gray-500">محبوب‌ترین دسته‌بندی‌های فروشگاه</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <?php foreach($popularCategories as $category): ?>
                        <a href="/products?cat=<?= $category['id']; ?>"
                           class="group bg-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition-all hover:-translate-y-2">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-200 w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas <?= htmlspecialchars($category['icon']) ?? 'fa-tag'; ?> text-2xl md:text-3xl text-blue-600"></i>
                            </div>
                            <h3 class="text-base md:text-xl font-bold text-gray-800 mb-1"><?= htmlspecialchars($category['name']); ?></h3>
                            <p class="text-gray-500 text-xs md:text-sm"><?= \App\Helpers::toPersianNumber(number_format($category['products_count'])); ?> محصول</p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Special Products Section -->
    <?php if(!empty($mostExpensiveProducts)): ?>
        <section class="py-12 md:py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">محصولات ویژه</h2>
                        <p class="text-gray-500 text-sm mt-1">گران‌ترین و لوکس‌ترین محصولات</p>
                    </div>
                    <a href="/products" class="text-blue-600 hover:text-blue-700 font-semibold">
                        مشاهده همه
                        <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                    <?php foreach($mostExpensiveProducts as $product): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all hover:-translate-y-2 group">
                            <div class="relative overflow-hidden h-56">
                                <a href="/product?id=<?= $product['id']; ?>">
                                <img src="<?= htmlspecialchars($product['main_image']) ?? '/images/products/no-image.jpg'; ?>"
                                     alt="<?= htmlspecialchars($product['name']); ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"></a>
                                <?php if($product['discount_percent'] > 0): ?>
                                    <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-semibold">
                                        <?= \App\Helpers::toPersianNumber($product['discount_percent']); ?>%
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded"><?= htmlspecialchars($product['category_name']); ?></span>
                                <h3 class="font-bold text-gray-800 mt-2 mb-1 line-clamp-1"><?= htmlspecialchars($product['name']); ?></h3>
                                <div class="flex justify-between items-center mt-3">
                                    <div>
                                        <span class="text-lg font-bold text-blue-600"><?= \App\Helpers::formatPrice($product['discounted_price']); ?></span>
                                        <span class="text-xs text-gray-500">تومان</span>
                                        <?php if(\App\Helpers::calculateDiscount($product['price'], $product['discounted_price']) > 0): ?>
                                            <span class="line-through text-gray-400 text-xs mr-1"><?= \App\Helpers::formatPrice($product['price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="/product?id=<?= $product['id']; ?>" class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- New Products Section -->
    <?php if(!empty($newestProducts)): ?>
        <section class="py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">جدیدترین محصولات</h2>
                        <p class="text-gray-500 text-sm mt-1">تازه‌های فروشگاه را ببینید</p>
                    </div>
                    <a href="/products" class="text-blue-600 hover:text-blue-700 font-semibold">
                        مشاهده همه
                        <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php foreach($newestProducts as $product): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all hover:-translate-y-2 group flex flex-col h-full">
                            <div class="relative overflow-hidden flex-shrink-0 h-48 md:h-56">
                                <a href="/product?id=<?= $product['id']; ?>">
                                    <img src="<?= htmlspecialchars($product['main_image']) ?? 'images/products/no-image.jpg'; ?>"
                                         alt="<?= htmlspecialchars($product['name']); ?>"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </a>
                                <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-0.5 rounded text-xs">
                                    جدید
                                </div>
                            </div>

                            <div class="p-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-sm line-clamp-1"><?= htmlspecialchars($product['name']); ?></h3>
                                    <?php if(!empty($product['short_description'])): ?>
                                        <p class="text-gray-500 text-xs mt-1 line-clamp-2"><?= htmlspecialchars(\App\Helpers::truncate($product['short_description'])); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <div>
                                        <span class="font-bold text-blue-600 text-sm"><?= \App\Helpers::formatPrice($product['discounted_price']); ?></span>
                                        <span class="text-xs text-gray-500">تومان</span>
                                    </div>
                                    <a href="/product?id=<?= $product['id']; ?>" class="bg-blue-600 text-white px-2 py-1 rounded-lg hover:bg-blue-700 transition text-sm">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="py-12 md:py-16 bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-right">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">
                            تخفیف ویژه هفته!
                        </h3>
                        <p class="text-white/90 text-base md:text-lg mb-4">
                            با کد تخفیف <span class="font-bold bg-yellow-400 text-gray-900 px-3 py-1 rounded">WEEKEND1405</span>
                            از ۲۰٪ تخفیف ویژه بهره‌مند شوید
                        </p>
                        <button class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:shadow-xl transition">
                            خرید سریع
                        </button>
                    </div>
                    <div>
                        <img src="/images/ads.gif" alt="تبلیغات" class="rounded-xl max-h-32 md:max-h-48">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . "/Layouts/Footer.php"?>