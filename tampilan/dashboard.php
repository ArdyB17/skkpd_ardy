<?php
include '../koneksi.php';

// Check if user is logged in
if (!isset($_COOKIE['level_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!');window.location.href='../login.php';</script>";
    exit;
}

// Page title handling
$title = 'Home';  // Default title

if (isset($_GET['page'])) {
    switch ($_GET['page']) {

            // siswa section
        case 'siswa':
            $title = 'Data Siswa';
            break;

        case 'tambah_siswa':
            $title = 'Tambah Siswa Baru';
            break;
        case 'ubah_siswa':
            $title = 'Edit Data Siswa';
            break;

            // jurusan section
        case 'jurusan':
            $title = 'Data Jurusan';
            break;
        case 'tambah_jurusan':
            $title = 'Tambah Jurusan Baru';
            break;
        case 'ubah_jurusan':
            $title = 'Edit Data Jurusan';
            break;

            // kategori kegiatan section
        case 'tambah_kegiatan':
            $title = 'Tambah Kategori Kegiatan';
            break;

        case 'kegiatan':
            $title = 'Data Kegiatan';
            break;

        case 'ubah_kegiatan':
            $title = 'Edit Data Kegiatan';
            break;

        case 'ubah_sub_kategori':
            $title = 'Edit Sub kategori';
            break;

            // sertifikat section
        case 'sertifikat':
            $title = 'Sertifikat';
            break;

            // operator section
        case 'operator':
            $title = 'Data Operator';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->


    <link rel="stylesheet" href="../bootstrap/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- another important link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>SKKPD - <?php echo $title; ?></title>
</head>

<style>
    <?php include '../css/style_dashboard.css'; ?><?php include '../css/style_dashboard_siswa.css'; ?>
</style>

<body>

    <!-- super cool aesthetic Navbar (trust me) -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <?php if ($_COOKIE['level_user'] == 'operator'): ?>
                <!-- Brand - left position -->
                <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                    🏫 <span class="brand-text">SKKPd</span>
                </a>
            <?php else: ?>
                <!-- Brand - left position -->
                <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                    🏫 <span class="brand-text">SKKPd</span>
                </a>
            <?php endif; ?>
            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- center and spacing ? -->
                <ul class="navbar-nav mx-auto">
                    <?php if ($_COOKIE['level_user'] == 'operator'): ?>
                        <!-- Menu items for operator -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'siswa') ? 'active' : ''; ?>"
                                href="dashboard.php?page=siswa">
                                <i class="bi bi-people me-1"></i>Siswa
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'jurusan') ? 'active' : ''; ?>"
                                href="dashboard.php?page=jurusan">
                                <i class="bi bi-diagram-3 me-1"></i>Jurusan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'kegiatan') ? 'active' : ''; ?>"
                                href="dashboard.php?page=kegiatan">
                                <i class="bi bi-calendar-event me-1"></i>Kategori
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'sertifikat') ? 'active' : ''; ?>"
                                href="dashboard.php?page=sertifikat">
                                <i class="bi bi-award me-1"></i>Sertifikat
                            </a>
                        </li>

                    <?php else: ?>
                        <!-- Only sertifikat menu for regular users -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'upload_sertifikat') ? 'active' : ''; ?>"
                                href="dashboard.php?page=upload_sertifikat">
                                <i class="bi bi-award me-1"></i>Upload Sertifikat
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Profile Dropdown - right position maybe -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-sm-inline"><?= $_COOKIE['Nama_Lengkap'] ?></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <?php if ($_COOKIE['level_user'] == 'operator'): ?>
                                <!-- Operator Profile Edit Option -->
                                <li class="operator">
                                    <a class="dropdown-item d-flex align-items-center" href="dashboard.php?page=operator">
                                        <i class="bi bi-gear me-2"></i>
                                        <span>Edit Profil</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <!-- Regular User Password Change Option -->
                                <li class="user">
                                    <a class="dropdown-item d-flex align-items-center" href="dashboard.php?page=ganti_password">
                                        <i class="bi bi-key me-2"></i>
                                        <span>Ganti Password</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Divider before logout -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <!-- Logout Option -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-danger" href="../logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>

                    </li>
                </ul>

            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {

                // the landing page

                // case 'dashboard':
                //     include 'dashboard.php';
                //     break;

                // siswa section
            case 'siswa':
                include 'siswa.php';
                break;
            case 'tambah_siswa':
                include '../tambah/tambah_siswa.php';
                break;
            case 'ubah_siswa':
                include '../ubah/ubah_siswa.php';
                break;


                // jurusan section
            case 'jurusan':
                include 'jurusan.php';
                break;
            case 'tambah_jurusan':
                include '../tambah/tambah_jurusan.php';
                break;
            case 'ubah_jurusan':
                include '../ubah/ubah_jurusan.php';
                break;

                // kategori kegiatan section
            case 'kegiatan':
                include 'kegiatan.php';
                break;

            case 'tambah_kegiatan':
                include '../tambah/tambah_kategori_kegiatan.php';
                break;

            case 'ubah_kegiatan':
                include '../ubah/ubah_kegiatan.php';
                break;

            case 'ubah_sub_kategori':
                include '../ubah/ubah_sub_kategori.php';
                break;

                // operator section
            case 'operator':
                include 'operator.php';
                break;

            case 'ganti_password':
                include '../ubah/ganti_password.php';
                break;

                // sertificate section
            case 'sertifikat':
                include 'sertifikat.php';
                break;

            case 'upload_sertifikat':
                include '../tambah/upload_sertifikat.php';
                break;

            default:
                // Show default content for unknown pages
                include 'dashboard.php';
                break;
        }
    } else {
        // Different landing pages based on user role
        if ($_COOKIE['level_user'] == 'operator') {
            // Operator Landing Page Content (existing content)
    ?>
            <!-- Landing Page Content for Operator -->
            <main>
                <!-- Enhanced Hero Section -->
                <section class="hero-section position-relative">
                    <div class="container">
                        <div class="row align-items-center min-vh-75">
                            <div class="col-lg-6 animate-fadeInUp">
                                <span class="badge bg-primary px-3 py-2 mb-3">SMK TI Bali Global Denpasar</span>
                                <h1 class="hero-title mb-4">
                                    Satuan Kredit Kegiatan <span class="text-primary">Peserta Didik</span>
                                </h1>
                                <p class="lead text-secondary mb-4">
                                    Sistem penilaian berbasis poin untuk meningkatkan soft skills, kesiapan kerja, dan jiwa wirausaha yang mendukung Kurikulum Merdeka dan Teaching Factory.
                                </p>
                                <div class="d-flex gap-3">
                                    <a href="#about-skkpd" class="btn btn-primary btn-lg px-4 py-2">
                                        Pelajari SKKPd <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                    <a href="#categories" class="btn btn-outline-primary btn-lg px-4 py-2">
                                        Explore fitur
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block animate-fadeInUp" style="animation-delay: 0.2s">
                                <div class="position-relative">
                                    <img src="../gambar/hero.jpg" alt="Education Illustration" class="img-fluid rounded-4 shadow-lg">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 rounded-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- [Rest of the operator content remains the same...] -->

            </main>
        <?php
        } else {
            // Student Landing Page Content
        ?>
            <main class="dashboard-main py-4">
                <div class="container">
                    <!-- Profile Section -->
                    <div class="row justify-content-center mb-4">
                        <div class="col-12 col-lg-8">

                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-header custom-header border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="header-avatar-wrapper">
                                            <div class="header-avatar">
                                                <?php echo strtoupper(substr($_COOKIE['Nama_Lengkap'], 0, 1)); ?>
                                            </div>
                                        </div>
                                        <div class="ms-3 text-white">
                                            <h4 class="mb-1 fw-bold"><?php echo $_COOKIE['Nama_Lengkap']; ?></h4>
                                            <div class="subtitle d-flex align-items-center">
                                                <i class="bi bi-person-badge me-2"></i>
                                                <span class="badge bg-light bg-opacity-25 border-0">
                                                    NIS: <?php echo $_COOKIE['NIS']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $nis = $_COOKIE['NIS'];
                                $query = mysqli_query($koneksi, "SELECT siswa.*, jurusan.Jurusan 
                                                               FROM siswa 
                                                               INNER JOIN jurusan ON siswa.Id_Jurusan = jurusan.Id_Jurusan 
                                                               WHERE siswa.NIS = '$nis'");
                                $siswa = mysqli_fetch_assoc($query);
                                ?>

                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-person-vcard me-2 text-primary"></i>
                                                    <p class="text-muted mb-0 fw-medium">No. Absen</p>
                                                </div>
                                                <p class="fw-bold mb-0"><?php echo $siswa['No_Absen']; ?></p>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-telephone me-2 text-primary"></i>
                                                    <p class="text-muted mb-0 fw-medium">No. Telp</p>
                                                </div>
                                                <p class="fw-bold mb-0"><?php echo $siswa['No_Telp']; ?></p>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-envelope me-2 text-primary"></i>
                                                    <p class="text-muted mb-0 fw-medium">Email</p>
                                                </div>
                                                <p class="fw-bold mb-0"><?php echo $siswa['Email']; ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-building me-2 text-primary"></i>
                                                    <p class="text-muted mb-0 fw-medium">Jurusan</p>
                                                </div>
                                                <h5 class="mb-0">
                                                    <span class="badge bg-primary"><?php echo $siswa['Jurusan']; ?> <?php echo $siswa['Kelas']; ?></span>
                                                </h5>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-calendar3 me-2 text-primary"></i>
                                                    <p class="text-muted mb-0 fw-medium">Angkatan</p>
                                                </div>
                                                <p class="fw-bold mb-0"><?php echo $siswa['Angkatan']; ?></p>
                                            </div>

                                            <div class="credit-points-card p-3 bg-primary bg-opacity-10 rounded-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <i class="bi bi-award-fill text-primary fs-3"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="mb-0 fw-bold text-primary">15 Poin</h4>
                                                        <p class="mb-0 small text-primary">Total SKKPd</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row justify-content-center g-4 mb-4">
                        <?php
                        // Fetch certificate statistics
                        $valid_certs = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM sertifikat WHERE NIS='$nis' AND Status='Valid'"));
                        $invalid_certs = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM sertifikat WHERE NIS='$nis' AND Status='Tidak Valid'"));
                        $pending_certs = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM sertifikat WHERE NIS='$nis' AND Status='Menunggu'"));

                        $stat_cards = [
                            ['title' => 'Sertifikat Valid', 'count' => $valid_certs, 'icon' => 'check-circle-fill', 'color' => 'success'],
                            ['title' => 'Menunggu Validasi', 'count' => $pending_certs, 'icon' => 'clock-fill', 'color' => 'warning'],
                            ['title' => 'Tidak Valid', 'count' => $invalid_certs, 'icon' => 'x-circle-fill', 'color' => 'danger']
                        ];

                        foreach ($stat_cards as $card) : ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="stats-icon bg-<?php echo $card['color']; ?>-subtle rounded-circle p-3">
                                                <i class="bi bi-<?php echo $card['icon']; ?> text-<?php echo $card['color']; ?> fs-4"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h3 class="fw-bold mb-0"><?php echo $card['count']; ?></h3>
                                                <p class="text-muted mb-0"><?php echo $card['title']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Action Button -->
                    <div class="text-center">
                        <a href="dashboard.php?page=upload_sertifikat" class="btn btn-primary btn-lg">
                            <i class="bi bi-upload me-2"></i>Upload Sertifikat Baru
                        </a>
                    </div>
                </div>
            </main>


    <?php
        }
    }
    ?>

    <!-- Scripts -->
    <script src="../bootstrap/bootstrap.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>