<?php use App\Helpers;

require_once __DIR__ . "/Layouts/Header.php"?>

    <main>
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center text-sm text-gray-600 flex-wrap gap-2">
                    <a href="/" class="hover:text-blue-600">خانه</a>
                    <i class="fas fa-chevron-left text-xs"></i>
                    <span class="text-gray-900 font-semibold">سبد خرید</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <h1 class="text-2xl md:text-3xl font-bold text-right mb-6 md:mb-8 relative inline-block">
                سبد خرید
                <span class="absolute bottom-[-10px] right-0 w-20 h-1 bg-blue-600 rounded-full"></span>
            </h1>

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

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1">

                    <div class="hidden md:grid md:grid-cols-12 gap-4 bg-gray-100 p-4 rounded-lg mb-4 text-gray-700 font-semibold text-sm">
                        <div class="col-span-5">محصول</div>
                        <div class="col-span-2 text-center">قیمت واحد</div>
                        <div class="col-span-2 text-center">تعداد</div>
                        <div class="col-span-2 text-center">قیمت کل</div>
                        <div class="col-span-1 text-center"></div>
                    </div>

                    <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="bg-white rounded-xl shadow-md p-4 mb-4 transition hover:shadow-lg">
                        <div class="flex flex-col md:grid md:grid-cols-12 gap-4 items-center">
                            <div class="flex items-center gap-3 md:col-span-5 w-full">
                                <img src="<?= $item['image'] ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>"
                                    class="w-16 h-16 md:w-20 md:h-20 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 text-sm md:text-base hover:text-blue-600 transition cursor-pointer">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </h3>
                                    <div class="md:hidden mt-2">
                                        <span class="text-gray-600 text-sm">قیمت واحد: </span>
                                        <span class="text-blue-600 font-semibold"><?= htmlspecialchars($item['price']) ?> تومان</span>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden md:block md:col-span-2 text-center">
                                <span class="text-gray-700 font-semibold"><?= \App\Helpers::formatPrice($item['price']) ?></span>
                                <span class="text-gray-500 text-xs">تومان</span>
                            </div>

                            <div class="flex items-center justify-between md:justify-center md:col-span-2 w-full">
                                <span class="md:hidden text-gray-600 text-sm">تعداد:</span>
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <form method="POST" action="/cart/decrease">
                                        <input type="hidden"
                                               name="_token"
                                               value="<?= \App\Helpers::csrfToken() ?>">

                                        <input type="hidden"
                                               name="product_id"
                                               value="<?= $item['id'] ?>">

                                        <button class="px-3 py-2 bg-gray-50 hover:bg-gray-100">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                    </form>
                                    <span class="cart-qty px-4 py-1 md:px-5 md:py-2 text-center font-semibold min-w-[50px]"><?= $item['qty'] ?></span>
                                    <form method="POST" action="/cart/increase">
                                        <input type="hidden"
                                               name="_token"
                                               value="<?= \App\Helpers::csrfToken() ?>">

                                        <input type="hidden"
                                               name="product_id"
                                               value="<?= $item['id'] ?>">

                                        <button class="px-3 py-2 bg-gray-50 hover:bg-gray-100">
                                            <i class="fas fa-plus"></i>
                                        </button>

                                    </form>
                                </div>
                            </div>

                            <div class="flex items-center justify-between md:justify-center md:col-span-2 w-full">
                                <span class="md:hidden text-gray-600 text-sm">قیمت کل:</span>
                                <span class="cart-total-price text-blue-600 font-bold text-lg"><?= \App\Helpers::formatPrice(
                                        $item['price'] * $item['qty']
                                    ) ?></span>
                                <span class="text-gray-500 text-xs mr-1">تومان</span>
                            </div>

                            <div class="flex justify-end md:justify-center md:col-span-1 w-full">
                                <form method="POST" action="/cart/remove">
                                    <input type="hidden"
                                            name="_token"
                                            value="<?= \App\Helpers::csrfToken() ?>">

                                    <input type="hidden"
                                           name="product_id"
                                           value="<?= $item['id'] ?>">

                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (empty($cart)): ?>
                    <div id="emptyCart" class="text-center py-12">
                        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">سبد خرید شما خالی است!</p>
                        <a href="/products" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            شروع خرید
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($cart)): ?>
                    <div class="mt-6 text-center md:text-right">
                        <a href="/products" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                            <i class="fas fa-arrow-right ml-2"></i>
                            ادامه خرید
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="lg:w-96">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-6 pb-3 border-b">جمع سفارش</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>قیمت کالاها</span>
                                <span id="subtotal"><?= \App\Helpers::formatPrice($subtotal) ?></span>
                                <span>تومان</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>هزینه ارسال</span>
                                <span id="shippingCost">رایگان</span>
                            </div>
                            <div class="border-t pt-3 mt-3">
                                <div class="flex justify-between text-xl font-bold text-gray-800">
                                    <span>مجموع قابل پرداخت</span>
                                    <span>
                                        <span id="total"><?= \App\Helpers::formatPrice($subtotal) ?></span>
                                        <span class="text-sm font-normal mr-1">تومان</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="/cart/checkout">
                            <input type="hidden"
                                    name="_token"
                                    value="<?= \App\Helpers::csrfToken() ?>">
                                    
                            <button type="submit" id="checkoutBtn" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                                <i class="fas fa-check-circle ml-2"></i>
                                ثبت سفارش
                            </button>
                        </form>

                        <div class="mt-6 pt-6 border-t">
                            <p class="text-gray-600 text-sm text-center mb-3">پرداخت امن با:</p>
                            <div class="flex justify-center gap-4 text-2xl text-gray-400">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fas fa-credit-card"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php require_once __DIR__ . "/Layouts/Footer.php"?>