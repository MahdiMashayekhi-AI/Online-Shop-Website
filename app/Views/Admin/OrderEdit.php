<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">وضعیت سفارش</h2>
                    <p class="text-gray-500 text-sm mt-1">تغییر وضعیت سفارش به حالت جدید</p>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6">
        <?php use App\Helpers;?>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="px-6 py-4 border-b">
                    <h1 class="text-xl font-bold text-gray-800">
                        تغییر وضعیت سفارش
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        سفارش شماره #<?= Helpers::toPersianNumber($order['id']); ?>
                    </p>
                </div>

                <form method="POST" action="/admin/orders/edit" class="p-6">
                    <input
                            type="hidden"
                            name="_token"
                            value="<?= Helpers::csrfToken(); ?>"
                    >

                    <input
                            type="hidden"
                            name="id"
                            value="<?= $order['id']; ?>"
                    >

                    <div class="mb-6">

                        <label
                                for="status"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            وضعیت سفارش
                        </label>

                        <select
                                id="status"
                                name="status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >

                            <option
                                    value="pending"
                                <?= $order['status'] === 'pending' ? 'selected' : ''; ?>
                            >
                                در انتظار پرداخت
                            </option>

                            <option
                                    value="processing"
                                <?= $order['status'] === 'processing' ? 'selected' : ''; ?>
                            >
                                در حال پردازش
                            </option>

                            <option
                                    value="shipped"
                                <?= $order['status'] === 'shipped' ? 'selected' : ''; ?>
                            >
                                ارسال شده
                            </option>

                            <option
                                    value="delivered"
                                <?= $order['status'] === 'delivered' ? 'selected' : ''; ?>
                            >
                                تحویل شده
                            </option>

                            <option
                                    value="cancelled"
                                <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>
                            >
                                لغو شده
                            </option>

                        </select>

                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-6">

                        <div class="grid grid-cols-2 gap-4 text-sm">

                            <div>
                        <span class="text-gray-500">
                            مشتری:
                        </span>

                                <p class="font-semibold text-gray-800">
                                    <?= htmlspecialchars($order['customer_name']); ?>
                                </p>
                            </div>

                            <div>
                                <span class="text-gray-500">
                            مبلغ سفارش:
                        </span>

                                <p class="font-semibold text-blue-600">
                                    <?= Helpers::formatPrice($order['total_price']); ?>
                                    تومان
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="flex gap-3">

                        <button
                                type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >
                            ذخیره تغییرات
                        </button>

                        <a
                                href="/admin/orders"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                        >
                            بازگشت
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>