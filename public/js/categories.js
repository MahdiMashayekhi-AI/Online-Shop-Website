function openAddModal() {
    document.getElementById('modalTitle').innerText = 'افزودن دسته‌بندی جدید';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryName').value = '';
    document.getElementById('categorySlug').value = '';
    document.getElementById('categoryIcon').value = 'fa-tag';
    document.getElementById('categoryStatus').checked = true;
    updateIconPreview('fa-tag');
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('categoryModal').style.display = 'flex';
}

function editCategory(id) {
    const category = categories.find(c => c.id === id);
    if (category) {
        document.getElementById('modalTitle').innerText = 'ویرایش دسته‌بندی';
        document.getElementById('categoryId').value = category.id;
        document.getElementById('categoryName').value = category.name;
        document.getElementById('categorySlug').value = category.slug;
        document.getElementById('categoryIcon').value = category.icon;
        document.getElementById('categoryDesc').value = category.description || '';
        document.getElementById('categoryStatus').checked = category.status;
        updateIconPreview(category.icon);
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').style.display = 'flex';
    }
}

function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('categoryModal').style.display = 'none';
}

function updateIconPreview(iconClass) {
    const preview = document.getElementById('iconPreview');
    preview.innerHTML = `<i class="fas ${iconClass}"></i>`;
}

document.getElementById('categoryIcon').addEventListener('input', function() {
    const iconClass = this.value.trim();
    if (iconClass) {
        updateIconPreview(iconClass);
    } else {
        updateIconPreview('fa-tag');
    }
});

document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        document.getElementById('modalTitle').innerText = 'ویرایش دسته‌بندی';

        document.getElementById('categoryForm').action = '/admin/categories/update';

        document.getElementById('categoryId').value = this.dataset.id || '';
        document.getElementById('categoryName').value = this.dataset.name || '';
        document.getElementById('categorySlug').value = this.dataset.slug || '';
        document.getElementById('categoryIcon').value = this.dataset.icon || 'fa-tag';

        document.getElementById('categoryStatus').checked =
            this.dataset.status == 1;

        updateIconPreview(this.dataset.icon || 'fa-tag');

        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').style.display = 'flex';
    });
});

let isSidebarOpen = false;

function toggleSidebar() {
    const sidebar = document.querySelector('aside');
    if (window.innerWidth < 1024) {
        if (isSidebarOpen) {
            sidebar.style.transform = 'translateX(100%)';
            isSidebarOpen = false;
        } else {
            sidebar.style.transform = 'translateX(0)';
            isSidebarOpen = true;
        }
    }
}

if (window.innerWidth < 1024) {
    document.querySelector('aside').style.transform = 'translateX(100%)';
    document.querySelector('aside').style.transition = 'transform 0.3s ease';

    const header = document.querySelector('header .flex');
    const hamburgerBtn = document.createElement('button');
    hamburgerBtn.innerHTML = '<i class="fas fa-bars text-xl"></i>';
    hamburgerBtn.className = 'lg:hidden p-2 text-gray-500 hover:text-blue-600 transition';
    hamburgerBtn.onclick = toggleSidebar;
    if(header.firstChild) {
        header.insertBefore(hamburgerBtn, header.firstChild);
    } else {
        header.appendChild(hamburgerBtn);
    }
}