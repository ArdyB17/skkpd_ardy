<?php
// Check if form is submitted
if (isset($_POST['update_password'])) {
    $new_password = mysqli_real_escape_string($koneksi, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    // Get current user's NIS
    $nis = $_COOKIE['NIS'];

    // Check if new passwords match
    if ($new_password === $confirm_password) {
        mysqli_begin_transaction($koneksi);
        try {
            // Hash password and update
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = mysqli_query($koneksi, "UPDATE pengguna SET Password='$hashed_password' WHERE NIS='$nis'");
            
            if ($update) {
                mysqli_commit($koneksi);
                
                // Clear all user cookies
                setcookie('NIS', '', time() - 3600, '/');
                setcookie('level_user', '', time() - 3600, '/');
                setcookie('Nama_Lengkap', '', time() - 3600, '/');
                
                echo "<script>
                    alert('Password berhasil diubah! Silakan login kembali.');
                    window.location.href='../login.php';
                </script>";
                exit;
            } else {
                throw new Exception('Update failed');
            }
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            echo "<script>alert('Gagal mengubah password!');</script>";
        }
    } else {
        echo "<script>alert('Password baru tidak cocok!');</script>";
    }
}
?>

<!-- Password Change Form -->
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg">
                <!-- Card Header -->
                <div class="card-header bg-gradient bg-primary border-0 p-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-key-fill text-white fs-4 me-2"></i>
                        <h5 class="mb-0 text-white">Ganti Password</h5>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <form method="POST" action="" class="needs-validation" novalidate>
                        <!-- User Info (Read-only) -->
                        <div class="mb-4">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <input type="text"
                                class="form-control bg-light"
                                value="<?= $_COOKIE['Nama_Lengkap'] ?>"
                                readonly>
                        </div>

                        <!-- New Password -->
                        <div class="mb-4 position-relative">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control"
                                    name="new_password"
                                    id="newPassword"
                                    required>
                                <button class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('newPassword')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Masukkan password baru
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4 position-relative">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control"
                                    name="confirm_password"
                                    id="confirmPassword"
                                    required>
                                <button class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('confirmPassword')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Konfirmasi password baru
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                name="update_password"
                                class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
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

                // Check if passwords match
                const newPass = form.querySelector('[name="new_password"]');
                const confirmPass = form.querySelector('[name="confirm_password"]');

                if (newPass.value !== confirmPass.value) {
                    event.preventDefault();
                    alert('Password baru tidak cocok!');
                    return false;
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>