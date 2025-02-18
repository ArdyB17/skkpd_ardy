<?php
// Fetch operator data
$query = mysqli_query($koneksi, "SELECT Nama_Lengkap, username FROM operator");
?>

<!-- Header Card -->
<div class="container-fluid dashboard-container py-4 ">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">
            <div class="card border-0 shadow-lg rounded-4 mb-4">

                <div class="card-header bg-dark bg-gradient text-white p-4 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-semibold">
                            <i class="bi bi-person-fill-gear"></i> Data Operator
                        </h4>
                        <a href="dashboard.php?page=tambah_siswa" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-2"></i>Tambah Operator
                        </a>
                    </div>
                </div>

            </div>

            <!-- Operator Cards Grid -->
            <div class="row g-4">
                <?php while ($data = mysqli_fetch_assoc($query)): ?>

                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm hover-card">
                            <div class="card-body p-4">

                                <div class="d-flex align-items-center gap-3">

                                    <!-- Operator Avatar -->
                                    <div class="operator-avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>

                                    <!-- Operator Info -->
                                    <div class="operator-info">
                                        <h5 class="fw-semibold mb-1"><?= $data['Nama_Lengkap'] ?></h5>
                                        <p class="text-muted mb-0">
                                            <i class="bi bi-person-vcard me-1"></i>
                                            <?= $data['username'] ?>
                                        </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>

        </div>
    </div>
</div>

<style>
    .hover-card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .operator-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .operator-info {
        flex: 1;
    }

    @media (max-width: 768px) {
        .operator-avatar {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>