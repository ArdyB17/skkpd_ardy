<?php
// Get operator data
$username = $_COOKIE['username'];
$query = mysqli_query($koneksi, "SELECT o.*, p.Password 
                                FROM operator o 
                                INNER JOIN pengguna p ON o.username = p.username 
                                WHERE o.username='$username'");
$data_operator = mysqli_fetch_assoc($query);

// Handle form submission
if (isset($_POST['update_password'])) {
    $new_password = mysqli_real_escape_string($koneksi, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $update = mysqli_query($koneksi, "UPDATE pengguna SET Password='$hashed_password' WHERE username='$username'");

        if ($update) {
            echo "<script>alert('Password berhasil diupdate!');window.location.href='dashboard.php?page=operator';</script>";
        } else {
            echo "<script>alert('Gagal mengupdate password!');</script>";
        }
    } else {
        echo "<script>alert('Password baru tidak cocok!');</script>";
    }
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'true') {
        mysqli_begin_transaction($koneksi);
        try {
            mysqli_query($koneksi, "DELETE FROM operator WHERE username='$username'");
            mysqli_query($koneksi, "DELETE FROM pengguna WHERE username='$username'");
            mysqli_commit($koneksi);
            
            // Clear cookies
            setcookie('username', '', time() - 3600, '/');
            setcookie('level_user', '', time() - 3600, '/');
            setcookie('Nama_Lengkap', '', time() - 3600, '/');
            
            echo "<script>alert('Akun berhasil dihapus!');window.location.href='../login.php';</script>";
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            echo "<script>alert('Gagal menghapus akun!');</script>";
        }
    }
}
?>

<div class="container py-4">
    <div class="row g-4">
        <!-- Profile Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white p-4">
                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle display-4"></i>
                    </div>
                    <h5 class="text-center mb-1"><?= htmlspecialchars($data_operator['Nama_Lengkap']) ?></h5>
                    <p class="text-center mb-0 opacity-75">Administrator</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Username:</small>
                        <p class="mb-0 fw-medium"><?= htmlspecialchars($data_operator['username']) ?></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Email:</small>
                        <p class="mb-0 fw-medium"><?= htmlspecialchars($data_operator['Email']) ?></p>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">No. Telepon:</small>
                        <p class="mb-0 fw-medium"><?= htmlspecialchars($data_operator['No_Telp']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white p-4">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Update Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="" class="needs-validation" novalidate>
                        <!-- Password fields -->
                        <div class="mb-4">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="new_password" id="newPassword" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" name="update_password" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Update Password
                            </button>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="bi bi-trash me-2"></i>Hapus Akun
                            </button>
                        </div>
                    </form>

                    <!-- Hidden delete form -->
                    <form id="deleteForm" method="POST" style="display: none;">
                        <input type="hidden" name="delete_account" value="true">
                        <input type="hidden" name="confirm_delete" value="true">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = input.nextElementSibling.querySelector('i');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
}

// Confirm delete account
function confirmDelete() {
    if (confirm('Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteForm').submit();
    }
}

// Form validation
(function() {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
