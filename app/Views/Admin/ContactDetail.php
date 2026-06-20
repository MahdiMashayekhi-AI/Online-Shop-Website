<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">پیام‌های تماس با ما</h2>
                <p class="text-gray-500 text-sm mt-1">مشاهده و مدیریت پیام‌های ارسال شده از فرم تماس</p>
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

        <div class="mb-6">
            <a href="/admin/contact-messages" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-right"></i>
                بازگشت به لیست پیام‌ها
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="border-b bg-gray-50 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-800">جزئیات پیام</h2>
            </div>

            <div class="p-6">
                <div class="mb-6">
                    <?php if($message['is_read'] == 0): ?>
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                    <i class="fas fa-envelope"></i> جدید (خوانده نشده)
                </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                    <i class="fas fa-envelope-open"></i> خوانده شده
                </span>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">نام و نام خانوادگی</label>
                        <p class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($message['full_name']); ?></p>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">ایمیل</label>
                        <p class="text-gray-800">
                            <a href="mailto:<?= htmlspecialchars($message['email']); ?>" class="text-blue-600 hover:underline">
                                <?= htmlspecialchars($message['email']); ?>
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">شماره تماس</label>
                        <p class="text-gray-800">
                            <a href="tel:<?= htmlspecialchars($message['phone']); ?>" class="text-blue-600 hover:underline">
                                <?= htmlspecialchars($message['phone'] ?? 'نامشخص'); ?>
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">IP آدرس</label>
                        <p class="text-gray-800"><?= htmlspecialchars($message['ip_address'] ?? 'نامشخص'); ?></p>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">تاریخ ارسال</label>
                        <p class="text-gray-800">
                            <i class="fas fa-calendar-alt ml-1 text-gray-400"></i>
                            <?= \App\Helpers::jalaliFormatter()->format($message['created_at']); ?>
                        </p>
                        <p class="text-gray-500 text-sm mt-1">
                            <i class="fas fa-clock ml-1 text-gray-400"></i>
                            <?= \App\Helpers::jalaliFormatter("H:m")->format($message['created_at']); ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">شناسه پیام</label>
                        <p class="text-gray-800">#<?= $message['id']; ?></p>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-600 text-sm mb-1">موضوع</label>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($message['subject']); ?></p>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-600 text-sm mb-1">متن پیام</label>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?= nl2br(htmlspecialchars($message['message'])); ?></p>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <a href="mailto:<?= htmlspecialchars($message['email']); ?>?subject=پاسخ به: <?php echo urlencode(htmlspecialchars($message['subject'])); ?>"
                       class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold text-center">
                        <i class="fas fa-reply ml-2"></i>
                        پاسخ به پیام
                    </a>

                    <form method="POST" action="/admin/contact-messages/delete" class="flex-1"
                          onsubmit="return confirm('آیا از حذف این پیام اطمینان دارید؟');">
                        <input type="hidden"
                                name="_token"
                                value="<?= \App\Helpers::csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= $message['id']; ?>">
                        <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition font-semibold">
                            <i class="fas fa-trash-alt ml-2"></i>
                            حذف پیام
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="messageModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 my-8">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">جزئیات پیام</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600 text-sm mb-1">نام و نام خانوادگی</label>
                    <p id="modalFullname" class="font-semibold text-gray-800"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">ایمیل</label>
                    <p id="modalEmail" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">شماره تماس</label>
                    <p id="modalPhone" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">تاریخ ارسال</label>
                    <p id="modalDate" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">IP آدرس</label>
                    <p id="modalIp" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">وضعیت</label>
                    <p id="modalStatus" class="text-gray-700"></p>
                </div>
            </div>
            <div>
                <label class="block text-gray-600 text-sm mb-1">موضوع</label>
                <p id="modalSubject" class="font-semibold text-gray-800 bg-gray-50 p-2 rounded"></p>
            </div>
            <div>
                <label class="block text-gray-600 text-sm mb-1">متن پیام</label>
                <div id="modalMessage" class="bg-gray-50 p-4 rounded-lg text-gray-700 leading-relaxed min-h-[150px] whitespace-pre-wrap"></div>
            </div>
        </div>
        <div class="flex gap-3 p-6 border-t bg-gray-50">
            <button onclick="replyToUser()" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                <i class="fas fa-reply ml-2"></i>
                پاسخ به پیام
            </button>
            <button onclick="closeModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                بستن
            </button>
        </div>
    </div>
</div>

<div id="messageModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 my-8">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">جزئیات پیام</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600 text-sm mb-1">نام و نام خانوادگی</label>
                    <p id="modalFullname" class="font-semibold text-gray-800"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">ایمیل</label>
                    <p id="modalEmail" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">شماره تماس</label>
                    <p id="modalPhone" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">تاریخ ارسال</label>
                    <p id="modalDate" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">IP آدرس</label>
                    <p id="modalIp" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm mb-1">وضعیت</label>
                    <p id="modalStatus" class="text-gray-700"></p>
                </div>
            </div>
            <div>
                <label class="block text-gray-600 text-sm mb-1">موضوع</label>
                <p id="modalSubject" class="font-semibold text-gray-800 bg-gray-50 p-2 rounded"></p>
            </div>
            <div>
                <label class="block text-gray-600 text-sm mb-1">متن پیام</label>
                <div id="modalMessage" class="bg-gray-50 p-4 rounded-lg text-gray-700 leading-relaxed min-h-[150px] whitespace-pre-wrap"></div>
            </div>
        </div>
        <div class="flex gap-3 p-6 border-t bg-gray-50">
            <button onclick="replyToUser()" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                <i class="fas fa-reply ml-2"></i>
                پاسخ به پیام
            </button>
            <button onclick="closeModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                بستن
            </button>
        </div>
    </div>
</div>