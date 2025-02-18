<?php

include 'koneksi.php';
if (isset($_POST['submit_login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Check operator login
    $cek_operator = mysqli_query($koneksi, "SELECT username, Password FROM pengguna WHERE username='$user'");
    $data_operator = mysqli_fetch_assoc($cek_operator);

    // Check student login
    $cek_siswa = mysqli_query($koneksi, "SELECT NIS, Password FROM pengguna WHERE NIS='$user'");
    $data_siswa = mysqli_fetch_assoc($cek_siswa);

    // Password Hashing Generation - Comment this when not generating hash
    // echo $enkrip = password_hash($pass, PASSWORD_DEFAULT);

    // Login Authentication - Uncomment this for normal login
    if (mysqli_num_rows($cek_operator) > 0) {
        if (password_verify($pass, $data_operator['Password'])) {
            $user_operator = $data_operator['username'];
            $nama_operator = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Lengkap FROM operator WHERE username='$user_operator'"));

            // Set cookies
            setcookie('username', $data_operator['username'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('Nama_Lengkap', $nama_operator['Nama_Lengkap'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('level_user', 'operator', time() + (60 * 60 * 24 * 7), '/');

            echo "<script>alert('Login Berhasil');window.location.href='view/dashboard.php?page=siswa'</script>";
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } elseif (mysqli_num_rows($cek_siswa) > 0) {
        if (password_verify($pass, $data_siswa['Password'])) {
            $user_siswa = $data_siswa['NIS'];
            $nama_siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Siswa FROM siswa WHERE NIS='$user_siswa'"));

            // Set cookies
            setcookie('NIS', $data_siswa['NIS'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('level_user', 'siswa', time() + (60 * 60 * 24 * 7), '/');
            setcookie('Nama_Lengkap', $nama_siswa['Nama_Siswa'], time() + (60 * 60 * 24 * 7), '/');

            echo "<script>alert('Login Berhasil');window.location.href='view/dashboard.php?page=siswa'</script>";
        } else {
            echo "<script>alert('Gagal login, Password salah!');window.location.href='login.php'</script>";
        }
    } else {
        echo "<script>alert('Gagal login,Username atau password salah!');window.location.href='login.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }

        .card {
            width: 400px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
        }

        .login-title {
            color: #2C3E50;
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
            color: #34495E;
        }

        .custom-input {
            border-radius: 10px;
            padding-left: 15px;
        }

        .password-input {
            border-radius: 10px 0 0 10px;
        }

        .toggle-password {
            border-radius: 0 10px 10px 0;
            cursor: pointer;
        }

        .login-button {
            background: linear-gradient(135deg, #3498DB, #2980B9);
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #3498DB;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
    </style>
</head>

<body>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">

                <h3 class="text-center mb-4 login-title">Login</h3>

                <form method="POST" action="">

                    <div class="mb-4 position-relative">

                        <label for="username" class="form-label">
                            <i class="fas fa-user-circle me-2"></i>Username
                        </label>

                        <input type="text" class="form-control form-control-lg custom-input" autocomplete="off" id="username" name="username">

                    </div>

                    <div class="mb-4 position-relative">

                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>

                        <div class="input-group">

                            <input type="password" class="form-control form-control-lg password-input" id="password" name="password" autocomplete="off" required>
                            <span class="input-group-text toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>

                        </div>
                    </div>

                    <button type="submit" name="submit_login" class="btn btn-primary w-100 py-3 login-button">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-lash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>