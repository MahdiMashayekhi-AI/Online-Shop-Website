function openAddUserModal() {
    document.getElementById('modalTitle').innerText = 'افزودن کاربر جدید';
    document.getElementById('userForm').action = '/admin/users/store';
    document.getElementById('userId').value = '';
    document.getElementById('fullName').value = '';
    document.getElementById('email').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('role').value = 'user';
    document.getElementById('password').value = '';
    document.getElementById('confirmPassword').value = '';
    document.getElementById('userStatus').checked = true;
    document.getElementById('passwordRequired').style.display = 'inline';
    document.getElementById('confirmRequired').style.display = 'inline';
    document.getElementById('passwordFields').style.display = 'block';
    document.getElementById('userModal').classList.remove('hidden');
    document.getElementById('userModal').style.display = 'flex';
}

function editUser(id) {
    fetch('/admin/users/get?id=' + id)
        .then(response => response.json())
        .then(user => {
            if(user.error) {
                alert(user.error);
                return;
            }

            document.getElementById('modalTitle').innerText = 'ویرایش کاربر';
            document.getElementById('userForm').action = '/admin/users/update';
            document.getElementById('userId').value = user.id;
            document.getElementById('fullName').value = user.full_name;
            document.getElementById('email').value = user.email;
            document.getElementById('phone').value = user.phone || '';
            document.getElementById('role').value = user.role;
            document.getElementById('userStatus').checked = user.is_active == 1;
            document.getElementById('password').value = '';
            document.getElementById('confirmPassword').value = '';
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('confirmRequired').style.display = 'none';
            document.getElementById('passwordFields').style.display = 'none';
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('userModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در دریافت اطلاعات کاربر');
        });
}

function closeUserModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById('userModal').style.display = 'none';
}

document.getElementById('userModal').addEventListener('click', function(e) {
    if(e.target === this) {
        closeUserModal();
    }
});