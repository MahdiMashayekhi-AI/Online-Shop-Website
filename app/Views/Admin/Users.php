<main class="flex-1 overflow-y-auto">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">مدیریت کاربران</h2>
                    <p class="text-gray-500 text-sm mt-1">مشاهده، جستجو و مدیریت کاربران فروشگاه</p>
                </div>
                <button onclick="openAddUserModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    افزودن کاربر جدید
                </button>
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

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">کل کاربران</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['total']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">کاربران فعال</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['active']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">کاربران غیرفعال</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['inactive']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">ادمین‌ها</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['admins']); ?></p>
            </div>
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90 mb-5">کاربران جدید (این ماه)</p>
                <p class="text-2xl font-bold"><?= \App\Helpers::toPersianNumber($stats['new_users']); ?></p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <form method="GET" action="/admin/users" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="<?= htmlspecialchars($currentSearch); ?>"
                               placeholder="جستجوی کاربران (نام، ایمیل، تلفن، نام کاربری)..."
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="flex gap-3 flex-wrap">
                    <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="all" <?= $currentRole == 'all' ? 'selected' : ''; ?>>همه نقش‌ها</option>
                        <option value="admin" <?= $currentRole == 'admin' ? 'selected' : ''; ?>>مدیر</option>
                        <option value="customer" <?= $currentRole == 'customer' ? 'selected' : ''; ?>>کاربر عادی</option>
                    </select>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="all" <?= $currentStatus == 'all' ? 'selected' : ''; ?>>همه وضعیت‌ها</option>
                        <option value="active" <?= $currentStatus == 'active' ? 'selected' : ''; ?>>فعال</option>
                        <option value="inactive" <?= $currentStatus == 'inactive' ? 'selected' : ''; ?>>غیرفعال</option>
                    </select>
                    <select name="sort" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="newest" <?= $currentSort == 'newest' ? 'selected' : ''; ?>>جدیدترین</option>
                        <option value="oldest" <?= $currentSort == 'oldest' ? 'selected' : ''; ?>>قدیمی‌ترین</option>
                        <option value="name_asc" <?= $currentSort == 'name_asc' ? 'selected' : ''; ?>>نام (الفبا)</option>
                        <option value="name_desc" <?= $currentSort == 'name_desc' ? 'selected' : ''; ?>>نام (الفبا معکوس)</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search ml-1"></i>
                        اعمال
                    </button>
                    <a href="/admin/users" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center">
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
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">کاربر</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">ایمیل</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">تلفن</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">نقش</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">تاریخ عضویت</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">وضعیت</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users-slash text-5xl mb-3 block"></i>
                                کاربری یافت نشد!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($users as $user): ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                                            <?= htmlspecialchars(mb_substr($user['full_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800"><?= htmlspecialchars($user['full_name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm"><?= htmlspecialchars($user['email']); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm"><?= htmlspecialchars(\App\Helpers::toPersianNumber($user['phone']) ?? '---'); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($user['role'] == 'admin'): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">
                                    <i class="fas fa-crown"></i> مدیر
                                </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    <i class="fas fa-user"></i> کاربر
                                </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <?= \App\Helpers::jalaliFormatter("YYYY/M/d")->format($user['created_at']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($user['is_active'] == 1): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                    <i class="fas fa-check-circle"></i> فعال
                                </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                                    <i class="fas fa-times-circle"></i> غیرفعال
                                </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <a href="/admin/users?edit=<?= $user['id']; ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="/admin/users/delete" class="inline" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟');">
                                            <input type="hidden"
                                               name="_token"
                                               value="<?= \App\Helpers::csrfToken() ?>">
                                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
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

    <div id="userModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 my-8">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800 mt-12">افزودن کاربر جدید</h3>
                <button onclick="closeUserModal()" class="text-gray-400 mt-12 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="userForm" method="POST" action="/admin/users/store">
                <div class="p-6 space-y-4">
                    <input type="hidden"
                            name="_token"
                            value="<?= \App\Helpers::csrfToken() ?>">
                    <input type="hidden" id="userId" name="id" value="">
                    <input type="hidden" id="formAction" name="formAction" value="store">

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user ml-1 text-gray-400"></i>
                            نام کامل <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="fullName" name="full_name" required
                               placeholder="احمد رضایی"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope ml-1 text-gray-400"></i>
                            ایمیل <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               placeholder="ahmad@example.com"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-phone ml-1 text-gray-400"></i>
                            شماره تماس
                        </label>
                        <input type="tel" id="phone" name="phone"
                               placeholder="09123456789"
                               maxlength="11"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user-tag ml-1 text-gray-400"></i>
                            نقش
                        </label>
                        <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="user">کاربر عادی</option>
                            <option value="admin">مدیر</option>
                        </select>
                    </div>

                    <div id="passwordFields">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock ml-1 text-gray-400"></i>
                                رمز عبور <span class="text-red-500" id="passwordRequired">*</span>
                            </label>
                            <input type="password" id="password" name="password"
                                   placeholder="********"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="mt-3">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock ml-1 text-gray-400"></i>
                                تکرار رمز عبور <span class="text-red-500" id="confirmRequired">*</span>
                            </label>
                            <input type="password" id="confirmPassword" name="confirm_password"
                                   placeholder="********"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="userStatus" name="is_active" class="w-4 h-4 text-blue-600 rounded" checked>
                            <span class="text-gray-700">فعال</span>
                        </label>
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t bg-gray-50">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save ml-1"></i>
                        ذخیره
                    </button>
                    <button type="button" onclick="closeUserModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                        انصراف
                    </button>
                </div>
            </form>
        </div>
    </div>
    </main>

<?php if(isset($editUser) && $editUser): ?>
    <div id="editModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 overflow-y-auto" style="display: flex !important;">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 my-8">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800">ویرایش کاربر</h3>
                <a href="/admin/users" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>

            <form method="POST" action="/admin/users/update">
                <input type="hidden"
                        name="_token"
                        value="<?= \App\Helpers::csrfToken() ?>">
                <input type="hidden" name="id" value="<?= $editUser['id']; ?>">

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user ml-1 text-gray-400"></i>
                            نام کامل <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="full_name" required
                               value="<?= htmlspecialchars($editUser['full_name']); ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope ml-1 text-gray-400"></i>
                            ایمیل <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" required
                               value="<?= htmlspecialchars($editUser['email']); ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-phone ml-1 text-gray-400"></i>
                            شماره تماس
                        </label>
                        <input type="tel" name="phone"
                               value="<?= htmlspecialchars($editUser['phone'] ?? ''); ?>"
                               placeholder="09123456789"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user-tag ml-1 text-gray-400"></i>
                            نقش
                        </label>
                        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="customer" <?= ($editUser['role'] == 'customer') ? 'selected' : ''; ?>>مشتری</option>
                            <option value="admin" <?= ($editUser['role'] == 'admin') ? 'selected' : ''; ?>>مدیر</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock ml-1 text-gray-400"></i>
                            رمز عبور جدید (در صورت تمایل)
                        </label>
                        <input type="password" name="password"
                               placeholder="برای تغییر رمز عبور وارد کنید"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" class="w-4 h-4 text-blue-600 rounded"
                                <?= ($editUser['is_active'] == 1) ? 'checked' : ''; ?>>
                            <span class="text-gray-700">فعال</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 p-6 border-t bg-gray-50">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-save ml-1"></i>
                        ذخیره تغییرات
                    </button>
                    <a href="/admin/users" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                        انصراف
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>