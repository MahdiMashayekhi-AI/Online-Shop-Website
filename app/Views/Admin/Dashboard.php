<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4 flex justify-between items-center flex-wrap gap-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">داشبورد مدیریت</h2>
                <p class="text-gray-500 text-sm mt-1">به پنل مدیریت خوش آمدید</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/shop-settings" class="p-2 text-gray-500 hover:text-blue-600 transition">
                    <i class="fas fa-cog text-xl"></i>
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm mb-5">تعداد کاربران</p>
                        <p class="text-3xl font-bold">
                            <?php use App\Models\OrderModel;?>
                            <?= \App\Helpers::toPersianNumber($userStats['total']); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-100 text-sm mb-5">تعداد محصولات</p>
                        <p class="text-3xl font-bold"><?= \App\Helpers::toPersianNumber($productStats); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-box text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-100 text-sm mb-5">تعداد سفارشات</p>
                        <p class="text-3xl font-bold"><?= \App\Helpers::toPersianNumber($orderStats['total']); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-orange-100 text-sm mb-5">فروش کل (ماه جاری)</p>
                        <p class="text-2xl font-bold"><?= \App\Helpers::formatPrice($orderStats['monthly_sales']); ?></p>
                        <p class="text-orange-100 text-xs mt-2">تومان</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">آخرین سفارشات</h3>
                    <a href="/admin/orders" class="text-blue-600 text-sm hover:text-blue-700">مشاهده همه</a>
                </div>
                <div class="space-y-3">
                    <?php if(empty($recentOrders)): ?>
                        <div class="text-center text-gray-500 py-4">هیچ سفارشی وجود ندارد</div>
                    <?php else: ?>
                        <?php foreach($recentOrders as $order): ?>
                            <?php $status = \App\Helpers::getOrderBadge($order['status']) ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-800"><?= htmlspecialchars($order['order_number'] ?? 'ORD-' . $order['id']); ?></p>
                                    <p class="text-xs text-gray-500"><?= htmlspecialchars($order['customer_name']); ?> - <?= \App\Helpers::jalaliFormatter()->format($order['created_at']); ?></p>
                                </div>
                                <div>
                                    <span class="text-green-600 font-semibold"><?= \App\Helpers::formatPrice($order['total_price']); ?></span>
                                    <span class="text-xs">تومان</span>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs <?= $status['color']; ?>">
                            <i class="fas <?= htmlspecialchars($status['icon']) ?>"></i>
                            <?= htmlspecialchars($status['label']) ?>
                        </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">محصولات پرفروش</h3>
                    <a href="/admin/products" class="text-blue-600 text-sm hover:text-blue-700">مشاهده همه</a>
                </div>
                <div class="space-y-3">
                    <?php if(empty($bestSellingProducts)): ?>
                        <div class="text-center text-gray-500 py-4">هیچ محصولی وجود ندارد</div>
                    <?php else: ?>
                        <?php foreach($bestSellingProducts as $product): ?>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800"><?= htmlspecialchars($product['name']); ?></p>
                                    <p class="text-xs text-gray-500"><?= \App\Helpers::toPersianNumber($product['total_sold']); ?> فروش</p>
                                </div>
                                <div class="text-green-600 font-semibold"><?= \App\Helpers::formatPrice($product['price']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">آمار فروش بر اساس دسته‌بندی</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php if(empty($categoryStats)): ?>
                    <div class="text-center text-gray-500 py-4 col-span-full">هیچ داده‌ای وجود ندارد</div>
                <?php else: ?>
                    <?php foreach($categoryStats as $cat): ?>

                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas <?= htmlspecialchars($cat['icon'] ?? 'fa-tag'); ?> text-3xl text-blue-600 mb-2"></i>
                            <p class="font-semibold text-gray-800"><?= htmlspecialchars($cat['name']); ?></p>
                            <p class="text-xs text-gray-500"><?= \App\Helpers::toPersianNumber($cat['total_sold']); ?> فروش</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
