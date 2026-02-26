<section class="content">
    <div class="container-fluid">

        <!-- ===== HEADER ===== -->
        <div class="welcome-box mb-5">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-1">
                        <i class="fa fa-book-open mr-2"></i>Sistem Perpustakaan
                    </h3>
                    <p class="mb-0">
                        Selamat datang,
                        <strong><?= ucfirst($this->session->userdata('role')) ?></strong>
                    </p>
                </div>
                <div class="welcome-icon">
                    <i class="fa fa-university"></i>
                </div>
            </div>
        </div>

        <!-- ===== MENU DASHBOARD ===== -->
        <div class="row">

            <?php if ($this->session->userdata('role') == 'admin') : ?>

            <!-- KELOLA ANGGOTA -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="<?= base_url('data-anggota') ?>" class="menu-link">
                    <div class="card dashboard-card">
                        <div class="card-body text-center">
                            <div class="icon-circle bg-primary">
                                <i class="fa fa-users"></i>
                            </div>
                            <h5>Kelola Anggota</h5>
                            <p>Tambah & kelola data anggota perpustakaan</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- KELOLA BUKU -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="<?= base_url('data-buku') ?>" class="menu-link">
                    <div class="card dashboard-card">
                        <div class="card-body text-center">
                            <div class="icon-circle bg-success">
                                <i class="fa fa-book"></i>
                            </div>
                            <h5>Kelola Buku</h5>
                            <p>Manajemen data buku & stok</p>
                        </div>
                    </div>
                </a>
            </div>

            <?php endif; ?>

            <!-- TRANSAKSI -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="<?= base_url('data-peminjaman') ?>" class="menu-link">
                    <div class="card dashboard-card">
                        <div class="card-body text-center">
                            <div class="icon-circle bg-danger">
                                <i class="fa fa-exchange-alt"></i>
                            </div>
                            <h5>Transaksi</h5>
                            <p>Peminjaman & pengembalian buku</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ===== CSS ===== -->
<style>
.welcome-box {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,.12);
    position: relative;
    overflow: hidden;
}

.welcome-icon {
    font-size: 90px;
    opacity: .15;
}

.menu-link {
    text-decoration: none !important;
    color: inherit !important;
}

.dashboard-card {
    border: none;
    border-radius: 18px;
    height: 100%;
    background: #fff;
    transition: .35s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 18px 40px rgba(0,0,0,.15);
}

.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: auto;
    margin-top: -25px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    box-shadow: 0 10px 25px rgba(0,0,0,.15);
}

.dashboard-card h5 {
    font-weight: 600;
    margin-bottom: 8px;
}

.dashboard-card p {
    font-size: 14px;
    color: #6b7280;
}
</style>