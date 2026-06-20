<?php require_once __DIR__ . "/Layouts/Header.php"?>

<main>
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">تماس با ما</h1>
            <p class="text-lg md:text-xl opacity-90">ما همیشه آماده شنیدن صدای شما هستیم</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">آدرس</h3>
                    <p class="text-gray-600 text-sm"><?= htmlspecialchars($pageSettings["address"]) ?></p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone-alt text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">شماره تماس</h3>
                    <p class="text-gray-600 text-sm"><?= \App\Helpers::toPersianNumber($pageSettings["phone"]) ?></p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">ایمیل</h3>
                    <p class="text-gray-600 text-sm"><?= htmlspecialchars($pageSettings["email"]) ?></p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">ساعات کاری</h3>
                    <p class="text-gray-600 text-sm">شنبه تا پنجشنبه: ۹ صبح تا ۶ عصر</p>
                    <p class="text-gray-600 text-sm mt-1">جمعه‌ها: تعطیل</p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4 text-center">ما را در شبکه‌های اجتماعی دنبال کنید</h3>
                    <div class="flex justify-center gap-4">
                        <a href="<?= htmlspecialchars($pageSettings["instagram"]) ?>" class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="<?= htmlspecialchars($pageSettings["telegram"]) ?>" class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition">
                            <i class="fab fa-telegram text-xl"></i>
                        </a>
                        <a href="<?= htmlspecialchars($pageSettings["twitter"]) ?>" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="<?= htmlspecialchars($pageSettings["linkedin"]) ?>" class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">ارسال پیام</h2>
                    <p class="text-gray-500 text-sm mb-6">برای ارتباط با ما، فرم زیر را تکمیل کنید</p>

                    <?php if (isset($_COOKIE['user_message'])): ?>
                        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-md">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-white text-lg"></i>
                                <span class="text-sm font-medium">پیام شما به موفقت ثبت شد.</span>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-md">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-white text-lg"></i>
                                <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['error']) ?></span>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <form id="contactForm" method="POST" action="/contact-us">
                        <input type="hidden"
                                name="_token"
                                value="<?= \App\Helpers::csrfToken() ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    نام و نام خانوادگی <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="fullName" name="fullname" required autocomplete="off"
                                       placeholder="احمد رضایی"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    ایمیل <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" required autocomplete="off"
                                       placeholder="example@gmail.com"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                شماره تماس<span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" required autocomplete="off" maxlength="11"
                                   placeholder="۰۹۱۲۳۴۵۶۷۸۹"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                موضوع <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" required autocomplete="off"
                                   placeholder="پیگیری سفارش"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">
                                پیام شما <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" rows="5" name="message"
                                      placeholder="پیام خود را بنویسید..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                            <i class="fas fa-paper-plane ml-2"></i>
                            ارسال پیام
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="pb-12 md:pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-right">موقعیت ما روی نقشه</h2>
            <div class="bg-gray-200 rounded-xl overflow-hidden h-80">
                <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1651.6431166815673!2d49.73104095381355!3d34.113421225030685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fecbf8133eaedc5%3A0x7247a51a99e6fb61!2z2K_Yp9mG2LTaqdiv2Ycg2YHZhtuMINmIINit2LHZgdmH4oCM2KfbjCDYp9mF24zYsdqp2KjbjNixINin2LHYp9qp!5e0!3m2!1sfa!2s!4v1780758799578!5m2!1sfa!2s"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">سوالات متداول</h2>
                <p class="text-gray-500">پاسخ به سوالات رایج شما</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-truck text-blue-600"></i>
                        هزینه ارسال چقدر است؟
                    </h3>
                    <p class="text-gray-600 text-sm">ارسال برای خریدهای بالای ۵ میلیون تومان رایگان است. برای خریدهای کمتر، هزینه ارسال <?= \App\Helpers::formatPrice($pageSettings['shipping_cost']) ?> تومان می‌باشد.</p>
                </div>
                <div class="bg-white rounded-xl p-6">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-clock text-blue-600"></i>
                        زمان تحویل سفارش چقدر است؟
                    </h3>
                    <p class="text-gray-600 text-sm">سفارشات تهران طی ۲۴ تا ۴۸ ساعت و شهرستان‌ها طی ۳ تا ۵ روز کاری ارسال می‌شوند.</p>
                </div>
                <div class="bg-white rounded-xl p-6">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-undo-alt text-blue-600"></i>
                        چگونه کالا را برگردانم؟
                    </h3>
                    <p class="text-gray-600 text-sm">شما تا ۷ روز پس از تحویل کالا، فرصت بازگشت دارید. برای هماهنگی با پشتیبانی تماس بگیرید.</p>
                </div>
                <div class="bg-white rounded-xl p-6">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-blue-600"></i>
                        ضمانت اصالت کالا چگونه است؟
                    </h3>
                    <p class="text-gray-600 text-sm">همه محصولات ما دارای گارانتی اصالت و سلامت فیزیکی هستند. در صورت مغایرت، کالا عودت داده می‌شود.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . "/Layouts/Footer.php"?>
