<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">همه سفارشات</h2>
                    <p class="text-gray-500 text-sm mt-1">مشاهده جزئیات سفارش مشتری</p>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6">
        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    جزئیات سفارش
                </h1>

                <a
                        href="/admin/orders"
                        class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200"
                >
                    بازگشت
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-8">

                <div class="border rounded-lg p-4">
                    <h2 class="font-bold mb-4">
                        اطلاعات مشتری
                    </h2>

                    <p class="mb-2">
                        <strong>نام:</strong>
                        <?= htmlspecialchars($order['customer_name']); ?>
                    </p>

                    <p class="mb-2">
                        <strong>ایمیل:</strong>
                        <?= htmlspecialchars($order['email']); ?>
                    </p>

                    <p>
                        <strong>تلفن:</strong>
                        <?= htmlspecialchars($order['phone'] ?? '---'); ?>
                    </p>
                </div>

                <div class="border rounded-lg p-4">
                    <h2 class="font-bold mb-4">
                        اطلاعات سفارش
                    </h2>

                    <p class="mb-2">
                        <strong>شناسه سفارش:</strong>
                        #<?= $order['id']; ?>
                    </p>

                    <p class="mb-2">
                        <strong>تعداد اقلام:</strong>
                        <?= \App\Helpers::toPersianNumber($order['total_items']); ?>
                    </p>

                    <p class="mb-2">
                        <strong>وضعیت:</strong>
                        <?= \App\Helpers::getOrderBadge($order['status'])['label']; ?>
                    </p>

                    <p class="mb-2">
                        <strong>مبلغ:</strong>
                        <?= \App\Helpers::formatPrice($order['total_price']); ?>
                        تومان
                    </p>

                    <p>
                        <strong>تاریخ ثبت:</strong>
                        <?= \App\Helpers::jalaliFormatter("yyyy/MM/dd - HH:mm")->format($order['created_at']); ?>
                    </p>

                </div>

            </div>

            <div class="border rounded-lg">

                <div class="p-4 border-b">
                    <h2 class="font-bold">
                        محصولات سفارش
                    </h2>
                </div>

                <table class="w-full">

                    <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-right">
                            محصول
                        </th>

                        <th class="p-3 text-center">
                            تعداد
                        </th>

                        <th class="p-3 text-center">
                            قیمت واحد
                        </th>

                        <th class="p-3 text-center">
                            جمع
                        </th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach($order['items'] as $item): ?>

                        <tr class="border-t">

                            <td class="p-3">
                                <?= htmlspecialchars($item['product_name']); ?>
                            </td>

                            <td class="p-3 text-center">
                                <?= \App\Helpers::toPersianNumber($item['quantity']); ?>
                            </td>

                            <td class="p-3 text-center">
                                <?= \App\Helpers::formatPrice($item['price']); ?>
                            </td>

                            <td class="p-3 text-center">
                                <?= \App\Helpers::formatPrice(
                                    $item['quantity'] * $item['price']
                                ); ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                    <tfoot>

                    <tr class="bg-gray-50 font-bold">

                        <td colspan="3" class="p-3 text-left">
                            مبلغ نهایی
                        </td>

                        <td class="p-3 text-center text-blue-600">
                            <?= \App\Helpers::formatPrice($order['total_price']); ?>
                            تومان
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>