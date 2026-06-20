<footer class="bg-gray-900 text-white pt-12 md:pt-16 pb-6 md:pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-8 md:mb-12">

            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-store ml-2 text-blue-500"></i>
                    <?= htmlspecialchars($pageSettings['store_name']) ?>
                </h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    <?= htmlspecialchars($pageSettings['slogan']) ?>
                </p>
                <div class="flex gap-3 mt-4">
                    <a href="<?= htmlspecialchars($pageSettings['instagram']) ?>" class="bg-gray-800 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="<?= htmlspecialchars($pageSettings['telegram']) ?>" class="bg-gray-800 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a href="<?= htmlspecialchars($pageSettings['twitter']) ?>" class="bg-gray-800 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="<?= htmlspecialchars($pageSettings['linkedin']) ?>" class="bg-gray-800 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">دسترسی سریع</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="/" class="hover:text-blue-500 transition">خانه</a></li>
                    <li><a href="/products" class="hover:text-blue-500 transition">محصولات</a></li>
                    <li><a href="/about-us" class="hover:text-blue-500 transition">درباره ما</a></li>
                    <li><a href="/contact-us" class="hover:text-blue-500 transition">تماس با ما</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">خدمات مشتریان</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="/contact-us" class="hover:text-blue-500 transition">سوالات متداول</a></li>
                    <li><a href="/contact-us" class="hover:text-blue-500 transition">رویه بازگشت کالا</a></li>
                    <li><a href="/contact-us" class="hover:text-blue-500 transition">حریم خصوصی</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">اطلاعات تماس</h4>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt ml-3 text-blue-500"></i>
                        <?= htmlspecialchars($pageSettings['address']) ?>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone ml-3 text-blue-500"></i>
                        <a href="tel:<?= htmlspecialchars($pageSettings['phone']) ?>"><?= htmlspecialchars($pageSettings['phone']) ?></a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope ml-3 text-blue-500"></i>
                        <a href="mailto:<?= htmlspecialchars($pageSettings['email']) ?>"><?= htmlspecialchars($pageSettings['email']) ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-6 text-center">
            <p class="text-gray-400 text-sm">
                فرشگاه اینترنتی ایران. کلیه حقوق محفوظ است - ساخته شده با 💙 توسط مهدی مشایخی <?= \App\Helpers::jalaliFormatter("Y")->format(time()) ?> ©
            </p>
        </div>
    </div>
</footer>

<script>
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if(mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });
</script>

</body>
</html>
