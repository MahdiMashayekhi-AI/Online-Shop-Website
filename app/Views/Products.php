<?php require_once __DIR__ . "/Layouts/Header.php"?>

<main>
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="/" class="hover:text-blue-600">خانه</a>
                <i class="fas fa-chevron-left mx-2 text-xs"></i>
                <span class="text-gray-900 font-semibold">محصولات</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800">دسته‌بندی محصولات</h2>
                <span class="text-sm text-gray-500 lg:hidden">→ اسکرول کنید</span>
            </div>
            <div class="overflow-x-auto pb-2 scrollbar-thin">
                <div class="flex gap-3 min-w-max">
                    <a href="?"
                       class="px-5 py-2 bg-blue-600 text-white rounded-full text-sm font-semibold">
                        همه
                    </a>
                    <?php foreach($categories as $category): ?>

                        <a href="?cat=<?= $category['id'] ?>"
                           class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap
                        <?= $cat == $category['id']
                               ? 'bg-blue-600 text-white'
                               : 'bg-gray-100 text-gray-700' ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </a>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-gray-600 text-sm md:text-base">
                <i class="fas fa-database ml-1"></i>
                <span id="resultsCount"><?= $totalProducts ?></span> محصول پیدا شد
            </div>
        </div>

        <!-- Products Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php foreach ($products as $product){ ?>
            <div onclick="window.location='/product?id=<?= $product['id'] ?>'">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all hover:-translate-y-2 duration-300 group">
                <div class="relative overflow-hidden h-56 sm:h-64">
                    <img src="<?= htmlspecialchars($product["main_image"]) ?? 'images/products/no-image.jpg' ?> "
                         alt="<?= htmlspecialchars($product["name"]) ?>"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-semibold">
                        <?= \App\Helpers::toPersianNumber(\App\Helpers::calculateDiscount($product['price'], $product['discounted_price'])) ?>%
                    </div>
                    <button class="absolute bottom-3 left-3 bg-white/90 p-2 rounded-full shadow-md hover:bg-red-500 hover:text-white transition">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-gray-800 hover:text-blue-600 transition cursor-pointer text-base md:text-lg">
                            <?= $product["name"] ?>
                        </h3>
                        <div class="flex items-center text-sm text-yellow-500">
                            <i class="fas fa-star"></i>
                            <span class="mr-1 text-gray-600 text-xs">۴.۸</span>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs md:text-sm mb-3"><?= htmlspecialchars(\App\Helpers::truncate($product["short_description"])) ?> </p>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-lg md:text-xl font-bold text-blue-600"><?= \App\Helpers::formatPrice($product["price"]) ?> </span>
                            <span class="text-gray-500 text-xs">تومان</span>
                            <span class="line-through text-gray-400 text-xs mr-2"><?= \App\Helpers::formatPrice($product["discounted_price"]) ?> </span>
                        </div>
                        <form method="POST" action="/cart/add">
                            <input type="hidden"
                                    name="_token"
                                    value="<?= \App\Helpers::csrfToken() ?>">
                                    
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                            <button type="submit"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition text-sm">

                                <i class="fas fa-shopping-cart"></i>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <?php } ?>
        </div>

        <!-- Pagination Section -->
        <div class="mt-10 md:mt-12 flex justify-center">
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
</main>

<?php require_once __DIR__ . "/Layouts/Footer.php"?>