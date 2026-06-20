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