function previewMainImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainPreviewImg').src = e.target.result;
            document.getElementById('mainImagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeMainImage() {
    document.getElementById('mainImageInput').value = '';
    document.getElementById('mainImagePreview').classList.add('hidden');
    document.getElementById('mainPreviewImg').src = '';
}

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