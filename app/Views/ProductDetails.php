<?php require_once __DIR__ . "/Layouts/Header.php"?>

<main>
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center text-sm text-gray-600 flex-wrap gap-2">
                <a href="/" class="hover:text-blue-600">خانه</a>
                <i class="fas fa-chevron-left text-xs"></i>
                <a href="/products" class="hover:text-blue-600">محصولات</a>
                <i class="fas fa-chevron-left text-xs"></i>
                <span class="text-gray-900 font-semibold"><?= htmlspecialchars($product['name']) ?></span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col lg:flex-row gap-8 p-4 md:p-8">

                <!-- Right Section -->
                <div class="lg:w-1/2">
                    <div class="relative bg-gray-100 rounded-2xl overflow-hidden mb-4 h-96 w-96">
                        <img id="mainImage"
                            src="<?= htmlspecialchars($product['main_image']) ?? 'images/products/no-image.jpg' ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="w-full h-full object-contain bg-gray-100">
                        <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                             <?= \App\Helpers::toPersianNumber(\App\Helpers::calculateDiscount($product['price'], $product['discounted_price'])) ?>٪ - تخفیف
                        </div>
                        <button class="absolute bottom-4 left-4 bg-white/90 p-3 rounded-full shadow-md hover:bg-red-500 hover:text-white transition">
                            <i class="far fa-heart text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Left Section -->
                <div class="lg:w-1/2">
                    <div class="mb-4">
                        <span class="inline-block bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                            <i class="fas fa-laptop ml-1"></i>
                            <?= htmlspecialchars($category['name']) ?>
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                        <?= htmlspecialchars($product['name']) ?>
                    </h1>

                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="mr-2 text-gray-700 font-semibold"><?= \App\Helpers::toPersianNumber(number_format($meanComments[0] ?? 0, 1)) ?></span>
                        </div>
                        <span class="text-gray-400">|</span>
                        <span class="text-gray-500 text-sm"><?= \App\Helpers::toPersianNumber($noComments) ?> نظر</span>
                        <span class="text-gray-400">|</span>
                        <span class="text-green-600 text-sm">
                            <i class="fas fa-check-circle ml-1"></i>
                            <?= $product['stock'] ?> عدد موجود در انبار
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <div class="flex items-baseline gap-3 flex-wrap">
                            <span class="text-3xl md:text-4xl font-bold text-blue-600"><?= \App\Helpers::formatPrice($product['discounted_price']) ?></span>
                            <span class="text-gray-500 text-sm">تومان</span>
                            <span class="line-through text-gray-400 text-lg"><?= \App\Helpers::formatPrice($product['price']) ?></span>
                            <span class="bg-green-500 text-white px-2 py-1 rounded-lg text-sm font-semibold">
                                ذخیره <?= \App\Helpers::formatPrice($product['price'] - $product['discounted_price']) ?> تومان
                            </span>
                        </div>
                        <p class="text-gray-500 text-sm mt-2">
                            قیمت نهایی شامل تخفیف ویژه
                        </p>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">توضیحات محصول:</h3>
                        <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                            <?= htmlspecialchars($product['short_description']) ?>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 items-stretch">

                        <form method="POST" action="/cart/add">
                            <input type="hidden"
                                    name="_token"
                                    value="<?= \App\Helpers::csrfToken() ?>">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button id="addToCartBtn" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                                <i class="fas fa-shopping-cart ml-2"></i>
                                افزودن به سبد خرید
                            </button>
                        </form>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-green-600"></i>
                                <span>گارانتی ۱۸ ماهه</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-truck text-blue-600"></i>
                                <span>ارسال رایگان</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-undo-alt text-orange-600"></i>
                                <span>ضمانت بازگشت ۷ روزه</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-4">
                <div class="flex flex-wrap border-b border-gray-200 px-4 md:px-8">
                    <button class="tab-btn active px-4 md:px-6 py-3 text-sm md:text-base font-semibold text-blue-600" data-tab="details">
                        توضیحات کامل
                    </button>
                    <button class="tab-btn px-4 md:px-6 py-3 text-sm md:text-base font-semibold text-gray-600 hover:text-blue-600 transition" data-tab="reviews">
                        نظرات کاربران
                    </button>
                </div>

                <div id="tab-details" class="tab-content p-4 md:p-8">
                    <div class="prose max-w-none">
                        <h3 class="text-xl font-bold mb-4">معرفی <?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                    </div>
                </div>

                <div id="tab-reviews" class="tab-content hidden p-4 md:p-8">
                    <div class="space-y-6">

                        <div class="mt-12">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">نظرات کاربران</h2>

                            <div class="space-y-5">
                                <?php if (!empty($comments)): ?>
                                    <?php foreach ($comments as $comment): ?>
                                        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                                            <div class="flex justify-between items-center mb-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                                        <?= mb_substr(htmlspecialchars($comment['full_name']) ?? 'U', 0, 1) ?>
                                                    </div>

                                                    <div>
                                                        <p class="font-semibold text-gray-800 text-sm">
                                                            <?= htmlspecialchars($comment['full_name'] ?? 'کاربر') ?>
                                                        </p>

                                                        <p class="text-xs text-gray-400">
                                                            <?= \App\Helpers::timeAgo($comment['created_at']) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center text-yellow-500 text-sm mb-2">

                                                <?php
                                                $rating = (float)$comment['rating'];
                                                $rating = round($rating * 2) / 2;

                                                $full = floor($rating);
                                                $half = ($rating - $full >= 0.5);
                                                $empty = 5 - $full - ($half ? 1 : 0);
                                                ?>

                                                <?php for($i=0;$i<$full;$i++): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php endfor; ?>

                                                <?php if($half): ?>
                                                    <i class="fas fa-star-half-alt"></i>
                                                <?php endif; ?>

                                                <?php for($i=0;$i<$empty;$i++): ?>
                                                    <i class="far fa-star text-gray-300"></i>
                                                <?php endfor; ?>

                                            </div>

                                            <p class="text-gray-600 text-sm leading-relaxed">
                                                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                            </p>

                                        </div>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed">
                                        <p class="text-gray-500 text-sm">هنوز نظری ثبت نشده است</p>
                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="mt-10">
                                <?php if (!empty($_SESSION['user'])): ?>
                                    <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                                            ثبت نظر شما
                                        </h3>
                                        <form method="POST" action="/products/comment" class="space-y-4">
                                            <input type="hidden"
                                               name="_token"
                                               value="<?= \App\Helpers::csrfToken() ?>">
                                               
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                                            <div>
                                                <label class="block text-sm text-gray-600 mb-1">امتیاز شما</label>
                                                <select name="rating"
                                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                                                    <option value="5">★★★★★ (5)</option>
                                                    <option value="4">★★★★☆ (4)</option>
                                                    <option value="3">★★★☆☆ (3)</option>
                                                    <option value="2">★★☆☆☆ (2)</option>
                                                    <option value="1">★☆☆☆☆ (1)</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm text-gray-600 mb-1">نظر شما</label>
                                                <textarea name="comment"
                                                          rows="4"
                                                          class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 resize-none"
                                                          placeholder="تجربه خود را بنویسید..."
                                                          required></textarea>
                                            </div>

                                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                                ثبت نظر
                                            </button>
                                        </form>
                                    </div>

                                <?php else: ?>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 text-center">
                                        <p class="text-gray-700 text-sm mb-3">
                                            برای ثبت نظر باید وارد حساب کاربری شوید
                                        </p>
                                        <a href="/login"
                                           class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                                            ورود به حساب
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl md:text-3xl font-bold text-right mb-6 relative inline-block">
                محصولات مرتبط
                <span class="absolute bottom-[-10px] right-0 w-20 h-1 bg-blue-600 rounded-full"></span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">

                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition hover:-translate-y-2 cursor-pointer">
                    <img src="<?= htmlspecialchars($relatedProduct['main_image']) ?>" alt="<?= htmlspecialchars($relatedProduct['name']) ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-1"><?= htmlspecialchars($relatedProduct['name']) ?></h3>
                        <p class="text-blue-600 font-bold"><?= \App\Helpers::formatPrice($relatedProduct['discounted_price']) ?> تومان</p>
                        <a href="/product?id=<?= $relatedProduct['id'] ?>" class="flex justify-center w-full mt-3 bg-gray-100 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition text-sm">
                            مشاهده محصول
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</main>

<script>
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.getAttribute('data-tab');

            tabs.forEach(t => {
                t.classList.remove('active', 'border-blue-600', 'text-blue-600');
                t.classList.add('text-gray-600');
            });
            tab.classList.add('active', 'border-blue-600', 'text-blue-600');
            tab.classList.remove('text-gray-600');

            contents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');
        });
    });
</script>

<?php require_once __DIR__ . "/Layouts/Footer.php"?>