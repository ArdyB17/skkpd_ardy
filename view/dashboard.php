<?php
include '../koneksi.php';

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
    body {
        font-family: "Plus Jakarta Sans", sans-serif;
        background-color: var(--light-bg);
    }

    .navbar {
        padding: 1rem 0;
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    :root {
        --primary-color: #2563eb;
        --secondary-color: #1e40af;
        --light-bg: #f8fafc;
    }

    /* Modern Navbar Styles */
    .navbar-brand {
        color: var(--primary-color);
        transition: all 0.3s ease;
        margin-right: 2rem;
        position: relative;
        padding: 0.5rem 1rem;
        border-radius: 12px;
    }

    .brand-text {
        font-size: 1.5rem;
        font-weight: 700;
        /* background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent; */
    }

    .navbar-brand:hover {
        background: rgba(37, 99, 235, 0.1);
        transform: translateY(-2px);
    }

    .navbar-nav {
        gap: 0.5rem;
    }

    .nav-link {
        font-size: 0.95rem;
        font-weight: 600;
        color: #64748b !important;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-link:hover {
        color: var(--primary-color) !important;
        background: rgba(37, 99, 235, 0.1);
        transform: translateY(-1px);
    }

    .nav-link.active {
        color: #fff !important;
        background: linear-gradient(135deg,
                var(--primary-color),
                var(--secondary-color));
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .nav-link i {
        font-size: 1.1rem;
        transition: transform 0.2s ease;
    }

    .nav-link:hover i {
        transform: scale(1.1);
    }

    /* Profile Dropdown Styles */
    .nav-item.dropdown {
        margin-left: 1.5rem;
    }

    .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 0.75rem;
        min-width: 200px;
    }

    /* .operator .dropdown-item {
        color: greenyellow;
    } */

    .operator .dropdown-item:hover {
        color: var(--primary-color) !important;
        background: rgba(37, 99, 235, 0.1);
        transform: translate3d(4px, 0, 0);
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(239, 68, 68, 0.08);
        transform: translateX(4px);
    }

    /* Hero Section Styles */
    .hero-section {
        padding: 5rem 0;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }

    /* Feature Cards */
    .feature-card {
        border-radius: 16px;
        transition: transform 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--primary-color);
        color: white;
        margin: 0 auto 1.5rem;
    }

    /* FAQ Section */
    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: white;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: var(--primary-color);
    }

    /* Custom Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }

        .navbar-nav {
            gap: 0.5rem;
        }

        .nav-link {
            padding: 1rem;
        }

        .nav-item.dropdown {
            margin-left: 0;
            margin-top: 0.5rem;
        }

        .dropdown-menu {
            box-shadow: none;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }
    }

    /************************************
  * Enhanced Landing Page Styles
  * Added for improved UI/UX 
  ************************************/

    /* Hero Section Enhancements */
    .min-vh-75 {
        min-height: 75vh;
    }

    .hero-section {
        position: relative;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        overflow: hidden;
    }

    .hero-title {
        font-size: 3.5rem;
        line-height: 1.2;
        font-weight: 700;
    }

    /* About SKKPD Section Styles */
    .py-6 {
        padding-top: 5rem;
        padding-bottom: 5rem;
    }

    .info-card {
        transition: all 0.3s ease;
        border-radius: 16px;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .feature-icon-sm {
        width: 48px;
        height: 48px;
        background: rgba(37, 99, 235, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    /* Badge Styles */
    .badge {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Card Hover Effects */
    .info-card {
        background: white;
    }

    .info-card:hover .feature-icon-sm {
        background: var(--primary-color);
        color: white;
    }

    /* Section Typography */
    h6.text-primary {
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.875rem;
    }

    .lead {
        font-size: 1.15rem;
        line-height: 1.7;
    }

    /* Category Section Styles */
    .category-card {
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
    }

    .category-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-color);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .category-list {
        list-style: none;
        padding-left: 0;
        margin-top: 1rem;
    }

    .category-list li {
        padding: 0.5rem 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
    }

    .category-list li:last-child {
        border-bottom: none;
    }

    /* Objectives Grid Improvements */
    .objectives-grid .info-card {
        height: 100%;
    }

    .objectives-grid .card-body {
        display: flex;
        flex-direction: column;
    }

    .objectives-grid .feature-icon-sm {
        margin-bottom: 1.25rem;
    }

    /* Enhanced Typography */
    .lead {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #475569;
    }
</style>

<body>

    <!-- super cool aesthetic Navbar (trust me) -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">

            <!-- Brand - left position -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                🏫 <span class="brand-text">SKKPd</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- center and spacing ? -->
                <ul class="navbar-nav mx-auto">

                    <!-- siswa -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'siswa') ? 'active' : ''; ?>"
                            href="dashboard.php?page=siswa">
                            <i class="bi bi-people me-1"></i>Siswa
                        </a>
                    </li>

                    <!-- jurusan -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'jurusan') ? 'active' : ''; ?>"
                            href="dashboard.php?page=jurusan">
                            <i class="bi bi-diagram-3 me-1"></i>Jurusan
                        </a>
                    </li>

                    <!-- kegiatan kategori -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'kegiatan') ? 'active' : ''; ?>"
                            href="dashboard.php?page=kegiatan">
                            <i class="bi bi-calendar-event me-1"></i>Kategori
                        </a>
                    </li>

                    <!-- sertifikat -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'jurusan') ? 'active' : ''; ?>"
                            href="dashboard.php?page=jurusan">
                            <i class="bi bi-award me-1"></i>Sertifikat
                        </a>
                    </li>

                    <!-- operator -->


                </ul>

                <!-- Profile Dropdown - right position maybe -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-sm-inline"><?= $_COOKIE['Nama_Lengkap'] ?></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <!-- <li>
                                <a class="dropdown-item" href="dashboard.php?page=profile">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a>
                            </li> -->
                            <li class="operator">
                                <a class="dropdown-item" href="dashboard.php?page=operator" style="transition: all 0.2s ease;">
                                    <i class="bi bi-gear me-2"></i> Operator
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="../logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
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
                include '../insert/tambah_siswa.php';
                break;
            case 'ubah_siswa':
                include '../update/ubah_siswa.php';
                break;


                // jurusan section
            case 'jurusan':
                include 'jurusan.php';
                break;
            case 'tambah_jurusan':
                include '../insert/tambah_jurusan.php';
                break;
            case 'ubah_jurusan':
                include '../update/ubah_jurusan.php';
                break;

                // kategori kegiatan section
            case 'kegiatan':
                include 'kegiatan.php';
                break;

            case 'tambah_kegiatan':
                include '../insert/tambah_kategori_kegiatan.php';
                break;

            case 'ubah_kegiatan':
                include '../update/ubah_kegiatan.php';
                break;

                // operator section
            case 'operator':
                include 'operator.php';
                break;

            default:
                // Show default content for unknown pages
                include 'dashboard.php';
                break;
        }
    } else {

        // Landing Page Content
    ?>
        <!-- Landing Page Content -->
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
                                <img src="../images/hero.jpg" alt="Education Illustration" class="img-fluid rounded-4 shadow-lg">
                                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 rounded-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Updated About SKKPd Section -->
            <section id="about-skkpd" class="py-6 bg-light">
                <div class="container">
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-8 text-center">
                            <h6 class="text-primary fw-bold mb-3">Overview SKKPd</h6>
                            <h2 class="mb-4">Tujuan Sistem Kredit Kegiatan</h2>
                            <p class="lead text-muted">
                                Sistem yang dirancang untuk mengembangkan kompetensi siswa melalui berbagai kegiatan terstruktur dengan target 30 poin dalam 3 tahun masa studi.
                            </p>
                        </div>
                    </div>

                    <div class="row g-4 objectives-grid">
                        <div class="col-md-6 col-lg-3">
                            <div class="info-card card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="feature-icon-sm mb-3">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <h5>Kesiapan Kerja</h5>
                                    <p class="text-muted mb-0">
                                        Meningkatkan kompetensi siswa dalam menghadapi dunia kerja dan wirausaha
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="info-card card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="feature-icon-sm mb-3">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h5>Soft Skills</h5>
                                    <p class="text-muted mb-0">
                                        Pengembangan kepemimpinan, komunikasi, dan kemampuan berpikir kritis
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="info-card card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="feature-icon-sm mb-3">
                                        <i class="bi bi-trophy"></i>
                                    </div>
                                    <h5>Keterlibatan Aktif</h5>
                                    <p class="text-muted mb-0">
                                        Partisipasi dalam kegiatan ekstrakurikuler dan kokurikuler
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="info-card card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="feature-icon-sm mb-3">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <h5>Syarat Kelulusan</h5>
                                    <p class="text-muted mb-0">
                                        Komponen penting untuk US dan UKK
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Updated FAQ Section -->
            <section class="py-6 bg-light">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h2 class="text-center mb-5">Pertanyaan Umum SKKPd</h2>
                            <div class="accordion" id="faqAccordion">
                                <!-- FAQ items about SKKPd... -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    <?php
    }
    ?>

    <!-- Scripts -->
    <script src="../bootstrap/bootstrap.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>