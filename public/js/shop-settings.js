function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logoPreviewImg').src = e.target.result;
            document.getElementById('logoPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeLogo() {
    document.getElementById('logoInput').value = '';
    document.getElementById('logoPreview').classList.add('hidden');
}

function previewFavicon(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('faviconPreviewImg').src = e.target.result;
            document.getElementById('faviconPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeFavicon() {
    document.getElementById('faviconInput').value = '';
    document.getElementById('faviconPreview').classList.add('hidden');
}