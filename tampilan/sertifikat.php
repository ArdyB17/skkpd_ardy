<?php
// Fungsi untuk mendapatkan sertifikat berdasarkan status dan kegiatan
function getSertifikat($status, $koneksi, $kegiatan = null)
{
    $whereClause = "WHERE Status='$status'";
    if (!empty($kegiatan)) {
        $whereClause .= " AND Jenis_Kegiatan LIKE '%" . $kegiatan . "%'";
    }

    $query = "SELECT * FROM sertifikat
              INNER JOIN kegiatan USING(Id_Kegiatan)
              INNER JOIN kategori USING(Id_Kategori)
              INNER JOIN siswa USING(NIS)
              $whereClause
              ORDER BY Sub_Kategori, Tanggal_Upload ASC";

    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='row g-4'>";
        while ($data = mysqli_fetch_assoc($result)) {
?>
            <div class='col-12'>
                <div class='card certificate-card border-0 shadow-sm'>
                    <div class='row g-0'>
                        <!-- Left Column -->
                        <div class='col-md-6 p-4'>
                            <div class='certificate-info'>
                                <div class='mb-3'>
                                    <span class='badge bg-primary mb-2'><?= $data['Kategori'] ?></span>
                                    <h5 class='card-title mb-1'><?= $data['Sub_Kategori'] ?></h5>
                                    <p class='text-primary fw-bold mb-0'><?= $data['Jenis_Kegiatan'] ?></p>
                                </div>

                                <div class='mb-3'>
                    
                                    <div class='d-flex align-items-center gap-2'>
                                        <div class='student-avatar'>
                                            <?= strtoupper(substr($data['Nama_Siswa'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class='fw-medium mb-0'><?= $data['Nama_Siswa'] ?></p>
                                            <small class='text-muted'><?= $data['NIS'] ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class='certificate-meta'>
                                    <p class='text-muted mb-1'>
                                        <i class='bi bi-calendar3 me-2'></i>
                                        <?= $data['Tanggal_Upload'] ?>
                                    </p>
                                    <p class='text-muted mb-0'>
                                        <i class='bi bi-mortarboard me-2'></i>
                                        Angkatan <?= $data['Angkatan'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class='col-md-6 p-4 bg-light'>
                            <div class='d-flex flex-column h-100'>
                                <div class='preview-section text-center mb-4'>
                                    <img src='../gambar/pdf-preview.png' alt='PDF Preview' class='pdf-preview mb-2'>
                                    <p class='text-muted small mb-0'>Preview Sertifikat</p>
                                </div>

                                <div class='action-buttons mt-auto'>
                                    <div class='d-grid gap-2'>
                                        <a href='../gambar/<?= $data['Sertifikat'] ?>' target='_blank'
                                            class='btn btn-primary d-flex align-items-center justify-content-center gap-2'>
                                            <i class='bi bi-eye'></i>
                                            Lihat Sertifikat
                                        </a>
                                        <button type='button' class='btn btn-outline-primary d-flex align-items-center justify-content-center gap-2'>
                                            <i class='bi bi-pencil-square'></i>
                                            Edit Sertifikat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
        echo "</div>";
    } else {
        showNoDataMessage();
    }
}

function showNoDataMessage()
{
    $html = <<<HTML
    <div class='text-center py-5'>
    <img src='../gambar/no-data.svg' 
         alt='No Data' 
         class='no-data-img mb-3' 
         style='width: 200px;'>
    <h5 class='text-muted'>Tidak Ada Data</h5>
    </div>
    HTML;

    echo $html;
}
?>

<style>
    <?php include '../css/style_sertifikat.css' ?>
</style>

<div class='container-fluid py-4'>
    <div class='row justify-content-center'>
        <div class='col-xl-10'>
            <div class='card border-0 shadow-lg rounded-6'>

                <!-- Improved Header Section -->
                <div class='card-header bg-white border-0 p-4 rounded-5'>
                    <!-- Title Centered at Top -->
                    <div class='text-center mb-4'>
                        <h2 class='display-6 fw-bold text-primary'>
                            <i class='bi bi-card-heading me-2'></i>Sertifikat
                        </h2>
                    </div>

                    <!-- Search and Print Controls -->
                    <div class='row justify-content-center align-items-center g-3'>
                        <!-- Search Field -->
                        <div class='col-md-8 col-lg-6'>
                            <div class="search-wrapper">
                                <datalist id='kegiatan'>
                                    <?php
                                    $list_kategori = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan");
                                    while ($data_kegiatan = mysqli_fetch_assoc($list_kategori)) {
                                        echo "<option value='{$data_kegiatan['Jenis_Kegiatan']}'></option>";
                                    }
                                    ?>
                                </datalist>
                                <form method='POST' action='dashboard.php?page=sertifikat'>
                                    <div class="input-group">
                                        <input name='kegiatan'
                                            class='form-control form-control-lg shadow-none'
                                            autocomplete='off'
                                            list='kegiatan'
                                            type='search'
                                            placeholder='Cari Jenis Kegiatan...'
                                            value="<?php echo isset($_POST['kegiatan']) ? htmlspecialchars($_POST['kegiatan']) : ''; ?>">
                                        <button class='btn btn-primary px-4' type='submit'>
                                            <i class='bi bi-search'></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Print Button -->
                        <div class='col-md-4 col-lg-3'>
                            <button class='btn btn-warning w-100 btn-lg d-flex align-items-center justify-content-center gap-2'>
                                <i class='bi bi-printer-fill'></i>
                                <span>Cetak Laporan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Updated Navigation Tabs -->
                <div class='card-body p-4'>
                    <nav class='nav-tabs-wrapper'>
                        <div class='nav nav-tabs nav-tabs-custom border-0 mb-3' id='nav-tab' role='tablist'>
                            <button class='nav-link active px-4 py-3' data-bs-toggle='tab' data-bs-target='#menunggu-validasi'>
                                <i class='bi bi-clock-history me-2'></i>
                                <span>Menunggu Validasi</span>
                            </button>
                            <button class='nav-link px-4 py-3' data-bs-toggle='tab' data-bs-target='#tidak-valid'>
                                <i class='bi bi-x-circle me-2'></i>
                                <span>Tidak Valid</span>
                            </button>
                            <button class='nav-link px-4 py-3' data-bs-toggle='tab' data-bs-target='#valid'>
                                <i class='bi bi-check-circle me-2'></i>
                                <span>Sudah Tervalidasi</span>
                            </button>
                        </div>
                    </nav>

                    <!-- Tab Content -->
                    <div class='tab-content p-4 border-0 bg-light rounded-4' id='nav-tabContent'
                        style='max-height: 600px; overflow-y: auto;'>
                        <?php $kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : null; ?>

                        <!-- Tab Panes -->
                        <div class='tab-pane fade active show' id='menunggu-validasi'>
                            <?php getSertifikat('Menunggu Validasi', $koneksi, $kegiatan); ?>
                        </div>
                        <div class='tab-pane fade' id='tidak-valid'>
                            <?php getSertifikat('Tidak Valid', $koneksi, $kegiatan); ?>
                        </div>
                        <div class='tab-pane fade' id='valid'>
                            <?php getSertifikat('Valid', $koneksi, $kegiatan); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>