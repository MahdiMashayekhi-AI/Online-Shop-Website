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

    <div class="lg:flex justify-center gap-4 mb-6">
        <div class="w-full mb-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90 mb-5">کل پیام‌ها</p>
            <p class="text-2xl font-bold"><?= App\Helpers::toPersianNumber($stats['total']); ?></p>
        </div>
        <div class="w-full mb-5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90 mb-5">خوانده نشده</p>
            <p class="text-2xl font-bold"><?= App\Helpers::toPersianNumber($stats['unread']); ?></p>
        </div>
        <div class="w-full mb-5 bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90 mb-5">خوانده شده</p>
            <p class="text-2xl font-bold"><?= App\Helpers::toPersianNumber($stats['read_count']); ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <?php if(empty($messages)): ?>
            <div class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">هیچ پیامی وجود ندارد!</p>
            </div>
        <?php else: ?>
            <div class="divide-y divide-gray-200">
                <?php foreach($messages as $message): ?>
                    <?php $isUnread = $message['is_read'] == 0; ?>
                    <div class="p-5 hover:bg-gray-50 transition <?= $isUnread ? 'bg-blue-50/30 border-r-4 border-blue-500' : ''; ?>">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                        <?= mb_substr($message['full_name'], 0, 1); ?>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 <?= $isUnread ? 'font-bold' : ''; ?>">
                                            <?= htmlspecialchars($message['full_name']); ?>
                                        </h3>
                                        <p class="text-xs text-gray-500"><?= htmlspecialchars($message['email']); ?></p>
                                    </div>
                                </div>
                                <div class="mr-13">
                                    <p class="text-gray-700 text-sm">
                                        <span class="font-semibold">موضوع:</span> <?= htmlspecialchars($message['subject']); ?>
                                    </p>
                                    <p class="text-gray-500 text-xs mt-1">
                                        <i class="fas fa-calendar-alt ml-1"></i>
                                        <?= \App\Helpers::jalaliFormatter("HH:MM - YYYY/MM/dd")->format($message['created_at']); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <?php if($isUnread): ?>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                        <i class="fas fa-envelope"></i> جدید
                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full text-xs">
                        <i class="fas fa-envelope-open"></i> خوانده شده
                    </span>
                                <?php endif; ?>

                                <a href="/admin/contact-messages/show?id=<?= $message['id']; ?>"
                                   class="text-blue-500 hover:text-blue-700 transition p-2"
                                   title="مشاهده جزئیات">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <form method="POST" action="/admin/contact-messages/delete" class="inline"
                                      onsubmit="return confirm('آیا از حذف این پیام اطمینان دارید؟');">
                                    <input type="hidden"
                                            name="_token"
                                            value="<?= \App\Helpers::csrfToken() ?>">
                                    <input type="hidden" name="id" value="<?= $message['id']; ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition p-2" title="حذف">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

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