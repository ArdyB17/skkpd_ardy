<?php
// Get current operator data
$current_username = $_COOKIE['username'];
$operators_query = mysqli_query($koneksi, "SELECT * FROM operator ORDER BY Nama_Lengkap");
$current_operator = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM operator WHERE username='$current_username'"));

// Handle password update
if (isset($_POST['update_password'])) {
    $username = $_COOKIE['username'];
    $new_password = mysqli_real_escape_string($koneksi, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        mysqli_begin_transaction($koneksi);
        try {
            // Update password
            $update = mysqli_query($koneksi, "UPDATE pengguna SET Password='$hashed_password' WHERE username='$username'");
            
            if ($update) {
                mysqli_commit($koneksi);
                
                // Clear cookies and redirect to login
                setcookie('username', '', time() - 3600, '/');
                setcookie('level_user', '', time() - 3600, '/');
                setcookie('Nama_Lengkap', '', time() - 3600, '/');
                
                echo "<script>alert('Password berhasil diupdate! Silakan login kembali.');window.location.href='../login.php';</script>";
            } else {
                throw new Exception('Update failed');
            }
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            echo "<script>alert('Gagal mengupdate password!');</script>";
        }
    } else {
        echo "<script>alert('Password baru tidak cocok!');</script>";
    }
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    $username = $_COOKIE['username'];

    mysqli_begin_transaction($koneksi);
    try {
        // First delete from operator table due to foreign key constraint
        $delete_operator = mysqli_query($koneksi, "DELETE FROM operator WHERE username='$username'");
        
        // Then delete from pengguna table
        $delete_pengguna = mysqli_query($koneksi, "DELETE FROM pengguna WHERE username='$username'");

        if ($delete_operator && $delete_pengguna) {
            mysqli_commit($koneksi);
            
            // Clear cookies and redirect to login
            setcookie('username', '', time() - 3600, '/');
            setcookie('level_user', '', time() - 3600, '/');
            setcookie('Nama_Lengkap', '', time() - 3600, '/');
            
            echo "<script>alert('Akun berhasil dihapus!');window.location.href='../login.php';</script>";
        } else {
            throw new Exception('Delete failed');
        }
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Gagal menghapus akun! " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<div class="container py-4">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-gradient bg-primary text-white p-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-people-fill fs-4 me-2"></i>
                <h4 class="mb-0">Data Operator</h4>
            </div>
            <a href="dashboard.php?page=tambah_operator" class="btn btn-light">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Operator
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left: Operators List -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">Operator</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($operator = mysqli_fetch_assoc($operators_query)) { ?>
                                    <tr class="<?= $operator['username'] === $current_username ? 'table-primary' : '' ?>">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="operator-avatar-sm me-3">
                                                    <i class="bi bi-person-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold"><?= htmlspecialchars($operator['Nama_Lengkap']) ?></div>
                                                    <small class="text-muted">@<?= htmlspecialchars($operator['username']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Password Management -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white p-4">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Pengaturan Akun
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Current User Info -->
                    <div class="text-center mb-4">
                        <div class="operator-avatar-lg mx-auto mb-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h5 class="mb-1"><?= htmlspecialchars($current_operator['Nama_Lengkap']) ?></h5>
                        <p class="text-muted mb-0">@<?= htmlspecialchars($current_operator['username']) ?></p>
                    </div>

                    <hr class="my-4">

                    <!-- Password Update Form -->
                    <form method="POST" action="" class="needs-validation" novalidate>
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

                        <div class="d-grid">
                            <button type="submit" name="update_password" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Update Password
                            </button>
                        </div>
                    </form>

                    <!-- Danger Zone -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="text-danger d-flex align-items-center mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Danger Zone
                        </h6>
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                <i class="bi bi-trash me-2"></i>Hapus Akun
                            </button>
                        </div>
                    </div>

                    <form id="deleteForm" method="POST" style="display: none;">
                        <input type="hidden" name="delete_account" value="true">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Updated and new styles */
.operator-avatar-sm {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(37, 99, 235, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
}

.operator-avatar-lg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(37, 99, 235, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 2rem;
}

.table {
    border-spacing: 0;
    border-collapse: separate;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(37, 99, 235, 0.05) !important;
}

.table-primary {
    --bs-table-bg: rgba(37, 99, 235, 0.1);
}

/* Responsive height for operators list */
@media (min-width: 992px) {
    .table-responsive {
        max-height: calc(100vh - 300px);
        overflow-y: auto;
    }
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
}
</style>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }

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