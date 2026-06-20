<meta name="csrf-token" content="<?= \App\Helpers::csrfToken() ?>">
<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">مدیریت سفارشات</h2>
                    <p class="text-gray-500 text-sm mt-1">مشاهده، جستجو و مدیریت وضعیت سفارشات</p>
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

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">کل سفارشات</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['total']) ?></p>
            </div>
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">در انتظار پرداخت</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['pending']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">در حال پردازش</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['processing']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">ارسال شده</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['shipped']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">تحویل شده</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['delivered']); ?></p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <form method="GET" action="/admin/orders" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="<?= htmlspecialchars($currentSearch); ?>"
                               placeholder="جستجوی سفارش (شماره سفارش، نام مشتری، ایمیل، تلفن)..."
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="flex gap-3 flex-wrap">
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="all" <?= $currentStatus == 'all' ? 'selected' : ''; ?>>همه وضعیت‌ها</option>
                        <option value="pending" <?= $currentStatus == 'pending' ? 'selected' : ''; ?>>در انتظار پرداخت</option>
                        <option value="processing" <?= $currentStatus == 'processing' ? 'selected' : ''; ?>>در حال پردازش</option>
                        <option value="shipped" <?= $currentStatus == 'shipped' ? 'selected' : ''; ?>>ارسال شده</option>
                        <option value="delivered" <?= $currentStatus == 'delivered' ? 'selected' : ''; ?>>تحویل شده</option>
                        <option value="cancelled" <?= $currentStatus == 'cancelled' ? 'selected' : ''; ?>>لغو شده</option>
                    </select>
                    <select name="sort" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="newest" <?= $currentSort == 'newest' ? 'selected' : ''; ?>>جدیدترین</option>
                        <option value="oldest" <?= $currentSort == 'oldest' ? 'selected' : ''; ?>>قدیمی‌ترین</option>
                        <option value="price_high" <?= $currentSort == 'price_high' ? 'selected' : ''; ?>>بیشترین قیمت</option>
                        <option value="price_low" <?= $currentSort == 'price_low' ? 'selected' : ''; ?>>کمترین قیمت</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search ml-1"></i>
                        اعمال
                    </button>
                    <a href="/admin/orders" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center">
                        <i class="fas fa-undo-alt ml-1"></i>
                        بازنشانی
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">شماره سفارش</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">تاریخ ثبت</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">مشتری</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">تعداد اقلام</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">مبلغ کل</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">وضعیت</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($orders)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-5xl mb-3 block"></i>
                                سفارشی یافت نشد!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($orders as $order): ?>
                            <?php
                            $statusConfig = [
                                'pending' => ['label' => 'در انتظار پرداخت', 'color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'],
                                'processing' => ['label' => 'در حال پردازش', 'color' => 'bg-purple-100 text-purple-800', 'icon' => 'fa-spinner'],
                                'shipped' => ['label' => 'ارسال شده', 'color' => 'bg-orange-100 text-orange-800', 'icon' => 'fa-truck'],
                                'delivered' => ['label' => 'تحویل شده', 'color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
                                'cancelled' => ['label' => 'لغو شده', 'color' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle']
                            ];
                            $status = $statusConfig[$order['status']];
                            ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-mono font-semibold text-gray-800"><?= htmlspecialchars($order['id']); ?></p>
                                    <p class="text-xs text-gray-500 mt-1">#<?= $order['id']; ?></p>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    <?= \App\Helpers::jalaliFormatter("H:m - YYYY/M/dd")->format($order['created_at']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800"><?= htmlspecialchars($order['customer_name']); ?></p>
                                    <p class="text-xs text-gray-500"><?= htmlspecialchars($order['email']); ?></p>
                                    <p class="text-xs text-gray-500"><?= htmlspecialchars(\App\Helpers::toPersianNumber($order['phone']) ?? '---'); ?></p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold"><?= \App\Helpers::toPersianNumber($order['total_items']); ?></span>
                                    <span class="text-xs text-gray-500">عدد</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-blue-600"><?= \App\Helpers::formatPrice($order['total_price']); ?></span>
                                    <span class="text-xs text-gray-500">تومان</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs <?php echo $status['color']; ?>">
                                        <i class="fas <?= $status['icon']; ?>"></i>
                                        <?= $status['label']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <a
                                                href="/admin/orders/show?id=<?= $order['id']; ?>"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a
                                                href="/admin/orders/edit?id=<?= $order['id']; ?>"
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
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

<div id="orderModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 my-8">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">جزئیات سفارش</h3>
            <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="orderDetails" class="p-6">

        </div>
        <div class="flex gap-3 p-6 border-t bg-gray-50">
            <button onclick="closeOrderModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                بستن
            </button>
        </div>
    </div>
</div>

<div id="statusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">تغییر وضعیت سفارش</h3>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">وضعیت جدید را انتخاب کنید:</p>
            <select id="newStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                <option value="pending">در انتظار پرداخت</option>
                <option value="processing">در حال پردازش</option>
                <option value="shipped">ارسال شده</option>
                <option value="delivered">تحویل شده</option>
                <option value="cancelled">لغو شده</option>
            </select>
        </div>
        <div class="flex gap-3 p-6 border-t bg-gray-50">
            <button onclick="confirmStatusChange()" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                ذخیره تغییرات
            </button>
            <button onclick="closeStatusModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                انصراف
            </button>
        </div>
    </div>
</div>