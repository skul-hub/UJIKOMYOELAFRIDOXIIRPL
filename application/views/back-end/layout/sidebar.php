<?php
$role = $this->session->userdata('role');
$current = uri_string();
?>

<style>
/* ========== SIDEBAR ========== */
.nav-left-sidebar {
    width: 260px;
    min-height: 100vh;
    background: linear-gradient(180deg, #020617, #0f172a);
    color: #fff;
    padding-top: 20px;
    box-shadow: 8px 0 30px rgba(0,0,0,.4);
}

.nav-left-sidebar .nav-link {
    color: #cbd5e1;
    padding: 12px 20px;
    border-radius: 12px;
    margin: 4px 12px;
    transition: all .35s ease;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.nav-left-sidebar .nav-link span {
    display: flex;
    align-items: center;
}

.nav-left-sidebar .nav-link i {
    margin-right: 12px;
}

.nav-left-sidebar .nav-link:hover {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: #fff;
    transform: translateX(6px);
    box-shadow: 0 10px 25px rgba(37,99,235,.4);
}

.nav-left-sidebar .nav-link.active {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: #fff;
    box-shadow: inset 4px 0 0 #60a5fa;
}

.nav-divider {
    padding: 12px 20px;
    font-size: 11px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* SUBMENU */
.submenu {
    padding-left: 8px;
}

.submenu .nav-link {
    font-size: 13px;
    padding: 10px 18px;
}

/* DROPDOWN ARROW */
.dropdown-arrow {
    transition: transform .4s ease;
}

.nav-link[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(90deg);
}

/* LOGOUT HOVER */
.nav-link.logout:hover {
    background: linear-gradient(135deg, #dc2626, #991b1b);
    box-shadow: 0 10px 25px rgba(220,38,38,.4);
}

/* ========== MODAL LOGOUT ========== */
.logout-modal {
    border-radius: 20px;
    border: none;
    animation: scaleIn .4s ease;
}

.logout-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dc2626, #991b1b);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: #fff;
    font-size: 28px;
}

.btn-logout {
    background: linear-gradient(135deg, #dc2626, #991b1b);
    border: none;
    color: #fff;
    border-radius: 12px;
    padding: 10px 22px;
}

.btn-logout:hover {
    box-shadow: 0 10px 25px rgba(220,38,38,.5);
}

/* Samakan ukuran tombol di modal logout */
.logout-modal .btn {
    padding: 10px 22px;
    border-radius: 12px;
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<!-- ========== SIDEBAR ========== -->
<div class="nav-left-sidebar">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="collapse navbar-collapse show">
                <ul class="navbar-nav flex-column w-100">

                    <!-- DASHBOARD -->
                    <li class="nav-item">
                        <a class="nav-link <?= $current == 'halaman-sistem' ? 'active' : '' ?>"
                           href="<?= site_url('halaman-sistem') ?>">
                            <span><i class="fa fa-home"></i> Dashboard</span>
                        </a>
                    </li>

                    <?php if ($role === 'admin'): ?>

                        <!-- MASTER DATA -->
                        <li class="nav-item">
                            <a class="nav-link"
                               data-toggle="collapse"
                               href="#submenu-master">
                                <span><i class="fas fa-database"></i> Master Data</span>
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </a>

                            <div id="submenu-master" class="collapse submenu">
                                <a class="nav-link <?= $current == 'data-buku' ? 'active' : '' ?>"
                                   href="<?= site_url('data-buku') ?>">Data Buku</a>
                                <a class="nav-link <?= $current == 'data-anggota' ? 'active' : '' ?>"
                                   href="<?= site_url('data-anggota') ?>">Data Anggota</a>
                            </div>
                        </li>

                        <!-- TRANSAKSI -->
                        <li class="nav-item">
                            <a class="nav-link"
                               data-toggle="collapse"
                               href="#submenu-transaksi">
                                <span><i class="fas fa-exchange-alt"></i> Transaksi</span>
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </a>

                            <div id="submenu-transaksi" class="collapse submenu">
                                <a class="nav-link <?= $current == 'data-riwayat' ? 'active' : '' ?>"
                                   href="<?= site_url('data-riwayat') ?>">Riwayat Peminjaman</a>
                                <a class="nav-link <?= $current == 'data-peminjaman' ? 'active' : '' ?>"
                                   href="<?= site_url('data-peminjaman') ?>">Data Peminjaman</a>
                                <a class="nav-link <?= $current == 'data-pengembalian' ? 'active' : '' ?>"
                                   href="<?= site_url('data-pengembalian') ?>">Data Pengembalian</a>
                            </div>
                        </li>

                    <?php elseif ($role === 'siswa'): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $current == 'data-peminjaman' ? 'active' : '' ?>"
                               href="<?= site_url('data-peminjaman') ?>">
                                <span><i class="fas fa-book"></i> Peminjaman</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $current == 'data-pengembalian' ? 'active' : '' ?>"
                               href="<?= site_url('data-pengembalian') ?>">
                                <span><i class="fas fa-undo"></i> Pengembalian</span>
                            </a>
                        </li>

                    <?php endif; ?>

                    <!-- LOGOUT -->
                    <li class="nav-divider mt-3">Keluar</li>
                    <li class="nav-item">
                        <a href="javascript:void(0)"
                           class="nav-link logout text-danger"
                           data-toggle="modal"
                           data-target="#modalLogout">
                            <span><i class="fas fa-sign-out-alt"></i> Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- ========== MODAL LOGOUT ========== -->
<div class="modal fade" id="modalLogout" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content logout-modal">
            <div class="modal-body text-center p-4">
                <div class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>

                <h5 class="mt-3">Konfirmasi Logout</h5>
                <p class="text-muted mb-4">
                    Apakah kamu yakin ingin keluar dari sistem?
                </p>

                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-secondary mr-2" data-dismiss="modal">
                        Batal
                    </button>
                    <a href="<?= site_url('logout-sistem') ?>" class="btn btn-logout">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>